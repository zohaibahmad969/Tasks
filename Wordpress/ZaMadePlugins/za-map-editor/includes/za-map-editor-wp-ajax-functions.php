<?php 




// Ajax Function for addding product to cart
// Ajax Call coming from public/js/main.js

add_action('wp_ajax_zmeaddtocart', 'zmeaddtocart');
add_action('wp_ajax_nopriv_zmeaddtocart', 'zmeaddtocart');

function zmeaddtocart()
{

	$upload_dir  = wp_upload_dir();
	$upload_path = str_replace('/', DIRECTORY_SEPARATOR, $upload_dir['path']) . DIRECTORY_SEPARATOR;

	$img             = str_replace('data:image/jpeg;base64,', '', $_POST['zme_image']);
	$img             = str_replace(' ', '+', $img);
	$decoded         = base64_decode($img);
	$filename        = $title . '.jpeg';
	$file_type       = 'image/jpeg';
	$hashed_filename = md5($filename . microtime()) . '_' . $filename;
		// echo "image is " .$image;
		// Save the image in the uploads directory.
	$upload_file = file_put_contents($upload_path . $hashed_filename, $decoded);

	$attachment = array(
		'post_mime_type' => $file_type,
		'post_title'     => preg_replace('/\.[^.]+$/', '', basename($hashed_filename)),
		'post_content'   => '',
		'post_status'    => 'inherit',
		'guid'           => $upload_dir['url'] . '/' . basename($hashed_filename)
	);

	$attach_id = wp_insert_attachment($attachment, $upload_dir['path'] . '/' . $hashed_filename);


	// Custom Map Editor Prodcut Id
	$product_id = 8715;

	//set the image as the featured image
	set_post_thumbnail($product_id, $attach_id);

	// Updating  product meta
	update_post_meta($product_id, '_zme_title', $_POST['zme_title']);
	update_post_meta($product_id, '_zme_sub_title', $_POST['zme_sub_title']);
	update_post_meta($product_id, '_zme_product_type', $_POST['zme_product_type']);
	update_post_meta($product_id, '_zme_size', $_POST['zme_size']);
	$cart_item_data  = array(
		'zme_title' => $_POST['zme_title'], 
		'zme_sub_title' => $_POST['zme_sub_title'], 
		'zme_product_type' => $_POST['zme_product_type'], 
		'zme_size' => $_POST['zme_size'], 
	);
	update_post_meta( $product_id, '_price', $_POST['zme_price'] );

	// echo $product_id;
	// echo var_dump($_POST);
	WC()->cart->add_to_cart( $product_id);
	
	wp_die();
}

