<?php
/**
 * Plugin Name: Swatchify for WooCommerce
 * Author: Ashikur Rahman
 * Author URI: https://github.com/ashikurrahmanbd
 * Description: A professional WooCommerce variation swatches plugin to show the attributes in a beautiful way
 * Tags: woocommerce, variation swatches, color swatches, size swatches, text swatches
 * Version: 1.0
 * License: GPLv2 or later
 * Text Domain: swatchify 
*/

if ( !defined('ABSPATH' ) ) {

    exit;

}

/**
 * Load the Autoloader
*/
require_once __DIR__ . '/vendor/autoload.php';

final class Pxls_Swatchify{

    const version = '1.0';

    private function __construct(){

        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'plugin_activate'] );
        register_deactivation_hook(__FILE__, [$this, 'plugin_deactivate'] );

        add_action( 'plugins_loaded', [$this, 'load_dependencies'] );

    }

    /**
     * Summary of get_instance
     * @return Pxls_Swatchify
     */
    public static function get_instance(){

        static $instance = null;

        if ( ! $instance ) {

            $instance = new self();

        }

        return $instance;

    }

    /**
     * Define Constants
    */
    public function define_constants(){

        define('PXLS_SWATCHIFY_VERSION', self::version );

        define('PXLS_SWATCHIFY_FILE', __FILE__ );

        define('PXLS_SWATCHIFY_PATH', __DIR__ );

        define('PXLS_SWATCHIFY_URL', plugins_url( '', __FILE__ ) );

        define('PXLS_SWATCHIFY_ASSETS', PXLS_SWATCHIFY_URL . '/assets' );

    }

    /**
     * Plugin activation task
    */
    public function plugin_activate(){

        $pxls_swatchify_installed = get_option('pxls_swatchify_installed');

        if ( ! $pxls_swatchify_installed ) {

            update_option( 'pxls_swatchify_installed', time() );

        }

        update_option( 'pxls_swtchify_installed_version', 'PXLS_SWATCHIFY_VERSION' );

    }

    /**
     *Plugin Deactivation task 
    */
    public function plugin_deactivate(){

        //task needed to execute during plugin deactivation

    }

    /**
     * Load all the dependenceis 
    */
    public function load_dependencies(){

        if ( is_admin(  ) ) {

            //load admin dependenceis

        }else{

            //load frontend dependenceis
            new PXLS\Swatchify\Frontend();

        }

    }



}

/**
 * Return plugin instance
*/
function pxls_swatchify(){

    return Pxls_Swatchify::get_instance();

}

/**
 * Kick of the plugin
*/
pxls_swatchify();