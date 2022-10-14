<?php defined('WPINC') or die();

/**
 * GDPR checkbox for Woocommerce product review.
 * This is a standalone plugin!
 *
 * @package TFLD Simple Features 
 */

namespace TFLD\Includes\GDPR;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Woo_GDPR', false)) : class TFLD_Woo_GDPR extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {

            add_action('comment_form_logged_in_after', [$this, 'tfld_additional_fields']);
            add_action('comment_form_after_fields', [$this, 'tfld_additional_fields']);
            add_action('comment_post', [$this, 'tfld_save_comment_meta_data']);
            add_filter('preprocess_comment', [$this, 'tfld_verify_comment_meta_data']);
            add_action('add_meta_boxes_comment', [$this, 'tfld_extend_comment_add_meta_box']);
            add_action('edit_comment', [$this, 'tfld_extend_comment_edit_metafields']);
        }

        function tfld_additional_fields()
        {

            echo '<p class="comment-form-consent">' .
                '<input type="checkbox" id="consent" name="consent" checked>
                <label for="consent">' . sprintf(__('By using this form you agree with the storage and handling of your data by this website %s">GTC</a>', 'tfldframework'), '<a href="' . esc_url(home_url('/gtc/'))) . '<span class="required"> *</span></label>
            </p>';
        }

        // Save the comment meta data along with comment


        function tfld_save_comment_meta_data($comment_id)
        {
            if ((isset($_POST['consent'])) && ($_POST['consent'] != ''))
                $rating = wp_filter_nohtml_kses($_POST['consent']);
            add_comment_meta($comment_id, 'consent', $rating);
        }

        // Add the filter to check whether the comment meta data has been filled
        function tfld_verify_comment_meta_data($commentdata)
        {
            if (!isset($_POST['consent']))
                wp_die(__('Error: You did not consent.', 'tfldframework'));
            return $commentdata;
        }

        /**
         * Dashboard
         *
         */
        // Add an edit option to comment editing screen  
        function tfld_extend_comment_add_meta_box()
        {
            add_meta_box(
                'title',
                __('ABG comment checkbox'),
                [$this, 'extend_comment_meta_box'],
                'comment',
                'normal',
                'high'
            );
        }

        function extend_comment_meta_box($comment)
        {
            $consent = get_comment_meta($comment->comment_ID, 'consent', true);
            wp_nonce_field('extend_comment_update', 'extend_comment_update', false);
?>
            <p>
                <label for="consent"><?php _e('Consent: ', 'tfldframework'); ?></label>
                <span class="consentchecked">
                    <?php
                    if ($consent) {
                        $checked = 'checked';
                    } else {
                        $checked = '';
                    }
                    echo '<input type="checkbox" id="consent" name="consent" ' . $checked . '>';
                    ?>
                </span>
            </p>
<?php
        }

        // Update comment meta data from comment editing screen 
        function tfld_extend_comment_edit_metafields($comment_id)
        {
            if (!isset($_POST['extend_comment_update']) || !wp_verify_nonce($_POST['extend_comment_update'], 'extend_comment_update')) return;

            if ((isset($_POST['consent'])) && ($_POST['consent'] != '')) :
                $consent = wp_filter_nohtml_kses($_POST['consent']);
                update_comment_meta($comment_id, 'consent', $consent);
            else :
                delete_comment_meta($comment_id, 'consent');
            endif;
        }
    }
endif;
