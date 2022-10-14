<?php defined('WPINC') or die();

/**
 * Ajax Vote
 *
 * @package TFLD Simple Features
 * 
 */

namespace TFLD\Includes\Ajax;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Ajax_Vote', false)) : class TFLD_Ajax_Vote extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
            
            // load class.
            $this->setup_hooks();
        }

        function setup_hooks() {

            add_action('wp_ajax_tfld_ajax_user_vote', [$this, 'tfld_ajax_user_vote']);
            add_action('wp_ajax_nopriv_tfld_ajax_must_login', [$this, 'tfld_ajax_must_login']);
        }

        function tfld_ajax_user_vote(): void
        {

            if (!wp_verify_nonce($_REQUEST['nonce'], "ajax_user_vote_nonce")) {
                exit("No naughty business please");
            }

            $vote_count = get_post_meta($_REQUEST["post_id"], "votes", true);
            $vote_count = ($vote_count == '') ? 0 : $vote_count;
            $new_vote_count = $vote_count + 1;

            $vote = update_post_meta($_REQUEST["post_id"], "votes", $new_vote_count);

            if ($vote === false) {
                $result['type'] = "error";
                $result['vote_count'] = $vote_count;
            } else {
                $result['type'] = "success";
                $result['vote_count'] = $new_vote_count;
            }

            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $result = json_encode($result);
                echo $result;
            } else {
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }

            die();
        }

        function tfld_ajax_must_login(): void
        {
            echo "You must log in to vote";
            die();
        }
    }
endif;
