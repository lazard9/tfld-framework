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


    /**
     * Protected class constructor to prevent direct object creation
     *
     * This is meant to be overridden in the classes which implement
     * this trait. This is ideal for doing stuff that you only want to
     * do once, such as hooking into actions and filters, etc.
     */
    protected function __construct()
    {

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
        
        Admin\TFLD_Admin::get_instance();
        Frontend\TFLD_Public::get_instance();
        Templates\TFLD_Templates::get_instance();
        CPT\TFLD_CPT::get_instance();
        CPT\TFLD_Select_Editor::get_instance();
        CPT\TFLD_Courses_Details::get_instance();
        Taxonomies\TFLD_Taxonomies::get_instance();
        Shortcodes\TFLD_Shortcodes::get_instance();
        Ajax\TFLD_Ajax_Vote::get_instance();
        Ajax\TFLD_Ajax_Load_More::get_instance();
        GDPR\TFLD_Woo_GDPR::get_instance();
    }
}
