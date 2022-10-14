<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

if ( !function_exists( 'chld_thm_cfg_locale_css' ) ):
    function chld_thm_cfg_locale_css( $uri ){
        if ( empty( $uri ) && is_rtl() && file_exists( get_template_directory() . '/rtl.css' ) )
            $uri = get_template_directory_uri() . '/rtl.css';
        return $uri;
    }
endif;
add_filter( 'locale_stylesheet_uri', 'chld_thm_cfg_locale_css' );
         
if ( !function_exists( 'child_theme_configurator_css' ) ):
    function child_theme_configurator_css() {
        wp_enqueue_style( 'chld_thm_cfg_separate', trailingslashit( get_stylesheet_directory_uri() ) . 'ctc-style.css', array( 'twenty-twenty-one-style','twenty-twenty-one-style','twenty-twenty-one-print-style' ) );
    }
endif;
add_action( 'wp_enqueue_scripts', 'child_theme_configurator_css', 10 );

// END ENQUEUE PARENT ACTION


/**
 * TFLD Framework begins here
 * 
 */
// Theme dir path
if (!defined('TFLD_FRAMEWORK_DIR')) {
    define('TFLD_FRAMEWORK_DIR', untrailingslashit( get_stylesheet_directory() ));
}
// Theme URL
if (!defined('TFLD_FRAMEWORK_URL')) {
    define('TFLD_FRAMEWORK_URL', untrailingslashit( get_stylesheet_directory_uri() ));
}

/**
 * Abstract singleton class.
 * Could have used trait to inject the same code.
 * 
 */
include_once TFLD_FRAMEWORK_DIR . '/includes/classes/abstracts/class-tfld-singleton.php';

/**
 * Trait for includin files.
 * 
 */
include_once TFLD_FRAMEWORK_DIR . '/includes/traits/trait-include-files.php';

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
if (!class_exists('TFLD_Simple_Features', false)) {
    include_once TFLD_FRAMEWORK_DIR . '/includes/classes/class-tfld-framework.php'; // Include files witout the autoloader
}

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * 
 */
function tfld_framework(): void
{

    TFLD\Includes\TFLD_Framework::get_instance();
}

tfld_framework();
