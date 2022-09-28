<?php defined('WPINC') or die();

/**
 * The admin-specific public functionality of the plugin.
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\Admin\settings;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Main_Form', false)) : class TFLD_Main_Form extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        public function tfld_simple_main_form_init(): void
        {
            // If Theme settings don't exist, then create them
            if (false == get_option('tfld_main_settings')) {
                add_option('tfld_main_settings');
            }

            // Define (at least) one section for our fields
            add_settings_section(
                // Unique identifier for the section
                'tfld_main_settings_section',
                // Section Title
                __('Theme settings section', 'tfldframework'),
                // Callback for an optional description
                [$this, 'tfld_main_settings_section_callback'],
                // Admin page to add section to
                'tfld_settings'
            );

            // Checkbox Field for Ajax Infinite Scrolling
            add_settings_field(
                'tfld_main_settings_checkbox_ajax',
                __('Infinite scroll for courses archive:', 'tfldframework'),
                [$this, 'tfld_main_settings_ajax_checkbox_callback'],
                'tfld_settings',
                'tfld_main_settings_section',
                [
                    'label' => '*Check to enable.'
                ]
            );

            // Checkbox Field for CPT
            add_settings_field(
                'tfld_main_settings_checkbox_cpt',
                __('Remove all professors and course:', 'tfldframework'),
                [$this, 'tfld_main_settings_cpt_checkbox_callback'],
                'tfld_settings',
                'tfld_main_settings_section',
                [
                    'label' => '*Leave unchecked to preserve data for later use.'
                ]
            );

            // Checkbox Field for Taxonomies
            add_settings_field(
                'tfld_main_settings_checkbox_taxonomies',
                __('Remove all categories and tags:', 'tfldframework'),
                [$this, 'tfld_main_settings_taxonomies_checkbox_callback'],
                'tfld_settings',
                'tfld_main_settings_section',
                [
                    'label' => '*Leave unchecked to preserve data for later use.'
                ]
            );

            // Checkbox Field for Database Table
            add_settings_field(
                'tfld_main_settings_database',
                __('Remove data from the database:', 'tfldframework'),
                [$this, 'tfld_main_settings_database_checkbox_callback'],
                'tfld_settings',
                'tfld_main_settings_section',
                [
                    'label' => '*Leave unchecked to preserve data for later use.'
                ]
            );

            // Checkbox Field for Options Data
            add_settings_field(
                'tfld_main_settings_checkbox4',
                __('Remove all options data:', 'tfldframework'),
                [$this, 'tfld_main_settings_options_checkbox_callback'],
                'tfld_settings',
                'tfld_main_settings_section',
                [
                    'label' => '*Leave unchecked to preserve data for later use.'
                ]
            );

            register_setting(
                'tfld_main_settings',
                'tfld_main_settings'
            );
        }


        public function tfld_main_settings_section_callback(): void
        {
            esc_html_e('By cheking the settings options you will erase all data upon removing the plugin!', 'tfldframework');
        }

        public function tfld_main_settings_ajax_checkbox_callback($args): void
        {
            $options = get_option('tfld_main_settings');

            $checkbox = '';
            if (isset($options['checkbox-ajax'])) {
                $checkbox = esc_html($options['checkbox-ajax']);
            }

            $html = '<input type="checkbox" id="tfld_main_settings_checkbox" name="tfld_main_settings[checkbox-ajax]" value="1"' . checked(1, $checkbox, false) . '/>';
            $html .= '&nbsp;';
            $html .= '<label for="tfld_main_settings_checkbox">' . $args['label'] . '</label>';

            echo $html;
        }

        public function tfld_main_settings_cpt_checkbox_callback($args): void
        {
            $options = get_option('tfld_main_settings');

            $checkbox = '';
            if (isset($options['checkbox-cpt'])) {
                $checkbox = esc_html($options['checkbox-cpt']);
            }

            $html = '<input type="checkbox" id="tfld_main_settings_checkbox" name="tfld_main_settings[checkbox-cpt]" value="1"' . checked(1, $checkbox, false) . '/>';
            $html .= '&nbsp;';
            $html .= '<label for="tfld_main_settings_checkbox">' . $args['label'] . '</label>';

            echo $html;
        }

        public function tfld_main_settings_taxonomies_checkbox_callback($args): void
        {
            $options = get_option('tfld_main_settings');

            $checkbox = '';
            if (isset($options['checkbox-taxonomies'])) {
                $checkbox = esc_html($options['checkbox-taxonomies']);
            }

            $html = '<input type="checkbox" id="tfld_main_settings_checkbox" name="tfld_main_settings[checkbox-taxonomies]" value="1"' . checked(1, $checkbox, false) . '/>';
            $html .= '&nbsp;';
            $html .= '<label for="tfld_main_settings_checkbox">' . $args['label'] . '</label>';

            echo $html;
        }

        public function tfld_main_settings_database_checkbox_callback($args): void
        {
            $options = get_option('tfld_main_settings');

            $checkbox = '';
            if (isset($options['checkbox-database'])) {
                $checkbox = esc_html($options['checkbox-database']);
            }

            $html = '<input type="checkbox" id="tfld_main_settings_checkbox" name="tfld_main_settings[checkbox-database]" value="1"' . checked(1, $checkbox, false) . '/>';
            $html .= '&nbsp;';
            $html .= '<label for="tfld_main_settings_checkbox">' . $args['label'] . '</label>';

            echo $html;
        }

        public function tfld_main_settings_options_checkbox_callback($args): void
        {
            $options = get_option('tfld_main_settings');

            $checkbox = '';
            if (isset($options['checkbox-settings'])) {
                $checkbox = esc_html($options['checkbox-settings']);
            }

            $html = '<input type="checkbox" id="tfld_main_settings_checkbox" name="tfld_main_settings[checkbox-settings]" value="1"' . checked(1, $checkbox, false) . '/>';
            $html .= '&nbsp;';
            $html .= '<label for="tfld_main_settings_checkbox">' . $args['label'] . '</label>';

            echo $html;
        }
    }
endif;
