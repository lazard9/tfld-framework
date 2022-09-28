<?php defined('WPINC') or die();

/**
 * The admin-specific functionality of the plugin.
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\Admin;

use TFLD\Includes\Abstracts\TFLD_Singleton;
use TFLD\Includes\Admin\Settings\TFLD_Admin_Form;
use TFLD\Includes\Admin\Settings\TFLD_Main_Form;

if (!class_exists('TFLD_Admin_Pages', false)) : class TFLD_Admin_Pages extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        public function admin_form_init(): object
        {
            return new TFLD_Admin_Form;
        }

        public function main_form_init(): object
        {
            return new TFLD_Main_Form;
        }

        /**
         * Admin pages & sub pages.
         * 
         */
        public function tfld_simple_settings_page(): void
        {

            add_menu_page(
                __('Simple Features Theme Options', 'tfldframework'), // Name of the Theme
                __('TFLD', 'tfldframework'), // Menu name of the Theme
                'manage_options',
                'tfld_settings',
                [$this, 'tfld_simple_settings_page_markup'],
                'dashicons-screenoptions',
                100
            );

            // add_submenu_page( string $parent_slug, string $page_title, string $menu_title, string $capability, string $menu_slug, callable $callback = '', int|float $position = null )
            add_submenu_page(
                'tfld_settings',
                __('TFLD various form fields', 'tfldframework'),
                __('Form', 'tfldframework'),
                'manage_options',
                'tfld_form',
                [$this, 'tfld_simple_form_subpage_markup'],
            );

            add_submenu_page(
                'tfld_settings',
                __('TFLD Description', 'tfldframework'),
                __('Description', 'tfldframework'),
                'manage_options',
                'tfld_description',
                [$this, 'tfld_simple_descriptio_subpage_markup']
            );

            /**
             * Adds a submenu page for the CPT Courses.
             * 
             */
            add_submenu_page(
                'edit.php?post_type=courses',
                __('TFLD Simple Default Sub Page', 'tfldframework'),
                __('TFLD Sub Page', 'tfldframework'),
                'manage_options',
                'tfld_subpage',
                [$this, 'tfld_simple_courses_submenu_page_markup'],
            );

            /**
             * Adds a submenu page for the management page (tools).
             * 
             */
            // Can add page as a submenu using the following:
            // add_dashboard_page()
            // add_posts_page()
            // add_media_page()
            // add_pages_page()
            // add_comments_page()
            // add_theme_page()
            // add_plugins_page()
            // add_users_page()
            // add_management_page()
            // add_options_page()

            add_management_page(
                __('TFLD Simple Sub Page Info', 'tfldframework'),
                __('TFLD Info', 'tfldframework'),
                'manage_options',
                'tfld_info',
                [$this, 'tfld_simple_management_submenu_page_markup']
            );
        }

        /**
         * Display callback for the menu page.
         * 
         */
        public function tfld_simple_settings_page_markup(): void
        {
            // Double check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }

            include TFLD_FRAMEWORK_DIR . '/includes/classes/admin/templates/template-main.php';
        }

        /**
         * Display callback for the Form submenu page.
         * 
         */
        public function tfld_simple_form_subpage_markup(): void
        {
            // Double check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }

            include TFLD_FRAMEWORK_DIR . '/includes/classes/admin/templates/template-form.php';
        }

        /**
         * Add and save options (tfld_simple_options)
         * for the Description submenu page.
         * 
         */
        public function tfld_simple_description_options()
        {

            // $options = [
            //   'First Name',
            //   'Second Option',
            //   'Third Option'
            // ];

            $options = [];
            $options['name']      = 'Lazar Dacic';
            $options['location']  = 'Serbia';
            $options['sponsor']   = 'Theme Dev. Co.';

            if (!get_option('tfld_simple_options')) {
                add_option('tfld_simple_options', $options);
            }
            update_option('tfld_simple_options', $options);
            // delete_option( 'tfld_simple_options' );

        }

        /**
         * Display callback for the Description submenu page.
         * 
         */
        function tfld_simple_descriptio_subpage_markup()
        {
            // Double check user capabilities
            if (!current_user_can('manage_options')) {
                return;
            }

            include TFLD_FRAMEWORK_DIR . '/includes/classes/admin/templates/template-description.php';
        }

        /**
         * Display callback for CPT Courses the submenu page.
         * 
         */
        public function tfld_simple_courses_submenu_page_markup(): void
        {

            include TFLD_FRAMEWORK_DIR . '/includes/classes/admin/templates/template-cpt-courses.php';
        }

        /**
         * Display callback for the submenu management (tools) page.
         * 
         */
        public function tfld_simple_management_submenu_page_markup(): void
        {

            include TFLD_FRAMEWORK_DIR . '/includes/classes/admin/templates/template-management.php';
        }
    }
endif;
