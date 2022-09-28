<?php defined('WPINC') or die();

/**
 * Load Custom Taxonomies for CPT Courses
 *
 * @package TFLD Simple Features
 * 
 */

namespace TFLD\Includes\Taxonomies;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Taxonomies', false)) : class TFLD_Taxonomies extends TFLD_Singleton
    {
        /**
         * Protected class constructor to prevent direct object creation
         *
         */
        protected function __construct()
        {
        }

        /**
         * Professors CPT taxonomy
         *
         */
        function tfld_register_curriculum_taxonomy(): void
        {

            /**
             * Hierarchical taxonomy ~ Categories
             *
             */
            $labels = array(
                'name' => _x('Curriculums', 'taxonomy general name'),
                'singular_name' => _x('Curriculum', 'taxonomy singular name'),
                'search_items' =>  __('Search Curriculums'),
                'all_items' => __('All Curriculums'),
                'parent_item' => __('Parent Curriculum'),
                'parent_item_colon' => __('Parent Curriculum:'),
                'edit_item' => __('Edit Curriculum'),
                'update_item' => __('Update Curriculum'),
                'add_new_item' => __('Add New Curriculum'),
                'new_item_name' => __('New Curriculum Name'),
                'menu_name' => __('Curriculums'),
            );

            // Hierarchical taxonomy registration
            register_taxonomy('curriculums', array('professors'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'curriculum'),
            ));
        }

        /*
     * Populate terms for taxonomy Curriculums.
     * 
     */
        public function tfld_insert_curriculum_taxonomy_terms(): void
        {

            $taxonomyName = 'curriculums';

            $terms = [
                "mathematics" => "Mathematics",
                "geography" => "Geography",
                "physics" => "Physics",
                "biology" => "Biology",
                "chemistry" => "Chemistry",
                "computer-science" => "Computer Science",
                "applied-chemistry" => "Applied Chemistry",
            ];

            foreach ($terms as $slug => $term) {
                wp_insert_term($term, $taxonomyName, [
                    'slug' => $slug,
                ]);
            }
        }

        /**
         * Courses CPT taxonomies
         *
         */
        function tfld_register_courses_taxonomies(): void
        {

            /**
             * Level not hierarchical, only one can be selected,
             * and has only 3 choices.
             *
             */
            $labels = array(
                'name' => 'Level',
                'singular_name' => 'Level',
                'search_items' => 'Search Levels',
                'all_items' => 'All Levels',
                'parent_item' => 'Parent Level',
                'parent_item_colon' => 'Parent Field:',
                'edit_item' => 'Edit Level',
                'update_item' => 'Update Level',
                'add_new_item' => 'Add New Level',
                'new_item_name' => 'New Level Name',
                'menu_name' => 'Level'
            );

            register_taxonomy('level', 'courses', array(
                'labels' => $labels,
                'show_in_quick_edit' => false,
                'meta_box_cb' => false,
                'hierarchical' => false,
                'show_in_menu' => false,
                'show_in_nav_menus' => false,
            ));

            /**
             * Hierarchical taxonomy ~ Categories
             *
             */
            $labels = array(
                'name' => _x('Subjects', 'taxonomy general name'),
                'singular_name' => _x('Subject', 'taxonomy singular name'),
                'search_items' =>  __('Search Subjects'),
                'all_items' => __('All Subjects'),
                'parent_item' => __('Parent Subject'),
                'parent_item_colon' => __('Parent Subject:'),
                'edit_item' => __('Edit Subject'),
                'update_item' => __('Update Subject'),
                'add_new_item' => __('Add New Subject'),
                'new_item_name' => __('New Subject Name'),
                'menu_name' => __('Subjects'),
            );

            // Hierarchical taxonomy registration
            register_taxonomy('subjects', array('courses'), array(
                'hierarchical' => true,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'rewrite' => array('slug' => 'subject'),
            ));


            /**
             * Nonhierarchical taxonomy
             *
             */

            $labels = array(
                'name' => _x('Topics', 'taxonomy general name'),
                'singular_name' => _x('Topic', 'taxonomy singular name'),
                'search_items' =>  __('Search Topics'),
                'popular_items' => __('Popular Topics'),
                'all_items' => __('All Topics'),
                'parent_item' => null,
                'parent_item_colon' => null,
                'edit_item' => __('Edit Topic'),
                'update_item' => __('Update Topic'),
                'add_new_item' => __('Add New Topic'),
                'new_item_name' => __('New Topic Name'),
                'separate_items_with_commas' => __('Separate topics with commas'),
                'add_or_remove_items' => __('Add or remove topics'),
                'choose_from_most_used' => __('Choose from the most used topics'),
                'menu_name' => __('Topics'),
            );

            // Non-hierarchical taxonomy registration ~ Tag
            register_taxonomy('topics', 'courses', array(
                'hierarchical' => false,
                'labels' => $labels,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'update_count_callback' => '_update_post_term_count',
                'query_var' => true,
                'rewrite' => array('slug' => 'topic'),
            ));
        }


        /*
     * Set default cat for all CPT Courses taxonomies
     * @source {https://circlecube.com/says/2013/01/set-default-terms-for-your-custom-taxonomy-default/}
     * @source {http://wordpress.mfields.org/2010/set-default-terms-for-your-custom-taxonomies-in-wordpress-3-0/}
     * @license   GPLv2
     */
        public function tfld_set_default_object_terms($post_id, $post): void
        {
            if ('draft' === $post->post_status && $post->post_type === 'courses') {
                $defaults = array(
                    'level' => array('Any'),
                    'subjects' => array('Any'),
                    'topics' => array('Any')
                );
                $taxonomies = get_object_taxonomies($post->post_type);

                foreach ((array) $taxonomies as $taxonomy) {
                    $terms = wp_get_post_terms($post_id, $taxonomy);
                    if (empty($terms) && array_key_exists($taxonomy, $defaults)) {
                        wp_set_object_terms($post_id, $defaults[$taxonomy], $taxonomy);
                    }
                }
            }
        }

        /*
     * Only in array (e.g. 'Any','Beginer','Medium','Advanced') 
     * specified taxonomy terms are included.
     * 
     */
        public function tfld_cleanup_level_taxonomy_terms(): void
        {

            // Define your terms inside this array
            $predefined_terms = array(
                'Any',
                'Beginer',
                'Medium',
                'Advanced'
            );

            // Name your taxonomy here
            $predefined_taxonomy = 'level';

            $all_terms_inside_tax = get_terms(
                array(
                    'taxonomy'     => $predefined_taxonomy,
                    'hide_empty'   => false
                )
            );

            foreach ($all_terms_inside_tax as $term) {
                if (!in_array($term->name, $predefined_terms))
                    wp_delete_term($term->term_id, $predefined_taxonomy);
            }
        }

        /*
     * Populate terms for taxonomy Level. 
     * 
     */
        public function tfld_insert_level_taxonomy_terms(): void
        {

            $taxonomyName = 'level';

            $terms = [
                'Any',
                'Beginer',
                'Medium',
                'Advanced'
            ];

            foreach ($terms as $term) {
                wp_insert_term($term, $taxonomyName);
            }
        }

        /*
     * Add metabox for taxonomy Level.
     * 
     */
        public function tfld_level_meta_box(): void
        {

            add_meta_box(
                'tfld_level_box',
                __('Level', 'tfldframework'),
                [$this, 'tfld_level_meta_box_term'],
                ['courses'],
                'side',
                'high'
            );
        }

        /*
     * Make options radio (can select only singe term) for taxonomy Level. 
     * 
     */
        public function tfld_level_meta_box_term($post): void
        {

            $terms = get_terms(array(
                'taxonomy' => 'level',
                'hide_empty' => false // Retrieve all terms
            ));

            // We assume that there is a single category
            $currentTaxonomyValue = get_the_terms($post->ID, 'level')[0];
?>
            <p>Choose taxonomy value</p>
            <p>
                <?php foreach ($terms as $term) : ?>
                    <input type="radio" name="level" id="taxonomy_term_<?php echo $term->term_id; ?>" value="<?php echo $term->term_id; ?>" <?php if ($term->term_id == $currentTaxonomyValue->term_id) echo "checked"; ?>>
                    <label for="taxonomy_term_<?php echo $term->term_id; ?>"><?php echo $term->name; ?></label>
                    </input><br />
                <?php endforeach; ?>
            </p>
<?php
        }

        /*
     * Save term for taxonomy Level. 
     * 
     */
        function tfld_save_level_taxonomy($post_id): void
        {
            if (isset($_REQUEST['level']))
                wp_set_object_terms($post_id, (int)sanitize_text_field($_POST['level']), 'level');
        }
    }
endif;
