<?php defined('WPINC') or die();

/**
 * The admin-specific functionality of the plugin.
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\Admin;

use TFLD\Includes\Abstracts\TFLD_Singleton;
use TFLD\Includes\Traits\Include_Files;

if (!class_exists('TFLD_Admin', false)) : class TFLD_Admin extends TFLD_Singleton
    {
        use Include_Files;

        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {

            self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/admin/class-tfld-admin-pages.php' );
            self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/admin/settings/class-tfld-admin-form.php' );
            self::include_once( TFLD_FRAMEWORK_DIR . '/includes/classes/admin/settings/class-tfld-main-form.php' );

            TFLD_Admin_Pages::get_instance();
            Settings\TFLD_Admin_Form::get_instance();
            Settings\TFLD_Main_Form::get_instance();

            // load class.
		    $this->setup_hooks();
        }

        public function setup_hooks(): void
        {
            
            add_action('admin_enqueue_scripts', [$this, 'tfld_enqueue_admin_assets']);
        }

        /**
         * Register admin assets.
         *
         */
        public function tfld_enqueue_admin_assets(): void
        {

            wp_enqueue_style(
                "tfld-framework-admin-style",
                TFLD_FRAMEWORK_URL . '/assets/build/css/admin.css',
                [],
                '1.0.0'
            );

            wp_enqueue_script(
                "tfld-framework-main",
                TFLD_FRAMEWORK_URL . '/assets/build/js/admin.bundle.js',
                [],
                '1.0.0',
                true
            );
        }
    }
endif;
