<?php

// USER IDs allowed to see all admin menus
const MD_VIP_USERS = [1,2,3,11];

function is_md_vip() {
    $user_id = get_current_user_id();
    if(in_array($user_id,MD_VIP_USERS)):
        return TRUE;
    endif;
    return FALSE;
}


// ********************************************************************** CUSTOMISE THE ADMIN AREA ********
add_action( 'show_admin_bar', '__return_false' );
/*$user_id = get_current_user_id();
if($user_id == '1') {
	add_action( 'show_admin_bar', '__return_false' );
}*/

function rdsn_custom_login()
{
    echo '<style  type="text/css">
	body.login {background:#FFCA44;}
	body.login {-webkit-background-size:cover!important;-moz-background-size:cover!important;-o-background-size:cover!important;background-size:cover!important;}
	body.interim-login {background:#FFCA44!important;}
	h1 a {background-image:url(' . get_bloginfo('template_directory') . '/assets/img/logo-login.png) !important;width:320px!important;height:100px!important;background-size: 320px 100px!important;margin:0 auto!important;} 
	.login form {margin-top:20px!important;box-shadow:none!important;padding-bottom:30px!important;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;}
	.login .message {border-left:none!important;text-align:center!important;box-shadow:none!important;margin:0!important;padding-top:30px!important;background:#FFCA44!important;}
	.login #login_error {border-left:none!important;text-align:center!important;box-shadow:none!important;margin:0!important;padding-top:30px!important;background:#FFCA44!important;}
	.login #nav,.login #backtoblog {display:none!important;}
	.login .privacy-policy-page-link {display:none!important;}
	.wp-core-ui .button-primary {background:#4A1260!important;border-color:#4A1260!important;color:#FFF!important;box-shadow:none!important;text-shadow:none!important;text-transform:uppercase;height:38px!important;line-height:36px!important;padding:0px 22px 2px!important;transition:all 0.3s ease-in-out;}
	.wp-core-ui .button-primary:hover,.wp-core-ui .button-primary:focus {background:#91428B!important;border-color:#91428B!important;color:#FFF!important;box-shadow:none!important;text-shadow:none!important;}
	</style>';
}
add_action('login_head',  'rdsn_custom_login');

function rdsn_login_url() { return '/'; }
add_filter('login_headerurl', 'rdsn_login_url');
function rdsn_login_text() { return 'Home Page'; }
add_filter('login_headertitle', 'rdsn_login_text');


// ********************************************************************** RE-DIRECT NON ADMINS
add_action( 'admin_init', 'rdsn_redirect_non_admin_users' );
function rdsn_redirect_non_admin_users() {
	$user_id = get_current_user_id();
	if ( $user_id == '14' && ('/wp-admin/admin-ajax.php' != $_SERVER['PHP_SELF']) ) {
		wp_redirect( home_url().'/process-order/' );
		exit;
	}
}


// ********************************************************************** VALIDATE ADMIN FIELDS
function load_validation_scripts( $hook ) {
	global $post;	
	// Load the scripts & styles below only if we're creating/updating the post
	if ( $hook == 'post-new.php' || $hook == 'post.php' ):
	if ( $post->post_type == 'page' || $post->post_type == 'post' || $post->post_type == 'rdsn_ride' || $post->post_type == 'rdsn_event' || $post->post_type == 'rdsn_offer' || $post->post_type == 'rdsn_tickets' ) {
			wp_enqueue_script( 'check_title', get_template_directory_uri().'/assets/js/validate-title.js', array( 'jquery' ) );
		}
	if ( $post->post_type == 'rdsn_ride' ) {
			wp_enqueue_script( 'check_ride_cat', get_template_directory_uri().'/assets/js/validate-cat.js', array( 'jquery' ) );
		}
	endif;
}
add_action( 'admin_enqueue_scripts', 'load_validation_scripts' );


// ********************************************************************** ACF ********
$user_id = get_current_user_id();
	if(!is_md_vip()) {
	add_filter('acf/settings/show_admin', '__return_false');
}

if( function_exists('acf_add_options_page') ) {	
	// add parent
	$parent = acf_add_options_page(array(
		'page_title' 	=> 'Site Settings',
		'menu_title' 	=> 'Site Settings',
		'redirect' 		=> true
	));
	// add sub pages
	acf_add_options_sub_page(array(
		'page_title' 	=> 'General Settings',
		'menu_title' 	=> 'General Settings',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Default Banner',
		'menu_title' 	=> 'Default Banner',
		'parent_slug' 	=> $parent['menu_slug'],
	));
    acf_add_options_sub_page(array(
		'page_title' 	=> 'Calendar Colour Coding',
		'menu_title' 	=> 'Calendar Colours',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Navigation links',
		'menu_title' 	=> 'Navigation links',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Contact Page',
		'menu_title' 	=> 'Contact Page',
		'parent_slug' 	=> $parent['menu_slug'],
	));
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Footer Items',
		'menu_title' 	=> 'Footer Items',
		'parent_slug' 	=> $parent['menu_slug'],
	));
}


// ********************************************************************** SHOW DATE IN OPENING TIME ADMIN COLUMN
function add_rdsn_year_column ( $columns ) {
   	//return array_merge ( $columns, array ( 
     	//'ot_year' => __ ( 'Year' )
   	//) );
   	$column_title = array( 'ot_year' => 'Year' );
	$columns = array_slice( $columns, 1, 1, true ) + $column_title + array_slice( $columns, 1, NULL, true ); // first 1 is the offset so 0 would be first column etc
	return $columns;
 }
 add_filter ( 'manage_rdsn_opening_time_posts_columns', 'add_rdsn_year_column' );
 
 function rdsn_year_custom_column ( $column, $post_id ) {
   switch ( $column ) {
     case 'ot_year':
       echo '<strong>'.get_post_meta( $post_id, 'ot_year', true ).'</strong>';
       break;
     /*case 'end_date':
       echo get_post_meta ( $post_id, 'end_date', true );
       break;*/
   }
 }
 add_action ( 'manage_rdsn_opening_time_posts_custom_column', 'rdsn_year_custom_column', 10, 2 );


// ********************************************************************** POSTS TO NEWS ********
function change_post_menu_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add a News Item';
    $submenu['edit.php'][15][0] = 'News Categories'; // Change name for categories
    //$submenu['edit.php'][16][0] = 'Labels'; // Change name for tags  //dashicons-format-aside
    echo '';
}

function change_post_object_label() {
        global $wp_post_types;
        $labels = &$wp_post_types['post']->labels;
        $labels->name = 'News';
        $labels->singular_name = 'News';
        $labels->add_new = 'Add a News Item';
        $labels->add_new_item = 'Add a News Item';
        $labels->edit_item = 'Edit News Item';
        $labels->new_item = 'New News Item';
        $labels->view_item = 'View News Item';
        $labels->search_items = 'Search News Items';
        $labels->not_found = 'No News Items found';
        $labels->not_found_in_trash = 'No News Items found in Trash';
    }
    add_action( 'init', 'change_post_object_label' );
    add_action( 'admin_menu', 'change_post_menu_label' );


/*function custom_menu_order($menu_ord) {
       if (!$menu_ord) return true;
       return array(
        //'index.php', // this represents the dashboard link
        'edit.php?post_type=page', //the page tab
		'separator1', // First separator
		'edit.php', //the posts tab
		'separator2', // Second separator
		//'edit.php?post_type=rdsn_staff',
		//'edit.php?post_type=rdsn_vacancies',
		//'edit.php?post_type=rdsn_testimonials',
		//'upload.php', // the media manager
    );
   }
add_filter('custom_menu_order', 'custom_menu_order');
add_filter('menu_order', 'custom_menu_order');*/

function edit_admin_menus() {	
	$user_id = get_current_user_id();
	remove_menu_page( 'edit.php' );
	if(!is_md_vip()) {
		remove_menu_page( 'edit.php?post_type=acf-field-group' );
	}
	if(!is_md_vip()) {
		remove_menu_page( 'index.php' );
		//remove_menu_page( 'edit.php' );
		remove_menu_page( 'edit-comments.php' );
		remove_menu_page( 'link-manager.php' );
        remove_menu_page( 'themes.php' );
		remove_menu_page( 'plugins.php' );
		remove_menu_page( 'users.php' );
		remove_menu_page( 'tools.php' );
		remove_menu_page( 'options-general.php' );
	}
}
add_action( 'admin_menu', 'edit_admin_menus' );



add_action('admin_menu', 'my_remove_sub_menus');

function my_remove_sub_menus() {
	$user_id = get_current_user_id();
	if(!is_md_vip()) {
	remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=category');
    remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
	}
}



function custom_admin_nav() {
/*$user_id = get_current_user_id();
if($user_id != '1') {
echo '<style type="text/css">
.plugins-php tr[data-slug="advanced-custom-fields-pro"] {display:none;}
</style>';
}*/
$user_id = get_current_user_id();
if(!is_md_vip()) {
echo '<style type="text/css">
#toplevel_page_options-media,
#wp-admin-bar-wp-logo,#wp-admin-bar-comments,#wp-admin-bar-new-content,#wp-admin-bar-view,#wp-admin-bar-updates,
#collapse-menu,
#toplevel_page_eml-taxonomies-options,
.update-nag,
#footer-upgrade,#wp-version-message a.button,
#dashboard-widgets .postbox-container .empty-container,
#welcome-panel,
#wp-admin-bar-edit-profile,#wp-admin-bar-user-info,
#contextual-help-link-wrap {display:none!important;}
#category-adder {display:none!important;}
#toplevel_page_yit_plugin_panel {display:none!important;}
#menu-posts-rdsn_testimonials {display:none!important;}
#toplevel_page_loginizer {display:none!important;}
#dashboard_activity, #example_dashboard_widget, #yith_dashboard_products_news, #yith_dashboard_blog_news {display:none!important;}
#dashboard_site_health, #dashboard_php_nag, #wp-admin-bar-updraft_admin_node {display:none!important;}
</style>';
}
echo '<style type="text/css">
.admin-menu-tree-page-filter {display:none!important;}
#cpt_info_box {display:none!important;}
#publish {background:#093!important;border-color:#093!important;text-transform:uppercase;text-shadow:none!important;box-shadow:none!important;font-weight:bold;}
#publish:hover,#publish:focus {color:#FFF!important;background:#93D800!important;border-color:#93D800!important;}

.wee-field input {width:200px!important;}
.acf-image-uploader img {width:50%!important;}
.acf-postbox h2 {text-transform:uppercase!important;}
#order_data h2 {text-shadow:none!important;padding:8px 24px!important;margin:-23px -24px 12px!important;}
.acf-min-height .acf-editor-wrap iframe {height:100px!important;min-height:100px!important;}
.acf-repeater .acf-row-handle.order, .acf-fields.-left {border-bottom:10px solid #CCC!important;}
.acf-field.field-separator {border-bottom:5px solid #F4F4F4!important;}
.acf-field.field-separator-02 {border-bottom:10px solid #CCC!important;}
.acf-rdsn-title input[type="text"] {font-size:1.7em!important;height:1.7em!important;line-height:100%;margin:0 0 3px;outline:0 none;padding:3px 8px;width:100%;}
.acf-rdsn-title .acf-input-wrap {overflow:visible!important;}
.wee-field input {width:200px!important;}
.wp-menu-separator {height:1px!important;margin:12px 0px 12px 0px!important;background:#444!important;border-top:2px solid #000!important;}

#tagsdiv-post_tag {display:none!important;}
.post-state {color:#093!important;}
.postbox-header {background:#32373C;}
.postbox-header h2 {color:#FFF;}
#poststuff h2 {background:#32373C;color:#FFF;}
/*#postdivrich {display:none!important;}*/

/*div.acf-field[data-name="banner_text"], div.acf-field[data-name="banner_show_button"], div.acf-field[data-name=""] {display:none!important;}*/
div.acf-field[data-name="banner_text"], div.acf-field[data-name="banner_vid_length"],div.acf-field[data-name="ftr_app_show"], div[data-name="banner_order"]  {display:none!important;}

.acf-field-repeater[data-name="rep_glossary"] th[data-name="gl_term"] {width:30%!important;}
.acf-repeater .acf-row.-collapsed > .acf-fields > .acf-field[data-name="rpt_ot_custom"] {display:block!important;}
.acf-repeater .acf-row.-collapsed > .acf-fields > .acf-field[data-name="rpt_ot_custom"] input {font-weight:bold;color:#093!important;}

.acf-flexible-content .acf-fc-layout-handle {background:#CCC!important;}
.acf-fc-popup {padding:15px 10px!important;}

.acf-fc-popup li a {font-size:16px!important;}
.acf-fc-popup [data-layout="page_title"]:before{font-family:"dashicons";content:"\f333";margin-right:10px;}
.acf-fc-popup [data-layout="banner"]:before{font-family:"dashicons";content:"\f128";margin-right:10px;}
.acf-fc-popup [data-layout="content_block"]:before{font-family:"dashicons";content:"\f333";margin-right:10px;}
.acf-fc-popup [data-layout="full_image"]:before{font-family:"dashicons";content:"\f128";margin-right:10px;}
.acf-fc-popup [data-layout="columns"]:before{font-family:"dashicons";content:"\f535";margin-right:10px;}
.acf-fc-popup [data-layout="library_docs"]:before{font-family:"dashicons";content:"\f330";margin-right:10px;}
.acf-fc-popup [data-layout="video_embed"]:before{font-family:"dashicons";content:"\f126";margin-right:10px;}
.acf-fc-popup [data-layout="map_embed"]:before{font-family:"dashicons";content:"\f231";margin-right:10px;}
.acf-fc-popup [data-layout="gallery_images"]:before{font-family:"dashicons";content:"\f161";margin-right:10px;}
.acf-fc-popup [data-layout="divider"]:before{font-family:"dashicons";content:"\f168";margin-right:10px;}

.acf-fc-popup [data-layout="page_title"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="banner"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="content_block"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="full_image"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="columns"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="library_docs"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="video_embed"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="map_embed"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="gallery_images"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}
.acf-fc-popup [data-layout="divider"]:before{-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased;}


.post-type-rdsn_opening_time .widefat tr th#title {width:220px!important;}
.rdsn-toggle-repeater {position:relative;display:inline-block;font-weight:600;text-transform:uppercase;margin:10px 0 10px 12px;padding:10px 15px;color:#FFF;background:#CCC;line-height:100%;border-radius:5px;transition:background 0.25s ease-in-out;z-index:20;cursor:pointer;}
.rdsn-toggle-repeater:hover {background:#093;}

th.manage-column.column-ot_year {
 width:120px;
}

</style>';
}
add_action('admin_head', 'custom_admin_nav');


function rdsn_acf_repeater_collapse() {
?>
<style id="rdsn-acf-repeater-collapse">.acf-repeater .acf-table {display:none;}</style>
<script type="text/javascript">
	jQuery(function($) {
		$('.acf-postbox > .inside > .acf-field-repeater').before("<div class='rdsn-toggle-repeater'>open all &gt;</div>");
		$(".rdsn-toggle-repeater").on( "click touchstart", function() {	
			if($(this).html() == 'open all &gt;') {
				console.log('open all');
				$(this).next('.acf-field-repeater').find('.acf-repeater.-row .acf-row, acf-repeater.-table .acf-row').removeClass('-collapsed');
				$(this).html('close all &gt;');
			} else {
				console.log('close all');
				$(this).next('.acf-field-repeater').find('.acf-repeater.-row .acf-row, acf-repeater.-table .acf-row').addClass('-collapsed');
				$(this).html('open all &gt;');
			}
		});
		$('.acf-repeater.-row .acf-row').addClass('-collapsed');
		$('#rdsn-acf-repeater-collapse').detach();		
	});
</script>
<?php
}
add_action('acf/input/admin_head', 'rdsn_acf_repeater_collapse');


function remove_admin_link() {
	echo '<script type="text/javascript">jQuery(function(){ jQuery("#wp-admin-bar-my-account a.ab-item").first().attr("href", "#"); });</script>';
}
add_action('admin_head', 'remove_admin_link');


function replace_q( $wp_admin_bar ) {
	$my_account=$wp_admin_bar->get_node('my-account');
	$newq = str_replace( '?', ' ', $my_account->title );
	$wp_admin_bar->add_node( array(
	'id' => 'my-account',
	'title' => $newq,
	));
 }
add_filter( 'admin_bar_menu', 'replace_q',25 );


function replace_howdy( $wp_admin_bar ) {
	$my_account=$wp_admin_bar->get_node('my-account');
	$newtitle = str_replace( 'Hi,', 'Logged in as: ', $my_account->title );
	$wp_admin_bar->add_node( array(
	'id' => 'my-account',
	'title' => $newtitle,
	));
 }
add_filter( 'admin_bar_menu', 'replace_howdy',25 );



function vsnt_node( $wp_admin_bar ) {
//Grab all of the nodes
$all_toolbar_nodes = $wp_admin_bar->get_nodes();
//Loop through the nodes and find the ones to add the _blank target to
foreach ( $all_toolbar_nodes as $node ) {
	if($node->id == 'site-name' || $node->id == 'view-site')
        { // use the same node's properties
		$args = $node;
		// put a span before the title
		$args->meta = array('target' => '_blank');
		// update the Toolbar node
		$wp_admin_bar->add_node( $args );
        }
	}
}
add_action( 'admin_bar_menu', 'vsnt_node', 999 );


function remove_footer_admin ()
{
    echo '<span id="footer-thankyou">Developed by <a href="http://www.reflexblue.co.uk" target="_blank">reflexblue</a></span>';
}
add_filter('admin_footer_text', 'remove_footer_admin');


// ********************************************************************** ADMIN BAR
function mytinymce_buttons1($buttons)
 {
	$remove = array('fullscreen','strikethrough','wp_more');
	return array_diff($buttons,$remove);
 }
add_filter('mce_buttons','mytinymce_buttons1');

function mytinymce_buttons2($buttons)
 {
	$remove = array('forecolor','alignjustify','underline','wp_help');
	return array_diff($buttons,$remove);
 }
add_filter('mce_buttons_2','mytinymce_buttons2');

function mce_mod( $init ) {
   $init['block_formats'] = "Paragraph=p; Sub-heading=h2; Sub-heading with gap=h3;";
   return $init;
}
add_filter('tiny_mce_before_init', 'mce_mod');


// ********************************************************************** CUSTOM STYLE DROP-DOWN IN ADMIN EDITOR ********
// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	//if( ( $key = array_search( 'pastetext', $buttons ) ) !== false ) {
//		unset( $buttons[ $key ] );
//	}
	return $buttons;
}
add_filter('mce_buttons_2', 'my_mce_buttons_2');

function my_mce_before_init_insert_formats( $init_array ) {  
	$style_formats = array(  
		// Each array child is a format with it's own settings
		array(
        	'title' => 'Large text',
        	'inline' => 'span',
        	'classes' => 'txt-large'
        	),
		array(
        	'title' => 'Small text',
        	'inline' => 'span',
        	'classes' => 'txt-small'
        	),
		array(
        	'title' => 'Yellow text',
        	'inline' => 'span',
        	'classes' => 'yellow'
        	),
		array(
        	'title' => 'Purple text',
        	'inline' => 'span',
        	'classes' => 'purple-mid'
        	),
		array(
        	'title' => 'Link button',
        	'selector' => 'a',
        	'classes' => 'btn-solid btn-page trans-0-3'
        	),
		array(  
			'title' => 'Add invisible separator',
			'block' => 'div', 
			'classes' => 'separator-add',
			'wrapper' => true
			)
	);  
	$init_array['style_formats'] = json_encode( $style_formats );  
	return $init_array;  
} 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

add_filter( 'acf/fields/wysiwyg/toolbars' , 'custom_toolbars'  );
function custom_toolbars( $toolbars )
{
	// Add a new toolbar called "Custom" - only 1 row of buttons
	$toolbars['Custom' ] = array();
	$toolbars['Custom' ][1] = array('formatselect','styleselect','bold','italic','bullist','blockquote','alignleft','aligncenter','alignright','link','unlink');
	// return $toolbars
	return $toolbars;
}


// ********************************************************************** REMOVE META BOXES FROM WORDPRESS DASHBOARD FOR ALL USERS ********
function remove_dashboard_widgets()
{
    // Globalize the metaboxes array, this holds all the widgets for wp-admin
    global $wp_meta_boxes;
    // Main column:
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	// Side Column:
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );


