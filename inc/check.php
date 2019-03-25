<?php

	/***
	 *	2019-03-12
	 */

	if( !class_exists( 'rRestrictContent_Check' ) ){
		
		class rRestrictContent_Check {

			// init process
			public static function init(){
				add_action( 'template_redirect', 'rRestrictContent_Check::process' );
			}
			
			
			public static function process(){
				
				// update to check options
				// $values = get_option( 'r_rc_options', [] );
				
				if( !!get_post_meta( get_the_ID(), '_rc_restrict', true ) && !is_user_logged_in() ){
					
					$url = get_post_meta( get_the_ID(), '_rc_url', true );
					
					if( !!$url ){
						$url = wp_login_url();
					}
					
					if( strpos( 'redirect_to', $url ) === false ){
						$url .= '?redirect_to='. urlencode( get_permalink() );
					}
					
					wp_safe_redirect( $url );
				}
			}

		}

	}
