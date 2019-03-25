<?php

	/***
	 *	2019-03-12
	 */

	if( !class_exists( 'rRestrictContent_Admin_Metabox' ) ){

		class rRestrictContent_Admin_Metabox {

			private static $post_types;

			public static function init(){

				self::$post_types = get_post_types( [ 'public' => true, 'show_ui' => true ], 'names' );
				
				self::$post_types = apply_filters( 'r/restrict_content/metabox/post_types', self::$post_types );


				// add metabox
				add_action( 'add_meta_boxes',	'rRestrictContent_Admin_Metabox::add' );
				
				add_action( 'save_post',		'rRestrictContent_Admin_Metabox::save' );

			}
			
			public static function add( $post_type ){
				if ( in_array( $post_type, self::$post_types ) ) {
					add_meta_box( 
						'esc_files_file',								//id
						__( 'Restrict Content', 'r-restrict-content' ),	//title
						'rRestrictContent_Admin_Metabox::render',		//cb
						$post_type,										//screen
						'normal'										//context
					);
				}
			}


			// Register Custom Post Type
			public static function render( $post ){
				
				$restrict = get_post_meta( $post->ID, '_rc_restrict', 1 );
				
				$url = get_post_meta( $post->ID, '_rc_url', 1 );

				wp_nonce_field( 'r_rc_set_restriction', 'r_rc_nonce' );
				
				$url_visible = !!$restrict ? 'block' : 'none';
?>
			<div class="field-wrap">
				<label for="r_rc_restrict">
					<input type="checkbox" name="r_rc_restrict" id="r_rc_restrict" value="1"<?php if( !!$restrict ) echo " checked"; ?> />
					<span><?php printf( __( 'Restrict this %s to logged in users?' ), $post->post_type ) ?></span>
				</label>
			</div>
			<div id="r_rc_url_wrapper" class="field-wrap" style="display: <?php echo $url_visible ?>">
				<label for="r_rc_url"><?php printf( __( 'When unlogged users access this %s, they will be redirected to' ), $post->post_type ) ?>:</label>
				<input type="text"name="r_rc_url" value="<?php echo $url ?>" class="regular-text" />
			</div>
			<script type="text/javascript">
			jQuery( function( $ ){
				$( '#r_rc_restrict' ).on( 'change', function( e ){
					$( '#r_rc_url_wrapper' )[ !!this.checked ? 'show' : 'hide' ]();
				} );
			} );
			</script>
			<style scoped>
			#r_rc_url_wrapper { padding-top: 20px }
			#r_rc_url_wrapper label { display: block; margin-bottom: 8px }
			#r_rc_url { width: 100% }
			</style>
<?php

			}
			
			
			public static function save( $post_id ){
				
				// check if our nonce is set
				if( !isset( $_POST[ 'r_rc_nonce' ] ) ){
					return $post_id;
				}
				
				// check if nonce is valid
				$nonce = $_POST[ 'r_rc_nonce' ];
				if( !wp_verify_nonce( $nonce, 'r_rc_set_restriction' ) ) {
					return $post_id;
				}
				
				// autosave
				if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
					return $post_id;
				}

				// save data
				if( isset( $_POST[ 'r_rc_restrict' ] ) ){
					
					update_post_meta( $post_id, '_rc_restrict', (int)$_POST[ 'r_rc_restrict' ] );
					
					// if url provided, associate
					if( isset( $_POST[ 'r_rc_url' ] ) ){
						update_post_meta( $post_id, '_rc_url', esc_url( $_POST[ 'r_rc_url' ] ) );
					}
				}
				else {
					delete_post_meta( $post_id, '_rc_restrict' );
					delete_post_meta( $post_id, '_rc_url' );
				}

			}


		}
	}
