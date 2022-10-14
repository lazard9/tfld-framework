<?php defined( 'WPINC' ) or die();

/**
 * Meta Boxes
 *
 * @package TFLD Simple Features
 * 
 */

namespace TFLD\Includes\CPT;
use TFLD\Includes\Abstracts\TFLD_Singleton;

if ( ! class_exists( 'TFLD_Courses_Details', false ) ) : class TFLD_Courses_Details extends TFLD_Singleton
{
    /**
     * Protected class constructor to prevent direct object creation
     *
     */
    protected function __construct() {
        
        // load class.
		$this->setup_hooks();
    }

    function setup_hooks() {

        add_action('add_meta_boxes', [$this, 'tfld_courses_details_main']);
        add_action('save_post', [$this, 'tfld_save_course_details']);
        add_action('after_switch_theme', [$this, 'tfld_create_database_table']);
    }

    /*
     * Metabox - Add Custom Fields - Courses
     * For CPT Courses
     * 
     */
    public function tfld_courses_details_main() : void {

        add_meta_box(
            'tfld_courses_details_main',    	// ID
            'Courses Custom Field',         	// Title
            [$this, 'tfld_courses_details'],    // Function
            'courses',                    	    // Custom Post Type
            'normal',                       	// Priority
            'low',                          	// Position Up/Down
        );

    }

    public function tfld_courses_details( $post_id ) : void {

        global $wpdb;
        // $ID = get_the_id();
        $ourdb = $wpdb->prefix . 'ld_course_details';
        $subtitle = $wpdb->get_var("SELECT `subtitle` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");
        $price = $wpdb->get_var("SELECT `price` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");
        $video = $wpdb->get_var("SELECT `video` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");
        $curriculum = $wpdb->get_var("SELECT `content` FROM `$ourdb` WHERE `ID` = ".$post_id->ID."");

        echo <<<END
            <div class="bg-blue-1 pad">
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Subtitle</h3>
                    <input type="text" name="subtitle" value="{$subtitle}" class="col-85" />
                </div>
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Price</h3>
                    <input type="text" name="price" value="{$price}" class="col-85" />
                </div>
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Video Trailer</h3>
                    <input type="text" name="video-trailer" value="{$video}" class="col-85" />
                </div>
                <div class="bg-blue-2 ma center pad-b b-r">
                    <h3>Curriculum</h3>
                    <input type="text" name="curriculum" value="{$curriculum}" class="col-85" />
                </div>
            </div>
        END; // Heredoc https://www.php.net/manual/en/language.types.string.php#language.types.string.syntax.heredoc
        
    }

    /* Save Course Details to the DB */
    public function tfld_save_course_details() : void {

		$post_type = get_post_type();

		if ( $post_type == 'courses' ) {

			global $wpdb, $post;
			
			// $ID             = get_the_id();
			$title          = get_the_title();
			$thumbnail      = get_the_post_thumbnail_url();
			$price          = $_POST["price"];
			$subtitle       = $_POST["subtitle"];
			$video_trailer  = $_POST["video-trailer"];
			$curriculum     = $_POST["curriculum"];

			$wpdb->insert(
				$wpdb->prefix . 'ld_course_details', // DB table name
				[
					'ID'        => $post->ID 
				]
			);

			$wpdb->update(
				$wpdb->prefix . 'ld_course_details',
				[
					'title'     => $title,
					'thumbnail' => $thumbnail,
					'price'     => $price,
					'subtitle'  => $subtitle,
					'video'     => $video_trailer,
					'content'   => $curriculum,
				],
				[
					'ID'        => $post->ID // ID of post to be updated
				]
			);

		}
            
    }

    /**
     * On purpose in activation hook for testing!
     * Create Database Table - course_details.
     * 
     */
    public function tfld_create_database_table(): void
    {

        global $wpdb;

        $database_table_name = $wpdb->prefix . 'ld_course_details';
        $charset = $wpdb->get_charset_collate(); // DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci;
        $course_details = "CREATE TABLE IF NOT EXISTS $database_table_name(
            ID          INT(9) NOT NULL,
            title       TEXT(100) NOT NULL,
            subtitle    TEXT(500) NOT NULL,
            video       varchar(100) NOT NULL,
            price       DOUBLE(10,2) NOT NULL,
            thumbnail   TEXT NOT NULL,
            content     TEXT NOT NULL,
            PRIMARY KEY (ID)
        ) $charset; ";
        include_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($course_details);
    }

} endif;