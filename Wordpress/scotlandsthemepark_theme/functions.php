<?php
// ********************************************************************** EXTERNAL FUNCTIONS
@require('assets/functions/admin.php');
@require('assets/functions/post_and_taxonomy.php');
@require('assets/functions/woo_functions.php');
@require('assets/functions/maps.php');
@require('assets/functions/calendar.php');


// ********************************************************************** Show WP Admin Bar
// function admin_bar(){

//   if(is_user_logged_in()){
//     add_filter( 'show_admin_bar', '__return_true' , 1000 );
//   }
// }
// add_action('init', 'admin_bar' );


// ********************************************************************** Custom CSS JS for Child Pages Nav Menu
function show_sub_menu_onsub_pages_css_js_____attractions(){
?>
	<style>
		@media only screen and (max-width:767px){
			.page-child #sub-menu .container{display:none;}
			.show-child-page-nav-menu {max-height: fit-content!important;}
		}
		@media only screen and (min-width:768px){
			.page-child #nav-sub-icon{display:none!important}
		}
	</style>
	<script>
		jQuery(document).ready(function($){
			$(".page-child #nav-sub-icon").click(function(){
				$(".page-child #nav-sub-menu").toggleClass("show-child-page-nav-menu");
			});
		});
	</script>
<?php
}
add_action('wp_footer', 'show_sub_menu_onsub_pages_css_js_____attractions' );




// ********************************************************************** ENQUEUE CUSTOM SCRIPTS
function rdsn_insert_scripts(){
	wp_enqueue_style('dashicons');
	wp_enqueue_script('jquery', false, array(), false, false);	
}
add_action('wp_enqueue_scripts','rdsn_insert_scripts',1);


// ********************************************************************** ENQUEUE CUSTOM SCRIPTS
function rdsn_nav_setup() {
  register_nav_menus( array( 
    'md_main_menu' => 'M&D Main Menu'
  ) );
 }
add_action( 'after_setup_theme', 'rdsn_nav_setup' );


// ********************************************************************** ADD FUNCTIONALITY ********
load_theme_textdomain('thistheme', get_template_directory() . '/languages');
add_theme_support( 'post-thumbnails' );
add_editor_style();

function wp_remove_version() {return '';}
add_filter('the_generator', 'wp_remove_version');
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.


// ********************************************************************** REMOVE FUNCTIONALITY
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Clean the up the image from wp_get_attachment_image()
add_filter( 'wp_get_attachment_image_attributes', function( $attr )
{
    if( isset( $attr['sizes'] ) )
        unset( $attr['sizes'] );
    if( isset( $attr['srcset'] ) )
        unset( $attr['srcset'] );
    return $attr;
 }, PHP_INT_MAX );
add_filter( 'wp_calculate_image_sizes', '__return_false',  PHP_INT_MAX ); // Override the calculated image sizes
add_filter( 'wp_calculate_image_srcset', '__return_false', PHP_INT_MAX ); // Override the calculated image sources
remove_filter( 'the_content', 'wp_make_content_images_responsive' ); // Remove the reponsive stuff from the content




// ********************************************************************** GET ORDERS BY PRODUCT
function get_orders_ids_by_product_id( $product_id){
    global $wpdb;

    $results = $wpdb->get_col("
        SELECT order_items.order_id
        FROM {$wpdb->prefix}woocommerce_order_items as order_items
        LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as order_item_meta ON order_items.order_item_id = order_item_meta.order_item_id
        LEFT JOIN {$wpdb->posts} AS posts ON order_items.order_id = posts.ID
        WHERE posts.post_type = 'shop_order'
        AND order_items.order_item_type = 'line_item'
        AND order_item_meta.meta_key = '_product_id'
        AND order_item_meta.meta_value = '$product_id'
    ");

    return $results;
}

// AND posts.post_status IN ( '" . implode( "','", $order_status ) . "' )


// ********************************************************************** CUSTOM THUMBNAIL SIZES
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'banner-image', 2400, 870, true );
	//add_image_size( 'banner-image', 1920, 700, true );
	//add_image_size( 'max-image', 1200, 1200 );
}


// ********************************************************************** GET TOP ANCESTOR
function get_top_ancestor($id) 
{
	$current = get_post($id);
	if(!$current->post_parent){
	return $current->ID;
	} else {
	return get_top_ancestor($current->post_parent);
	}
}


// ********************************************************************** SET SECTION COLOURS
function rdsn_set_colour($classes) {
    global $post;
	//$topID = get_top_ancestor($post->ID);
	//if ($topID == 143) { $classes[] = 'section-amazonia'; }
	//elseif ($topID == 134) { $classes[] = 'section-green'; }
	if(is_page(143) || in_array(143, get_ancestors($post->ID, 'page'))) {$classes[] = 'section-amazonia'; }
	return $classes;
}
add_filter('body_class','rdsn_set_colour');

function test_top_ID() {
	global $post;
	$topID = get_top_ancestor($post->ID);
	echo '<h1>'.$topID.'</h1>';
}



//// ********************************************************************** MAIN MENU
//function displayMainMenu() {
//	$menuTopLevel=wp_list_pages('title_li=&depth=2&echo=0&include=102'); // 102 is "Opening Times"
//	$menuMidLevel=wp_list_pages('title_li=&depth=2&echo=0&exclude=2,3,102,104,106,123,125,127,129,131,133,655,1473,3257,3264,3460'); // 123 is "Contact Us",  3264 is "Process Order", 3460 is new home page
//	$menuBtmLevel=wp_list_pages('title_li=&depth=1&echo=0&include=123,655'); // 655 is "How to find us"
//	//$mailchimp_link = get_field('ftr_signup_link','option');	
//	//echo '<ul>'.$menuTopLevel.'<li class="page-item-104"><a href="'.get_field('main_ticket_url','option').'" target="_blank">Buy tickets</a></li>'.$menuMidLevel.'<li id="chimp-link" class="page-item-123"><a href="#">Join our mailing list</a></li>'.$menuBtmLevel.'</ul>';
//	echo '<ul>'.$menuTopLevel.'<li class="page-item-104"><a href="/tickets/prices/">Buy tickets</a></li>'.$menuMidLevel.'<li id="chimp-link" class="page-item-123"><a href="#">Join our mailing list</a></li>'.$menuBtmLevel.'</ul>';
//}


// ********************************************************************** AMAZONIA MENU
function menu_amazonia() {
	$menu= wp_list_pages('title_li=&depth=2&echo=0&child_of=143');
	$mob_menu= wp_list_pages('title_li=&depth=1&echo=0&child_of=143');
	/*echo '<script src="https://www.universe.com/embed2.js" data-state=""></script>';*/
	echo '<div id="sub-menu">';
		echo '<div id="nav-sub-icon"><span></span><span></span><span></span><span></span></div>';
		echo '<div class="container"><div class="sub-menu"><ul><li><a href="/attractions/amazonia/">Amazonia</a></li>'.$menu.'<li><a href="/tickets/prices/" target="_self">Buy Tickets</a></li></ul></div></div>';
	echo '</div>';
	echo '<div id="nav-sub-menu" class="trans-1"><ul><li><a href="/attractions/amazonia/">Amazonia</a></li>'.$mob_menu.'<li><a href="/tickets/prices/" target="_self">Buy Tickets</a></li></ul></div>';
}

//  


// ********************************************************************** CUSTOM TITLE
function rdsn_custom_title() {
	if (get_field('page_title')){ echo get_field('page_title');
	} else { echo get_the_title(); }
}


// ********************************************************************** BANNER
/*function rdsn_mega_banner() {
$banner_type = get_field('banner_type');
if ($banner_type == 'video') {
//
echo '<style>.row-mid {background:#FFCA44;}</style>';
$banner_vid_id = get_field('banner_vid_id');
$banner_vid_poster_frame = wp_get_attachment_image_src(get_field('banner_vid_poster_frame'), 'full');
if ($banner_vid_poster_frame) { $banner_vid_poster = $banner_vid_poster_frame[0]; } else { $banner_vid_poster = get_template_directory_uri().'/assets/img/default-banner.jpg'; }
$banner_vid_poster_offset = get_field('banner_vid_poster_offset');
if (!$banner_vid_poster_offset) { $banner_vid_poster_offset = 0; }
//	
$overlay = get_field('banner_vid_overlay');
$clip_path_01 = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/banner-clip-01.svg" alt="" class="clip-path" />';
//
echo '<div id="banner-wrapper">';
	echo '<div class="rdsn-poster-frame" style="background:url('.$banner_vid_poster.') center center no-repeat;background-size:cover;"></div>';
	echo '<div id="rdsn-tv" class="rdsn-tv"></div>';
	if ($overlay == 'yes') { echo '<div class="overlay">&nbsp;</div>'; }
echo $clip_path_01.'</div>';
echo '
<script type="text/javascript">
var vidID = "'.$banner_vid_id.'";
var tag = document.createElement("script"); tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName("script")[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var rdsn_tv, playerDefaults = { playlist: vidID, autoplay: 0, end: 5, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, loop: 0, disablekb: 1, enablejsapi: 1, iv_load_policy: 3};

function onYouTubePlayerAPIReady(){
	rdsn_tv = new YT.Player("rdsn-tv", {events: {"onReady": onPlayerReady, "onStateChange": onPlayerStateChange}, playerVars: playerDefaults});
}

function onPlayerReady(){
	rdsn_tv.loadVideoById(vidID);
	rdsn_tv.mute();
}

function onPlayerStateChange(e) {
	if (e.data === 0){
		jQuery("#rdsn-tv").removeClass("active");
		jQuery(".rdsn-poster-frame").removeClass("active");
		e.target.playVideo()
	} else if (e.data === 1){
		jQuery("#rdsn-tv").addClass("active");
		jQuery(".rdsn-poster-frame").addClass("active");
		timestamp_callback();
	}
}*/

/* ------- timer  -------  */
/*var timestamp = '.$banner_vid_poster_offset.';
var timer;
 
function timestamp_reached() {
   console.log("timestamp reached");
   jQuery(".rdsn-poster-frame").removeClass("active");
}
 
function timestamp_callback() {
	clearTimeout(timer);
	current_time = rdsn_tv.getCurrentTime();
	remaining_time = timestamp - current_time;
	if (remaining_time > 0) {
		timer = setTimeout(timestamp_reached, remaining_time * 1000);
	}    
}*/

/* ------- responsive video  -------  */
/*function vidRescale(){
	var w = jQuery(window).width()+200,
	h = jQuery(window).height()+200;
	if (w/h > 16/9){
		rdsn_tv.setSize(w, w/16*9);
		jQuery(".rdsn-tv").css({"left":"0px"});
	} else {
		rdsn_tv.setSize(h/9*16, h);
		jQuery(".rdsn-tv").css({"left": -(jQuery(".rdsn-tv").outerWidth()-w)/2});
  }
}

jQuery(window).on("load resize", function(){
  vidRescale();
});
</script>
';	
	
} elseif (is_front_page()) {
	rdsn_banner_home();
} else {
	rdsn_banner();
}
}

/*function rdsn_vid_btn() {
$banner_type = get_field('banner_type');
if ($banner_type == 'video') {
//
$show_btn = get_field('banner_vid_show_button');
$btn_text = get_field('banner_vid_btn_text');
$btn_link = get_field('banner_vid_btn_link');	
//
	if ($show_btn == 'yes' && $btn_text && $btn_link) {
		echo '<div id="btn-vid-wrapper"><a href="'.$btn_link.'" class="btn-solid trans-0-25">'.$btn_text.'</a></div>';
	}
}
}*/

/*function rdsn_banner_home() {
if(have_rows('banner_home')) {
$clip_path_01 = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/banner-clip-01.svg" alt="" class="clip-path" />';
echo '<div id="banner-wrapper"><div id="banner" class="animated fadeIn">';
while(have_rows('banner_home')):the_row();
	$image = wp_get_attachment_image_src(get_sub_field('banner_home_image'), 'banner-image');
	//$title = get_sub_field('banner_home_title');
	$overlay = get_sub_field('banner_home_overlay');
	// render the slide	
	echo '<div class="slide">';
		echo '<div class="container">';
		echo '</div>';
		if ($overlay == 'yes') { echo '<div class="overlay">&nbsp;</div>'; }
		echo '<div class="image" style="background:url('.$image[0].') center center no-repeat;background-size:cover;"></div>';
	echo '</div>';
	// close the slide
endwhile;
echo '</div>';
echo '<div id="btn-wrapper">';
while(have_rows('banner_home')):the_row();
	$show_btn = get_sub_field('banner_home_show_button');
	$btn_text = get_sub_field('banner_home_btn_text');
	$btn_link = get_sub_field('banner_home_btn_link');	
	//
	if ($show_btn == 'yes' && $btn_text && $btn_link) {
	echo '<div class="slide">';
		echo '<div class="btn-wrapper"><a href="'.$btn_link.'" class="btn-solid trans-0-25">'.$btn_text.'</a></div>';
	echo '</div>';
	}
endwhile;
echo '</div>';
echo $clip_path_01.'</div>';
}
}*/


function rdsn_banner() {
global $post;
if(have_rows('banner') && !is_shop()) {
	$banner_id = '';
} elseif (is_shop()) {
	$banner_id = 2381;
} elseif (is_product()) {
	if (have_rows('banner',$post->ID)): $banner_id = $post->ID;
	else: $banner_id = 'option';
	endif;
}
elseif ( in_array(143, get_ancestors($post->ID,'page')) ) {
	$banner_id = 143;
//} elseif (is_product()) {
	//$banner_id = $post->ID;
/*} elseif(is_product_category() && !is_shop() ) {
	$cat = get_queried_object();
	$cat_id = $cat->term_id;
	//$parent_cats = get_ancestors($cat_id, 'product_cat');
	//if(count($parent_cats) == '0') { $cat_parent_id = NULL; } else { $cat_parent_id = $parent_cats[0]; }
	//
	if(have_rows('banner','product_cat_'.$cat_id)) {
		$banner_id = 'product_cat_'.$cat_id; }
	//elseif(have_rows('banner','product_cat_'.$cat_parent_id)) {
		//$banner_id = 'product_cat_'.$cat_parent_id; }
	else {
		$banner_id = 'option';
	}*/
} else {
	$banner_id = 'option';
}
$btn_prev = '<div class="btn-prev trans-0-25"></div>';
$btn_next = '<div class="btn-next trans-0-25"></div>';
$clip_path_01 = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/banner-clip-01.svg" alt="" class="clip-path" />';
echo '<div id="banner-wrapper">'.$btn_prev.$btn_next.'<div id="banner" class="animated fadeIn">';
while(have_rows('banner',$banner_id)):the_row();
	$banner_type = get_sub_field('banner_type_x');
	$image = wp_get_attachment_image_src(get_sub_field('banner_image'), 'banner-image');
	$v_align = get_sub_field('banner_alignment');
	$title = get_sub_field('banner_title');
	$show_title = get_sub_field('banner_show_title');
	if (!is_front_page() && !$title) { $title = get_the_title(); }
	//if (is_page(143) || $post->post_parent=='143') { $title = ''; }
	$overlay = get_sub_field('banner_overlay');
	//
	$show_btn = get_sub_field('banner_show_button');
	$btn_text = get_sub_field('banner_btn_text');
	$btn_link = get_sub_field('banner_btn_link');	
	//
	$banner_vid_id = get_sub_field('banner_vid_id_x');
	$banner_vid_poster_frame = wp_get_attachment_image_src(get_sub_field('banner_vid_poster_frame_x'), 'full');
	if ($banner_vid_poster_frame) { $banner_vid_poster = $banner_vid_poster_frame[0]; } else { $banner_vid_poster = get_template_directory_uri().'/assets/img/default-banner.jpg'; }
	//$banner_vid_length = get_sub_field('banner_vid_length');  // no longer needed as we're advancing automatically at the end of the video.
	//$banner_vid_length = $banner_vid_length * 1000;
	//if (!$banner_vid_length) { $banner_vid_length = 30000; }
	//$banner_vid_poster_offset = 0; 
	// render the slide	
	if ($show_btn == 'yes' && $btn_text && $btn_link) { $openlink = '<a href="'.$btn_link.'" class="slide-link">'; $closelink = '</a>'; } else { $openlink = ''; $closelink = ''; }
	
	if ($banner_type == 'image') { echo '<div class="slide">'.$openlink; } // $('.cycle-slideshow').cycle('next') 
	if ($banner_type == 'video') { echo '<div class="slide" data-cycle-timeout=0 >'; }
	//echo '<div class="slide" data-cycle-timeout=0>';
		echo '<div class="container">';
			if ($show_title != 'no') { echo '<div class="title-page animated fadeInUp"><h1>'.$title.'</h1></div>'; }
		echo '</div>';
		if ($overlay == 'yes') { echo '<div class="overlay">&nbsp;</div>'; }
		if ($banner_type == 'image') { echo '<div class="image" style="background:url('.$image[0].') center '.$v_align.' no-repeat;background-size:cover;"></div>'; }
		if ($banner_type == 'video') {
			echo '<div class="rdsn-poster-frame" style="background:url('.$banner_vid_poster.') center center no-repeat;background-size:cover;"></div>';
			echo '<div id="rdsn-tv" class="rdsn-tv"></div>';
		}
	echo $closelink.'</div>';
	if ($banner_type == 'video') {
	echo '
	<script type="text/javascript">
	var vidID = "'.$banner_vid_id.'";
	var tag = document.createElement("script"); tag.src = "https://www.youtube.com/iframe_api";
	var firstScriptTag = document.getElementsByTagName("script")[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
	var rdsn_tv, playerDefaults = { playlist: vidID, autoplay:0, end: 5, autohide: 1, modestbranding: 0, rel: 0, showinfo: 0, controls: 0, loop: 0, disablekb: 1, enablejsapi: 1, iv_load_policy: 3};
	
	function onYouTubePlayerAPIReady(){
		rdsn_tv = new YT.Player("rdsn-tv", {events: {"onReady": onPlayerReady, "onStateChange": onPlayerStateChange}, playerVars: playerDefaults});
	}
	
	function onPlayerReady(){
		rdsn_tv.loadVideoById(vidID);
		rdsn_tv.mute();
	}
	
	function onPlayerStateChange(e) {
		if (e.data === 0){
			//jQuery("#rdsn-tv").removeClass("active");
			//jQuery(".rdsn-poster-frame").removeClass("active");
			//e.target.playVideo()
			//rdsn_tv.playVideo();
			jQuery("#banner").cycle("next");
		} else if (e.data === 1){
			jQuery("#rdsn-tv").addClass("active");
			jQuery(".rdsn-poster-frame").addClass("active");
		}
	}
	
	/* ------- responsive video  -------  */   // *********** NOTE - need to manually over-ride "left" on tablet/phone with more square window
	function vidRescale(){
		var w = jQuery("#banner-wrapper").width()+200,
		h = jQuery("#banner-wrapper").height()+200;
		//if (w/h > 16/9){
		if (w > h){
			rdsn_tv.setSize(w, w/16*9);
			jQuery(".rdsn-tv").css({"left":"0px"});
		} else {
			rdsn_tv.setSize(h/9*16, h);
			jQuery(".rdsn-tv").css({"left": -(jQuery(".rdsn-tv").outerWidth()-w)/2});
	  }
	}
	
	jQuery(window).on("load resize", function(){
	  vidRescale();
	});
	
	jQuery("#banner").on("cycle-before", function(e) {
		rdsn_tv.seekTo(0, true);
	});
	</script>
	';
	}
	// close the slide
endwhile;
echo '</div>';
echo '<div id="btn-wrapper">';
while(have_rows('banner',$banner_id)):the_row();
	$show_btn = get_sub_field('banner_show_button');
	$btn_text = get_sub_field('banner_btn_text');
	$btn_link = get_sub_field('banner_btn_link');	
	//
	if ($show_btn == 'yes' && $btn_text && $btn_link) {
	echo '<div class="slide">';
		echo '<div class="btn-wrapper"><a href="'.$btn_link.'" class="btn-solid trans-0-25">'.$btn_text.'</a></div>';
	echo '</div>';
	}
endwhile;
echo '</div>';
echo $clip_path_01.'</div>';
if (!is_page(143) && $post->post_parent!='143') { echo '<div id="banner-spacer">&nbsp;</div>'; }
//
//echo 'banner vid ID = '.$banner_vid_id;
/*$order = get_field('banner_order');
if ($order == 'random') { $random = 'true'; } else  { $random = 'false'; }
echo '
<script type="text/javascript">
jQuery(document).ready(function() {
jQuery("#banner").cycle({
	fx:"scrollHorz",
	speed:500,
	timeout:5000,
	slides:"> div",
	random : '.$random.',
	swipe: true,
	cycleLoader: true,
	easing: "easeOutQuint",
	prev: "#banner-wrapper .btn-prev",
	next: "#banner-wrapper .btn-next",
	pauseOnHover:"#banner-wrapper .btn-prev,#banner-wrapper .btn-next"
});

var ban_num = jQuery("#banner div.slide").length;
if (ban_num == 1) {
	jQuery("#banner-wrapper .btn-prev,#banner-wrapper .btn-next").hide();
}

jQuery("#btn-wrapper").cycle({
	fx:"fade",
	speed:500,
	timeout:0,
	slides:"> div",
	cycleLoader: true,
	easing: "easeOutQuint"
});

jQuery("#banner").on("cycle-before", function(e) {
	jQuery("#btn-wrapper").cycle("next");
});
});
</script>
';*/
}


/*function rdsn_banner() {
if(have_rows('banner')) {
	$banner_id = '';
} else {
	$banner_id = 'option';
}
$clip_path_01 = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/banner-clip-01.svg" alt="" class="clip-path" />';
echo '<div id="banner-wrapper"><div id="banner" class="animated fadeIn">';
while(have_rows('banner',$banner_id)):the_row();
	$image = wp_get_attachment_image_src(get_sub_field('banner_image'), 'banner-image');
	$v_align = get_sub_field('banner_alignment');
	$title = get_sub_field('banner_title');
	if (!$title) { $title = get_the_title(); }
	if (is_page(143) || $post->post_parent=='143') { $title = ''; }
	$overlay = get_sub_field('banner_overlay');
	// render the slide	
	echo '<div class="slide">';
		echo '<div class="container">';
			echo '<div class="title-page animated fadeInUp"><h1>'.$title.'</h1></div>';
		echo '</div>';
		if ($overlay == 'yes') { echo '<div class="overlay">&nbsp;</div>'; }
		echo '<div class="image" style="background:url('.$image[0].') center '.$v_align.' no-repeat;background-size:cover;"></div>';
	echo '</div>';
	// close the slide
endwhile;
echo '</div>'.$clip_path_01.'</div>';
}*/


// ********************************************************************** SOCIAL LINKS
function rdsn_social() {
$fbook = get_field('facebook_url','option');
$twitter = get_field('twitter_url','option');
$instagram = get_field('instagram_url','option');
	if ($fbook || $twitter || $instagram) {
	echo '<div class="social-links">';
		if ($fbook) { echo '<a class="icon-social icon-facebook" href="'.$fbook.'" target="_blank"></a>'; }	
		if ($instagram) { echo '<a class="icon-social icon-instagram" href="'.$instagram.'" target="_blank"></a>'; }
		if ($twitter) { echo '<a class="icon-social icon-twitter" href="'.$twitter.'" target="_blank"></a>'; }
	echo '</div>';	
	}
}



// ********************************************************************** HOME PAGE CAROUSEL ********
/*function rdsn_home_carousel() {
$crsl_links = get_field('carousel_links','option'); // relationship	
$btn_prev = '';
$btn_next = '';
$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-landscape-trans-01.png" alt="" class="placeholder" />';
echo '<div id="rdsn-crsl-wrapper">'.$btn_prev.$btn_next.'<div id="rdsn-crsl" class="rdsn-crsl group">';
foreach( $crsl_links as $post): setup_postdata($post);
	$title = get_the_title($post->ID);
	$link = get_permalink($post->ID);
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
	if($image_src) { $image = $image_src[0]; } else { $image = get_template_directory_uri().'/assets/img/default-landscape.jpg'; }
	//
	echo '<div class="grid-item"><a href="'.$link.'">';
		echo '<div class="rdsn-image-wrapper"><div class="rdsn-image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div></a>';
		echo '<div class="content"><div class="title">'.$title.'</div></div>';
	echo '</a></div>';
	//
endforeach;
wp_reset_postdata();
echo '</div></div>';
}*/


// ********************************************************************** HOME CAROUSEL 2
function rdsn_home_carousel() {
if(have_rows('crsl_home_rep','option')):
$btn_prev = '<div id="btn-crsl-prev" class="trans-0-3"></div>';
$btn_next = '<div id="btn-crsl-next" class="trans-0-3"></div>';
$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-landscape-trans-01.png" alt="" class="placeholder" />';
echo '<div id="rdsn-crsl-wrapper">'.$btn_prev.$btn_next.'<div id="rdsn-crsl" class="rdsn-crsl group">';
//
while(have_rows('crsl_home_rep','option')):the_row();
	$title = get_sub_field('crsl_home_title');
	$link = get_sub_field('crsl_home_link');
	$image_src = wp_get_attachment_image_src(get_sub_field('crsl_home_bg'), 'medium');
	if($image_src) { $image = $image_src[0]; } else { $image = get_template_directory_uri().'/assets/img/default-landscape-02.jpg'; }
	//
	echo '<div class="grid-item">';
	if ($link) { echo '<a href="'.$link.'">'; }
		echo '<div class="rdsn-image-wrapper"><div class="rdsn-image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
		echo '<div class="content"><div class="vcenter-outer"><div class="vcenter-inner"><div class="title">'.$title.'</div></div></div></div>';
	if ($link) { echo '</a>'; }
	echo '</div>';
	//
endwhile;
//
echo '</div></div>';
endif;	
}


// ********************************************************************** RIDES (INDIVIDUAL PAGES)
function get_rides() {
if (is_page(137)) { $cat_ride = 9; }
if (is_page(139)) { $cat_ride = 10; }
if (is_page(141)) { $cat_ride = 8; }
$args = array(
	'numberposts' => -1,
	'post_type' => 'rdsn_ride',
	'tax_query' => array(
		array(
        	'taxonomy' => 'tax_ride_type',
        	'field' => 'term_id',
			'terms' => $cat_ride,
    		)
		)
	);
$ride_items = get_posts($args);	
if ($ride_items):
echo '<div id="e-grid" class="grid-wrapper">';
foreach($ride_items as $post) : setup_postdata($post);
	$title = get_the_title($post->ID);
	$link = get_the_permalink($post->ID);
	$excerpt = get_field('rdsn_custom_excerpt',$post->ID);
	if(!$excerpt) { $excerpt = custom_excerpt_foreach(20,$post->ID); }
	$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
	if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	//
	echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
		echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
		echo '<div class="pop-content trans-0-3"><div class="vcenter-outer"><div class="vcenter-inner"><div class="pop-inner"><div class="title">'.$title.'</div><div class="excerpt">'.$excerpt.'</div><div class="btn-solid trans-0-25">Find out more</div></div></div></div></div>';
		echo '<div class="title-wrapper trans-0-3"><h3>'.$title.'</h3></div>';
		echo '<div class="pop-overlay trans-0-3"></div>';
		echo '<div class="overlay trans-0-3"></div>';
		echo '</a>';
	echo '</div>';
	endforeach;
wp_reset_postdata();
echo '</div>';
endif;
}
/*function get_rides() {
if (is_page(137)) { $cat_ride = 9; }
if (is_page(139)) { $cat_ride = 10; }
if (is_page(141)) { $cat_ride = 8; }
$args = array(
	'numberposts' => -1,
	'post_type' => 'rdsn_ride',
	'tax_query' => array(
		array(
        	'taxonomy' => 'tax_ride_type',
        	'field' => 'term_id',
			'terms' => $cat_ride,
    		)
		)
	);
$wp_query = NULL;
$wp_query = new WP_Query();
$wp_query->query($args);
if ($wp_query->have_posts()):
echo '<div id="e-grid" class="grid-wrapper">';
while ($wp_query->have_posts()):$wp_query->the_post();
	$title = get_the_title($post->ID);
	$link = get_the_permalink($post->ID);
	$excerpt = custom_excerpt(20);
	$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
	if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	//
	echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
		echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
		echo '<div class="title-wrapper"><h3>'.$title.$excerpt.'</h3></div>';
		echo '<div class="overlay"></div>';
		echo '</a>';
	echo '</div>';
endwhile;
$wp_query = NULL;
wp_reset_postdata();
echo '</div>';
endif;
}*/


// ********************************************************************** EVENTS
function get_events() {
$args = array( 'numberposts' => -1,'post_type' => 'rdsn_event' );
$event_items = get_posts($args);	
if ($event_items):
echo '<div id="e-grid" class="grid-wrapper">';
foreach($event_items as $post) : setup_postdata($post);
	$title = get_the_title($post->ID);
	$link = get_the_permalink($post->ID);
	$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
	if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$show_title = get_field('rdsn_list_show_title',$post->ID);
	$show_overlay = get_field('rdsn_list_show_overlay',$post->ID);
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	//
	echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
			echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
			echo '<div class="pop-content trans-0-3"><div class="vcenter-outer"><div class="vcenter-inner"><div class="pop-inner"><div class="title">'.$title.'</div><div class="btn-solid trans-0-25">Find out more</div></div></div></div></div>';
			if ($show_title != 'no') { echo '<div class="title-wrapper"><h3>'.$title.'</h3></div>'; }
			echo '<div class="pop-overlay trans-0-3"></div>';
			if ($show_overlay != 'no') { echo '<div class="overlay trans-0-3"></div>'; }
	echo '</a>';
	echo '</div>';
	endforeach;
wp_reset_postdata();
echo '</div>';
endif;
}

/*function get_events() {
$args = array( 'numberposts' => -1,'post_type' => 'rdsn_event' );
$event_items = get_posts($args);	
if ($event_items):
echo '<div id="e-grid" class="grid-wrapper">';
foreach($event_items as $post) : setup_postdata($post);
	$title = get_the_title($post->ID);
	$link = get_the_permalink($post->ID);
	$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
	if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$show_title = get_field('rdsn_list_show_title',$post->ID);
	$show_overlay = get_field('rdsn_list_show_overlay',$post->ID);
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	//
	echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
		echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
		if ($show_title != 'no') { echo '<div class="title-wrapper"><h3>'.$title.'</h3></div>'; }
		if ($show_overlay != 'no') { echo '<div class="overlay"></div>'; }
		echo '</a>';
	echo '</div>';
	endforeach;
wp_reset_postdata();
echo '</div>';
endif;
}*/


// ********************************************************************** OFFERS
function get_offers() {
$args = array( 'numberposts' => -1,'post_type' => 'rdsn_offer' );
$offer_items = get_posts($args);	
if ($offer_items):
echo '<div id="e-grid" class="grid-wrapper">';
foreach($offer_items as $post) : setup_postdata($post);
	$title = get_the_title($post->ID);
	$link = get_the_permalink($post->ID);
	$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
	if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$show_title = get_field('rdsn_list_show_title',$post->ID);
	$show_overlay = get_field('rdsn_list_show_overlay',$post->ID);
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	//
	echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
			echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
			echo '<div class="pop-content trans-0-3"><div class="vcenter-outer"><div class="vcenter-inner"><div class="pop-inner"><div class="title">'.$title.'</div><div class="btn-solid trans-0-25">Find out more</div></div></div></div></div>';
			echo '<div class="title-wrapper trans-0-3"><h3>'.$title.'</h3></div>';
			echo '<div class="pop-overlay trans-0-3"></div>';
			echo '<div class="overlay trans-0-3"></div>';
	echo '</a>';
	echo '</div>';
	endforeach;
wp_reset_postdata();
echo '</div>';
endif;
}

/*function get_offers() {
$args = array( 'numberposts' => -1,'post_type' => 'rdsn_offer' );
$offer_items = get_posts($args);	
if ($offer_items):
echo '<div id="e-grid" class="grid-wrapper">';
foreach($offer_items as $post) : setup_postdata($post);
	$title = get_the_title($post->ID);
	$link = get_the_permalink($post->ID);
	$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
	if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
	$show_title = get_field('rdsn_list_show_title',$post->ID);
	$show_overlay = get_field('rdsn_list_show_overlay',$post->ID);
	$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
	//
	echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
		echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
		if ($show_title != 'no') { echo '<div class="title-wrapper"><h3>'.$title.'</h3></div>'; }
		if ($show_overlay != 'no') { echo '<div class="overlay"></div>'; }
		echo '</a>';
	echo '</div>';
	endforeach;
wp_reset_postdata();
echo '</div>';
endif;
}*/


// ********************************************************************** GET CHILD PAGES
function rdsn_child_pages() {
global $post;
$parent = $post->ID;
$childPages = get_pages( array( 'parent' => $parent, 'sort_column' => 'menu_order' ) );
if ($childPages):
echo '<div id="e-grid" class="grid-wrapper">';
	foreach($childPages as $page) : setup_postdata($page);
		$title = get_the_title($page->ID);
		$link = get_the_permalink($page->ID);
		$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID),'large');
		if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
		$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
		//
		echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
			echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
			echo '<div class="pop-content trans-0-3"><div class="vcenter-outer"><div class="vcenter-inner"><div class="pop-inner"><div class="title">'.$title.'</div><div class="btn-solid trans-0-25">Find out more</div></div></div></div></div>';
			echo '<div class="title-wrapper trans-0-3"><h3>'.$title.'</h3></div>';
			echo '<div class="pop-overlay trans-0-3"></div>';
			echo '<div class="overlay trans-0-3"></div>';
		echo '</a>';
		echo '</div>';
		//
	endforeach;
	wp_reset_postdata();
echo '</div>';
endif;
}

function child_menu() {
global $post;
$current_id = $post->ID;
$parent = wp_get_post_parent_id($current_id);
$childPages = get_pages( array( 'parent' => $parent, 'sort_column' => 'menu_order', 'exclude' => $current_id, ) );
if ($childPages):
echo '<div class="mini-menu">';
	foreach($childPages as $page) : setup_postdata($page);
		$title = get_the_title($page->ID);
		$link = get_the_permalink($page->ID);
		//
		echo '<a href="'.$link.'" class="btn-solid trans-0-3">'.$title.'</a><br />';
		//
	endforeach;
	wp_reset_postdata();
echo '</div>';
endif;
}

function side_boxes() {
if(have_rows('rep_sideboxes')):
global $post;
echo '<div id="side-boxes">';
while(have_rows('rep_sideboxes')):the_row();
	$title = get_sub_field('rep_sidebox_title');
	$content = get_sub_field('rep_sidebox_content');
	if (in_array(143, get_ancestors($post->ID, 'page'))) {
		$lizard = '<img src="'.get_template_directory_uri().'/assets/img/amazonia-lizard.png" alt="wee lizard" />';
	}
	//
	echo '<div class="side-box border-box animated anim-up">';
		if (in_array(143, get_ancestors($post->ID, 'page')) && $lizard ) { echo '<div class="wee-lizard animated breathe">'.$lizard.'</div>'; }
		//echo '<div class="wee-lizard>'.$lizard.'</div>';
		echo '<div class="title">'.$title.'</div><div class="text">'.$content.'</div>';	
	echo '</div>';
	//
endwhile;
echo '</div>';
endif;
}


function rdsn_amazonia_animals_child_pages() {
global $post;
$parent = $post->ID;
$childPages = get_pages( array( 'parent' => $parent, 'sort_column' => 'menu_order' ) );
if ($childPages):
echo '<div id="e-grid" class="amazonia-wood-panel grid-wrapper">';
	foreach($childPages as $page) : setup_postdata($page);
		$title = get_the_title($page->ID);
		$link = get_the_permalink($page->ID);
		$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID),'large');
		if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-amazonia-01.jpg'; }
		$wood_panel_src = wp_get_attachment_image_src(get_field('wood_panel_image', $page->ID),'full');
		$wood_panel = '<img src="'.$wood_panel_src[0].'" alt="'.$title.'" />';
		$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
		//
		echo '<div class="grid-item animated anim-up">';
			echo '<a href="'.$link.'">';
			echo '<div class="wood-panel">'.$wood_panel.'</div>';
			echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
			//echo '<div class="title-wrapper"><h3>'.$title.'</h3></div>';
			echo '</a>';
		echo '</div>';
		//
	endforeach;
	wp_reset_postdata();
echo '</div>';
endif;
}

function rdsn_amazonia_lower_pages() {
global $post;
$parent = $post->ID;
$childPages = get_pages( array( 'parent' => $parent, 'sort_column' => 'menu_order' ) );
if ($childPages):
echo '<div id="e-grid" class="amazonia-animal grid-wrapper">';
	foreach($childPages as $page) : setup_postdata($page);
		$title = get_the_title($page->ID);
		$link = get_the_permalink($page->ID);
		$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID),'large');
		if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-amazonia-01.jpg'; }
		$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
		//
		echo '<div class="grid-item animated anim-up">';
			echo '<a href="'.$link.'">';
			echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
			echo '<div class="title-wrapper"><h3>'.$title.'</h3></div>';
			echo '</a>';
		echo '</div>';
		//
	endforeach;
	wp_reset_postdata();
echo '</div>';
endif;
}


function get_restaurants() {
global $post;
$parent = 115;
$childPages = get_pages( array( 'parent' => $parent, 'sort_column' => 'menu_order' ) );
if ($childPages):
echo '<div id="e-grid" class="grid-wrapper" style="margin-top:40px;">';
	foreach($childPages as $page) : setup_postdata($page);
		$title = get_the_title($page->ID);
		$link = get_the_permalink($page->ID);
		$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($page->ID),'large');
		if ($image_src) { $image = $image_src[0]; } else { $image = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
		$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$title.'" class="placeholder" />';
		//
		echo '<div class="grid-item animated anim-up">';
		echo '<a href="'.$link.'">';
			echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
			echo '<div class="pop-content trans-0-3"><div class="vcenter-outer"><div class="vcenter-inner"><div class="pop-inner"><div class="title">'.$title.'</div><div class="btn-solid trans-0-25">Find out more</div></div></div></div></div>';
			echo '<div class="title-wrapper trans-0-3"><h3>'.$title.'</h3></div>';
			echo '<div class="pop-overlay trans-0-3"></div>';
			echo '<div class="overlay trans-0-3"></div>';
		echo '</a>';
		echo '</div>';
		//
	endforeach;
	wp_reset_postdata();
echo '</div>';
endif;
}


// ********************************************************************** GET ATTRACTIONS OPENING TIMES
function rdsn_attractions_ot() {
$childPages = get_pages( array( 'parent' => 111, 'sort_column' => 'menu_order' ) );
if ($childPages):
echo '<div class="list-wrapper">';
echo '<h2>Attractions</h2>';
	foreach($childPages as $page) : setup_postdata($page);
		$title = get_the_title($page->ID);
		$link = get_the_permalink($page->ID);
		$monday = get_field('ot_monday',$page->ID);
		$tuesday = get_field('ot_tuesday',$page->ID);
		$wednesday = get_field('ot_wednesday',$page->ID);
		$thursday = get_field('ot_thursday',$page->ID);
		$friday = get_field('ot_friday',$page->ID);
		$saturday = get_field('ot_saturday',$page->ID);
		$sunday = get_field('ot_sunday',$page->ID);
		$notes = get_field('ot_notes',$page->ID);
		echo '<div class="list-item animated anim-up">';
			//echo '<div class="row top"><a href="'.$link.'"><div class="title">'.$title.'</div></a></div>';
			echo '<div class="row top"><div class="title">'.$title.'</div></div>';
			echo '<div class="content"><div class="inner">';
				echo '<div class="row group"><div class="left border-box">Monday</div><div class="right border-box">'.$monday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Tuesday</div><div class="right border-box">'.$tuesday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Wednesday</div><div class="right border-box">'.$wednesday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Thursday</div><div class="right border-box">'.$thursday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Friday</div><div class="right border-box">'.$friday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Saturday</div><div class="right border-box">'.$saturday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Sunday</div><div class="right border-box">'.$sunday.'</div></div>';
				if ($notes) { echo '<div class="notes">'.$notes.'</div>'; }
			echo '</div></div>';
		echo '</div>';
	endforeach;
	wp_reset_postdata();
echo '</div>';
endif;
}


function rdsn_attraction_ot() {  // for individual attraction pages
$monday = get_field('ot_monday',$page->ID);
$tuesday = get_field('ot_tuesday',$page->ID);
$wednesday = get_field('ot_wednesday',$page->ID);
$thursday = get_field('ot_thursday',$page->ID);
$friday = get_field('ot_friday',$page->ID);
$saturday = get_field('ot_saturday',$page->ID);
$sunday = get_field('ot_sunday',$page->ID);
$notes = get_field('ot_notes');
if ($monday || $tuesday || $wednesday || $thursday || $friday || $saturday || $sunday) {
echo '<div class="list-wrapper page-top">';
echo '<div class="list-item animated anim-up">';
	echo '<div class="row top"><div class="title">Opening Times</div></div>';
	echo '<div class="content"><div class="inner">';
		echo '<div class="row group"><div class="left border-box">Monday</div><div class="right border-box">'.$monday.'</div></div>';
		echo '<div class="row group"><div class="left border-box">Tuesday</div><div class="right border-box">'.$tuesday.'</div></div>';
		echo '<div class="row group"><div class="left border-box">Wednesday</div><div class="right border-box">'.$wednesday.'</div></div>';
		echo '<div class="row group"><div class="left border-box">Thursday</div><div class="right border-box">'.$thursday.'</div></div>';
		echo '<div class="row group"><div class="left border-box">Friday</div><div class="right border-box">'.$friday.'</div></div>';
		echo '<div class="row group"><div class="left border-box">Saturday</div><div class="right border-box">'.$saturday.'</div></div>';
		echo '<div class="row group"><div class="left border-box">Sunday</div><div class="right border-box">'.$sunday.'</div></div>';
		if ($notes) { echo '<div class="notes">'.$notes.'</div>'; }
	echo '</div></div>';
echo '</div>';
echo '</div>';
}
}


function rdsn_food_drink_ot() {
$childPages = get_pages( array( 'parent' => 115, 'sort_column' => 'menu_order' ) );
if ($childPages):
echo '<div class="list-wrapper">';
echo '<h2>Food &amp; Drink</h2>';
	foreach($childPages as $page) : setup_postdata($page);
		$title = get_the_title($page->ID);
		$link = get_the_permalink($page->ID);
		$monday = get_field('ot_monday',$page->ID);
		$tuesday = get_field('ot_tuesday',$page->ID);
		$wednesday = get_field('ot_wednesday',$page->ID);
		$thursday = get_field('ot_thursday',$page->ID);
		$friday = get_field('ot_friday',$page->ID);
		$saturday = get_field('ot_saturday',$page->ID);
		$sunday = get_field('ot_sunday',$page->ID);
		$notes = get_field('ot_notes',$page->ID);
		echo '<div class="list-item animated anim-up">';
			//echo '<div class="row top"><a href="'.$link.'"><div class="title">'.$title.'</div></a></div>';
			echo '<div class="row top"><div class="title">'.$title.'</div></div>';
			echo '<div class="content"><div class="inner">';
				echo '<div class="row group"><div class="left border-box">Monday</div><div class="right border-box">'.$monday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Tuesday</div><div class="right border-box">'.$tuesday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Wednesday</div><div class="right border-box">'.$wednesday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Thursday</div><div class="right border-box">'.$thursday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Friday</div><div class="right border-box">'.$friday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Saturday</div><div class="right border-box">'.$saturday.'</div></div>';
				echo '<div class="row group"><div class="left border-box">Sunday</div><div class="right border-box">'.$sunday.'</div></div>';
				if ($notes) { echo '<div class="notes">'.$notes.'</div>'; }
			echo '</div></div>';
		echo '</div>';
	endforeach;
	wp_reset_postdata();
echo '</div>';
endif;
}


// ********************************************************************** AMAZONIA CONTACT
function amazonia_contact() {
$show =	get_field('show_amazonia_contact_form','option');
if ($show != 'no'):
?>
<div id="contact-form-wrapper">
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/process.js"></script>
    <form action="/no-js.php" method="post" name="amazonia_contact_form" id="amazonia-contact-form" class="rdsn-form">
        <div class="group">
            <div class="row"><label>Name*</label><input class="input" name="name" type="text" placeholder="NAME*" /></div>
            <div class="row"><label>Email*</label><input class="input" name="email" type="email" placeholder="EMAIL*" /></div>
            <div class="row"><label>Phone*</label><input class="input" name="phone" type="text" placeholder="PHONE" /></div>
            <div class="row row-radio group">
            	<label>Interests</label>
                <div><input id="opt-birthdays" class="rdsn-radio" name="opt_birthdays" type="checkbox" value="Birthdays"/><label for="opt-birthdays">Birthdays</label></div>
                <div><input id="opt-groups" class="rdsn-radio" name="opt_groups" type="checkbox" value="Groups/Educational visits"/><label for="opt-groups">Groups/Educational visits</label></div>
                <div><input id="opt-animals" class="rdsn-radio" name="opt_animals" type="checkbox" value="Animals"/><label for="opt-animals">Animals</label></div>
                <div><input id="opt-passport" class="rdsn-radio" name="opt_passport" type="checkbox" value="Amazonia passport"/><label for="opt-passport">Amazonia passport</label></div>
            </div>
            <div class="row"><label>Message</label><textarea class="input" name="message" rows="5" placeholder="MESSAGE" ></textarea></div>
            <div class="row"><input class="btn-solid btn-form trans-0-3" type="submit" value="Send Message" onClick="return amazoniaContactApprove()"/></div>
        </div>
    </form>
</div>  
<?php
endif;
}


// ********************************************************************** INFO ROWS
function info_rows() {
if(have_rows('rep_content')):
$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-landscape-trans-02.png" alt="" class="placeholder" />';
echo '<div class="grid-rows">';
while(have_rows('rep_content')):the_row();
	$title = get_sub_field('rep_cont_title');
	$content = get_sub_field('rep_cont_content');
	$image_src = wp_get_attachment_image_src(get_sub_field('rep_cont_image'), 'medium');
	$proportion = get_sub_field('rep_cont_img_proportion');
	if($image_src) { $image = $image_src[0]; } else { $image = get_template_directory_uri().'/assets/img/default-landscape-02.jpg'; }
	//
	echo '<div class="grid-row group animated anim-up">';
		if ($proportion == 'uploaded') { echo '<div class="rdsn-image"><img src="'.$image_src[0].'" alt="'.$title.'" /></div>'; }
		else { echo '<div class="rdsn-image" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div>'; }
		echo '<div class="content"><div class="title">'.$title.'</div><div class="text">'.$content.'</div></div>';	
	echo '</div>';
	//
endwhile;
echo '</div>';
endif;	
}
function inforows_shcd(){
	ob_start();
  	info_rows();
  	$data = ob_get_clean();
  	return $data;	
}
add_shortcode('info-rows','inforows_shcd');



// ********************************************************************** TICKET ROWS
function ticket_grid() {
if(have_rows('ticket_rep')):
$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="" class="placeholder" />';
echo '<div id="ticket-grid" class="grid-wrapper">';
while(have_rows('ticket_rep')):the_row();
	$title = get_sub_field('ticket_rep_title');
	$online_price = get_sub_field('ticket_rep_online_price');
	$onday_price = get_sub_field('ticket_rep_day_price');
	$link = get_sub_field('ticket_rep_link');
	$image_src = wp_get_attachment_image_src(get_sub_field('ticket_rep_image'), 'medium');
	if($image_src) { $image = $image_src[0]; } else { $image = get_template_directory_uri().'/assets/img/default-square-amazonia-01.jpg'; }
	//
	echo '<div class="grid-item animated anim-up">';
		echo '<div class="overlay"></div>';
		echo '<div class="image-wrapper"><div class="image trans-0-3" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></div>';
		echo '<div class="content-wrapper"><div class="vcenter-outer"><div class="vcenter-inner"><div class="title">'.$title.'</div><div class="prices"><div class="online">Online: '.$online_price.'</div><div>On the day: '.$onday_price.'</div></div></div></div></div>';
		if($link) { echo '<div class="btn-wrapper"><a href="'.$link.'" class="btn-solid trans-0-3">Buy Now</a></div>'; }
	echo '</div>';
	//
endwhile;
echo '</div>';
endif;	
}
function ticket_grid_shcd(){
	ob_start();
  	ticket_grid();
  	$data = ob_get_clean();
  	return $data;	
}
add_shortcode('ticket-prices','ticket_grid_shcd');


// ********************************************************************** OFFERS ROWS
function offers_rows() {
$posts = get_field('assign_offers');
if( $posts ):
$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-landscape-trans-02.png" alt="" class="placeholder" />';
echo '<div class="grid-rows">';
	foreach( $posts as $post ): setup_postdata($post);
	$title = get_the_title($post);
	$content = apply_filters('the_content', $post->post_content);
	$image_src = wp_get_attachment_image_src( get_post_thumbnail_id($post), 'medium' );
	if($image_src) { $image = $image_src[0]; } else { $image = get_template_directory_uri().'/assets/img/default-landscape-02.jpg'; }
	//
	echo '<div class="grid-row group animated anim-up">';
		echo '<div class="rdsn-image" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div>';
		echo '<div class="content"><div class="title">'.$title.'</div><div class="text">'.$content.'</div></div>';	
	echo '</div>';
	//
	endforeach;
	wp_reset_postdata();	
echo '</div>';
endif;
}	


// ********************************************************************** DEAL ICONS
function deal_icons() {
if(have_rows('rep_deals')):
$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="" class="placeholder" />';
echo '<div id="grid-icons">';
while(have_rows('rep_deals')):the_row();
	$title = get_sub_field('rep_deal_title');
	$content = get_sub_field('rep_deal_content');
	$image_src = wp_get_attachment_image_src(get_sub_field('rep_deal_image'), 'full');
	if($image_src) { $image = $image_src[0]; } else { $image = get_template_directory_uri().'/assets/img/default-landscape-02.jpg'; }
	//
	echo '<div class="grid-item group animated anim-up">';
		echo '<div class="rdsn-image" style="background:url('.$image.') center center no-repeat;background-size:cover;">'.$placeholder.'</div>';
		echo '<div class="content"><div class="title">'.$title.'</div><div class="text">'.$content.'</div></div>';
	echo '</div>';
	//
endwhile;
echo '</div>';
endif;	
}
function deal_icons_shcd(){
	ob_start();
  	deal_icons();
  	$data = ob_get_clean();
  	return $data;	
}
add_shortcode('deal-icons','deal_icons_shcd');


// ********************************************************************** TICKET LINK
function ticket_link() {
	$ticket_link = get_field('ticket_link');
	if ($ticket_link) { echo '<a href="'.$ticket_link.'" target="_blank" class="btn-solid ticket-link trans-0-2">Buy tickets</a>'; }	
}
function ticket_shcd(){
	ob_start();
  	ticket_link();
  	$data = ob_get_clean();
  	return $data;	
}
add_shortcode('ticket-link','ticket_shcd');


// ********************************************************************** GALLERY
function rdsn_gallery() {
	$gallery_type = get_field('gallery_type');
	$images = get_field('gallery');
	$btn_prev = '<div class="btn-prev trans-0-5" />&nbsp;</div>';
	$btn_next = '<div class="btn-next trans-0-5" />&nbsp;</div>';
	//
	if( $images && $gallery_type == 'slider' ):
	echo '<div id="slider-wrapper" class="slider-wrapper">'.$btn_prev.$btn_next.'<div id="slider" class="slider">';
		foreach( $images as $image ):
			$alt = $image['alt'];
			$large_img_src = $image['sizes']['large'];
			$caption = $image['caption']; 
			if ($alt) { $alt = $image['alt']; } else $alt = "";
			$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-landscape-trans.png" alt="'.$alt.'" class="placeholder" />';
			echo '<div class="slide" style="background:url('.$large_img_src.') center center no-repeat;background-size:cover;">'.$placeholder.'</div>';
		endforeach;
	echo '</div></div>';
	endif;
	//
	if( $images && $gallery_type == 'lightbox' ):
	echo '<div class="grid-gallery grid-wrapper group">';
		foreach( $images as $image ):
			$alt = $image['alt'];
			//$large_img_src = $image['sizes']['large'];
			$large_img_src = $image['url'];
			$thumb_img_src = $image['sizes']['medium'];
			$caption = $image['caption']; 
			if ($alt) { $alt = $image['alt']; } else $alt = "";
			$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png" alt="'.$alt.'" class="placeholder" />';
			echo '<div class="grid-item"><a class="pop-gallery" href="'.$large_img_src.'" data-fgallery data-fancybox="images" data-caption="'.$caption.'"><div class="inner trans-0-3" style="background:url('.$thumb_img_src.') center center no-repeat;background-size:cover;">'.$placeholder.'</div></a></div>';
		endforeach;
	echo '</div>';
	echo '<script type="text/javascript">jQuery(document).ready(function() { jQuery.fancybox.defaults.hash = false; });</script>';
	endif;
}
function gallery_shcd(){
	ob_start();
  	rdsn_gallery();
  	$data = ob_get_clean();
  	return $data;	
}
add_shortcode('image-gallery','gallery_shcd');


function rdsn_gallery_fixed() {
	$images = get_field('gallery_fixed');
	$btn_prev = '<div class="btn-prev trans-0-5" />&nbsp;</div>';
	$btn_next = '<div class="btn-next trans-0-5" />&nbsp;</div>';
	//
	if($images) {
	$title = get_the_title();
	$wood_panel_src = wp_get_attachment_image_src(get_field('wood_panel_image'),'full');
	if($wood_panel_src) { $wood_panel = '<img src="'.$wood_panel_src[0].'" alt="'.$title.'" />'; }
	if($wood_panel_src) { echo '<div id="slider-wrapper" class="amazonia-wood-panel slider-wrapper"><div class="wood-panel">'.$wood_panel.'</div>'.$btn_prev.$btn_next.'<div id="slider" class="slider">'; } else { echo '<div id="slider-wrapper" class="slider-wrapper">'.$btn_prev.$btn_next.'<div id="slider" class="slider">'; }
		foreach( $images as $image ):
			$alt = $image['alt'];
			$large_img_src = $image['sizes']['large'];
			$caption = $image['caption']; 
			if ($alt) { $alt = $image['alt']; } else $alt = "";
			$placeholder = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/placeholder-landscape-trans.png" alt="'.$alt.'" class="placeholder" />';
			echo '<div class="slide" style="background:url('.$large_img_src.') center center no-repeat;background-size:cover;">'.$placeholder.'</div>';
		endforeach;
	echo '</div></div>';
	}
	//
}



// ********************************************************************** FOOTER CALL-TO-ACTION BOXES
function footer_box_type() {
	$footer_box = get_field('display_footer_box');
	if($footer_box == 'appstore') { footer_box_app(); } elseif ($footer_box == 'attraction_2') { footer_box_attraction_2(); } elseif ($footer_box == 'attraction_3') { footer_box_attraction_3(); } else { footer_box_attraction(); }	
}


function footer_box_attraction() {
//
$title = get_field('ftr_attr_title','option');
$text = get_field('ftr_attr_text','option');
$link_text = get_field('ftr_attr_btn','option');
$link = get_field('ftr_attr_link','option');
$image = wp_get_attachment_image_src(get_field('ftr_attr_bg','option'), 'large');
$vid_url = get_field('ftr_attr_vid_url','option');
$vid_btn = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/btn-vid-01.png" alt="Play Video" class="vid-btn trans-0-3" />';
//
echo '<div id="footer-top" class="footer-attraction group">';
	echo '<div class="left" style="background:url('.$image[0].') center top no-repeat;background-size:cover;">';
	if($vid_url) { echo '<a data-fancybox rdsn-vid-modal href="'.$vid_url.'&amp;autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0">'.$vid_btn.'</a>'; }
	echo '</div>';
	echo '<div class="right"><div class="inner">';
		echo '<div class="title">'.$title.'</div>';
		echo '<div class="text">'.$text.'</div>';
		echo '<div class="links"><a href="'.$link.'" class="btn-solid trans-0-3">'.$link_text.'</a></div>';
	echo '</div></div>';
echo '</div>';
if($vid_url) {
echo '<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("[rdsn-vid-modal]").fancybox({
		baseClass: "vid-modal-wrapper"
	});
});
</script>';	
}
}

function footer_box_attraction_2() {
//
$title = get_field('ftr_attr_title_2','option');
$text = get_field('ftr_attr_text_2','option');
$link_text = get_field('ftr_attr_btn_2','option');
$link = get_field('ftr_attr_link_2','option');
$image = wp_get_attachment_image_src(get_field('ftr_attr_bg_2','option'), 'large');
$vid_url = get_field('ftr_attr_vid_url_2','option');
$vid_btn = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/btn-vid-01.png" alt="Play Video" class="vid-btn trans-0-3" />';
//
echo '<div id="footer-top" class="footer-attraction group">';
	echo '<div class="left" style="background:url('.$image[0].') center top no-repeat;background-size:cover;">';
	if($vid_url) { echo '<a data-fancybox rdsn-vid-modal href="'.$vid_url.'&amp;autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0">'.$vid_btn.'</a>'; }
	echo '</div>';
	echo '<div class="right"><div class="inner">';
		echo '<div class="title">'.$title.'</div>';
		echo '<div class="text">'.$text.'</div>';
		echo '<div class="links"><a href="'.$link.'" class="btn-solid trans-0-3">'.$link_text.'</a></div>';
	echo '</div></div>';
echo '</div>';
if($vid_url) {
echo '<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("[rdsn-vid-modal]").fancybox({
		baseClass: "vid-modal-wrapper"
	});
});
</script>';	
}
}

function footer_box_attraction_3() {
//
$title = get_field('ftr_attr_title_3','option');
$text = get_field('ftr_attr_text_3','option');
$link_text = get_field('ftr_attr_btn_3','option');
$link = get_field('ftr_attr_link_3','option');
$image = wp_get_attachment_image_src(get_field('ftr_attr_bg_3','option'), 'large');
$vid_url = get_field('ftr_attr_vid_url_3','option');
$vid_btn = '<img src="'.get_bloginfo('stylesheet_directory').'/assets/img/btn-vid-01.png" alt="Play Video" class="vid-btn trans-0-3" />';
//
echo '<div id="footer-top" class="footer-attraction group">';
	echo '<div class="left" style="background:url('.$image[0].') center top no-repeat;background-size:cover;">';
	if($vid_url) { echo '<a data-fancybox rdsn-vid-modal href="'.$vid_url.'&amp;autoplay=1&amp;rel=0&amp;controls=0&amp;showinfo=0">'.$vid_btn.'</a>'; }
	echo '</div>';
	echo '<div class="right"><div class="inner">';
		echo '<div class="title">'.$title.'</div>';
		echo '<div class="text">'.$text.'</div>';
		echo '<div class="links"><a href="'.$link.'" class="btn-solid trans-0-3">'.$link_text.'</a></div>';
	echo '</div></div>';
echo '</div>';
if($vid_url) {
echo '<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery("[rdsn-vid-modal]").fancybox({
		baseClass: "vid-modal-wrapper"
	});
});
</script>';	
}
}


function footer_box_app() {
//
$title = get_field('ftr_app_title','option');
$text = get_field('ftr_app_text','option');
$link_apple = get_field('ftr_app_link_apple','option');
$link_android = get_field('ftr_app_link_android','option');
$image = wp_get_attachment_image_src(get_field('ftr_app_bg','option'), 'large');
//
echo '<div id="footer-top" class="footer-app group">';
	echo '<div class="left" style="background:url('.$image[0].') center center no-repeat;background-size:cover;"></div>';
	echo '<div class="right"><div class="inner">';
		echo '<div class="title">'.$title.'</div>';
		echo '<div class="text">'.$text.'</div>';
		echo '<div class="links"><a href="'.$link_apple.'" class="btn-solid trans-0-3" target="_blank">App Store</a><a href="'.$link_android.'" class="btn-solid trans-0-3" target="_blank">Android</a></div>';
	echo '</div></div>';
echo '</div>';
}


// ********************************************************************** FOOTER ATTRACTIONS MENU
function rdsn_attractions() {
if(have_rows('attractions_rep','option')):
echo '<div id="footer-sites">';
//
while(have_rows('attractions_rep','option')):the_row();
	$title = get_sub_field('attractions_title');
	$link = get_sub_field('attractions_text');
	$dest = get_sub_field('attractions_link_destination');
	$link_bg = wp_get_attachment_image_src(get_sub_field('attractions_link_bg'), 'large');
	$tab_bg = wp_get_attachment_image_src(get_sub_field('attractions_tab_bg'), 'large');
	$tab_content = get_sub_field('attractions_tab_content');
	echo '<div class="grid-item" style="background:url('.$link_bg[0].') center center no-repeat;background-size:cover;">';
		echo '<div class="vcenter-outer"><div class="vcenter-inner"><div class="title">'.$title.'</div></div></div>';
		echo '<div class="tab trans-0-3" style="background:#4A1260 url('.$tab_bg[0].') center center no-repeat;background-size:cover;"><div class="inner">'.$tab_content.'<a href="'.$link.'" target="'.$dest.'" class="more-link">See More</a></div></div>';
	echo '</div>';
endwhile;
//
echo '</div>';
endif;	
}


// ********************************************************************** FOOTER CONTACT
function rdsn_footer_contact() {
	$address = get_field('ftr_address','option');
	$phone = get_field('ftr_phone','option');
	$phone_link = str_replace(' ', '', $phone);
	$mobile = get_field('ftr_mobile','option');
	$mobile_link = str_replace(' ', '', $mobile);
	$email = get_field('ftr_email','option');
	if ($address) { echo $address.'<br />'; }
	if ($phone) { echo 'Tel: <a href="tel:'.$phone_link.'" class="trans-0-3">'.$phone.'</a>'; }
	if ($mobile) { echo ', Mob: <a href="tel:'.$mobile_link.'" class="trans-0-3">'.$mobile.'</a>'; }
	if ($email) { echo ' | Email: <a href="mailto:'.antispambot($email).'" class="trans-0-3">'.antispambot($email).'</a>'; }	
}


// ********************************************************************** GET FOOTER MENUS ********
function footerLinks() {
$ftr_links = get_field('footer_links','option'); // relationship	
echo '<ul>';
foreach( $ftr_links as $link):
	echo '<li><a href="'.get_permalink($link->ID).'">'.get_the_title($link->ID).'</a></li>';
endforeach;
echo '</ul>';
}


// ********************************************************************** CONTACT FORM
function rdsn_department() {
if(have_rows('rpt_contact', 'option')):
echo '<div id="department-menu" class="rdsn-select"><div class="select-btn">Select Department</div><div class="select-menu">';
	//
	while (have_rows('rpt_contact', 'option')) : the_row();
	$dept = get_sub_field('rpt_ct_department');
	echo '<div class="menu-item">'.$dept.'</div>';		
endwhile;
echo '</div><div class="selected">*</div></div>';			
endif;
}

function rdsn_contact_form() {
$show = get_field('contact_form_show','option');
if ($show != 'no'):
?>
<div id="contact-form-wrapper">
	<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/process.js"></script>
    <form action="/no-js.php" method="post" name="contact_form" id="contact-form" class="rdsn-form">
        <div class="group">
            <div class="row"><?php rdsn_department(); ?></div>
            <div class="row"><label>Name*</label><input class="input" name="name" type="text" placeholder="NAME*" /></div>
            <div class="row"><label>Email*</label><input class="input" name="email" type="email" placeholder="EMAIL*" /></div>
            <div class="row"><label>Phone*</label><input class="input" name="phone" type="text" placeholder="PHONE" /></div>
            <div class="row"><label>Message</label><textarea class="input" name="message" rows="5" placeholder="MESSAGE" ></textarea></div>
            <div class="row"><input class="btn-solid btn-form trans-0-3" type="submit" value="Send Message" onClick="return contactApprove()"/></div>
            <input type="hidden" id="department-row" name="department_row" />
        </div>
    </form>
</div>  
<?php
endif;
}
function contact_form_shcd(){
	ob_start();
  	rdsn_contact_form();
  	$data = ob_get_clean();
  	return $data;	
}
add_shortcode('contact-form','contact_form_shcd');

function rdsn_contact_thanks() {
	echo '<div id="contact-complete"><h2>'.get_field('ct_th_title','option').'</h2>'.get_field('ct_th_text','option').'</div>';
}


// ********************************************************************** SEARCH CUSTOM FIELDS
// Join posts and postmeta tables
function cf_search_join( $join ) {
    global $wpdb;
    if ( is_search() ) {    
        $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
    }
    return $join;
}
add_filter('posts_join', 'cf_search_join' );

// Modify the search query with posts_where
function cf_search_where( $where ) {
    global $pagenow, $wpdb;
    if ( is_search() ) {
        $where = preg_replace(
            "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
            "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
    }
    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );

// Prevent duplicates
function cf_search_distinct( $where ) {
    global $wpdb;
    if ( is_search() ) {
        return "DISTINCT";
    }
    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );


function jp_search_filter( $query ) {
if ( $query->is_search && $query->is_main_query() ) {
$query->set( 'post__not_in', array( 1475,1886,1888 ) );
}
}
add_action( 'pre_get_posts', 'jp_search_filter' );


// ********************************************************************** SET CUSTOM EXCERPT TEXT AND SIZE PER REF
function custom_excerpt_foreach( $limit, $post_id=NULL )   // works great in foreach loops
{
    if ( $post_id == NULL ) { 
        $the_excerpt = get_the_excerpt(); 
    } else { 
        $the_excerpt = get_the_excerpt($post_id); 
    }
    $excerpt = explode( ' ', $the_excerpt, $limit );     
    if ( count( $excerpt ) >= $limit ) {
        array_pop($excerpt);
        $excerpt = implode( " ",$excerpt ) . '...';
    } else {
        $excerpt = implode( " ",$excerpt );
    } 
    $excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );
return $excerpt;
}


function custom_excerpt($limit) {   // works better for wp_query loops
	  $excerpt = explode(' ', get_the_excerpt(), $limit);
      if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'';
      } else {
        $excerpt = implode(" ",$excerpt);
      } 
      $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
      return $excerpt;
}

function search_page_excerpt($new_length = 20, $new_more = '') { //
  add_filter('excerpt_length', function () use ($new_length) {
    return $new_length;
  }, 999);
  add_filter('excerpt_more', function () use ($new_more) {
	global $post;
	$new_more = '... <a class="text-link trans-0-3" href="'.get_permalink($post->ID).'">more&nbsp;&gt;</a>';  // CSR custom
	return $new_more;
  });
  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';
  echo $output;
}


// ********************************************************************** GET CONTENT WITH FORMATTING
function get_the_content_with_formatting ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	$content = get_the_content($more_link_text, $stripteaser, $more_file);
	$content = apply_filters('the_content', $content);
	$content = str_replace(']]>', ']]&gt;', $content);
	return $content;
}


// ********************************************************************** REDSUN SEO MODULE 
function rdsn_meta_title() {
	echo '<title>';
	if (get_field("seo_title")){
		echo get_field("seo_title").' | ';
		bloginfo('name');
	} else {
		wp_title(' | ', true, 'right');bloginfo('name');
	}
	echo '</title>'.PHP_EOL;
}

function rdsn_meta_description() {
	if (get_field("seo_description")) {
		$meta_desc = get_field("seo_description");
		echo '<meta name="description" content="'.$meta_desc.'">'.PHP_EOL;
	} else {
		$meta_desc = get_meta_description();
		if (get_meta_description()) {
			echo '<meta name="description" content="'.$meta_desc.'">'.PHP_EOL;
		} else {
			$meta_desc = get_bloginfo('description');
			echo '<meta name="description" content="'.$meta_desc.'" />'.PHP_EOL;
		}
	}
}

function rdsn_meta_og_title() {
	if (get_field("seo_title")){
		echo get_field("seo_title").' | ';
		bloginfo('name');
	} else {
		wp_title(' | ', true, 'right');bloginfo('name');
	}
}

function rdsn_meta_og_image() {
	$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
	if (!$image) { $image = get_bloginfo('stylesheet_directory').'/assets/img/site-icon.png'; } else { $image = $image[0]; }
	echo $image;
}

function rdsn_meta_og_description() {
	if (get_field("seo_description")){
		$meta_desc = get_field("seo_description");
		echo $meta_desc;
	} else {
	$meta_desc = get_meta_description();
		if (get_meta_description()) {
			echo $meta_desc;
		} else {
			$meta_desc = get_bloginfo('description');
			echo $meta_desc;
		}
	}
}

function rdsn_meta_og_site_name() {
	echo bloginfo('name');
}

function get_meta_description(){
	if (!is_404() && !is_search())  {
		global $post;
		setup_postdata( $post );
		$excerpt = get_the_content();
		$excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
		$excerpt = strip_shortcodes($excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, 170);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		$excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
		return $excerpt;
		wp_reset_postdata( $post );
	}
}


// ********************************************************************** UTILITIES ********
function pa($array)
{
// for debugging
echo '<pre>'; print_r($array);echo '</pre>';
}

function pax($array) 
{ // shortcut 
		 pa($array); exit;
}

function qx()
{ // shortcut to show last query and exit
$CI =& get_instance();
echo '<pre>'; 
echo $CI->db->last_query();
echo '</pre>';	
exit;
}


?>