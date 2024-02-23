<script>
  jQuery(document).on("submit",".za-quick-donation-form",function(e){
        e.preventDefault();
        let crnt = $(".za-quick-donation-form");
        let product_id = crnt.find(".za-donation-products option:selected").val();
        let amount = crnt.find(".donation-amount").val();
        
        // Perform AJAX call to add product to cart
        $.ajax({
            type: 'POST',
            url: '/wp-admin/admin-ajax.php',
            data: {
                'action': 'add_to_cart_action',
                'product_id': product_id,
                'quantity': 1, // Assuming quantity is 1 for donation products
                'amount': amount
            },
            success: function(response) {
                // Handle successful addition to cart
                console.log('Product added to cart successfully!', response);
                // You can add further actions here after successful addition to cart
                window.location.href = "/checkout";
            },
            error: function(error) {
                // Handle error scenario
                console.error('Error adding product to cart:', error);
            }
        });
        
    });
</script>


<?php

// Ajax function for adding product to cart with custom amount
add_action('wp_ajax_add_to_cart_action', 'add_to_cart_ajax');
add_action('wp_ajax_nopriv_add_to_cart_action', 'add_to_cart_ajax');

function add_to_cart_ajax() {
    if (isset($_POST['product_id']) && isset($_POST['amount'])) {
        $product_id = intval($_POST['product_id']);
        $donation_amount = floatval($_POST['amount']);
        $donation_dedication_to = $_POST['donation-dedication-to-name'];

        // Assuming WooCommerce is active
        if (class_exists('WooCommerce')) {
            global $woocommerce;

            WC()->cart->add_to_cart($product_id, 1, 0, [], ['donation_amount' => $donation_amount , 'donation_dedication_to' => $donation_dedication_to]);
            // Save cart to session
            $woocommerce->cart->set_session();


        }
    }

    wp_die();
}



// Modify cart item price on display
add_filter('woocommerce_cart_item_price', 'display_custom_price_in_cart', 10, 3);
function display_custom_price_in_cart($product_price, $cart_item, $cart_item_key) {
    if (isset($cart_item['donation_amount'])) {
        $product_price = wc_price($cart_item['donation_amount']);
    }
    return $product_price;
}



// Hook to modify cart item price based on donation amount
add_action('woocommerce_before_calculate_totals', 'apply_donation_amount_to_cart_item', 10, 1);
function apply_donation_amount_to_cart_item($cart) {
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }
    if (did_action('woocommerce_before_calculate_totals') >= 2) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
        if (isset($cart_item['donation_amount'])) {
            $cart_item['data']->set_price($cart_item['donation_amount']); // Set the price to the donation amount
        }
    }
}

?>
