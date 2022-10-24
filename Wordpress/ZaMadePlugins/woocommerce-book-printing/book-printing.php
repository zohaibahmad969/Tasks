<?php
/**
 * Plugin Name: Trs Book Printing
 * Description: This plugin look for the order item pdf file on drive and then send data to printing api and work with order status
 * Plugin URI: http://therightsw.com/
 * Author: The Right Software
 * Version: 1.0
 * Author URI: http://therightsw.com/
 *
 * Text Domain: trs-book-printing
 *
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}



add_action('add_meta_boxes', 'print_actions_box');
function print_actions_box()
{
    add_meta_box(
        'print-actions-box',
        'Print Action Buttons',
        'print_actions_box_callback',
        'shop_order',
        'side',
        'core'
    );
}

//define printing order status
function print_register_printing_arrival_order_status() {
    register_post_status( 'wc-printing', array(
        'label'                     => 'Printing',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Printing <span class="count">(%s)</span>', 'Printing <span class="count">(%s)</span>' )
    ) );
}
add_action( 'init', 'print_register_printing_arrival_order_status' );

function print_add_printing_to_order_statuses( $order_statuses ) {
    $new_order_statuses = array();
    foreach ( $order_statuses as $key => $status ) {
        $new_order_statuses[ $key ] = $status;
        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-printing'] = 'Printing';
        }
    }
    return $new_order_statuses;
}
add_filter( 'wc_order_statuses', 'print_add_printing_to_order_statuses' );

// Callback
function print_actions_box_callback($post)
{
    global $woocommerce, $post;

    $order = new WC_Order($post->ID);
	$p_count = 0;

    //to escape # from order id 

    $order_id = $order->get_id(); //trim(str_replace('#', '', $order->get_order_number()));
	if ($order->data['status'] == 'processing') {
		echo '<table>
				<tr>
					<td><button type="button" class="button button-primary" id="fetch_pdf_link" data-orderId=' . $order_id . '>Fetch Pdf Link</button></td>
					<td><button type="button" class="button button-primary" id="send_book_data_for_printing" data-orderId=' . $order_id . '>Send data for printing</button></td>
				</tr>
			</table>';
		
	}
	echo '<div id="book_pdf_link">';
	if (get_post_meta($order_id, '_woo_book_print_google_files', true)) {
		
		$woo_order_get_files = get_post_meta($order_id, '_woo_book_order_google_files', true);
		$woo_order_get_files_covers = get_post_meta($order_id, '_woo_book_order_google_files_cover', true);
		foreach ($order->get_items() as $item_id => $item) {
			if (isset($woo_order_get_files[$item_id]) && isset($woo_order_get_files_covers[$item_id])) { $p_count++;
				if ($p_count == 1) {
					echo '<p><h3 style="margin:5px 0;">File Links:</h3>';
				}
				echo '<p>' . $woo_order_get_files[$item_id];
				echo '<br>';
				echo $woo_order_get_files_covers[$item_id] . '</p>';
			}
		}
		
	}
	echo '</div>';
	echo '<div id="send_json_to_printer_response"></div>
						<img src="https://i.gifer.com/origin/b4/b4d657e7ef262b88eb5f7ac021edda87.gif" class="trs-preloader" width="30px">';
}



add_action('admin_footer', 'trs_book_printing_footer_scripts');
function trs_book_printing_footer_scripts()
{
?>
    <style>
        .trs-preloader {
            display: none;
        }
    </style>
    <script>
        jQuery(document).ready(function($) {

            $("#fetch_pdf_link").click(function() {
                $(".trs-preloader").css("display", "block");
                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'POST',
                    data: {
                        'action': 'fetchbookpdflink',
                        'order_id': $("#fetch_pdf_link").attr("data-orderId")
                    },
                    success: function(response) {
                        console.log(response);
                        $(".trs-preloader").css("display", "none");
                        $("#book_pdf_link").html(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

            $("#send_book_data_for_printing").click(function() {
                $(".trs-preloader").css("display", "block");
                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'POST',
                    data: {
                        'action': 'sendbookdataforprinting',
                        'order_id': $("#send_book_data_for_printing").attr("data-orderId")
                    },
                    success: function(response) {
                        $(".trs-preloader").css("display", "none");
                        $("#send_json_to_printer_response").html(response);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });

        });
    </script>
<?php
}


// Ajax Function for fetching TRS Book pdf link

add_action('wp_ajax_fetchbookpdflink', 'fetchbookpdflink');
add_action('wp_ajax_nopriv_fetchbookpdflink', 'fetchbookpdflink');

function fetchbookpdflink()
{
    $order_id = $_POST['order_id'];
	$order = wc_get_order($order_id);

    global $wpdb;
	$pdf_file_links_for_matching_to_drive_files = array();
	$pdf_file_links_for_matching_to_drive_files_cover = array();
   
    $wpdb_prefix = $wpdb->prefix;
    $table1 = $wpdb_prefix . 'woocommerce_order_items';
    $table2 = $wpdb_prefix . 'woocommerce_order_itemmeta';
   // $results = $wpdb->get_results('Select * from ' . $table1 . ' INNER join ' . $table2 . ' On ' . $table1 . '.order_item_id = ' . $table2 . '.order_item_id Where ' . $table1 . '.order_id =' . $order_id);

    // Matching pdf file names with Drive Files, if found, save pdf download links in order meta for sending to printer in json

   // $pdf_file_links_for_matching_to_drive_files = get_post_meta($order_id, '_pdf_file_links_for_matching_to_drive_files', true);

    require plugin_dir_path(__FILE__) . 'vendor/autoload.php';

    $client = new Google_Client();

    $client->setApplicationName('Characterful Personalised Story Books');

    $client->setRedirectUri(plugin_dir_url(__FILE__) . 'drive-callback.php');

    $client->setScopes(Google_Service_Drive::DRIVE);
    $client->setAuthConfig(plugin_dir_path(__FILE__) . 'credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    $client->setIncludeGrantedScopes(true);

    $tokenPath = plugin_dir_path(__FILE__) . 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);
    }
    if ($client->isAccessTokenExpired()) {
        // Refresh the token if possible, else fetch a new one.
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {
            // Request authorization from the user.
            $authUrl = $client->createAuthUrl();
            echo 'Go to url to create new access token <a href="' . $authUrl . '" target="_blank">' . $authUrl . '</a>';
        }
    }

    $driveService = new Google_Service_Drive($client);
    $woo_files = array();
    $woo_cover_files = array();
	$woo_order_files = array();
    $woo_order_cover_files = array();
    $response = $driveService->files->listFiles(array(
        'q' => 'mimeType != "application/vnd.google-apps.folder" and "1oFATn9_FFnrSm05e6rcKP3UZ6Vu01XGB" in parents',
        'fields' => 'nextPageToken, files(name, webContentLink)',
    ));
    if (!empty($response->getFiles())) {
		 echo '<h3 style="margin:5px 0;">File Links:</h3>';
		foreach ($order->get_items() as $item_id => $item) {
        $product_id = $item->get_product_id();
		
        if (wc_get_order_item_meta( $item_id, 'language')) {
            $language = wc_get_order_item_meta( $item_id, 'language');
		}
        if (wc_get_order_item_meta( $item_id, 'Child 1 name')) {
            $child_1_name = strtok(wc_get_order_item_meta( $item_id, 'Child 1 name'), " "); // Getting first word only
		}
        if (wc_get_order_item_meta( $item_id, 'cover-type')) {
            $cover_type =wc_get_order_item_meta( $item_id, 'cover-type');
        }
    
    
    if ($cover_type == "SoftCover") {
        $cover_type = "HC";
    } else if ($cover_type == "Hardcover") {
        $cover_type = "HC";
    } else if ($cover_type == "Awesome Edition") {
        $cover_type = "AE";
    }

    $product = wc_get_product($product_id);
    $book_reference = $product->get_meta('book_reference');

    // Saving page count for using in Json sending to printer
    $pdf_page_count = $product->get_meta('number_of_pages');
	update_post_meta($order_id, '_pdf_page_count_'.$item_id, $pdf_page_count);

    $woo_file_link = $order_id . '-' . $book_reference . '-' . $language . '-' . $child_1_name . '-' . $cover_type . '.pdf';
    $woo_cover_file_link = $order_id . '-' . $book_reference . '-' . $language . '-' . $child_1_name . '-' . $cover_type . '-COVER.pdf';

    //$pdf_file_links_for_matching_to_drive_files[$product_id] = $woo_file_link;
    //$pdf_file_links_for_matching_to_drive_files_cover[$product_id] = $woo_cover_file_link;
    //update_post_meta($order_id, '_pdf_file_links_for_matching_to_drive_files', $pdf_file_links_for_matching_to_drive_files);

       
	    
        foreach ($response->getFiles() as $file) {
            if ($file->getName() == $woo_file_link) {
				$woo_files[$item_id] = $file->getWebContentLink();
				$woo_order_files[$item_id] = $woo_file_link;
				echo '<p>' . $woo_file_link. '</p>';
            } elseif ($file->getName() == $woo_cover_file_link) {
                $woo_cover_files[$item_id] = $file->getWebContentLink();
				 $woo_order_cover_files[$item_id] = $woo_cover_file_link;
				echo '<br>';
				echo $woo_cover_file_link . '</p>';
            }
        }
	}
	

        if (!empty($woo_files)) {
            update_post_meta($order_id, '_woo_book_print_google_files', $woo_files);
            update_post_meta($order_id, '_woo_book_print_google_files_cover', $woo_cover_files);
			update_post_meta($order_id, '_woo_book_order_google_files', $woo_order_files);
            update_post_meta($order_id, '_woo_book_order_google_files_cover', $woo_order_cover_files);
            echo "File links saved in order meta";
        } else {
            echo "No files matched";
        }
    } else {
        echo "No files found in drive";
    }


    wp_die();
}



// Ajax Function for sedning TRS Book data to printer api

add_action('wp_ajax_sendbookdataforprinting', 'sendbookdataforprinting');
add_action('wp_ajax_nopriv_sendbookdataforprinting', 'sendbookdataforprinting');

function sendbookdataforprinting()
{
    $order_id = $_POST['order_id'];
    $order = wc_get_order($order_id);
    $i = 1;
    $args = array();
    if (get_post_meta($order_id, '_woo_book_print_google_files', true)) {
        $woo_get_files = get_post_meta($order_id, '_woo_book_print_google_files', true);
		$woo_get_files_covers = get_post_meta($order_id, '_woo_book_print_google_files_cover', true);
        foreach ($order->get_items() as $item_id => $item) {
            $product_id = $item->get_product_id();
			$product_id_files = $item->get_product_id();
            $variation_id = $item->get_variation_id();
            $product = $item->get_product();
            $name = $item->get_name();
            $quantity = $item->get_quantity();

            if ($item->is_type('variable')) {
                $variation_id = $item->get_variation_id();
				$product_id_files = $item->get_variation_id();
            }
			if (isset($woo_get_files[$item_id]) && isset($woo_get_files_covers[$item_id])) {
				$args[] = array(
				"id"=> $variation_id,
				"sku"=> $product->get_sku(),
				"remote_file?"=> true,
				"item_path"=> $woo_get_files[$item_id],
				"md5"=> "fc9cc0f3ebf64fe2ca45df44efdba9ac",
				"cover_type"=> null,
				"cover_url"=> $woo_get_files_covers[$item_id],
				"cover_url_md5"=> "213b8a8b29d59912feecbb9a5f6e442f",
				"quantity"=> $quantity,
				"page_count"=> get_post_meta($order_id, '_pdf_page_count_'.$item_id, true),
				"options"=> array(
					"character"=> $item->get_meta('Child 1 character', true),
					"language"=> "en-US",
					"name" => $item->get_meta('Child 1 name', true)
				));
			}
			
        }
        // $args = json_encode($args);
        $PayLoad = array(
            "order_on" => wc_format_datetime($order->get_date_created()),
            "order_id" => $order->get_id(),
            "shipment_id" => "H234234234",
            "items" => $args,
            "ship_to" => array(
                "name" => $order->get_formatted_shipping_full_name(),
                "address1" => $order->get_shipping_address_1(),
                "address2" =>  $order->get_shipping_address_2(),
                "town" => $order->get_shipping_city(),
                "state" =>  $order->get_shipping_state(),
                "postcode" => $order->get_shipping_postcode(),
                "country" => $order->get_shipping_country(),
                "phone" => $order->get_billing_phone(),
                "isoCountry" => $order->get_shipping_country(),
                "email" => $order->get_billing_email()
            ),
            "ship_via" => $order->get_shipping_method(),
            "reprint" => false,
            "reprint_reason" => null,
            "order_locale" => "en-GB",
            "packaging" => "Standard",
            "status" => "create"
        );

        $APIKey = 'characterful_f6a38ca5';

        //Initiate cURL.
        $ch = curl_init("https://characterful.charlesworth.com/api/receive.php");

        //Encode the array into JSON.
        $jsonDataEncoded = json_encode($PayLoad);

        //Tell cURL that we want to send a POST request.
        curl_setopt($ch, CURLOPT_POST, 1);

        //Attach our encoded JSON string to the POST fields.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($APIKey != '') {
            //Set the content type to application/json
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'api-key: ' . $APIKey));
        }

        //Execute the request
        $resJson = curl_exec($ch);
		
		$err = curl_error($ch);

		curl_close($ch);

		if ($err) {
		  echo "cURL Error #:" . $err;
		} else {
			$response = json_decode($resJson, true);
			if (isset($response['status'])){
				 if ($response['status']){
					 $order->update_status('completed');
					 echo $response['message'];
				} else {
					echo $response['message'];
				}
			} else {
				echo $resJson;
			}
        
		}
    } else {
        echo "No files found.";
    }


    wp_die();
}



// Api Endpoint for changing order status for charlesworth printer

add_action('rest_api_init', 'trsPdfPrintingAPIEndpoints');

function trsPdfPrintingAPIEndpoints()
{
    register_rest_route('trs-pdf-printing-api', '/orderupdates', array(
        'methods'         => 'POST',
        'callback' =>  'orderupdates',
    ));
}

function orderupdates(WP_REST_Request $request)
{
	$parameters = $request->get_params();
    if (!$parameters['order_id']) {

        $message = "You must include a 'order id' variable.";
        $response = array("status" => "failure", "message" => $message);
        return new WP_REST_Response($response, 200);
    } else {
        $order_id = intval($parameters['order_id']);
    }
	
	if (!$parameters['shipment_date']) {

        $message = "You must include a 'shipment_date id' variable.";
        $response = array("status" => "failure", "message" => $message);
        return new WP_REST_Response($response, 200);
    } else {
        $shipment_date = intval($parameters['shipment_date']);
    }
	
	if (!$parameters['tracking_number']) {

        $message = "You must include a 'tracking_number id' variable.";
        $response = array("status" => "failure", "message" => $message);
        return new WP_REST_Response($response, 200);
    } else {
        $tracking_number = intval($parameters['tracking_number']);
    }
	
	if (!$parameters['tracking_link']) {

        $message = "You must include a 'tracking_link id' variable.";
        $response = array("status" => "failure", "message" => $message);
        return new WP_REST_Response($response, 200);
    } else {
        $tracking_link = intval($parameters['tracking_link']);
    }

    if (get_post_type($order_id) != "shop_order") {
        $message = "Invalid order id.";
        $response_json = array("status" => "failure", "data" => $message);
        return new WP_REST_Response($response_json, 200);
    } else {
        $order = new WC_Order($order_id);
		
		if ( function_exists( 'wc_st_add_tracking_number' ) ) {
			$provider = apply_filters( 'woocommerce_shipment_tracking_default_provider', $provider );
			wc_st_add_tracking_number( $order_id, $tracking_number, $provider, $shipment_date );
			$order->update_status('completed');
        //update_post_meta($order_id, '_pdf_printing_tracking_link', $parameters['order_tacking-link']);
        $message = "The status of order with order_id = " . $order_id . " is updated to completed.";
		
        $response_json = array("status" => "success", "data" => $message);
		} else {
			$message = "Shipment tracking missing.";
			$response_json = array("status" => "failure", "data" => $message);
		}

        return new WP_REST_Response($response_json, 200);
    }
}
