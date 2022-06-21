<?php
/**
 * Handle frontend scripts
 *
 * @package Assets/Classes
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
/**
 * Frontend scripts class.
 */
class SDE_Frontend_Scripts {
    /**
     * Contains an array of script handles registered by DM.
     *
     * @var array
     */
    private static $scripts = array();

    /**
     * Contains an array of script handles registered by DM.
     *
     * @var array
     */
    private static $styles = array();

    /**
     * Contains an array of script handles localized by DM.
     *
     * @var array
     */
    private static $wp_localize_scripts = array();
    /**
     * Hook in methods.
     */
    public static function init() {
        add_action( 'admin_enqueue_scripts', array( __CLASS__, 'load_scripts' ),9999 );
        add_action( 'admin_print_styles', array( __CLASS__, 'load_scripts' ),9999 );
    }

    /*
    * Register default scripts
    */
    private static function defult_register_scripts(){
        $defult_register_scripts =  
            array(
                'jquery-ui-datepicker'
            );
         foreach ( $defult_register_scripts as $name => $props ) {
            self::register_defult_script( $props );
        }
    }

    /*
    * Register sample data export plugins scripts
    */
    private static function register_scripts() {
        $register_scripts = array(
            'jquery.dataTables' => array(
                'src'     => self::get_asset_url( 'assets/js/jquery.dataTables.js'),
                'deps'    => array( 'jquery' ),
                'version' => '1.11.3',
            ),
            'jquery.validate' => array(
                'src'     => self::get_asset_url( 'assets/js/jquery.validate.min.js'),
                'deps'    => array( 'jquery' ),
                'version' => '1.19.3',
            ),
            'custom' => array(
                'src'     => self::get_asset_url( 'assets/js/custom.js'),
                'deps'    => array( 'jquery' ),
                'version' => '1.0',
            ),
        );
        foreach ( $register_scripts as $name => $props ) {
            self::register_script( $name, $props['src'], $props['deps'], $props['version'] );
        }
    }

    private static function register_defult_script( $handle) {
        wp_enqueue_script($handle);
    } 

    private static function register_script( $handle, $path, $deps = array( 'jquery' ), $version = SDE_VERSION, $in_footer = true ) {
        self::$scripts[] = $handle;
        wp_register_script( $handle, $path, $deps, $version, $in_footer );
        wp_enqueue_script($handle);
    }

    /**
     * Register all DM styles.
     */
    private static function register_styles() {
        $version = '';

        $register_styles = array(
            'jquery-ui' => array(
                'src'     => self::get_asset_url('assets/css/jquery-ui.css'),
                'deps'    => array(),
                'version' => '1.11.4',
                'has_rtl' => false,
            ),
            'bootstrap.css'   => array(
                'src'     => self::get_asset_url('assets/css/bootstrap.css'),
                'deps'    => array(),
                'version' => '5.1.3',
                'has_rtl' => false,
            ),
            'dataTables.bootstrap5.min'    => array(
                'src'     => self::get_asset_url( 'assets/css/dataTables.bootstrap5.min.css' ),
                'deps'    => array(),
                'version' => '5',
                'has_rtl' => false,
            ),
            'style'    => array(
                'src'     => self::get_asset_url( 'assets/css/style.css' ),
                'deps'    => array(),
                'version' => $version,
                'has_rtl' => false,
            ),
        );
        foreach ( $register_styles as $name => $props ) {
            self::register_style( $name, $props['src'], $props['deps'], $props['version'], 'all', $props['has_rtl'] );
        }
    }

    private static function get_asset_url( $path ) {
        return apply_filters( 'get_asset_url', plugins_url( $path, SDE_PLUGIN_FILE ), $path );
    }
    
    private static function register_style( $handle, $path, $deps = array(), $version = SDE_VERSION, $media = 'all', $has_rtl = false ) {
        self::$styles[] = $handle;
        wp_register_style( $handle, $path, $deps, $version, $media );
        wp_enqueue_style($handle);
    }

    /*
     * Load all the script functions
     */
    public static function load_scripts() {
        global $post;
        self::defult_register_scripts();
        self::register_scripts();
        self::register_styles();
        // CSS Styles.
    }

}
SDE_Frontend_Scripts::init();