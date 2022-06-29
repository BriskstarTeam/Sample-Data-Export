<?php 

/*
Plugin Name: Sample Data Export
Description: Download Users Data from the table.
Version: 1.0.0
Author: Briskstar Technologies LLP
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action('plugins_loaded', 'plugin_initialization');

function plugin_initialization()
{

    if ( ! defined( 'SDE_PLUGIN_FILE' ) ) {
        define( 'SDE_PLUGIN_FILE', __FILE__ );
    }

    // Enable error reporting in development
    if(getenv('WPAE_DEV')) {
        error_reporting(E_ALL ^ E_DEPRECATED );
        ini_set('display_errors', 1);
        // xdebug_disable();
    }

    require 'autoload.php';

    function SDE() 
    { 
        return SDExport::instance();
    }

    function SDE_Admin() 
    { 
        return new SDE_Admin();
    }

    $GLOBALS['SDExport'] = SDE();
    $GLOBALS['SDE_Admin'] = SDE_Admin();
    

}    
?>