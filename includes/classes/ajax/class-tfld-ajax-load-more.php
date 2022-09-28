<?php defined('WPINC') or die();

/**
 * Ajax load More
 *
 * @package TFLD Simple Features
 * 
 */

namespace TFLD\Includes\Ajax;

use TFLD\Includes\Abstracts\TFLD_Singleton;
use \WP_Query;

if (!class_exists('TFLD_Ajax_Load_More', false)) : class TFLD_Ajax_Load_More extends TFLD_Singleton
	{
		/**
		 * Protected class constructor to prevent direct object creation
		 *
		 */
		protected function __construct()
		{
		}

		public function tfld_ajax_load_more_posts(): void
		{

			if (!check_ajax_referer('load_more_post_nonce', 'ajax_nonce', false)) {
				wp_send_json_error(__('Invalid security token.', 'tfldframework'));
				wp_die('0', 400);
			}

			// Check if it's an ajax call.
			$is_ajax_request = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

			/**
			 * Page number.
			 * If get_query_var( 'paged' ) is 2 or more, its a number pagination query.
			 * If $_POST['page'] has a value which means its a loadmore request, which will take precedence.
			 */
			$page_no = get_query_var('paged') ? get_query_var('paged') : 1;
			$page_no = !empty($_POST['page']) ? filter_var($_POST['page'], FILTER_VALIDATE_INT) + 1 : $page_no;

			// Default Argument.
			$args = [
				'post_type'      => 'courses',
				'post_status'    => 'publish',
				'posts_per_page' => 2,
				'paged'          => $page_no,
			];

			$query = new WP_Query($args);

			if ($query->have_posts()) :
				// Loop Posts.
				while ($query->have_posts()) : $query->the_post();
					include TFLD_FRAMEWORK_DIR . '/template-parts/components/course-card.php';
				endwhile;

			else :
				// Return response as zero, when no post found.
				wp_die('0');
			endif;

			wp_reset_postdata();

			/**
			 * Check if its an ajax call
			 *
			 * @see https://wordpress.stackexchange.com/questions/116759/why-does-wordpress-add-0-zero-to-an-ajax-response
			 */
			if ($is_ajax_request) {
				wp_die();
			}
		}
	}
endif;
