<?php


add_action( 'rest_api_init', 'tasksAPIEndpoints' );

function tasksAPIEndpoints() {

    // REGISTER NEW ENDPOINT AND SET CALLBACK METHOD
    register_rest_route( 'tasksapi', '/get_cus_projects', array(
        'methods'         => 'GET',
        'callback' => 'get_cus_projects',
    ));

}

function get_cus_projects() {

	if( is_user_logged_in() ){
		$num_of_posts = 3;
	}else{
		$num_of_posts = 6;
	}

	global $post;
 
    $myposts = get_posts( array(
		'post_type'     => 'projects',
		'posts_per_page' => $num_of_posts,
		'orderby'          => 'date',
		'order'            => 'DESC',
	) );

    $data = array();
    $temp = array();
	if ( $myposts ) {
        foreach ( $myposts as $post ) : 
			setup_postdata( $post );
			$temp['id'] = $post->ID;
			$temp['title'] = get_the_title( $post->ID );
			$temp['link'] = get_post_permalink( $post->ID );
			array_push($data, $temp);
		endforeach;
		wp_reset_postdata();
    }
   
	$response = array("status" => "success", "message" => $data);
	return new WP_REST_Response($response, 200);
}