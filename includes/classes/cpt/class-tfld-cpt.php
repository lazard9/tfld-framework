<?php defined( 'WPINC' ) or die();

/**
 * Load Custom Post Types
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\CPT;
use TFLD\Includes\Abstracts\TFLD_Singleton;

if ( ! class_exists( 'TFLD_CPT', false ) ) : class TFLD_CPT extends TFLD_Singleton
{
    /**
     * Protected class constructor to prevent direct object creation
     *
     */
    protected function __construct() {
    }

    function tfld_register_cpt() {

        $this->tfld_register_courses_cpt();
        $this->tfld_register_professors_cpt();

    }

    function tfld_register_courses_cpt() : void {

        /**
         * Register a custom post type called "courses".
         *
         * @see get_post_type_labels() for label keys.
         */
        $labels = array(
            'name'                  => _x( 'Courses', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'Course', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'Courses', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'Course', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New Course', 'textdomain' ),
            'new_item'              => __( 'New Course', 'textdomain' ),
            'edit_item'             => __( 'Edit Course', 'textdomain' ),
            'view_item'             => __( 'View Course', 'textdomain' ),
            'all_items'             => __( 'All Courses', 'textdomain' ),
            'search_items'          => __( 'Search Courses', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent Courses:', 'textdomain' ),
            'not_found'             => __( 'No Courses found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No Courses found in Trash.', 'textdomain' ),
            'featured_image'        => _x( 'Course Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'archives'              => _x( 'Course archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
            'insert_into_item'      => _x( 'Insert into course', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this course', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
            'filter_items_list'     => _x( 'Filter courses list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
            'items_list_navigation' => _x( 'Courses list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
            'items_list'            => _x( 'Courses list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
        );
    
        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'course' ),
            'capability_type'    => 'post',
            'has_archive'        => 'courses',
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-database-view',
            // 'show_in_rest'       => true,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        );
    
        register_post_type( 'courses', $args );

    }

    function tfld_register_professors_cpt() {
        /**
         * Register a custom post type called "Professors".
         *
         * @see get_post_type_labels() for label keys.
         */
        
        $labels = array(
            'name'                  => _x( 'Professors', 'Post type general name', 'textdomain' ),
            'singular_name'         => _x( 'Professor', 'Post type singular name', 'textdomain' ),
            'menu_name'             => _x( 'Professors', 'Admin Menu text', 'textdomain' ),
            'name_admin_bar'        => _x( 'Professor', 'Add New on Toolbar', 'textdomain' ),
            'add_new'               => __( 'Add New', 'textdomain' ),
            'add_new_item'          => __( 'Add New Professor', 'textdomain' ),
            'new_item'              => __( 'New Professor', 'textdomain' ),
            'edit_item'             => __( 'Edit Professor', 'textdomain' ),
            'view_item'             => __( 'View Professor', 'textdomain' ),
            'all_items'             => __( 'All Professors', 'textdomain' ),
            'search_items'          => __( 'Search Professors', 'textdomain' ),
            'parent_item_colon'     => __( 'Parent Professors:', 'textdomain' ),
            'not_found'             => __( 'No Professors found.', 'textdomain' ),
            'not_found_in_trash'    => __( 'No Professors found in Trash.', 'textdomain' ),
            'featured_image'        => _x( 'Professor Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
            'archives'              => _x( 'Professor archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
            'insert_into_item'      => _x( 'Insert into professor', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
            'uploaded_to_this_item' => _x( 'Uploaded to this professor', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
            'filter_items_list'     => _x( 'Filter professors list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
            'items_list_navigation' => _x( 'Professors list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
            'items_list'            => _x( 'Professors list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array( 'slug' => 'professor' ),
            'capability_type'    => 'post',
            'has_archive'        => 'professors',
            'hierarchical'       => false,
            'menu_position'      => null,
            'menu_icon'          => 'dashicons-businessperson',
            // 'show_in_rest'       => true,
            'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
        );

        register_post_type( 'professors', $args );

    }

} endif;
