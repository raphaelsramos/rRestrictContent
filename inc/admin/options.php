<?php

	/***
	 *	2019-03-06
	 *
	 *	https://wpshout.com/wordpress-options-page/
	 */

	if( !class_exists( 'rRestrictContent_Admin_Options' ) ){

		class rRestrictContent_Admin_Options {

			public static function init(){

				add_action( 'admin_menu', 'rRestrictContent_Admin_Options::add' );
				
				add_action( 'r/restrict-content/options/fields', 'rRestrictContent_Admin_Options::fields' );

			}

			public static function add(){
				add_options_page(
					'rRestrictContent',
					'rRestrictContent',
					'manage_options',
					'r-restrict-content-options',
					'rRestrictContent_Admin_Options::render'
				);
			}
			
			
			public static function fields(){
				
				$values = get_option( 'r_rc_options', [] );
				
				wp_nonce_field( 'r_rc_set_options', 'r_rc_options_nonce' );
				
?>
				<style scoped>
					.field-wrap {}
					.field-wrap + .field-wrap { margin-top: 12px }
					.field-wrap label { display: block; margin-bottom: 8px }
				</style>

				<div class="field-wrap">
					<label for="r_rc_options_type"><?php _e( 'Restriction Type', 'r-restrict-content' ) ?>:</label>
					<select name="r_rc_options[type]" id="r_rc_options_type" class="regular-text">
						<option <?php if( !isset( $values[ 'type' ] ) || $values[ 'type' ] = '' || $values[ 'type' ] = 'none' ) echo ' selected'; ?>><?php _e( 'None', 'r-restrict-content' ) ?>
						<option <?php if( isset( $values[ 'type' ] ) && $values[ 'type' ] = 'all' ) echo ' selected'; ?>><?php _e( 'All Site', 'r-restrict-content' ) ?>
						<option <?php if( isset( $values[ 'type' ] ) && $values[ 'type' ] = 'item' ) echo ' selected'; ?>><?php _e( 'Choose Items', 'r-restrict-content' ) ?>
					</select>
				</div>
				
				<div class="field-wrap">
					<label for="r_rc_options_url"><?php _e( 'Default URL to Redirect', 'r-restrict-content' ) ?>:</label>
					<input type="text" name="r_rc_options[url]" id="r_rc_options_url" value="<?php if( isset( $values[ 'url' ] ) ) echo $values[ 'url' ]; ?>" class="regular-text" />
				</div>
				
				
<?php
			}
			
			
			public static function render(){
				
				$show_success = false;
				
				// check permission
				if( !current_user_can( 'manage_options' ) ){
					wp_die( 'Unauthorized user' );
				}
				
				if( count( $_POST ) ){
					
					// check nonce
					$nonce = $_POST[ 'r_rc_options_nonce' ];
					if( !wp_verify_nonce( $nonce, 'r_rc_set_options' ) ) {
						wp_die( 'Unauthorized user' );
					}
		
					// save data
					if( isset( $_POST[ 'r_rc_options' ] ) ){
						$show_success = update_option( 'r_rc_options', $_POST[ 'r_rc_options' ] );
					}
				
				}
?>
    <div class="wrap">
        <h1><?php _e( 'rRestrictContent', 'r-restrict-content' ); ?></h1>
		<hr />
		<form method="post">
<?php
			if( $show_success ){
			
?>
	<div class="notice notice-success is-dismissible">
		<p><?php _e( 'rRestrictContent options saved.', 'r-restrict-content' ); ?></p>
	</div>
<?php
			}
		
			do_action( 'r/restrict-content/options/fields' );
	
			submit_button();
?>
		</form>
    </div>
<?php
			}
		}
	}
