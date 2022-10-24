<div class="row-mid">
<div class="container">

<?php
if(isset($_GET['bookingdate'])) {
	$get_date = $_GET['bookingdate'];
	$display_date = ' for '.date('D jS F Y', strtotime($get_date));
} else {
	$display_date = '';
}
?>

<!--<h1>Santa's Grotto 2020</h1>
<h2>Bookings<?php echo $display_date; ?></h2>
<div class="no-print" style="padding:0 0 30px 0;">
	<div><input type="text" id="datepicker"><span class="rdsn-date">&lt; Select date</span><a href="#" id="btn-select" class="btn-line btn-orange">Show Bookings</a><a href="#" id="btn-print" class="btn-line" onClick="window.print()">Print</a></div>
    <input type="hidden" id="date-field">
    <span class="rdsn-error">Please select a date</span>
</div>-->

<?php

$rdsn_query = NULL;
$args = (array(
	'post_type' => 'shop_order',
	'post_status' => 'wc-processing',
	'return' => 'ids',
	'limit' => -1,
	//'order' => 'ASC',
	//'orderby' => 'meta_value',
  	//'meta_key' => '_from'
	));	
$rdsn_query = new WP_Query($args);

//$rdsn_query->query($args);
if ($rdsn_query->have_posts()):
while ($rdsn_query->have_posts()):$rdsn_query->the_post();
	$order_id = get_the_ID();
	echo 'OrderID: '.$order_id.' - <br />';
	echo 'Blah<br />';
endwhile;
$rdsn_query = NULL;
endif;
wp_reset_postdata();

/*$args = array(
     'post_type' => 'shop_order',
     'post_status' => 'wc-processing'
);
$loop = new WP_Query( $args );

while ( $loop->have_posts() ) : $loop->the_post();
	echo 'Blah<br />';//Do stuff
endwhile;
wp_reset_postdata();*/


/*$customer_orders = wc_get_orders( array(
    'limit'    => -1,
    //'status'   => 'pending'
) );

// Iterating through each Order with pending status
foreach ( $customer_orders as $order ) {

    // Going through each current customer order items
    foreach($order->get_items() as $item_id => $item_values){
        $product_id = $item_values['product_id']; // product ID

        // Order Item meta data
        $item_meta_data = wc_get_order_item_meta( $item_id );

        // Some output
        //echo '<p>Line total for '.wc_get_order_item_meta( $item_id, '_line_total', true ).'</p><br>';
		
		echo 'Blah';
    }
}*/


//$orders_ids = get_orders_ids_by_product_id( 3365 );

// The output (for testing)
//pa( $orders_ids );

/*foreach( $orders_ids as $order_id[0] ) {
	$ord_id = $order_id->get_id();
	echo'OrderID: '.$ord_id.' - <br />';
}*/


/*$args = array(
	'limit' => -1,
	'return' => 'ids'
);
$query = new WC_Order_Query( $args );
$orders = $query->get_orders();
foreach( $orders as $order_id ) {
	$product_id = $order_id->get_product_id();
	echo'OrderID: '.$order_id.' - <br />';
}*/


/*$order = wc_get_order( );
$order_data = $order->get_data();
pa($order_data);*/
/*foreach ( $order->get_items() as $item_id => $item ) {
	$product_id = $item->get_product_id();
	if($product_id == 3361) {
		$prod_title = get_the_title($product_id);
		echo 'Title: '.$product_id.'<br />';
	
	}
}*/


/*if(isset($_GET['bookingdate'])) {
$rdsn_query = NULL;
$rdsn_query = new WP_Query();
$args = (array(
	'post_type' => 'yith_booking',
	'posts_per_page' => -1,
	'order' => 'ASC',
	'orderby' => 'meta_value',
  	'meta_key' => '_from'
	));	
$rdsn_query->query($args);
if ($rdsn_query->have_posts()):
while ($rdsn_query->have_posts()):$rdsn_query->the_post();
	$booking_id = get_the_ID();
	$booking_title = get_the_title();
	$all_meta = get_post_meta($booking_id);
	//
	$booking_date_stamp = get_post_meta( $booking_id, '_from', true );
	$booking_day_filter = date('Ymd', $booking_date_stamp);
	$booking_day = date('D jS F Y', $booking_date_stamp);
	$booking_time = date('g:i a', $booking_date_stamp);
	//
	$order_id = get_post_meta( $booking_id, '_order_id', true );
	$order = wc_get_order($order_id);
	$order_num = $order->get_order_number();
	$order_date = $order->get_date_paid();
	$order_total = $order->get_formatted_order_total();
	$order_phone = $order->get_billing_phone();
	$order_link = '/wp-admin/post.php?post='.$order_id.'&action=edit';
	//
	if($booking_day_filter == $get_date) {
	echo '<div class="grid-item">';
		echo '<div class="row group"><div class="left"><strong>Order Number</strong></div><div class="right"><strong>'.$order_num.'</strong></div></div>';
		//echo '<div class="row group"><div class="left"><strong>Booking Date/time</strong></div><div class="right"><strong>'.$booking_day.' - '.$booking_time.'</strong></div></div>';
		foreach ( $order->get_items() as $item_id => $item ) {
			echo '<div class="grid-meta">';
				$n_booking_date_meta = $item->get_meta('yith_booking_data', true);
	   			$n_booking_date_stamp = $n_booking_date_meta['from'];
	   			$n_booking_day = date('D jS F Y', $n_booking_date_stamp);
				$n_booking_time = date('g:i a', $n_booking_date_stamp);
				$n_booking_day_filter = date('Ymd', $n_booking_date_stamp);
				//
				$booking_item_meta = $item->get_meta('_ywapo_meta_data', true);
				$booking_item = $booking_item_meta[0]['value'];
				$booking_adult = $booking_item_meta[1]['value'];
				$booking_child1 = $booking_item_meta[2]['value'];
				$booking_child2 = $booking_item_meta[3]['value'];
				//pa ($n_booking_date_meta);
				//
				if($booking_item_meta) {
					echo '<div class="row group"><div class="left"><strong>Booking date/time</strong></div><div class="right"><strong>'.$booking_day.' - '.$booking_time.'</strong></div></div>'; // 1605960600
					if($booking_item) echo '<div class="row group"><div class="left">Booking Option</div><div class="right">'.$booking_item.'</div></div>';	
					if($booking_adult) echo '<div class="row group"><div class="left" style="font-weight:normal;">Adult Name</div><div class="right">'.$booking_adult.'</div></div>';
					if($booking_child1) echo '<div class="row group"><div class="left" style="font-weight:normal;">Child Name</div><div class="right">'.$booking_child1.'</div></div>';
					if($booking_child2) echo '<div class="row group"><div class="left" style="font-weight:normal;">Child Name</div><div class="right">'.$booking_child2.'</div></div>';
					echo '<div class="row group"><div class="left">&nbsp;</div><div class="right">'.$booking_adult.' : '.$booking_day.' - '.$booking_time.'</div></div>';
				}
			echo '</div>';
		}
		echo '<div class="meta-btm">';	
			echo '<div class="row group"><div class="left"><em>Phone</em></div><div class="right">'.$order_phone.'</div></div>';
			echo '<div class="row group"><div class="left"><em>Order Date</em></div><div class="right">'.date("D jS F Y", strtotime($order_date)).'</div></div>';
			echo '<div class="row group"><div class="left"><em>Order Total</em></div><div class="right">'.$order_total.' (ID: <a href="'.$order_link.'" target="_blank">'.$order_id.'</a>)</div></div>';
		echo '</div>';
	echo '</div>';
	}
	//pa ($all_meta);	
endwhile;
$rdsn_query = NULL;
endif;
wp_reset_postdata();
}*/
?>
<div class="no-print" style="height:100px;"></div>

</div>
</div>

<?php
/*$args = array(
	'numberposts' => -1,
	'order' => 'ASC',
	//'orderby' => 'meta_value',
  	//'meta_key' => '_from'
);
$orders = wc_get_orders($args);
foreach ($orders as $order):
	$order_id = $order->get_id();
	$order_date = $order->get_date_paid();
	$order_total = $order->get_formatted_order_total();
	$order_num = $order->get_order_number(); //wc_seq_order_number_pro()->find_order_by_order_number( $order_id );
	//
	echo '<div class="grid-item">';
	echo '<div class="row group"><div class="left">Booking ID</div><div class="right"><strong>'.$order_num.' - '.$order_id.'</strong></div></div>';
	foreach ( $order->get_items() as $item_id => $item ) {
		echo '<div class="grid-meta">';
			$booking_date_meta = $item->get_meta('yith_booking_data', true);
	   		$booking_date_stamp = $booking_date_meta['from'];
	   		$booking_day = date('D jS F Y', $booking_date_stamp); // D d M Y
			$booking_time = date('g:i a', $booking_date_stamp);
			//
			$booking_item_meta = $item->get_meta('_ywapo_meta_data', true);
			$booking_item = $booking_item_meta[0]['value'];
			$booking_adult = $booking_item_meta[1]['value'];
			$booking_child1 = $booking_item_meta[2]['value'];
			$booking_child2 = $booking_item_meta[3]['value'];
			//pa ($booking_item_meta);
			//
			echo '<div class="row group"><div class="left">Booking date/time</div><div class="right"><strong>'.$booking_day.' - '.$booking_time.'</strong></div></div>';
			if($booking_item_meta) {
				if($booking_item) echo '<div class="row group"><div class="left">Booking Option</div><div class="right">'.$booking_item.'</div></div>';	
				if($booking_adult) echo '<div class="row group"><div class="left" style="font-weight:normal;">Adult Name</div><div class="right">'.$booking_adult.'</div></div>';
				if($booking_child1) echo '<div class="row group"><div class="left" style="font-weight:normal;">Child Name</div><div class="right">'.$booking_child1.'</div></div>';
				if($booking_child2) echo '<div class="row group"><div class="left" style="font-weight:normal;">Child Name</div><div class="right">'.$booking_child2.'</div></div>';
			}
		echo '</div>';
	}
	echo '<div class="meta-btm">';
		echo '<div class="row group"><div class="left" style="font-weight:normal;">Order Date</div><div class="right">'.date("D jS F Y", strtotime($order_date)).'</div></div>';
		echo '<div class="row group"><div class="left" style="font-weight:normal;">Order Total</div><div class="right">'.$order_total.' (Order ID: '.$order_id.')</div></div>';
	echo '</div>';
	//
	echo '</div>';
endforeach;*/
?>