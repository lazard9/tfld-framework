<?php defined( 'WPINC' ) or die();

/**
 * Meta Boxes
 *
 * @package TFLD Simple Features
 * 
 */

namespace TFLD\Includes\CPT;
use TFLD\Includes\Abstracts\TFLD_Singleton;
use \WP_User_Query;

if ( ! class_exists( 'TFLD_Select_Editor', false ) ) : class TFLD_Select_Editor extends TFLD_Singleton
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

        add_filter('add_meta_boxes', [$this, 'tfld_select_editor_main']);
        add_filter('save_post', [$this, 'tfld_save_editor']);
    }

    /*
     * Metabox - Select Editor 
     * For CPT Courses and default Posts
     * 
     */
    public function tfld_select_editor_main() : void {

		add_meta_box(
            'tfld_editor_id', 
            'Post Editor', 
            [$this, 'tfld_meta_box_html'], 
            ['courses', 'post'], 
            'normal', 
            'low'
        );

	}

	public function tfld_save_editor( $post_id ) : void {

        // var_dump($_POST['tfld_post_editor']);

		if( isset($_POST['tfld_post_editor']) && is_numeric($_POST['tfld_post_editor']) ) {

			$editor_id = sanitize_text_field($_POST['tfld_post_editor']);

			update_post_meta($post_id, 'tfld_post_editor', $editor_id );

		}

	}

	public function tfld_meta_box_html() : void {

		$user_query = new WP_User_Query([
			'role' => 'editor',
			'number' => '-1',
			'fields' => [
				'display_name',
				'ID',
			],
		]);

		$editors = $user_query->get_results();

		if( ! empty( $editors ) ) {

		    $select_editor = '<label for="post_editor">Editor: </label>';
			$select_editor .= '<select name="tfld_post_editor" id="post_editor">';
			$select_editor .= '<option> - Select One -</option>';			
            foreach ($editors as $editor) {
                $select_editor .= '<option value="'.$editor->ID.'" '. selected(get_post_meta(get_the_ID(), 'tfld_post_editor', true ), $editor->ID, false).'>'.$editor->display_name.'</option>';
            }
            $select_editor .= '</select>';
            
            echo $select_editor;

		} else {
			echo '<p>No Editors Found.</p>';
		}

	}

} endif;
