<?php
/*
* CSV file export related functions
*/
defined( 'ABSPATH' ) || exit;
if ( class_exists( 'SDE_Admin_Menus', false ) ) {
	return new SDE_Admin_Menus();
}

class SDE_Admin_Menus {
	public function __construct() {
		// Add menus.
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 50 );
		add_action( 'admin_menu', array( $this, 'CsvExportFromAdmin' ), 50 );
	}

	public function userexportdata(){
		global $wpdb;
		$table_name = $wpdb->users;
		$actionUrl  = esc_url('admin.php?page=export-data');
		include(SDE_ADMIN_ABSPATH. 'views/html-for-users-csv.php');
	}
	
	public function CsvExportFromAdmin() {
		include_once(SDE_ADMIN_ABSPATH . 'export-data.php');
	}

	/**
	 * Add menu items.
	 */
	public function admin_menu() {
		add_menu_page( __( 'Sample Data Export', 'Sample Data Export' ), __( 'Sample Data Export', 'Sample Data Export' ), 'edit_pages', 'sample-data-export', array( $this, 'userexportdata' ), null, '55.5' );

		add_submenu_page( NULL, 'Sample Data Export', 'Sample Data Export','export-data', 'CsvExportFromAdmin');
	}
}
return new SDE_Admin_Menus();
?>