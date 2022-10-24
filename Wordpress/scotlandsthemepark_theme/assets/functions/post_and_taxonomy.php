<?php 

// **************************************************************** CUSTOM POST TYPES AND TAXONOMIES ********
add_action( 'init', 'create_post_ride' );
function create_post_ride() {
	register_post_type( 'rdsn_ride',
		array(
			'labels' => array(
				'name' => __( 'Rides' ),
				'singular_name' => __( 'Ride' ),
				'add_new' => __( 'Add a Ride' ),
				'add_new_item' => __( 'Add a Ride' ),
				'edit_item' => __( 'Edit Ride' ),
				'new_item' => __( 'New Ride' ),
				'view_item' => __( 'View Ride' )
			),
		'public' => true,
		'has_archive' => true,
		'menu_icon'=>'dashicons-buddicons-activity',
		'rewrite' => array( 'slug' => 'ride' ),
		'supports' => array(
				'title',
				'editor',
				'thumbnail'
			),
		)
	);
}

// register taxomomy for ride type categories
$ride_type_args = array(
		'hierarchical'=>true,
		'query_var'=>true,
		'show_tagcloud'=>false,
		'show_admin_column' => true,
		'rewrite' => array (
			//'slug'=>$slug,
			'with_front'=>false
		),
		'labels'=>array(
			'name'=>'Ride Type Categories',
			'singular_name' => 'Ride Type Category',
            'edit_item' => 'Edit Ride Type Category',
            'update_item' => 'Update Ride Type Category',
            'add_new_item' => 'Add New Ride Type Category',
            'new_item_name' => 'New Ride Type Category Name',
            'all_items' => 'All Ride Type Categories',
            'search_items' => 'Search Ride Type Categories',
            'popular_items' => 'Popular Ride Type Categories',
            'separate_items_with_commas' => 'Separate Ride Type Categories with commas',
            'add_or_remove_items' => 'Add or remove Ride Type Categories',
            'choose_from_most_used' => 'Choose from the most popular Ride Type Categories',
        ),
    ); 
register_taxonomy( 'tax_ride_type', array( 'rdsn_ride' ), $ride_type_args );

// register taxomomy for ride height categories
$ride_height_args = array(
		'hierarchical'=>true,
		'query_var'=>true,
		'show_tagcloud'=>false,
		'show_admin_column' => true,
		'rewrite' => array (
			//'slug'=>$slug,
			'with_front'=>false
		),
		'labels'=>array(
			'name'=>'Ride Height Categories',
			'singular_name' => 'Ride Height Category',
            'edit_item' => 'Edit Ride Height Category',
            'update_item' => 'Update Ride Height Category',
            'add_new_item' => 'Add New Ride Height Category',
            'new_item_name' => 'New Ride Height Category Name',
            'all_items' => 'All Ride Height Categories',
            'search_items' => 'Search Ride Height Categories',
            'popular_items' => 'Popular Ride Height Categories',
            'separate_items_with_commas' => 'Separate Ride Height Categories with commas',
            'add_or_remove_items' => 'Add or remove Ride Height Categories',
            'choose_from_most_used' => 'Choose from the most popular Ride Height Categories',
        ),
    ); 
register_taxonomy( 'tax_ride_height', array( 'rdsn_ride' ), $ride_height_args );


add_action( 'init', 'create_post_event' );
function create_post_event() {
	register_post_type( 'rdsn_event',
		array(
			'labels' => array(
				'name' => __( 'Events' ),
				'singular_name' => __( 'Event' ),
				'add_new' => __( 'Add an Event' ),
				'add_new_item' => __( 'Add an Event' ),
				'edit_item' => __( 'Edit Event' ),
				'new_item' => __( 'New Event' ),
				'view_item' => __( 'View Event' )
			),
		'public' => true,
		'has_archive' => true,
		'menu_icon'=>'dashicons-universal-access-alt',
		'rewrite' => array( 'slug' => 'event' ),
		'supports' => array(
				'title',
				'editor',
				'thumbnail'
			),
		)
	);
}

add_action( 'init', 'create_post_opening_time' );
function create_post_opening_time() {
	register_post_type( 'rdsn_opening_time',
		array(
			'labels' => array(
				'name' => __( 'Opening Times' ),
				'singular_name' => __( 'Opening Time' ),
				'add_new' => __( 'Add a month' ),
				'add_new_item' => __( 'Add a month' ),
				'edit_item' => __( 'Edit month' ),
				'new_item' => __( 'New month' ),
				'view_item' => __( 'View month' )
			),
		'public' => true,
		'has_archive' => true,
		'menu_icon'=>'dashicons-clock',
		'rewrite' => array( 'slug' => 'month' ),
		'supports' => array(
				'title',
				'editor',
				'thumbnail'
			),
		)
	);
}

add_action( 'init', 'create_post_offers' );
function create_post_offers() {
	register_post_type( 'rdsn_offer',
		array(
			'labels' => array(
				'name' => __( 'Offers' ),
				'singular_name' => __( 'Offer' ),
				'add_new' => __( 'Add an Offer' ),
				'add_new_item' => __( 'Add an Offer' ),
				'edit_item' => __( 'Edit Offer' ),
				'new_item' => __( 'New Offer' ),
				'view_item' => __( 'View Offer' )
			),
		'public' => true,
		'has_archive' => true,
		'menu_icon'=>'dashicons-buddicons-groups',
		'rewrite' => array( 'slug' => 'offer' ),
		'supports' => array(
				'title',
				'editor',
				'thumbnail'
			),
		)
	);
}

add_action( 'init', 'create_post_tickets' );
function create_post_tickets() {
	register_post_type( 'rdsn_tickets',
		array(
			'labels' => array(
				'name' => __( 'Ticket Pricing' ),
				'singular_name' => __( 'Ticket Page' ),
				'add_new' => __( 'Add a Ticket Page' ),
				'add_new_item' => __( 'Add a Ticket Page' ),
				'edit_item' => __( 'Edit Ticket Page' ),
				'new_item' => __( 'New Ticket Page' ),
				'view_item' => __( 'View Ticket Pages' )
			),
		'public' => true,
		'has_archive' => true,
		'menu_icon'=>'dashicons-tickets-alt',
		'rewrite' => array( 'slug' => 'tickets' ),
		'supports' => array(
				'title',
				'editor',
				'thumbnail'
			),
		)
	);
}

?>