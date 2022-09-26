<?php
/**
 * Plugin Name:       ZA Map Editor
 * Description:       A plugin for custom map editor with woocommerce linked for cart and checkout.
 * Version:           1.1.0
 * Author:            Zohaib Ahmad
 * Email:             za.solutions55@gmail.com
 * Author URI:        https://wordpress.org
 * License:           GPL-2.0+
 * License URI:       https://wordpress.org
 * GitHub Plugin URI: https://wordpress.org
 */

/*
 *
 * MAIN CLASS
 *
 */

global $zamapeditor_version;
$zamapeditor_version = '1.0';
global $zamapeditor_pluginUrl;
$zamapeditor_pluginUrl = plugin_dir_url( __FILE__ );

Class ZAMapEditor {

	public function __construct(){

		// PLUGIN ACTIVATION CALLBACK
        register_activation_hook( __FILE__, array( $this, 'activatePlugin' ) );

        // PLUGIN DEACTIVATION CALLBACK
        register_deactivation_hook( __FILE__, array( $this, 'deactivatePlugin' ) );

        require_once( dirname( __FILE__ ) . '/public/za_map_editor_shortcode.php' );

        require_once( dirname( __FILE__ ) . '/includes/za-map-editor-wp-ajax-functions.php' );
		
		add_filter( 'woocommerce_add_cart_item_data', array( $this , 'zme_add_field_data_to_cart' ), 10, 4 );
		add_filter( 'woocommerce_get_item_data', array( $this , 'zme_field_to_cart' ), 10, 3  );
		add_action( 'woocommerce_checkout_create_order_line_item', array( $this , 'zme_add_field_data_to_order' ), 10, 4 );

	}


    /*
    * PLUGIN ACTIVATION CALLBACK
    */
    public function activatePlugin() {
        ob_start();
      
        // do your actions here

        return ob_get_clean();
    }

    /*
    * PLUGIN DEACTIVATION CALLBACK
    */
    public function deactivatePlugin() {
        ob_start();
        
        // do your actions here

        return ob_get_clean();
    }

    /*
    * PLUGIN ACTIVATION CALLBACK
    */
    public function uninstallPlugin() {
        ob_start();

        // do your actions here

        return ob_get_clean();
    }
	
	public function zme_add_field_data_to_cart( $cart_item_data, $product_id, $variation_id, $quantity ) {

		$product = wc_get_product( $product_id );
		$cart_item_data['_zme_title'] = $product->get_meta( '_zme_title' );
		$cart_item_data['_zme_sub_title'] = $product->get_meta( '_zme_sub_title' );
		$cart_item_data['_zme_product_type'] = $product->get_meta( '_zme_product_type' );
		$cart_item_data['_zme_size'] = $product->get_meta( '_zme_size' );
		return $cart_item_data;
	}

	public function zme_field_to_cart( $item_data, $cart_item ) {
		
		$product = wc_get_product( $cart_item['product_id'] );
		
		$item_data[] = array(
			'key'     => 'Title',
			'value'   => wc_clean( $cart_item['_zme_title'] ),
			'display' => '',
		);
		
		$item_data[] = array(
			'key'     => 'Subtitle',
			'value'   => wc_clean( $cart_item['_zme_sub_title'] ),
			'display' => '',
		);
			
		$item_data[] = array(
			'key'     => 'Product Type',
			'value'   => wc_clean( $cart_item['_zme_product_type'] ),
			'display' => '',
		);
		
		$item_data[] = array(
			'key'     => 'Size',
			'value'   => wc_clean( $cart_item['_zme_size'] ),
			'display' => '',
		);

		return $item_data;

	}

	public function vicode_add_field_data_to_order( $item, $cart_item_key, $values, $order ) {
		
		$product = wc_get_product( $values['product_id'] );
		$item->add_meta_data( 'Title' , $values['_zme_title'], true );
		$item->add_meta_data( 'Sub Title' , $values['_zme_sub_title'], true );
		$item->add_meta_data( 'Product Type' , $values['_zme_product_type'], true );
		$item->add_meta_data( 'Size' , $values['_zme_size'], true );

	}

}




/*
 * START THE MAIN PLUGIN
 */
new ZAMapEditor();