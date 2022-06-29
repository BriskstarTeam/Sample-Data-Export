<?php
/**
 * CSV File setup
 *
 * @package samplecsvfile  1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main SDExport Class.
 *
 * @class SDExport
 */
if (!class_exists('SDExport')) {
	final class SDExport {
		private static $instance;
		public $version 	= "1.0.0";
		public $wp_version  = "5.8.2";

		public static function instance() {
			if (!isset(self::$instance) && !(self::$instance instanceof SDExport)) {
				self::$instance = new SDExport;
			}
			return self::$instance;
		}

		public function __construct() {
			if (!$this->check_requirements()) {
				return;
			}

			$this->define_constants();
			$this->create_options();
			$this->includes();
			
			//
			// Activation Hooks
			//
			
			register_deactivation_hook(__FILE__, array($this, 'deactivate'));
			register_uninstall_hook(__FILE__, 'SDExport::uninstall');
		}

		private function check_requirements() {
			global $wp_version;
			if (!version_compare($wp_version, $this->wp_version, '>=')) {
				return false;
			}
			return true;
		}

		/**
		 * Define SDE Constants.
		 */
		private function define_constants() {
			$upload_dir = wp_upload_dir( null, false );

			$this->define( 'SDE_ABSPATH', dirname( SDE_PLUGIN_FILE ) . '/' );
			$this->define( 'SDE_ADMIN_ABSPATH', dirname( SDE_PLUGIN_FILE ) . '/includes/admin/' );
			$this->define( 'SDE_PLUGIN_BASENAME', plugin_basename( SDE_PLUGIN_FILE ) );
			$this->define( 'SDE_VERSION', $this->version );
			$this->define( 'SDE_DATE', date('Y-m-d H:i:s') );
			$this->define( 'SDE_LOG_DIR', $upload_dir['basedir'] . '/csv-logs/' );
			$this->define( 'SDE_NOTICE_MIN_PHP_VERSION', '7.2' );
			$this->define( 'SDE_NOTICE_MIN_WP_VERSION', '5.4' );
			$this->define( 'SDE_PLUGIN_URL', plugin_dir_url( __DIR__ ) );
		}


		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		public function create_options(){
			if ( $this->is_request( 'admin' ) ) {
 				include_once(SDE_ADMIN_ABSPATH . 'class-admin.php');
  			}
		}

		public function includes() {
			/**
			 * Core classes.
			 */
			if ( $this->is_request( 'admin' ) ) {
				include_once(SDE_ADMIN_ABSPATH . 'class-admin.php');
				include_once(SDE_ADMIN_ABSPATH . 'class-scripts.php');
			}
		}

		private function is_request( $type ) {
			if($type == 'admin') {
				return is_admin();
			}
		}
	}
}