<?php
/*
Plugin Name: Sample Data Export
Description: Download Users Data from the table.
Version: 1.0.0
Author: Briskstar Technologies LLP
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! defined( 'SDE_PLUGIN_FILE' ) ) {
    define( 'SDE_PLUGIN_FILE', __FILE__ );
}

// Enable error reporting in development
if(getenv('WPAE_DEV')) {
    error_reporting(E_ALL ^ E_DEPRECATED );
    ini_set('display_errors', 1);
    // xdebug_disable();
}

// Include the main SDExport class.
if ( ! class_exists( 'SDExport', false ) ) {
    include_once(dirname( SDE_PLUGIN_FILE ) . '/includes/admin/class-sample-data.php');
}

// phpcs:ignore WordPress.NamingConventions.ValidFunctionName.FunctionNameInvalid
function SDE() { 
    return SDExport::instance();
}

$GLOBALS['SDExport'] = SDE();
?>