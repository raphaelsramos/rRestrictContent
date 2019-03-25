<?php

	/***
	 *	2019-03-11
	 */

	if( !class_exists( 'rRestrictContent_Core' ) ){
		
		class rRestrictContent_Core {

			// init process
			public static function init(){

				self::load_dependencies();
				
				self::load_textdomain();

			}

			
			// plugin name get
			public static function get_name() {
				return R_RC_NAME;
			}

			
			// plugin version get
			public static function get_version() {
				return R_RC_VERSION;
			}


			// load dependencies
			public static function load_dependencies(){

				if( is_admin() ){
					require_once( R_RC_DIR .'inc/admin/core.php' );
					rRestrictContent_Admin_Core::init();
				}
				
				// check if page is restrict and redirect
				// update with options
				require_once( R_RC_DIR .'inc/check.php' );
				rRestrictContent_Check::init();

			}


			// load textdomain
			public static function load_textdomain() {
				load_plugin_textdomain(
					self::get_name(),
					false,
					R_RC_PATH .'/lang'
				);
			}


		}

	}
