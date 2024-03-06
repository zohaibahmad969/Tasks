<?php


function add_comment_field_to_product_page() {
    echo '<div class="comment-field">
            <label for="product_comment">Add a Comment:</label>
            <textarea id="product_comment" name="product_comment"></textarea>
          </div>';
}

add_action('woocommerce_before_add_to_cart_button', 'add_comment_field_to_product_page');

function save_product_comment_to_cart($cart_item_data, $product_id) {
    if (isset($_POST['product_comment'])) {
        $cart_item_data['product_comment'] = sanitize_text_field($_POST['product_comment']);
    }
    return $cart_item_data;
}

add_filter('woocommerce_add_cart_item_data', 'save_product_comment_to_cart', 10, 2);

function display_product_comment_in_cart($item_data, $cart_item) {
    if (isset($cart_item['product_comment']) && !empty($cart_item['product_comment']) ) {
        $item_data[] = array(
            'key' => 'Comment',
            'value' => wp_kses_post($cart_item['product_comment']),
        );
    }
    return $item_data;
}

add_filter('woocommerce_get_item_data', 'display_product_comment_in_cart', 10, 2);

function add_product_comment_to_order_item($item, $cart_item_key, $values, $order) {
    if (isset($values['product_comment'])  && !empty($cart_item['product_comment']) ) {
        $item->add_meta_data('Comment', $values['product_comment']);
    }
}

add_action('woocommerce_checkout_create_order_line_item', 'add_product_comment_to_order_item', 10, 4);





// Add "Pickup date" and "Comments/Special Instructions" field to WooCommerce checkout
add_action('woocommerce_before_order_notes', 'pickup_date_field');
function pickup_date_field($checkout) {
    
    echo '<div id="pickup_delivery_field_wrap">';
    echo '<p class="form-row form-row-wide"><label for="pickup_delivery_radio">' . __('Would you like Pickup or Delivery?', 'woocommerce') . ' <span class="required">*</span></label>';
    woocommerce_form_field('pickup_delivery', array(
        'type' => 'radio',
        'class' => array('form-row-wide'),
        'options' => array(
            'pickup' => __('Pickup', 'woocommerce'),
            'delivery' => __('Delivery', 'woocommerce'),
        ),
        'default' => 'delivery',
        'required' => true,
    ), $checkout->get_value('pickup_delivery'));
    echo '</p></div>';
    
    
    echo '<div id="pickup_date_field">';
    woocommerce_form_field('pickup_date', array(
        'type' => 'date',
        'class' => array('form-row-wide'),
        'label' => __('Select Pickup or Delivery Date'),
        'required' => true,
    ), $checkout->get_value('pickup_date'));
    echo '<p class="pickup_date_notice">Order before noon for next business day delivery.<br>Any order placed after noon will be available for delivery in 2 business days or a selected date after.</p></div>';
    
    
    
    echo '<div id="comments_special_instructions_field">';
    woocommerce_form_field('comments_special_instructions', array(
        'type' => 'textarea',
        'class' => array('form-row-wide'),
        'label' => __('Add Comments/Special Instructions'),
        'required' => false,
    ), $checkout->get_value('comments_special_instructions'));
    echo '</div>';
    
    
    
    echo '<div id="gift_checkbox_field">';
    woocommerce_form_field('is_gift', array(
        'type' => 'radio',
        'class' => array('form-row-wide'),
        'options' => array(
            'yes' => __('Yes'),
            'no' => __('No')
        ),
        'default' => 'no',
        'label_class' => array('woocommerce-form__label woocommerce-form__label-for-checkbox checkbox'),
        'input_class' => array('woocommerce-form__input woocommerce-form__input-checkbox input-checkbox'),
        'label' => __('Is this a gift?'),
    ), $checkout->get_value('is_gift'));

    echo '</div>';
    
    $is_gift = WC()->session->get('is_gift');
    $style = ($is_gift === 'yes') ? 'block' : 'none';
    
    echo '<div id="gift_note_field" style="display: ' . $style . ';">';
    woocommerce_form_field('gift_note', array(
        'type' => 'textarea',
        'class' => array('form-row-wide'),
        'label_class' => array('woocommerce-form__label woocommerce-form__label-for-textarea textarea'),
        'input_class' => array('woocommerce-form__input woocommerce-form__input-textarea textarea'),
        'label' => __('Add a gift note'),
    ), $checkout->get_value('gift_note'));
    echo '</div>';
    
    
}
// Enqueue JavaScript to toggle visibility based on radio button selection
add_action('wp_footer', 'show_hide_gift_note_field_script');

function show_hide_gift_note_field_script() {
    if (is_checkout()) {
        ?>
        <script type="text/javascript">
            jQuery(function ($) {
                $('input[name="is_gift"]').change(function () {
                    var isGift = $(this).val();
                    if (isGift === 'yes') {
                        $('#gift_note_field').slideDown();
                    } else {
                        $('#gift_note_field').slideUp();
                    }
                });
            });
        </script>
        <?php
    }
}






// Validate "Pickup date" field
add_action('woocommerce_checkout_process', 'validate_pickup_date');
function validate_pickup_date() {
    
    if (empty($_POST['pickup_delivery'])) {
        wc_add_notice(__('Please choose Pickup or Delivery.', 'woocommerce'), 'error');
    }
    
    if (isset($_POST['pickup_date']) && empty($_POST['pickup_date'])) {
        wc_add_notice(__('Please select a Pickup or Delivery Date.', 'woocommerce'), 'error');
    }
}
// Validate and save "Pickup date" and "Comments/Special Instructions" fields
add_action('woocommerce_checkout_update_order_meta', 'save_pickup_date');
function save_pickup_date($order_id) {
    
    if (!empty($_POST['pickup_delivery'])) {
        update_post_meta($order_id, 'pickup_or_delivery', sanitize_text_field($_POST['pickup_delivery']));
    }
    if (!empty($_POST['pickup_date'])) {
        update_post_meta($order_id, 'Pickup Date', sanitize_text_field($_POST['pickup_date']));
    }
    if (!empty($_POST['comments_special_instructions'])) {
        update_post_meta($order_id, 'Comments/Special Instructions', sanitize_text_field($_POST['comments_special_instructions']));
    }
    if (!empty($_POST['is_gift'])) {
        update_post_meta($order_id, '_is_gift', sanitize_text_field($_POST['is_gift']));
    }
    if (!empty($_POST['gift_note'])) {
        update_post_meta($order_id, '_gift_note', sanitize_text_field($_POST['gift_note']));
    }
    if (isset($_POST['permission_checkbox']) && $_POST['permission_checkbox'] == 1) {
        update_post_meta($order_id, 'permission_checkbox', 1);
    } else {
        update_post_meta($order_id, 'permission_checkbox', 0);
    }
}




// Add "Permission to contact customer via email or text" checkbox
add_action('woocommerce_review_order_before_submit', 'add_permission_checkbox');
function add_permission_checkbox() {
    echo '<div id="permission_checkbox" class="form-row form-row-wide">';
    woocommerce_form_field('permission_checkbox', array(
        'type' => 'checkbox',
        'class' => array('input-checkbox'),
        'label' => __('Permission to contact customer via email or text', 'woocommerce'),
    ));
    echo '</div>';
}



// Add "Pickup Date" and "Permission" to the order details meta box
add_action('woocommerce_admin_order_data_after_billing_address', 'display_pickup_date_in_order_details');

function display_pickup_date_in_order_details($order) {
    
    $pickup_or_delivery = get_post_meta($order->get_id(), 'pickup_or_delivery', true);
    $pickup_delivery_text = ($pickup_or_delivery === 'pickup') ? 'Pickup' : 'Delivery';
    echo '<p><strong>Pickup or Delivery:</strong> ' . esc_html($pickup_delivery_text) . '</p>';
    
    $pickup_date = get_post_meta($order->get_id(), 'Pickup Date', true);
    if ($pickup_date) {
        echo '<p><strong>Pickup Date:</strong> ' . esc_html($pickup_date) . '</p>';
    }
    
    $is_gift = get_post_meta($order->get_id(), '_is_gift', true);
    if ($is_gift) {
        echo '<p><strong>Is this a gift? :</strong> ' . esc_html($is_gift) . '</p>';
    }
    
    $gift_note = get_post_meta($order->get_id(), '_gift_note', true);
    if ($gift_note) {
        echo '<p><strong>Gift Note:</strong> ' . esc_html($gift_note) . '</p>';
    }
    
    $permission_checkbox = get_post_meta($order->get_id(), 'permission_checkbox', true);
    if ($permission_checkbox) {
        echo '<p><strong>Permission to contact:</strong> Yes</p>';
    } else {
        echo '<p><strong>Permission to contact:</strong> No</p>';
    }
    
    $comments_special_instructions = get_post_meta($order->get_id(), 'Comments/Special Instructions', true);
    if ($comments_special_instructions) {
        echo '<p><strong>Comments/Special Instructions:</strong> ' . esc_html($comments_special_instructions) . '</p>';
    }
}






// Adding Custom meta data on order emails

add_action('woocommerce_email_order_meta', 'add_pickup_or_delivery_to_order_email', 10, 3);

function add_pickup_or_delivery_to_order_email($order, $sent_to_admin, $plain_text) {
    // Get the pickup or delivery meta data from the order
    $pickup_or_delivery = $order->get_meta('pickup_or_delivery');
    $pickup_date = $order->get_meta('Pickup Date');
    $comments_special_instructions = $order->get_meta('Comments/Special Instructions');
    $is_gift = $order->get_meta('_is_gift');
    $gift_note = $order->get_meta('_gift_note');
    $permission_checkbox = $order->get_meta('permission_checkbox');
    if ($permission_checkbox === '0') {
        $permission_checkbox = 'No';
    } else {
        $permission_checkbox = 'Yes';
    }
    
     echo '
        <style>
            .additional-details-border{
                color: #636363;border:1px solid #e5e5e5;vertical-align:middle;width:100%;margin-bottom: 20px;
            }
            .additional-details-border td,
            .additional-details-border th{
                border: 1px solid #e5e5e5;
            }
        </style>
        <table class="additional-details-border" cellpadding="6" cellspacing="0">
            <tbody>
                <tr>
                    <th colspan="2" style="text-align: center;">Additional Details</th>
                </tr>';
    // Output the meta data in the email
    if ($pickup_or_delivery) {
       echo '
            <tr>
                <th>Would you like Pickup or Delivery?</th>
                <td style="text-transform: capitalize;">'.$pickup_or_delivery.'</td>
            </tr>';
    }            
    if ($pickup_date) {
       echo '
            <tr>
                <th>Pickup Date</th>
                <td style="">'.$pickup_date.'</td>
            </tr>';
    }  
                
    if ($comments_special_instructions) {
       echo '
            <tr>
                <th>Comments/Special Instructions</th>
                <td style="">'.$comments_special_instructions.'</td>
            </tr>';
    }             
    if ($is_gift) {
       echo '
            <tr>
                <th>Is this a gift?</th>
                <td  style="text-transform: capitalize;">'.$is_gift.'</td>
            </tr>';
    }             
    if ($gift_note) {
       echo '
            <tr>
                <th>Gift note</th>
                <td style="">'.$gift_note.'</td>
            </tr>';
    }             
    if ($permission_checkbox) {
       echo '
            <tr>
                <th>Permission to contact customer via email or text</th>
                <td  style="text-transform: capitalize;">'.$permission_checkbox.'</td>
            </tr>';
    } 
                        
    echo '                   
            </tbody>
        </table>';
}

