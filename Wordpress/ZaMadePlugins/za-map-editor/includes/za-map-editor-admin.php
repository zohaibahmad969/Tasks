<?php


add_action( 'admin_menu' , array( $this ,'zme_display_admin_page' ) );

add_action( 'woocommerce_product_options_general_product_data', array( $this , 'vicode_create_field' ) );
add_action( 'woocommerce_process_product_meta', array( $this , 'vicode_save_field_data' ) );
add_action( 'woocommerce_before_add_to_cart_button', array( $this , 'vicode_display_field' ) );
add_filter( 'woocommerce_add_to_cart_validation', array( $this , 'vicode_field_validation' ), 10, 3 );
add_filter( 'woocommerce_add_cart_item_data', array( $this , 'vicode_add_field_data_to_cart' ), 10, 4 );
add_filter( 'woocommerce_get_item_data', array( $this , 'vicode_field_to_cart' ), 10, 3  );
add_action( 'woocommerce_checkout_create_order_line_item', array( $this , 'vicode_add_field_data_to_order' ), 10, 4 );

function zme_display_admin_page() {

	add_menu_page(
			'Za Map Editor', // Page title
			'Za Map Editor', // Menu title
			'manage_options', // capability
			'za-map-editor', //menu slug
			'za_map_editor_admin_fn' //function
			'dashicons-admin-site-alt2', //icon url
			'200' // position from the menu top
		);

}

function trs_all_ecards_fn() {
		global $wpdb;
		global $wp_ecards_table_name;
		global $trs_plugin_path;
		global $trs_plugin_url;


		if( !get_option( 'trs_ecards_license_key' ) ){

			include $trs_plugin_path.'admin/partials/trs-ecards-authenticate.php';

		}else{

			include $trs_plugin_path.'admin/partials/trs-all-ecards-admin-menu-display.php';

		}

	}

function vicode_create_field() {

	global $post;
	$product = wc_get_product( $post->ID );
	$num_of_text_fields = $product->get_meta( '_ecard_num_of_text_fields' );

	for ($i=1; $i <= $num_of_text_fields ; $i++) { 
		$args = array(
			'id' => 'trs_ecard_text_field_title'.$i,
			'label' => __( 'TRS Ecard Text ' . $i, 'vicode' ),
			'class' => 'trs-custom-field',
			'desc_tip' => true,
			'description' => __( 'Enter the title of TRS text field.', 'trs-ecards' ),
		);
		woocommerce_wp_text_input( $args );
	}

}

function vicode_save_field_data( $post_id ) {

	$product = wc_get_product( $post_id );
	$num_of_text_fields = $product->get_meta( '_ecard_num_of_text_fields' );
	for ($i=1; $i <= $num_of_text_fields ; $i++) { 
		$title = isset( $_POST['trs_ecard_text_field_title'.$i] ) ? $_POST['trs_ecard_text_field_title'.$i] : '';
		$product->update_meta_data( 'trs_ecard_text_field_title'.$i , sanitize_text_field( $title ) );
	}

	$product->save();
}

function vicode_display_field() {

	global $post;
	$product = wc_get_product( $post->ID );
	$num_of_text_fields = $product->get_meta( '_ecard_num_of_text_fields' );

	echo '<div class="trs-ecard-custom-fields">';
	for ($i=1; $i <= $num_of_text_fields ; $i++) { 
		$title = $product->get_meta( 'trs_ecard_text_field_title'.$i );
		if( $title ) {
				// Display the field if not empty
			printf(
				'<div class="trs-ecard-custom-field-wrapper">
				<label for="trs-ecard-title-field'.$i.'">%s: </label>
				<input type="text" id="trs-ecard-title-field'.$i.'" name="trs-ecard-title-field'.$i.'" value="">
				</div>'
				,esc_html( $title )
			);
		}
	}
	echo '</div>';
}

function vicode_field_validation( $passed, $product_id, $quantity ) {

	$product = wc_get_product( $product_id );
	$num_of_text_fields = $product->get_meta( '_ecard_num_of_text_fields' );
	for ($i=1; $i <= $num_of_text_fields ; $i++) {
		if( empty( $_POST['trs-ecard-title-field'.$i] ) ) {
				// Fails validation
			$passed = false;
		}
	}
	if( !$passed ){
		wc_add_notice( __( 'Please enter name for your ecard.', 'trs-ecards' ), 'error' );
	}
	return $passed;
}

function vicode_add_field_data_to_cart( $cart_item_data, $product_id, $variation_id, $quantity ) {

	$product = wc_get_product( $product_id );
	$num_of_text_fields = $product->get_meta( '_ecard_num_of_text_fields' );
	for ($i=1; $i <= $num_of_text_fields ; $i++) {
		if( ! empty( $_POST['trs-ecard-title-field'.$i] ) ) {
				// Add the item data
			$cart_item_data['trs-ecard-title-field'.$i] = $_POST['trs-ecard-title-field'.$i];
		}
	}
	return $cart_item_data;
}

function vicode_field_to_cart( $item_data, $cart_item ) {

	$product = wc_get_product( $cart_item['product_id'] );
	$num_of_text_fields = $product->get_meta( '_ecard_num_of_text_fields' );
	for ($i=1; $i <= $num_of_text_fields ; $i++) {
		if ( !empty( $cart_item['trs-ecard-title-field'.$i] ) ) {
			$trs_ecard_field_title = $product->get_meta( 'trs_ecard_text_field_title'.$i );
			$item_data[] = array(
				'key'     => __( $trs_ecard_field_title, 'trs-ecards' ),
				'value'   => wc_clean( $cart_item['trs-ecard-title-field'.$i] ),
				'display' => '',
			);
		}
	}

	return $item_data;

}

function vicode_add_field_data_to_order( $item, $cart_item_key, $values, $order ) {

	$product = wc_get_product( $values['product_id'] );
	$num_of_text_fields = $product->get_meta( '_ecard_num_of_text_fields' );
	for ($i=1; $i <= $num_of_text_fields ; $i++) {
		if( isset( $values['trs-ecard-title-field'.$i] ) ) {
			$trs_ecard_field_title = $product->get_meta( 'trs_ecard_text_field_title'.$i );
			$item->add_meta_data( __( $trs_ecard_field_title, 'trs-ecards' ), $values['trs-ecard-title-field'.$i], true );
		}
	}

}


