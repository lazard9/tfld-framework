<?php

/**
 * Using the singleton pattern in WordPress is an easy way to protect against
 * mistakes caused by creating multiple objects or multiple initialization
 * of classes which need to be initialized only once.
 *
 * With complex plugins, there are many cases where multiple copies of
 * the plugin would load, and action hooks would load (and trigger) multiple
 * times.
 *
 * @package TFLD Simple Features
 */

namespace TFLD\Includes\Abstracts;

abstract class TFLD_Singleton
{

    /**
     * Collection of instance.
     *
     * @var array
     */
    static protected $_instances = array();

    /**
     * Protected class constructor to prevent direct object creation
     */
    abstract protected function __construct();

    /**
     * Prevent object cloning.
     */
    final public function __clone()
    {
    }

    /**
     * Prevent magic method from being invoked by serialize function.
     */
    final public function __sleep()
    {
    }

    /**
     * Prevent magic method from being called by unserialize function.
     */
    final public function __wakeup()
    {
    }

    /**
     * This method returns new or existing Singleton instance
     * of the class for which it is called. This method is set
     * as final intentionally, it is not meant to be overridden.
     *
     * @return object Singleton instance of the class.
     */
    static public function get_instance()
    {

        $class = get_called_class();

        if (!array_key_exists($class, self::$_instances)) {
            self::$_instances[$class] = new $class();
        }

        return self::$_instances[$class];
    }
}
