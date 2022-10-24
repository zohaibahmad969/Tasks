<?php 

// ********************************************************************** WOO SUPPORTED - THIS IS BREAAKING THE SITE???
add_action( 'after_setup_theme', 'rdsn_theme_setup_new' );
function rdsn_theme_setup_new() {
    add_theme_support( 'woocommerce' );
}

// ********************************************************************** EMAILS
add_filter( 'woocommerce_email_styles', 'rdsn_woocommerce_email_styles' );
function rdsn_woocommerce_email_styles( $css ) {
	$css .= "#template_header_image p {margin:0!important;padding:0!important;}";
	$css .= "#template_container {border:none!important;border-radius:0!important;box-shadow:none!important;}";
	$css .= "#template_header {border-radius:0!important;}";
	$css .= "#body_content_inner h2 {margin: 30px 0 18px;!important;}";
	$css .= "#addresses h2 {margin: 10px 0 18px;!important;}";
	$css .= "table.td td {vertical-align:top!important;}";
	$css .= ".wc-item-meta-label {display:block!important;float:none!important;}";
	$css .= "tbody td {font-size:14px;}";
	$css .= "tbody td p:last-child {margin:0!important;}";
	$css .= "tbody tr.order_item td {font-size:16px;}";
	$css .= "tbody tr.order_item td:first-child {width:60%;}";
	$css .= "address.address {font-size:14px!important;font-style:normal!important;line-height:20px;border:none!important;padding:0!important;}";
	return $css;
}

/*add_filter('woocommerce_email_order_meta_keys', 'my_woocommerce_email_order_meta_keys');
function my_woocommerce_email_order_meta_keys( $keys ) {
    $keys['Extra Meta'] = 'yith_booking_data';
    return $keys;
}*/

add_action('woocommerce_order_item_meta_end', 'email_confirmation_display_order_items', 10, 4);
function email_confirmation_display_order_items($item_id, $item, $order, $plain_text) {
	$booking_data = wc_get_order_item_meta( $item_id, 'yith_booking_data');
	if($booking_data) {
        $booking_date_stamp = $booking_data[ 'from' ];
        $booking_day = date('D d M Y', $booking_date_stamp);
        $booking_time = date('g:i a', $booking_date_stamp);
        //$booking_duration = $booking_data[ 'duration' ];
        //echo '<p style="padding-top:10px;/*font-weight:bold;*/">'.$booking_day.'<br />'.$booking_time.'<br />'.$booking_duration.' mins</p>';
		echo '<p style="padding-top:10px;/*font-weight:bold;*/">'.$booking_day.'<br />'.$booking_time.'</p>';
		//
		$booking_persons = $booking_data[ 'person_types' ];
        if($booking_persons) {
			echo '<div style="padding-bottom:16px;"><strong>Ticket Quantities</strong>';
            foreach ($booking_persons as $item) {
                echo '<div>'.$item['title'].': '.$item['number'].'</div>';
            }
			echo '</div>';
		} else {
			$num_people = $booking_data[ 'persons' ];
			if($num_people) {
				echo '<div style="padding-bottom:16px;"><strong>Ticket Quantities</strong>';
                echo '<div>Total: '.$num_people.'</div>';
				echo '</div>';
			}
		}
		$booking_services = $booking_data[ 'booking_services' ];
		if($booking_services) {
			echo '<div style="padding-bottom:16px;"><strong>Additional Options</strong>';
            foreach ($booking_services as $item) {
                echo '<div>'.$item['title'].': '.$item['number'].'</div>';
            }
			echo '</div>';
		}
	}
	//pa($booking_persons);
}


// ********************************************************************** SHOP MAIN PAGE
// remove Breadcrumbs
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
// remove Sort By select
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
// remove side-bar from all store pages
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
// Remove Showing results functionality site-wide
remove_action( 'woocommerce_before_shop_loop' , 'woocommerce_result_count', 20 );
// removes products count after categories name 
add_filter( 'woocommerce_subcategory_count_html', 'woo_remove_category_products_count' );
function woo_remove_category_products_count() {
	return;
}


// Wrap in CSS page elements
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
add_action('woocommerce_before_main_content', 'my_theme_wrapper_start', 10);
add_action('woocommerce_after_main_content', 'my_theme_wrapper_end', 10);
function my_theme_wrapper_start() {
	rdsn_banner();
	/*
	if (is_shop()) {
		$title = get_field('page_title',2381);
		echo '<div class="row-top"><div class="container"><h1>'.$title.'</h1></div></div>';
	}
	
	if (is_product()) {
		$title = get_the_title();
		echo '<div class="row-top"><div class="container"><h1>'.$title.'</h1></div></div>';
	}*/
	
	echo '<div id="rdsn-store" class="row-mid"><div class="container">';
}
function my_theme_wrapper_end() {
	echo '</div></div>';
}


// change thumbnail wrapper on shop categories
function woocommerce_subcategory_thumbnail($category){
	$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
	$title = $category->name;
	$image = wp_get_attachment_image_src( $thumbnail_id, 'shop_catalog' );
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	if ($image) { $image = $image[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	//
	echo '<div class="grid-item"><div class="grid-image" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
}

// change thumbnail wrapper on archive
function woocommerce_template_loop_product_thumbnail(){
	//global $post;
	$title = get_the_title();
	$image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'shop_catalog' );
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	if ($image) { $image = $image[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$rdsn_info = get_field('rdsn_woo_info');
	$rdsn_gen_info = get_field('rdsn_woo_gen_info');
	echo '<div class="grid-item"><div class="grid-image" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
	echo '<h2 class="woocommerce-loop-product__title rdsn-show">'.$title.'</h2>';
	if($rdsn_info) { echo '<div class="rdsn-info">'.$rdsn_info.'</div>'; };
	if($rdsn_gen_info) { echo '<div class="rdsn-info">'.$rdsn_gen_info.'</div>'; };
	echo '<span class="rdsn-button">View</span>';
}




// ********************************************************************** PRODUCT DETAIL PAGE
// remove short description from product page 
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
// remove link from image
add_filter('woocommerce_single_product_image_thumbnail_html','wc_remove_link_on_thumbnails' );
function wc_remove_link_on_thumbnails( $html ) {
     return strip_tags( $html,'<div><img>' );
}

// move tabbed product description to page 
add_action( 'woocommerce_single_product_summary', 'rdsn_wc_template_product_description', 20 );
function rdsn_wc_template_product_description() {
	echo '<div id="cont-desc" class="page-content">';the_content();echo '</div>';
}

// Show additional fields/button before product text
add_action( 'woocommerce_single_product_summary', 'rdsn_product_css_wrapper_start' );
function rdsn_product_css_wrapper_start( $q ){
	$rdsn_info = get_field('rdsn_woo_info');
	$rdsn_gen_info = get_field('rdsn_woo_gen_info');
	if($rdsn_info) { echo '<div class="rdsn-info">'.$rdsn_info.'</div>'; }
	if($rdsn_gen_info) { echo '<div class="rdsn-info">'.$rdsn_gen_info.'</div>'; };
	// Show "book now" button before product text
	$product_type = get_the_terms( $product_id,'product_type')[0]->slug;
	if($product_type == 'booking') {  echo '<a href="#" id="book-now" class="btn-solid trans-0-2">Book Now</a>'; }
	//
	echo '<div class="rdsn-product-wrapper">';
}

add_action( 'woocommerce_share', 'rdsn_product_css_wrapper_end' );
function rdsn_product_css_wrapper_end( $q ){
    echo '</div>';
}

// Move the price down the page
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 25 );

// remove the product tabs
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
    unset( $tabs['description'] );      		// Remove the description tab
    unset( $tabs['reviews'] ); 					// Remove the reviews tab
    unset( $tabs['additional_information'] );  	// Remove the additional information tab
    return $tabs;
}

add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Book Now', 'woocommerce' ); 
}

// Remove the SKU and category and add styled SKU only to top of product description
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

// Remove related products
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );


add_action( 'woocommerce_share', 'woocommerce_rdsn_terms_notice' );
function woocommerce_rdsn_terms_notice() {   
	$rdsn_terms = get_field('rdsn_woo_terms');
	if($rdsn_terms) { echo '<div class="rdsn-terms txt-small">'.$rdsn_terms.'</div>'; }
}


// ********************************************************************** ADD ACF DATE/INFO FIELD TO ORDER
// Save ACF custom field label and value in cart
function rdsn_save_custom_product_field( $cart_item_data, $product_id ) {
    $custom_field_value = get_field( 'rdsn_woo_info', $product_id, true ); // rdsn_woo_info
    if( !empty( $custom_field_value ) ) 
    {
        $cart_item_data['rdsn_woo_info'] = $custom_field_value;
        //$cart_item_data['unique_key'] = md5( microtime().rand() ); // make sure every add to cart action is a unique line item
    }
    return $cart_item_data;
}
add_filter( 'woocommerce_add_cart_item_data', 'rdsn_save_custom_product_field', 10, 2 );

// Display product custom field label and value in cart and checkout pages
function rdsn_show_custom_meta_on_cart_and_checkout( $cart_data, $cart_item ) {
    $custom_items = array();
    if( !empty( $cart_data ) ) {
        $custom_items = $cart_data;
    }
    if( isset( $cart_item['rdsn_woo_info'] ) ) {
        $custom_items[] = array( 'name' => 'Info', 'value' => $cart_item['rdsn_woo_info'] );
    }
    return $custom_items;
}
add_filter( 'woocommerce_get_item_data', 'rdsn_show_custom_meta_on_cart_and_checkout', 10, 2 );

// Save item custom fields label and value as order item meta data
function rdsn_save_custom_product_field_in_order_item_meta( $item_id, $values ) {
    wc_add_order_item_meta( $item_id, 'Info', $values [ 'rdsn_woo_info' ] );
  }
add_action( 'woocommerce_add_order_item_meta', 'rdsn_save_custom_product_field_in_order_item_meta' , 10, 2);


// ********************************************************************** CART
add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_update_cart_count');
function woocommerce_header_update_cart_count( $fragments ) {
    global $woocommerce;
	ob_start();
    $cart_count = WC()->cart->get_cart_contents_count();
	if ($cart_count == 1) { $item_text = 'item'; } else { $item_text = 'items'; }
	echo '<div class="cart-totals"><span>'.$woocommerce->cart->cart_contents_count.'</span> '.$item_text.'</div>';
    $fragments['div.cart-totals'] = ob_get_clean();
    return $fragments;
}

/*function rdsn_in_cart($product_id) {
    global $woocommerce;
    foreach($woocommerce->cart->get_cart() as $key => $val ) {
        $_product = $val['data'];
        if($product_id == $_product->id ) {
            return true;
        }
    }
    return false;
}*/

/*function rdsn_add_to_cart() {
    //$product_ids = array(2400,2401,2417,118);
	//$booking_fee_id = array(2425);
	if (!is_checkout() && !is_cart() ) {
        return;
    }
    if (WC()->cart->is_empty() ) {
        return;
    }
	if( !rdsn_in_cart(2400) || !rdsn_in_cart(2401) ){
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
     		if ( $cart_item['product_id'] == 2425 ) {
          	WC()->cart->remove_cart_item( $cart_item_key );
     		}
		}
	}
	if( (rdsn_in_cart(2400) || rdsn_in_cart(2401)) && !rdsn_in_cart(2425) ){
    	WC()->cart->add_to_cart( 2425, 1 );
	}
}
add_action( 'wp', 'rdsn_add_to_cart' );*/

// Booking fee
/*add_action( 'woocommerce_cart_calculate_fees', 'wc_add_surcharge' ); 
function wc_add_surcharge() { 
	global $woocommerce; 
	$cart_count = WC()->cart->get_cart_contents_count();
	if ( is_admin() && !defined( 'DOING_AJAX' ) )  {
		return;
	}
	$fee_total = 5 * $cart_count;
	//$rev_vat = '1.2';
	$fee = $fee_total / '1.2';
	$woocommerce->cart->add_fee( 'Booking Fee', $fee, true, 'standard' );
}*/


add_action( 'woocommerce_cart_calculate_fees', 'wc_add_surcharge' ); 
function wc_add_surcharge($cart) {
	if ( is_admin() && !defined( 'DOING_AJAX' ) )  {
		return;
	}
	foreach ( $cart->get_cart() as $cart_item_key => $values ) {
        if ( 0 != ( $fee = get_post_meta( $values['product_id'], 'rdsn_woo_fee', true ) ) ) {
            $quantity  = $values['quantity'];
			$name      = 'Booking fee: ' . get_the_title( $values['product_id'] );
			$amount_a  = $fee / '1.2';
			$amount    = $amount_a * $quantity;
            $taxable   = true;
            $tax_class = '';
            $cart->add_fee( $name, $amount, $taxable, $tax_class );
        }
    }
}


function woocommerce_button_proceed_to_checkout() {
   $new_checkout_url = WC()->cart->get_checkout_url();
   ?>
   <a href="<?php echo $new_checkout_url; ?>" class="checkout-button button alt wc-forward">
   <?php _e( 'Checkout', 'woocommerce' ); ?></a>
<?php
}


// ********************************************************************** CHECKOUT
// Stripe input styling
add_filter( 'wc_stripe_elements_styling', 'rdsn_add_stripe_elements_styles' );
function rdsn_add_stripe_elements_styles($array) {
	$array = array(
		'base' => array( 
			'fontSize' 	=> '18px'
		)
	);
	return $array;
}

// Auto Complete all orders
/*add_action( 'woocommerce_thankyou', 'rdsn_woocommerce_auto_complete_order' );
function rdsn_woocommerce_auto_complete_order( $order_id ) { 
    if ( ! $order_id ) {
        return;
    }
    $order = wc_get_order( $order_id );
    $order->update_status( 'completed' );
}*/

add_action( 'woocommerce_before_thankyou', 'rdsn_add_content_thankyou' );
function rdsn_add_content_thankyou() {
echo '<h2>Please note</h2><p style="padding-bottom:40px;">Please check your junk mail if you don\'t receive your order email. <br />Please either print out your order email and bring with you or bring your order email on your device (phone/tablet).</p>';
}


// ********************************************************************** BARCODE SCANNING PERMISSIONS
/*add_filter( 'woocommerce_order_barcodes_scan_permission', 'modify_woocommerce_order_barcodes_scan_permission' );
function modify_woocommerce_order_barcodes_scan_permission( $has_permission ) {
  // Do any required permission checks here
  $has_permission = true;
  return $has_permission;
}*/


// ********************************************************************** FALLBACK PRODUCT IMAGE
// If no image - applies to product detail page
add_action( 'init', 'custom_fix_thumbnail' );
function custom_fix_thumbnail() {
add_filter('woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src');
	function custom_woocommerce_placeholder_img_src( $src ) {
		$src = get_template_directory_uri().'/assets/img/default-square-02.jpg';
	return $src;
	}
}

?>