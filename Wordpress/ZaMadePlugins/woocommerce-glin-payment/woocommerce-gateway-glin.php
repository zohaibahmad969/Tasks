<?php
/**
 * Plugin Name: Glin Payment Gateway
 * Plugin URI: https://wordpress.org/plugins/woocommerce-gateway-glin/
 * Description: Woocomerce payments on your store using Glin.
 * Author: ikonic
 * Author URI: https://glin.com/
 * Version: 1.0.0
 * Requires at least: 4.0
 * Tested up to: 5.3.2
 * WC requires at least: 2.6
 * WC tested up to: 3.9.2
 * Text Domain: woocommerce-gateway-glin
 * Domain Path: /languages
 *
 */
 
 //include( plugin_dir_path( __FILE__ ) . 'paymentresponse.php');

if(isset($_GET['success']) && $_GET['success'] == "true"){
	echo '
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script>
			jQuery(document).ready(function($){
				$("#orderUpdates").append("<p>Thank you for the order. We have received the payment. We will notify you shortly.</p>");
			});
		</script>
	';
}
 
function register_paid_by_customers() {
    register_post_status( 'wc-by-customer', array(
            'label' => _x( 'Payment Received', 'Order Status', 'woocommerce-gateway-glin' ),
            'public' => true,
            'exclude_from_search' => false,
            'show_in_all_admin_list' => true,
            'show_in_admin_status_list' => true,
            'label_count' => _n_noop(
                'Invoiced <span class="count">(%s)</span>',
                'Invoiced <span class="count">(%s)</span>',
                'woocommerce-gateway-glin' )
        )
    );
}
add_action( 'init', 'register_paid_by_customers' );

function paid_by_customer_statuss( $order_statuses ){
    $order_statuses['wc-by-customer'] = _x( 'Payment Received', 'Order Status', 'woocommerce-gateway-glin' );
    return $order_statuses;
}

add_filter( 'wc_order_statuses', 'paid_by_customer_statuss' );



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * This action hook registers our PHP class as a WooCommerce payment gateway
 */
define('GLIN_GATEWAY_PLUGIN_URL', plugin_dir_url(__FILE__));


add_filter( 'woocommerce_payment_gateways', 'glin_add_gateway_class' );

function glin_add_gateway_class( $gateways ) {
	$gateways[] = 'WC_Glin_Gateway'; // your class name is here
	return $gateways;
}


/*
 * The class itself, please note that it is inside plugins_loaded action hook
 */
add_action( 'plugins_loaded', 'woocommerce_gateway_glin_init' );

function carrega_scriptss() {
    wp_enqueue_style('jquery_modal_css','https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css', array(),'','all');
    wp_enqueue_script('jquery_modal_js','https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js', array(),null,true);
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_style( 'wp-jquery-ui-dialog' );
	wp_enqueue_script( 'frontend-custom', get_template_directory_uri() . '/assets/js/frontend-custom.js', array("jquery"));
}
add_action( 'wp_enqueue_scripts', 'carrega_scriptss' );

//wc-checkout 	
function woocommerce_gateway_glin_init() {

    if ( ! class_exists( 'WooCommerce' ) ) {
	//	add_action( 'admin_notices', 'woocommerce_stripe_missing_wc_notice' );
		return;
	}
	
	class WC_Glin_Gateway extends WC_Payment_Gateway {
		
 		/**
 		 * Class constructor, more about it in Step 3
 		 */
 		public function __construct() {
 		    
            $this->id = 'Glin'; // payment gateway plugin ID
            
            $this->icon = '';
            
            if( !is_checkout()){ // tela admin detalhes do pedido
                $this->title = 'Glin - Cartão de Crédito Parcelado, PIX';
            }else{ // tela de checkout pagamento
                $this->title = 'Glin - Cartão de Crédito Parcelado, PIX';
            }
            
            $this->has_fields = false; // in case you need a custom credit card form
            $this->method_title = 'Glin Gateway ';
            $this->method_description = 'Glin - Cartão de Crédito Parcelado, PIX'; // will be displayed on the options page

            $this->supports = array(
                'products'
            );
            
                
            
            
            // Method with all the options fields
            $this->init_form_fields();
        
            // Load the settings.
            $this->init_settings();
            $this->enabled = $this->get_option( 'enabled' );
            $this->secret_key = $this->get_option( 'secret_key' );
            $this->client_id = $this->get_option( 'client_id');
            // Save settings
            
         }

		/**
 		 * Plugin options, we deal with it in Step 3 too
 		 */
 		public function init_form_fields(){
            global $wp; 
             $this->form_fields = array(
                'enabled' => array(
                    'title'       => 'Enable/Disable',
                    'label'       => 'Enable Glin Gateway',
                    'type'        => 'checkbox',
                    'description' => '',
                    'default'     => 'yes'
                ),
				'client_id' => array(
                    'title'       => '101',
                    'type'        => 'text'
                ),
                'secret_key' => array(
                    'title'       => 'Bearer Key',
                    'type'        => 'text',
                    'default'     => ''
                ),
                'webHook' => array(
                    'title'       => 'WebHook',
                    'type'        => 'textarea',
                    'description' => 'Copy and Paste the link above',
                ),
            );
         }
         
         public function calcMultiCurrencyBRLtoUSD( $vlr ) {
            if($this->enableMultiCurrency  && 'BRL' == $this->moedaSelecionada ){
                return $vlr / $this->valorReais;
            }
            return $vlr;
        }

 
		
 
		/*
		 * We're processing the payments here, everything about it is in Step 5
		 */
		 
		 public function check_payment(){
		     
		 }
		public function process_payment( $order_id ) {
		    
			global $wp; 
			global $wp_session;
			$wp_session['order_id'] = $order_id;
			$order = wc_get_order( $order_id );
    
            $args = array(
                'successUrl' => 'https://muneka.us/wp-content/plugins/glin-payment/paymentresponse.php', 
                'cancelUrl'  => home_url( $wp->request ) . '/carrinho', 
                'client[email]' => $_POST['billing_email'],
                'client[name]'  => $_POST['billing_first_name'].' '.$_POST['billing_last_name'],
                'client[cep]'   => $_POST['billing_postcode'],
                'client[phone]' => $_POST['billing_phone'],
                'client[cpf]' => $order->get_meta( '_billing_cpf' ),
				'client[address_street]' => $_POST['billing_address_1'],
				'client[address_complement]' => (!isset($_POST['billing_address_2']) ? '' : $_POST['billing_address_2']),
				'client[address_number]' => (!isset($_POST['billing_number']) ? '' : $_POST['billing_number']),
				'client[address_neighborhood]' => $_POST['billing_city'],
				'client[address_city]' => $_POST['billing_city'],
				'client[address_state]' => $_POST['billing_state'],
				'shipping[amount]' =>$this->calcMultiCurrencyBRLtoUSD($order->get_total_shipping())*100, //$order->get_total_shipping()*100,
				'clientReferenceId' => "WCM".strtoupper( substr(uniqid(mt_rand()), 0, 5) ) . '_' . $order_id,         
				'amount' =>  $order->calculate_totals(),
				'currency'=> 'USD',
				"expiresAt"=> "2023-08-18T10:00:00Z",
            );
            
            $i=0; 
            // Get and Loop Over Order Items
            foreach ($order->get_items() as $item_id => $item) {
            
                $product_id = $item->get_product_id();
                $variation_id = $item->get_variation_id();
                $product = $item->get_product();
                $name = $item->get_name();
                $quantity = $item->get_quantity();
            
                $price = ($order->get_item_subtotal($item,false)) * 100;
                $price= $this->calcMultiCurrencyBRLtoUSD($price); // BRL change to USD
                $item_name= $name;
   
                $args= array_merge($args, array('items['.$i.'][description]' => $item_name,
                'items['.$i.'][quantity]' => $quantity,
                'items['.$i.'][amount]' => $price)); 
	
                $i++;
            }
            
            $item_name = "TAXES";
            $quantity = 1;
            $taxesAmount = (0 + $order->get_total_tax())*100;
            $taxesAmount= $this->calcMultiCurrencyBRLtoUSD($taxesAmount); //BRL change to USD

            if ($taxesAmount > 0) {
                
                $args= array_merge($args, array('items['.$i.'][description]' => $item_name,
                'items['.$i.'][quantity]' => $quantity,
                'items['.$i.'][amount]' =>  $this->calcMultiCurrencyBRLtoUSD(  ($order->get_total_tax()*100) ) )); //BRL change to USD
                
            }
            
            $couponCode = "COUPON";
            $discount = (0 + WC()->cart->get_discount_total())*100;
            $discount= $this->calcMultiCurrencyBRLtoUSD($discount);// BRL change to USD

            if($discount > 0 ) {
                $args= array_merge($args, array('coupon[code]' => $couponCode,
                'coupon[value]' => $discount,
                'coupon[issuer]' => "merchant_api"));
            }
            
            print_r($args);
    
			
           /* if (!session_id()) {
              session_start();
            }*/
            
            
            
            
			 
            /*  Your API interaction could be built with wp_remote_post() */
            // $args = array(
            //     "clientReferenceId"=> "Client".rand(10,1000),
            //     "amount"=> 1030.00,
            //     "currency"=> "USD",
            //     "expiresAt"=> "2023-08-18T10:00:00Z",
            //     "successUrl"=> "https://muneka.us/wp-content/plugins/glin-payment/paymentresponse.php",
            //     "cancelUrl"=> "https://muneka.us"     
            // );
            //https://muneka.us/en/order-updates
          //  
            $args = json_encode($args);
            $payload = array(
                'method' => 'POST',
                'headers' => array(
                    'Authorization' => "Bearer YThkMjg2MWEtNTdjMy00ZDBlLTk4ZGQtZmQyOGUyNmIxMjI2OkNBME1iUDd4Nm9KbjBaWW5IenlaNmpzN2hGTzNQVndI",
                    'Content-Type' => "application/json"
                    ),
                'body' =>  $args
            );
            $wp_session['order_id'] = $order_id;

            print_r($payload);

            $response = wp_remote_post( 'https://pay.glin.com.br/merchant-api/remittances/', $payload );
            $payment_id = json_decode($response['body']);
            
            $wp_session['payment_id'] = $payment_id->id;
            
            
            if (is_wp_error($response)) {
                throw new Exception(__('There is issue for connectin payment gateway. Sorry for the inconvenience.',
                    'wc-gateway-nequi'));
            }
        
            if (empty($response['body'])) {
                throw new Exception(__('Glin.com\'s Response was not get any data.', 'wc-gateway-nequi'));
            }

            $body = json_decode( wp_remote_retrieve_body( $response ), true );

            if ( $body['status'] == 'created' ) {
                    $data= $body['data'];

                    return [
                        'result' => 'success',
                        'redirect' => urldecode( $body['checkoutUrl'] ),
                    ];
            } else {
                     wc_add_notice(  'Some error occured at Glin.', 'error' );
				 	print_r( $response );
                     return;
            }
	 	}

	 
 	}
}