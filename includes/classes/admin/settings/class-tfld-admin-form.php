<?php defined('WPINC') or die();

/**
 * The admin-specific public functionality of the plugin.
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\Admin\Settings;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Admin_Form', false)) : class TFLD_Admin_Form extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        public function tfld_simple_admin_form_init(): void
        {
            // If Theme settings don't exist, then create them
            if (false == get_option('tfld_simple_settings')) {
                add_option('tfld_simple_settings');
            }

            // Define (at least) one section for our fields
            add_settings_section(
                // Unique identifier for the section
                'tfld_simple_settings_section',
                // Section Title
                __('Theme Settings Section', 'tfldframework'),
                // Callback for an optional description
                [$this, 'tfld_simple_settings_section_callback'],
                // Admin page to add section to
                'tfld_form'
            );

            // Input Text Field
            add_settings_field(
                // Unique identifier for field
                'tfld_simple_settings_input_text',
                // Field Title
                __('Text Input', 'tfldframework'),
                // Callback for field markup
                [$this, 'tfld_simple_settings_text_input_callback'],
                // Page to go on
                'tfld_form',
                // Section to go in
                'tfld_simple_settings_section'
            );

            // Textarea Field
            add_settings_field(
                'tfld_simple_settings_textarea',
                __('Text Area', 'tfldframework'),
                [$this, 'tfld_simple_settings_textarea_callback'],
                'tfld_form',
                'tfld_simple_settings_section'
            );

            // Checkbox Field
            add_settings_field(
                'tfld_simple_settings_checkbox',
                __('Checkbox', 'tfldframework'),
                [$this, 'tfld_simple_settings_checkbox_callback'],
                'tfld_form',
                'tfld_simple_settings_section',
                [
                    'label' => 'Checkbox Label'
                ]
            );

            // Radio Field
            add_settings_field(
                'tfld_simple_settings_radio',
                __('Radio', 'tfldframework'),
                [$this, 'tfld_simple_settings_radio_callback'],
                'tfld_form',
                'tfld_simple_settings_section',
                [
                    'option_one' => 'Radio 1',
                    'option_two' => 'Radio 2'
                ]
            );

            // Dropdown
            add_settings_field(
                'tfld_simple_settings_select',
                __('Select', 'tfldframework'),
                [$this, 'tfld_simple_settings_select_callback'],
                'tfld_form',
                'tfld_simple_settings_section',
                [
                    'option_one' => 'Select Option 1',
                    'option_two' => 'Select Option 2',
                    'option_three' => 'Select Option 3'
                ]
            );


            register_setting(
                'tfld_simple_settings',
                'tfld_simple_settings'
            );
        }


        public function tfld_simple_settings_section_callback(): void
        {
            esc_html_e('Theme settings section description', 'tfldframework');
        }

        public function tfld_simple_settings_text_input_callback(): void
        {
            $options = get_option('tfld_simple_settings');

            $text_input = '';
            if (isset($options['text_input'])) {
                $text_input = esc_html($options['text_input']);
            }

            echo '<input type="text" id="tfld_simple_customtext" name="tfld_simple_settings[text_input]" value="' . $text_input . '" />';
        }

        public function tfld_simple_settings_textarea_callback(): void
        {
            $options = get_option('tfld_simple_settings');

            $textarea = '';
            if (isset($options['textarea'])) {
                $textarea = esc_html($options['textarea']);
            }

            echo '<textarea id="tfld_simple_settings_textarea" name="tfld_simple_settings[textarea]" rows="5" cols="50">' . $textarea . '</textarea>';
        }

        public function tfld_simple_settings_checkbox_callback($args): void
        {
            $options = get_option('tfld_simple_settings');

            $checkbox = '';
            if (isset($options['checkbox'])) {
                $checkbox = esc_html($options['checkbox']);
            }

            $html = '<input type="checkbox" id="tfld_simple_settings_checkbox" name="tfld_simple_settings[checkbox]" value="1"' . checked(1, $checkbox, false) . '/>';
            $html .= '&nbsp;';
            $html .= '<label for="tfld_simple_settings_checkbox">' . $args['label'] . '</label>';

            echo $html;
        }

        public function tfld_simple_settings_radio_callback($args): void
        {
            $options = get_option('tfld_simple_settings');

            $radio = '';
            if (isset($options['radio'])) {
                $radio = esc_html($options['radio']);
            }

            $html = '<input type="radio" id="tfld_simple_settings_radio_one" name="tfld_simple_settings[radio]" value="1"' . checked(1, $radio, false) . '/>';
            $html .= ' <label for="tfld_simple_settings_radio_one">' . $args['option_one'] . '</label> &nbsp;';
            $html .= '<input type="radio" id="tfld_simple_settings_radio_two" name="tfld_simple_settings[radio]" value="2"' . checked(2, $radio, false) . '/>';
            $html .= ' <label for="tfld_simple_settings_radio_two">' . $args['option_two'] . '</label>';

            echo $html;
        }

        public function tfld_simple_settings_select_callback($args): void
        {
            $options = get_option('tfld_simple_settings');

            $select = '';
            if (isset($options['select'])) {
                $select = esc_html($options['select']);
            }

            $html = '<select id="tfld_simple_settings_options" name="tfld_simple_settings[select]">';

            $html .= '<option value="option_one"' . selected($select, 'option_one', false) . '>' . $args['option_one'] . '</option>';
            $html .= '<option value="option_two"' . selected($select, 'option_two', false) . '>' . $args['option_two'] . '</option>';
            $html .= '<option value="option_three"' . selected($select, 'option_three', false) . '>' . $args['option_three'] . '</option>';

            $html .= '</select>';

            echo $html;
        }
    }
endif;
