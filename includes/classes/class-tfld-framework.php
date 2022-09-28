<?php

/**
 * 
 * Table of Contents (number is code line):
 * 
 * Include admin scripts
 * Include frontend scripts
 * Include Swiper.js plugin scripts
 * Admin pages - menu page, for CPT courses, under Tools
 * Admin pages - settings and forms
 * Load Course Template - with Swiper.js plugin carousel
 * Load Archive Courses Template - with Ajax load more button
 * Register CPT Courses
 * Register CPT Professors
 * Register Custom Taxonomies for CPT Courses with additional functionalities for tax Level
 * Tax Level has only 4 terms, custom metabox with input type radio (only one option can be selected)
 * Taxonomies Level, Subject, Topics in draft have autosave set to term Any
 * Register Custom Taxonomies for CPT Professors and autopopulate
 * Register Shortcode to display Swiper.js slider in Course Template
 * Metabox - Select Editor
 * Save Editor to Post Meta
 * Metabox - Add Custom Fields - Courses
 * Save Course Details to custom DB table
 * Woo GDPR Complience Checkbox for the Comments/Reviews
 * 
 * @package TFLD Simple Features
 *  
 */

namespace TFLD\Includes;

use TFLD\Includes\Abstracts\TFLD_Singleton;
use TFLD\Includes\Traits\Include_Files;

final class TFLD_Framework extends TFLD_Singleton
{
    use Include_Files;

    private $loader;
    private $theme_name;
    private $theme_version;


    /**
     * Protected class constructor to prevent direct object creation
     *
     * This is meant to be overridden in the classes which implement
     * this trait. This is ideal for doing stuff that you only want to
     * do once, such as hooking into actions and filters, etc.
     */
    protected function __construct()
    {

        $this->theme_name = 'tfldframework';
        $this->theme_version = '2.0.0';

        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/class-tfld-loader.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/admin/class-tfld-admin.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/frontend/class-tfld-public.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/templates/class-tfld-templates.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/cpt/class-tfld-cpt.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/cpt/class-tfld-select-editor.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/cpt/class-tfld-courses-details.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/taxonomies/class-tfld-taxonomies.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/shortcodes/class-tfld-shortcodes.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/ajax/class-tfld-ajax-vote.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/ajax/class-tfld-ajax-load-more.php' );
        self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/gdpr/class-tfld-woo-gdpr.php' );
        
        $this->init();
        $this->init_hooks();
    }

    /**
     * Initialize all dependencies.
     * 
     */
    private function init(): void
    {

        $this->loader = TFLD_Loader::get_instance();

        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_template_hooks();
        $this->define_cpt_hooks();
        $this->define_taxonomy_hooks();
        $this->define_shortcode_hooks();
        $this->define_ajax_hooks();
        $this->define_gdpr_hooks();

    }

    /**
     * Retrieve the name of the plugin used to uniquely identify it.
     * 
     */
    public function get_theme_name(): string
    {
        return $this->theme_name;
    }

    /**
     * Retrieve the version number of the plugin.
     * 
     */
    public function get_theme_version(): string
    {
        return $this->theme_version;
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     */
    public function init_hooks(): void
    {
        $this->loader->run_hooks();
    }

    /**
     * Define all hooks & register shortcodes.
     * 
     */
    private function define_admin_hooks(): void
    {

        $plugin_admin = Admin\TFLD_Admin::get_instance();
        $plugin_admin->init($this->get_theme_name(), $this->get_theme_version());
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'tfld_enqueue_admin_assets');

        $plugin_admin_pages = Admin\TFLD_Admin_Pages::get_instance();
        $this->loader->add_action('admin_menu', $plugin_admin_pages, 'tfld_simple_settings_page');
        $this->loader->add_action('admin_init', $plugin_admin_pages, 'tfld_simple_description_options');
        $this->loader->add_action('admin_init', $plugin_admin_pages->admin_form_init(), 'tfld_simple_admin_form_init');
        $this->loader->add_action('admin_init', $plugin_admin_pages->main_form_init(), 'tfld_simple_main_form_init');
    }

    private function define_public_hooks(): void
    {

        $plugin_public = Frontend\TFLD_Public::get_instance();
        $plugin_public->init($this->get_theme_name(), $this->get_theme_version());
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'tfld_enqueue_frontend_assets');
    }

    private function define_template_hooks(): void
    {

        $plugin_templates = Templates\TFLD_Templates::get_instance();
        $this->loader->add_filter('single_template', $plugin_templates, 'tfld_template_course');
        $this->loader->add_filter('template_include', $plugin_templates, 'tfld_template_arcive_courses');
    }

    private function define_cpt_hooks(): void
    {

        $plugin_cpt = CPT\TFLD_CPT::get_instance();
        $this->loader->add_filter('init', $plugin_cpt, 'tfld_register_cpt');

        $plugin_select_editor = CPT\TFLD_Select_Editor::get_instance();
        $this->loader->add_action('add_meta_boxes', $plugin_select_editor, 'tfld_select_editor_main');
        $this->loader->add_action('save_post', $plugin_select_editor, 'tfld_save_editor');

        $plugin_courses_details = CPT\TFLD_Courses_Details::get_instance();
        $this->loader->add_action('add_meta_boxes', $plugin_courses_details, 'tfld_courses_details_main');
        $this->loader->add_action('save_post', $plugin_courses_details, 'tfld_save_course_details');
        $this->loader->add_action('after_switch_theme', $plugin_courses_details, 'tfld_create_database_table');
    }

    private function define_taxonomy_hooks(): void
    {

        $plugin_taxonomies = Taxonomies\TFLD_Taxonomies::get_instance();
        // Professors CPT
        $this->loader->add_filter('init', $plugin_taxonomies, 'tfld_register_curriculum_taxonomy', 0);
        $this->loader->add_action('save_post', $plugin_taxonomies, 'tfld_insert_curriculum_taxonomy_terms', 100, 2);
        // Courses CPT
        $this->loader->add_filter('init', $plugin_taxonomies, 'tfld_register_courses_taxonomies', 0);
        $this->loader->add_action('save_post', $plugin_taxonomies, 'tfld_set_default_object_terms', 100, 2);
        $this->loader->add_action('init', $plugin_taxonomies, 'tfld_cleanup_level_taxonomy_terms');
        $this->loader->add_action('init', $plugin_taxonomies, 'tfld_insert_level_taxonomy_terms', 999);
        $this->loader->add_action('add_meta_boxes', $plugin_taxonomies, 'tfld_level_meta_box');
        $this->loader->add_action('save_post', $plugin_taxonomies, 'tfld_save_level_taxonomy');
    }

    private function define_shortcode_hooks(): void
    {

        $plugin_shortcode = Shortcodes\TFLD_Shortcodes::get_instance();
        // Usage echo do_shortcode('[swiper_slider_01]');
        $this->loader->add_shortcode('swiper_slider_01', $plugin_shortcode, 'tfld_swiper_shortcode');
        // Usage echo do_shortcode('[ajax_load_more]');
        $this->loader->add_shortcode('ajax_load_more', $plugin_shortcode, 'tfld_ajax_lm_shortcode');
    }

    private function define_ajax_hooks(): void
    {

        $plugin_ajax_vote = Ajax\TFLD_Ajax_Vote::get_instance();
        $this->loader->add_action('wp_ajax_tfld_ajax_user_vote', $plugin_ajax_vote, 'tfld_ajax_user_vote');
        $this->loader->add_action('wp_ajax_nopriv_tfld_ajax_must_login', $plugin_ajax_vote, 'tfld_ajax_must_login');

        $plugin_ajax_load_more = Ajax\TFLD_Ajax_Load_More::get_instance();
        $this->loader->add_action('wp_ajax_load_more', $plugin_ajax_load_more, 'tfld_ajax_load_more_posts');
        $this->loader->add_action('wp_ajax_nopriv_load_more', $plugin_ajax_load_more, 'tfld_ajax_load_more_posts');
    }

    private function define_gdpr_hooks(): void
    {

        $plugin_woo_gdpr = GDPR\TFLD_Woo_GDPR::get_instance();
        $this->loader->add_action('comment_form_logged_in_after', $plugin_woo_gdpr, 'tfld_additional_fields');
        $this->loader->add_action('comment_form_after_fields', $plugin_woo_gdpr, 'tfld_additional_fields');
        $this->loader->add_action('comment_post', $plugin_woo_gdpr, 'tfld_save_comment_meta_data');
        $this->loader->add_filter('preprocess_comment', $plugin_woo_gdpr, 'tfld_verify_comment_meta_data');
        $this->loader->add_action('add_meta_boxes_comment', $plugin_woo_gdpr, 'tfld_extend_comment_add_meta_box');
        $this->loader->add_action('edit_comment', $plugin_woo_gdpr, 'tfld_extend_comment_edit_metafields');
    }
}
