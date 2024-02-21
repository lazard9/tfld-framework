<?php defined('WPINC') or die();

/**
 * Load templates
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\Templates;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Templates', false)) : class TFLD_Templates extends TFLD_Singleton
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

    public function setup_hooks(): void
    {

      add_filter('single_template', [$this, 'tfld_template_course']);
      add_filter('template_include', [$this, 'tfld_template_arcive_courses']);
    }

    /* 
     * Load Single Course Template
     */
    public function tfld_template_course($template)
    {

      // global $post;
      // $post_type = $post->post_type;
      $post_type = get_post_type();

      /* 
       *  Include template for each CPT single view.
       */
      $post_type_object = get_post_type_object($post_type);
      $rewrite_slug = $post_type_object->rewrite['slug'];
      $post_types_array = [
        'courses',
        'professors',
      ];

      if (in_array($post_type, $post_types_array) && file_exists(TFLD_FRAMEWORK_DIR . '/templates/post/template-' .  $rewrite_slug . '.php')) {
        $template = TFLD_FRAMEWORK_DIR . '/templates/post/template-' .  $rewrite_slug . '.php';
      }

      return $template;
    }

    /* 
     * Load Archive Courses Template
     */
    public function tfld_template_arcive_courses($template)
    {
      if (is_post_type_archive('courses') && file_exists(TFLD_FRAMEWORK_DIR . '/templates/archive/archive-courses.php')  ) {
        $template = TFLD_FRAMEWORK_DIR . '/templates/archive/archive-courses.php';
      }

      return $template;
    }
  }
endif;
