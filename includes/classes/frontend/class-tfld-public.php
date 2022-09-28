<?php defined('WPINC') or die();

/**
 * The public-facing functionality of the plugin.
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\Frontend;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Public', false)) : class TFLD_Public extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        public function init($theme_name, $theme_version): void
        {

            $this->theme_name = $theme_name;
            $this->theme_version = $theme_version;
        }

        /**
         * Register frontend assets for the public-facing side of the site.
         *
         */
        public function tfld_enqueue_frontend_assets(): void
        {

            /**
             * Check if Swiper plugin is active,
             * to prevent double loading of the same resources.
             * 
             */
            if (!is_plugin_active('wp-swiper/wp-swiper.php')) {

                wp_enqueue_style(
                    $this->theme_name . '-swiper-bundle',
                    TFLD_FRAMEWORK_URL . '/assets/vendor/css/swiper-bundle.min.css',
                    [],
                    $this->theme_version
                );

                wp_enqueue_script(
                    $this->theme_name . '-swiper-bundle',
                    TFLD_FRAMEWORK_URL . '/assets/vendor/js/swiper-bundle.min.js',
                    NULL,
                    $this->theme_version,
                    true
                );
            }

            wp_enqueue_style(
                $this->theme_name . '-frontend-style',
                TFLD_FRAMEWORK_URL . '/assets/build/css/frontend.css',
                [],
                $this->theme_version
            );

            wp_enqueue_script(
                $this->theme_name . "-frontend-script",
                TFLD_FRAMEWORK_URL . '/assets/build/js/frontend.bundle.js',
                ['jquery'],
                $this->theme_version,
                true
            );

            wp_localize_script(
                $this->theme_name . "-frontend-script",
                'ajaxConfig',
                [
                    'ajaxUrl' => admin_url('admin-ajax.php'),
                    'ajax_nonce' => wp_create_nonce('load_more_post_nonce'),
                    'enable_infinite_scroll' => get_option('tfld_main_settings') ?? ['checkbox-ajax']
                ]
            );
        }
    }
endif;
