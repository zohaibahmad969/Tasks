<script>
  jQuery(document).ready(function ($) {
    $('body').on('change', '#cover_transactional_costs_field', function() {
          var isChecked = $(this).is(':checked');
          var data = {
              action: 'add_cover_transaction_cost_fee',
              is_checked: isChecked
          };
  
          $.ajax({
              type: 'POST',
              url: wc_checkout_params.ajax_url,
              data: data,
              success: function(response) {
                  // Update the order review section
                  console.log(response);
                  window.location.href = window.location.href;
              }
          });
      });
  });
</script>



<?php

// Allow empty checkout
add_filter( 'woocommerce_checkout_redirect_empty_cart', '__return_false' );
add_filter( 'woocommerce_checkout_update_order_review_expired', '__return_false' );




// Add checkbox option on checkout page for Admin Fees
function add_cover_transaction_cost_checkbox() {
    
    $percent_fee = (float) get_option('cover_transactional_costs_price');

    $cart_total = WC()->cart->cart_contents_total;
    $fee = ($cart_total * ($percent_fee / 100)) + 0.3;
    $fee = number_format($fee, 2);
        
    if( get_option('cover_transactional_costs') === "true" ){
        $checked = ' checked';
    }else{
        $checked = '';
    }
    
    echo '<div class="woocommerce-payment-box-additional-fields">
            <div class="za-additional-field-wrap">
                <div class="za-checkbox-field-wrap">
                    <input type="checkbox" class="za-checkbox-field" id="cover_transactional_costs_field" '.$checked.'>
                    <label for="cover_transactional_costs_field">Cover Transactional Costs</label>
                </div>  
                <div class="za-additional-field-price-wrap">
                    <span class="woo-currency">'.get_woocommerce_currency_symbol().'</span><span class="cover-transactional-costs">'.$fee.'</span>
                </div>
              </div>
          </div>';
}
add_action('woocommerce_review_order_before_payment', 'add_cover_transaction_cost_checkbox');


// ajax function for updating cover_transactional_costs option from checkout page
function add_cover_transaction_cost_fee_callback() {
    if (isset($_POST['is_checked']) && $_POST['is_checked'] == 'true') {
        update_option( 'cover_transactional_costs' , "true");
    }else{
        update_option( 'cover_transactional_costs' , "false");
    }
    wp_die();
}
add_action('wp_ajax_add_cover_transaction_cost_fee', 'add_cover_transaction_cost_fee_callback');
add_action('wp_ajax_nopriv_add_cover_transaction_cost_fee', 'add_cover_transaction_cost_fee_callback');


// // Calculate cart with fees added
function woo_add_cart_fee(  ) {
    if( get_option('cover_transactional_costs') === "true" ){
        
        $percent_fee = (float) get_option('cover_transactional_costs_price');
        $cart_total = WC()->cart->cart_contents_total;
        $fee = ($cart_total * ($percent_fee / 100)) + 0.3;
        $fee = number_format($fee, 2);
        
        WC()->cart->add_fee( 'Transactional Cost: ', $fee, false );
    }
}
add_action( 'woocommerce_cart_calculate_fees','woo_add_cart_fee' );


// Hook to add custom fields to the General settings page
add_filter( 'woocommerce_general_settings', 'custom_woocommerce_general_settings' );

function custom_woocommerce_general_settings( $settings ) {

    // Option: cover_transactional_costs_price
    $settings[] = array(
        'title'    => __( 'Transactional Costs Price', 'woocommerce' ),
        'desc'     => __( 'Enter the price to cover transactional costs.', 'woocommerce' ),
        'id'       => 'cover_transactional_costs_price',
        'type'     => 'text',
        'default'  => '',
        'desc_tip' => true,
    );

    return $settings;
}


?>
