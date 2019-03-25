<?php
/*
Plugin Name: rRestrictContent
Plugin URI: https://www.raphaelramos.com.br/wp/plugins/r-restrict-content/
Description: With this plugin you can block access to a page to logged in users only and redirect the others to a defined URL
Version: 0.1.0
Author: Raphael Ramos
Author URI: https://www.raphaelramos.com.br/
Requires at least: 4.8
Tested up to: 3.4.2
*/


	// Exit if accessed directly
	if( !defined( 'ABSPATH' ) ) exit;

	
	// plugin path
	if( !defined( 'R_RC_DIR' ) ){
		define( 'R_RC_DIR', plugin_dir_path( __FILE__ ) );
	}

	// plugin url
	if( !defined( 'R_RC_URL' ) ){
		define( 'R_RC_URL', plugin_dir_url( __FILE__ ) );
	}
	
	// plugin path
	if( !defined( 'R_RC_PATH' ) ){
		define( 'R_RC_PATH', dirname( plugin_basename( __FILE__ ) ) );
	}

	// plugin version
	if( !defined( 'R_RC_NAME' ) ){
		define( 'R_RC_NAME', 'r-restrict-content' );

	}

	// plugin version
	if( !defined( 'R_RC_VERSION' ) ){
		define( 'R_RC_VERSION', '0.1.0' );

	}

	// base class
	require_once( R_RC_DIR .'inc/core.php' );
	
	/***
	 *	The code that runs during plugin activation.
	 *	This action is documented in includes/class-plugin-name-activator.php
	 */
	function activate_restrict_content() {
		do_action( 'r/restrict-content/activate' );
	}
	register_activation_hook( __FILE__, 'activate_restrict_content' );


	/***
	 *	The code that runs during plugin deactivation.
	 *	This action is documented in includes/class-plugin-name-deactivator.php
	 */
	function deactivate_restrict_content() {
		do_action( 'r/restrict-content/deactivate' );
	}
	register_deactivation_hook( __FILE__, 'deactivate_deactivate_restrict_content' );


	/***
	 *	Begins execution of the plugin.
	 */
	rRestrictContent_Core::init();
