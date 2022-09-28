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
        }

        public function init($theme_name, $theme_version): void
        {

            $this->theme_name = $theme_name;
            $this->theme_version = $theme_version;
        }

        /**
         * Register admin assets.
         *
         */
        public function tfld_enqueue_admin_assets(): void
        {

            wp_enqueue_style(
                $this->theme_name . '-admin-style',
                TFLD_FRAMEWORK_URL . '/assets/build/css/admin.css',
                [],
                $this->theme_version
            );

            wp_enqueue_script(
                $this->theme_name . "-main",
                TFLD_FRAMEWORK_URL . '/assets/build/js/admin.bundle.js',
                [],
                $this->theme_version,
                true
            );
        }
    }
endif;
