<?php

	/***
	 *	2019-03-11
	 */

	if( !class_exists( 'rRestrictContent_Admin_Core' ) ){

		class rRestrictContent_Admin_Core {

			public static function init(){

				// add metabox
				require_once( R_RC_DIR .'inc/admin/metabox.php' );
				rRestrictContent_Admin_Metabox::init();
				
				// add option page to:
				// - set page to redirect			r_rc_redirect_url: wp_login_url( $url_to_redirect_after_login )
				// - block all site or per page		r_rc_type: [ all, item, none ]
				// - list cpts to apply restrict
				require_once( R_RC_DIR .'inc/admin/options.php' );
				rRestrictContent_Admin_Options::init();

			}

		}
	}
