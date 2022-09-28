<?php defined('WPINC') or die();

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://digitalapps.com
 */

namespace TFLD\Includes;

use TFLD\Includes\Abstracts\TFLD_Singleton;

if (!class_exists('TFLD_Loader')) : final class TFLD_Loader extends TFLD_Singleton
    {

        /**
         * The array of actions registered with WordPress.
         */
        private $actions;

        /**
         * The array of filters registered with WordPress.
         */
        private $filters;

        /**
         * The array of shortcodes registered with WordPress.
         */
        private $shortcodes;

        /**
         * Protected class constructor to prevent direct object creation
         *
         * This is meant to be overridden in the classes which implement
         * this trait. This is ideal for doing stuff that you only want to
         * do once, such as hooking into actions and filters, etc.
         */
        protected function __construct()
        {

            $this->actions = array();
            $this->filters = array();
            $this->shortcodes = array();
        }

        /**
         * Add a new action to the collection to be registered with WordPress.
         *
         * 
         * @param    string               $hook             The name of the WordPress action that is being registered.
         * @param    object               $component        A reference to the instance of the object on which the action is defined.
         * @param    string               $callback         The name of the function definition on the $component.
         * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
         * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1.
         */
        public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
        {
            $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
        }

        /**
         * Add a new filter to the collection to be registered with WordPress.
         *
         * 
         * @param    string               $hook             The name of the WordPress filter that is being registered.
         * @param    object               $component        A reference to the instance of the object on which the filter is defined.
         * @param    string               $callback         The name of the function definition on the $component.
         * @param    int                  $priority         Optional. The priority at which the function should be fired. Default is 10.
         * @param    int                  $accepted_args    Optional. The number of arguments that should be passed to the $callback. Default is 1
         */
        public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
        {
            $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
        }

        /**
         * Add a new filter to the collection to be registered with WordPress.
         *
         * 
         * @param    string               $tag              The name of the WordPress shortcode that is being registered.
         * @param    object               $component        A reference to the instance of the object on which the filter is defined.
         * @param    string               $callback         The name of the function definition on the $component.
         */
        public function add_shortcode($tag, $component, $callback)
        {
            // $this->shortcodes[] = array( 'tag'=> $tag, 'component' => $component, 'callback'=> $callback );
            $this->shortcodes = $this->add_sc($this->shortcodes, $tag, $component, $callback);
        }

        /**
         * A utility function that is used to register the actions and hooks into a single
         * collection.
         *
         * 
         * @access   private
         * @param    array                $hooks            The collection of hooks that is being registered (that is, actions or filters).
         * @param    string               $hook             The name of the WordPress filter that is being registered.
         * @param    object               $component        A reference to the instance of the object on which the filter is defined.
         * @param    string               $callback         The name of the function definition on the $component.
         * @param    int                  $priority         The priority at which the function should be fired.
         * @param    int                  $accepted_args    The number of arguments that should be passed to the $callback.
         * @return   array                                  The collection of actions and filters registered with WordPress.
         */
        private function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
        {

            $hooks[] = array(
                'hook'          => $hook,
                'component'     => $component,
                'callback'      => $callback,
                'priority'      => $priority,
                'accepted_args' => $accepted_args
            );

            return $hooks;
        }

        /**
         * A utility function that is used to register the shortcodes into a single
         * collection.
         * 
         * @param    array                $shortcodes       The collection of hooks shortcodes is being registered.
         * @param    string               $tag              The name of the WordPress shortcode that is being registered.
         * @param    object               $component        A reference to the instance of the object on which the filter is defined.
         * @param    string               $callback         The name of the function definition on the $component.
         */
        private function add_sc($shortcodes, $tag, $component, $callback)
        {

            $shortcodes[] = array(
                'tag'          => $tag,
                'component'    => $component,
                'callback'     => $callback,
            );

            return $shortcodes;
        }

        /**
         * Register the filters and actions with WordPress.
         *
         * 
         */
        public function run_hooks()
        {

            foreach ($this->actions as $hook) {
                add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
            }

            foreach ($this->filters as $hook) {
                add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
            }

            foreach ($this->shortcodes as $tag) {
                add_shortcode($tag['tag'], array($tag['component'], $tag['callback']));
            }
        }
    }
endif;
