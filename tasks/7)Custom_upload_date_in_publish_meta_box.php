
function add_custom_meta_update() {
	
    global $post, $action;
	
	// DISPLAY CUSTOM DATE/TIME OR THE PUBLISHED DATE IF NO CUSTOM DATE/TIME HAS BEEN SET
	if ( get_post_meta( $post->ID , "_cstm_update_post" ) ) { // if meta_value 'cstm_update_post' in 'wp_postmeta' is not empty 
		$cus_date = date_create( get_post_meta( $post->ID , "_cstm_update_post" )[0] );
		$cus_date_format = date_format( $cus_date , "M d, Y" ) . " at " . date_format( $cus_date , "H:i" );
		$PostDate = 'Updated on: <b>' . $cus_date_format . '</b>'; 
	} else {
		$PostDate = 'No update set';
	}
	
	?>	
 		<div class="misc-pub-section post_uptime">
			<span id="updt-datetime"><span class="dashicons dashicons-clock"></span> <?php echo $PostDate ?></span>
			<a href="#edit_timestamp" class="edit-timestamp" role="button"><span class="open-updt-edit">Edit</span></a>
			<div id="updt-timestamp" style="display:none;" ><input type="datetime-local" name="_cstm_update_post" placeholder="Date"></div>
		</div>

		<script type='text/javascript'>
			jQuery(document).ready(function($) {
				$('.open-updt-edit').on( 'click', function() {
					$('#updt-timestamp').slideToggle('fast');
				});	
			});
		</script>
	<?php
	
}
add_action('post_submitbox_misc_actions', 'add_custom_meta_update');

function store_custom_update_time() {
    global $post, $wpdb;
	if(isset( $_POST[ "_cstm_update_post" ] )){
		// STORE THE CUSTOM DATE/TIME WHEN HIT "OK" BUTTON
		update_post_meta( $post->ID, "_cstm_update_post", sanitize_text_field( $_POST[ "_cstm_update_post" ] ) );
	}
} 
add_action('save_post', 'store_custom_update_time');
