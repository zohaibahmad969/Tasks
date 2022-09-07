<?php
/**
 * Plugin Name:       Theme Park API Mod
 * Description:       Do the extra work for the APIs safely and independently.
 * Version:           1.1.0
 * Author:            Goshila Sadaf
 * Email:             sadafk883@gmail.com
 * Author URI:        https://therightsw.com
 * License:           GPL-2.0+
 * License URI:       https://therightsw.com
 * GitHub Plugin URI: https://therightsw.com
 */

/*
 *
 * MAIN CLASS
 *
 */
global $scotlandsthemeparkdb_version;
$scotlandsthemeparkdb_version = '1.0';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
// require_once get_template_directory().'/assets/forms/Exception.php';
// require_once get_template_directory().'/assets/forms/PHPMailer.php';
// require_once get_template_directory().'/assets/forms/SMTP.php';
class ThemeParkAPIMod 
{
    private $apiNamespace;
    private $apiVersion;
    private $host_name;
	

    public function __construct(){

        $this->apiNamespace = 'themepark-api';
        $this->apiVersion = 'v1';
        $this->host_name = 'https://scotlandsthemepark.com/mds-login/';
		##### Required Library #####
        require_once( dirname( __FILE__ ) . '/src/Twitter/twitteroauth.php');

        // PLUGIN ACTIVATION CALLBACK
        register_activation_hook( __FILE__, array( $this, 'activatePlugin' ) );

        // PLUGIN DEACTIVATION CALLBACK
        register_deactivation_hook( __FILE__, array( $this, 'deactivatePlugin' ) );

        // PLUGIN UNINSTALL CALLBACK
        //register_uninstall_hook( __FILE__, array( $this, 'uninstallPlugin' ) );

        // REGISTER NEW API ENDPOINTS
        add_action( 'rest_api_init', array($this, 'themeparkAPIEndpoints') );
		
		//CUSTOM POST TYPE LOCATION
		add_action( 'init', array($this, 'create_post_location') );
		
		// ADD MENU
		add_action( 'admin_menu', array($this, 'themeparkAPI_admin_menu') );
		

    }
	
    /*
    * PLUGIN ACTIVATION CALLBACK
    */
    public function themeparkAPIEndpoints() {

        // REGISTER NEW ENDPOINT AND SET CALLBACK METHOD
        register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/user/register', array(
                'methods'         => 'GET',
                'callback' => array($this, 'register'),
        ));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/user/fb_connect', array(
                'methods'         => 'GET',
                'callback' => array($this, 'fb_connect'),
        ));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/user/twitter_connect', array(
                'methods'         => 'GET',
                'callback' => array($this, 'twitter_connect'),
        ));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/user/google_connect', array(
                'methods'         => 'GET',
                'callback' => array($this, 'google_connect'),
        ));
		 register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_nonce', array(
                'methods'         => WP_REST_Server::READABLE,
                'callback' => array($this, 'get_nonce'),
        ));
        register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/user/login', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'login'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/user/userinfo', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_userinfo'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/user/password_reset', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'retrieve_password'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/nav_menus', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_nav_menus'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/pages', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_page_contents'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_rides', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_rides_content'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_events', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_events_content'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_attractions', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_attractions_content'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/posts', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_post_contents'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/banner', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_banner'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/opening_times', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_opening_times'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/special_offers', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_offers_content'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/food_drinks', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_food_drinks'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_in_touch', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_in_touch_content'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/submit_data', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'post_submit_data'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/device_configuration', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'post_device_configuration'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/push_notifications', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'func_push_notifications'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_departments', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_departments_content'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_locations', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_locations_data'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/post_user_location', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_user_location_data'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/location_base_notification', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'func_locationbase_push_notifications'),
		));
		register_rest_route( $this->apiNamespace . '/' . $this->apiVersion, '/get_style', array(
				  'methods'  => 'GET',
				  'callback' => array($this, 'get_stylesheet_themepark'),
		));

       
    }

    /*
    * PLUGIN ACTIVATION CALLBACK
    */
    public function activatePlugin() {
        ob_start();
      
        // do your actions here

        return ob_get_clean();
    }

    /*
    * PLUGIN DEACTIVATION CALLBACK
    */
    public function deactivatePlugin() {
        ob_start();
        
        // do your actions here

        return ob_get_clean();
    }

    /*
    * PLUGIN ACTIVATION CALLBACK
    */
    public function uninstallPlugin() {
        ob_start();

        // do your actions here

        return ob_get_clean();
    }
 /*
    * CREATE REQUIRED TABLE(S)
    */
    public static function CreateTables() {

        global $wpdb;
global $scotlandsthemeparkdb_version;
        $tables = array();

        $table = $wpdb->prefix . 'themepark_user_device_information';
        $charset_collate = $wpdb->get_charset_collate();

        $table_name = "CREATE TABLE $table (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
			device_token longtext NOT NULL ,
			location_id mediumint(9) NOT NULL ,
			location_radius varchar(255) NOT NULL,
			location_latitude varchar(255) NOT NULL,
			location_longitude varchar(255) NOT NULL,
            checkin_date_time datetime DEFAULT '2009-01-01 00:00:00' NOT NULL,
            
            PRIMARY KEY  (id)
        ) $charset_collate;";
		array_push($tables, $table_name);
		
		$table1 = $wpdb->prefix . 'themepark_push_notification';
        $charset_collate = $wpdb->get_charset_collate();

        $table_name_2 = "CREATE TABLE $table1 (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
			device_token longtext NOT NULL ,
			location_id mediumint(9) NOT NULL ,
			status varchar(255) NOT NULL,
			notification text NOT NULL,
			title varchar(255) NOT NULL,
            checkin_date_time datetime DEFAULT '2009-01-01 00:00:00' NOT NULL,
            
            PRIMARY KEY  (id)
        ) $charset_collate;";
		array_push($tables, $table_name_2);
		
		$table_2 = $wpdb->prefix . 'themepark_device_configuration';
        $charset_collate = $wpdb->get_charset_collate();

        $table_name_2 = "CREATE TABLE $table (
            id int(11) NOT NULL AUTO_INCREMENT,
			device_id int(11) NOT NULL ,
			device_token longtext NOT NULL,
			os_type varchar(255) NOT NULL,
            date_created datetime DEFAULT '2009-01-01 00:00:00' NOT NULL,
            
            PRIMARY KEY  (id)
        ) $charset_collate;";
		array_push($tables, $table_name_2);
		
		$table_3 = $wpdb->prefix . 'themepark_user_locations_information';
        $charset_collate = $wpdb->get_charset_collate();

        $table_name_3 = "CREATE TABLE $table_3 (
            id int(11) NOT NULL AUTO_INCREMENT,
			device_token longtext NOT NULL ,
			location_latitude varchar(255) NOT NULL,
			location_longitude varchar(255) NOT NULL,
            date_created datetime DEFAULT '2009-01-01 00:00:00' NOT NULL,
            
            PRIMARY KEY  (id)
        ) $charset_collate;";
		array_push($tables, $table_name_3);

        dbDelta( $tables );

        // ADD OPTION FOR DATABASE VERSION CONTROL
        if( !get_option( $scotlandsthemeparkdb_version ) ){
            add_option( 'scotlandsthemeparkdb_version', $scotlandsthemeparkdb_version );
        }
    }
	
	/*
	* CREATE ADMIN MENU
	*/
	
	public function themeparkAPI_admin_menu()
	{
				add_menu_page(__('Push Notifications', 'themeparkAPI'), __('Push Notifications', 'themeparkAPI'), 'activate_plugins', 'rdsn_push_notifications', 'rdsn_push_notifications_page');
				add_submenu_page('rdsn_push_notifications', __('App Devices Registered', 'themeparkAPI'), __('App Devices Registered', 'themeparkAPI'), 'activate_plugins', 'rdsn_app_devices_information', 'rdsn_app_devices_information');
				add_submenu_page('rdsn_push_notifications', __('Sent Notification', 'themeparkAPI'), __('Sent Notification', 'themeparkAPI'), 'activate_plugins', 'rdsn_app_notification', 'rdsn_app_notification_page');
				
	 }

			
    /*
    * PLUGIN SHORTCODE CALLBACK
    */
    public function PluginShortcode() {
        ob_start();

        echo '<h1>Greetings from Themepark API Mod Plugin!</h1>';

        return ob_get_clean();
    }

    public function login(){
		$creds = array();
		 if (!$_REQUEST['username']) {
	   $message = "You must include 'username' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $username = sanitize_user( $_REQUEST['username'] );
	if (!$_REQUEST['password']) {
	   $message = "You must include 'password' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $username = $_REQUEST['password'];
    $creds['user_login'] = $_REQUEST["username"];
    $creds['user_password'] =  $_REQUEST["password"];
    $creds['remember'] = true;
    $user = wp_signon( $creds, false );

    if ( is_wp_error($user) ){
	  $message = $user->get_error_message();
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
	}
			$response = array("status" => "success", "data" => $user);
			return new WP_REST_Response($response, 200);

	}
	public function register(){

	//$_REQUEST = $request->get_json_params();
			if(!count($_REQUEST) > 0){
				$message = "No User data received.";
				$response = array("status" => "failure", "message" => $message);
				return new WP_REST_Response($response, 200);
			}  



		
   if (!$_REQUEST['username']) {
	        $message = "You must include 'username' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $username = sanitize_user( $_REQUEST['username'] );
	
 
  if (!$_REQUEST['email']) {
	  $message = "You must include 'email' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $email = sanitize_email( $_REQUEST['email'] );
	
   if (!$_REQUEST['sex']) {
	  $message = "You must include 'sex' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $sex = sanitize_text_field( $_REQUEST['sex'] );
	
	if (!$_REQUEST['mobile']) {
	    $message = "You must include 'mobile' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $mobile = sanitize_text_field( $_REQUEST['mobile'] );
if (!$_REQUEST['dob']) {
	  $message = "You must include 'dob' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $dob = sanitize_text_field( $_REQUEST['dob'] );
	
 if (!$_REQUEST['nonce']) {
			$message = "You must include 'nonce' var in your request. Use the 'get_nonce' Core API method.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
 else $nonce =  sanitize_text_field( $_REQUEST['nonce'] ) ;
 
 if (!$_REQUEST['display_name']) {
	$message = "You must include 'display_name' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
	else $display_name = sanitize_text_field( $_REQUEST['display_name'] );

$user_pass = sanitize_text_field( $_REQUEST['user_pass'] );



//Add usernames we don't want used

$invalid_usernames = array( 'admin' );

//Do username validation

$nonce_id = 'themeparkuser-register';
 if( !wp_verify_nonce($_REQUEST['nonce'], $nonce_id) ) {
$message = "Invalid access, unverifiable 'nonce' value.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
        }

 else {

	if ( !validate_username( $username ) || in_array( $username, $invalid_usernames ) ) {
$message = "Username is invalid.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

  
        }

    elseif ( username_exists( $username ) ) {
$message = "Username already exists.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

           }			

	else{


	if ( !is_email( $email ) ) {
		$message = "E-mail address is invalid.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

             }
    elseif (email_exists($email)) {

$message = "E-mail address is already in use.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
          }			

else {

	//Everything has been validated, proceed with creating the user

//Create the user

if( !isset($_REQUEST['user_pass']) ) {
	 $user_pass = wp_generate_password();
	 $_REQUEST['user_pass'] = $user_pass;
}

 $_REQUEST['user_login'] = $username;
 $_REQUEST['user_email'] = $email;

$allowed_params = array('user_login', 'user_email', 'user_pass', 'display_name', 'user_nicename', 'user_url', 'nickname', 'first_name',
                         'last_name', 'description', 'rich_editing', 'user_registered', 'role', 'jabber', 'aim', 'yim',
						 'comment_shortcuts', 'admin_color', 'use_ssl', 'show_admin_bar_front'
                   );


foreach($_REQUEST as $field => $value){
		
	if( in_array($field, $allowed_params) ) $user[$field] = trim(sanitize_text_field($value));
	
    }
$user['role'] = get_option('default_role');
$user_id = wp_insert_user( $user );

/*Send e-mail to admin and new user - 
You could create your own e-mail instead of using this function*/

if( isset($_REQUEST['user_pass']) && $_REQUEST['notify']=='no') {
	$notify = '';	
  }elseif($_REQUEST['notify']!='no') $notify = $_REQUEST['notify'];


if($user_id) wp_new_user_notification( $user_id, '',$notify );  


			}
		} 
   }
	if($user_id){
		add_user_meta( $user_id, 'sex', $sex);
		add_user_meta( $user_id, 'dob', $dob);
		add_user_meta( $user_id, 'mobile', $mobile);
	}
	$seconds = 1209600;
	$expiration = time() + apply_filters('auth_cookie_expiration', $seconds, $user_id, true);

	$cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');
	$data = array( 
          "cookie" => $cookie,	
		  "user_id" => $user_id	
		  ); 
			$response = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response, 200);
		  

  } 
   public function get_nonce() {
    if (!$_REQUEST['controller']) {
	   $message = "You must include 'controller' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
		if (!$_REQUEST['method']) {
	   $message = "You must include 'method' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
      $data = array(
        'nonce' => wp_create_nonce('themepark'.$_REQUEST['controller'].'-'.$_REQUEST['method'])
      );
	  $response = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response, 200);
    
  }
  public function get_userinfo(){	  


    if (!$_REQUEST['user_id']) {
 $message = "You must include 'user_id' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}



		$user = get_userdata($_REQUEST['user_id']);



        preg_match('|src="(.+?)"|', get_avatar( $user->ID, 32 ), $avatar);		



		$data =  array(

				"id" => $user->ID,

				"username" => $user->user_login,

				"nicename" => $user->user_nicename,

				"email" => $user->user_email,

				"url" => $user->user_url,

				"displayname" => $user->display_name,

				"firstname" => $user->user_firstname,

				"lastname" => $user->last_name,

				"nickname" => $user->nickname,

				"sex" => get_user_meta( $user->ID, 'sex', true ),
				
				"mobile" => get_user_meta( $user->ID, 'mobile', true )  

		   );	   

        $response = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response, 200);

	  }   
public function retrieve_password(){



    global $wpdb, $json_api, $wp_hasher;  



   if (!$_REQUEST['user_login']) {



		 $message = "You must include 'user_login' var in your request.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);


		}



    $user_login = $_REQUEST['user_login'];



  if ( strpos( $user_login, '@' ) ) {



        $user_data = get_user_by( 'email', trim( $user_login ) );



        if ( empty( $user_data ) )



        



	 $message = "Your email address not found!";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		



    } else {



        $login = trim($user_login);



        $user_data = get_user_by('login', $login);



    }







    // redefining user_login ensures we return the right case in the email



    $user_login = $user_data->user_login;



    $user_email = $user_data->user_email;





    do_action('retrieve_password', $user_login);





    $allow = apply_filters('allow_password_reset', true, $user_data->ID);



    if ( ! $allow )  {$message = "password reset not allowed!";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);}            



    elseif ( is_wp_error($allow) ) { $message = "An error occured!";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200); }







    $key = wp_generate_password( 20, false );



    do_action( 'retrieve_password_key', $user_login, $key );







    if ( empty( $wp_hasher ) ) {



        require_once ABSPATH . 'wp-includes/class-phpass.php';



        $wp_hasher = new PasswordHash( 8, true );



    }



    

    $hashed = time() . ':' . $wp_hasher->HashPassword( $key );



    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) ); 



    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";



    $message .= network_home_url( '/' ) . "\r\n\r\n";



    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";



    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";



    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";



    $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";







    if ( is_multisite() )



        $blogname = $GLOBALS['current_site']->site_name;



    else



        $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);







    $title = sprintf( __('[%s] Password Reset'), $blogname );







    $title = apply_filters('retrieve_password_title', $title);



    $message = apply_filters('retrieve_password_message', $message, $key);







    if ( $message && !wp_mail($user_email, $title, $message) ){

 $message = "The e-mail could not be sent. Possible reason: your host may have disabled the mail() function...";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

	}

	else     
{
    $data = array(



    "msg" => 'Link for password reset has been emailed to you. Please check your email.',



		  );	;
			$response = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response, 200);

   
}


     } 
	   /*
    * RETURN THE menu
    * endpoint: /nav_menus
    */
    public function get_nav_menus( WP_REST_Request $request ) {
		/*$data = array();
		$menuTopLevel=wp_list_pages('title_li=&depth=2&echo=0&include=102'); // 102 is "Opening Times"
		$menuMidLevel=wp_list_pages('title_li=&depth=2&echo=0&exclude=2,3,102,104,123,125,127,129,131,133'); // 123 is "Contact Us"
		$menuBtmLevel=wp_list_pages('title_li=&depth=1&echo=0&include=123');
		$mailchimp_link = get_field('ftr_signup_link','option');	
		
		array_push($data, array('Buy tickets' => get_field('main_ticket_url','option')), array('Buy tickets' => get_field('main_ticket_url','option')));
		array_push($data, $menuMidLevel);
		array_push($data, array('Buy tickets' => get_field('Join our mailing list',$mailchimp_link)));*/
		
		/*$data = $menuTopLevel.'<li class="page-item-104"><a href="'.get_field('main_ticket_url','option').'" target="_blank">Buy tickets</a></li>'.$menuMidLevel.'<li class="page-item-123"><a href="'.$mailchimp_link.'" target="_blank">Join our mailing list</a></li>'.$menuBtmLevel.'</ul>';*/
		
		

        //
		//$menu = wp_get_nav_menu_items( "main-menu" );
		
		/*$menu_arr = array();
		foreach($menu as $m){
			array_push($menu_arr,$m->object_id);

		}
		*/
		$data = array();
		
        $menuTopLevel = get_pages( array( 'include' => array(102,111,109,113,462,115,123), 'sort_column' => 'menu_order', 'sort_order' => 'ASC','hierarchical' => 1, 'post_status' => 'publish', 'post_type' => 'page', ) );
		foreach($menuTopLevel as $m){
		$temp = array();
             
            $temp['menu_id'] = $m->ID;
            $temp['menu_title'] = $m->post_title;
            $temp['menu_slug'] = $m->post_name;
			if(get_post_meta($m->ID, 'app_show', true) && get_post_meta($m->ID, 'app_show', true) == 'yes'){
			$thumbnail = wp_get_attachment_image_src( get_post_meta($m->ID, 'app_icon', true), 'full' );	
			$temp['thumbnail'] = $thumbnail[0];
			}
			else{
				$temp['thumbnail'] = '';
			}
            
            array_push($data, $temp);
			//array_push($data, array('Buy tickets' => get_field('main_ticket_url','option')));
			}
			$temp_map = array();
             
            $temp_map['menu_id'] = 150;
            $temp_map['menu_title'] = 'Location';
            $temp_map['menu_slug'] = '';
			$thumbnail_map = wp_get_attachment_image_src( 651, 'full' );	
			$temp_map['thumbnail'] = $thumbnail_map[0];
            
            array_push($data, $temp_map);
			
			$temp_map_t = array();
             
            $temp_map_t['menu_id'] = 151;
            $temp_map_t['menu_title'] = 'Theme Park Map';
            $temp_map_t['menu_slug'] = '';
			$thumbnail_map_t = wp_get_attachment_image_src(652, 'full' );	
			$temp_map_t['thumbnail'] = $thumbnail_map_t[0];
            
            array_push($data, $temp_map_t);
			/*$menuMidLevel = get_pages( array( 'include' => array(32,109,111,113,462,115,117,119,121,123), 'sort_column' => 'post_date', 'sort_order' => 'desc','hierarchical' => 1, 'post_status' => 'publish', 'post_type' => 'page', ) );
		foreach($menuMidLevel as $ms){
		$temp_s = array();
             
            $temp_s['menu_id'] = $ms->ID;
            $temp_s['menu_title'] = $ms->post_title;
            $temp_s['menu_slug'] = $ms->post_name;
			if(get_post_meta($ms->ID, 'app_show', true) && get_post_meta($ms->ID, 'app_show', true) == 'yes'){
			$thumbnail = wp_get_attachment_image_src( get_post_meta($ms->ID, 'app_icon', true), 'full' );
			$temp_s['thumbnail'] = $thumbnail[0];
			}
			else{
				$temp_s['thumbnail'] = '';
			}
			$temp_s['submenu'] = array();
            $menuMidLevel_d = get_pages( array( 'parent' => $ms->ID, 'sort_column' => 'post_date', 'sort_order' => 'desc','hierarchical' => 2, 'post_status' => 'publish', 'post_type' => 'page', ) );
		if(!empty($menuMidLevel_d)){
		foreach($menuMidLevel_d as $md){
		$temp_s_1 = array();
             
            $temp_s_1['menu_id'] = $md->ID;
            $temp_s_1['menu_title'] = $md->post_title;
            $temp_s_1['menu_slug'] = $md->post_name;
			if(get_post_meta($md->ID, 'app_show', true) && get_post_meta($md->ID, 'app_show', true) == 'yes'){
				$thumbnail = wp_get_attachment_image_src( get_post_meta($md->ID, 'app_icon', true), 'full' );
			$temp_s_1['thumbnail'] = $thumbnail[0];
			}
			else{
				$temp_s_1['thumbnail'] = '';
			}

            array_push($temp_s['submenu'], $temp_s_1);
		}
		}
            array_push($data, $temp_s);
		}*/

		
		
		//print_r($menu);die();
       /* foreach($menu as $m){
		$temp = array();
             
			$slug = get_post_field( 'post_name', $m->object_id );
            $temp['menu_id'] = $m->object_id;
            $temp['menu_title'] = $m->title;
            $temp['menu_slug'] = $slug;
			$temp['thumbnail'] = get_the_post_thumbnail_url($m->object_id, 'post-thumbnail');

            array_push($data, $temp);
		}*/
	    /*foreach( $menu as $page ) {	

            $temp = array();

            $temp['menu_id'] = $page->ID;
            $temp['menu_title'] = $page->post_title;
            $temp['menu_url'] = get_permalink($page->ID);
			$temp['thumbnail'] = get_the_post_thumbnail_url($page->ID, 'post-thumbnail');

            array_push($data, $temp);
            
        }*/
			$response = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response, 200);


    }
	public function fb_connect( WP_REST_Request $request ){

	  

	    $fields = 'id,name,first_name,last_name,email';

		

		$enable_ssl = true;

	

	if (!$_REQUEST[ 'access_token']) {

		
			$message = "You must include a 'access_token' variable. Get the valid access_token for this app from Facebook API.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}else{

			

		$url='https://graph.facebook.com/me/?fields='.$fields.'&access_token='.$_REQUEST[ 'access_token'];
		
			
		
			//  Initiate curl
		
		$ch = curl_init();
		
		// Enable SSL verification
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $enable_ssl);
		
		// Will return the response, if false it print the response
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// Set the url
		
		curl_setopt($ch, CURLOPT_URL,$url);
		
		// Execute
		
		$result=curl_exec($ch);
		
		// Closing
		
		curl_close($ch);



	$result = json_decode($result, true);

	

   if(isset($result["email"])){

          

            $user_email = $result["email"];

           	$email_exists = email_exists($user_email);

			

			if($email_exists) {

				$user = get_user_by( 'email', $user_email );

			  $user_id = $user->ID;

			  $user_name = $user->user_login;

			 }

			

         

		   

		    if ( !$user_id && $email_exists == false ) {

				

			  $user_name = strtolower($result['first_name'].'.'.$result['last_name']);

               				

				while(username_exists($user_name)){		        

				$i++;

				$user_name = strtolower($result['first_name'].'.'.$result['last_name']).'.'.$i;			     

	

					}

				

			 $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );

      		   $userdata = array(

                           'user_login'    => $user_name,

						   'user_email'    => $user_email,

                           'user_pass'  => $random_password,

						   'display_name'  => $result["name"],

						   'first_name'  => $result['first_name'],

						   'last_name'  => $result['last_name']

                                     );



                   $user_id = wp_insert_user( $userdata ) ;				   

				 if($user_id) $user_account = 'user registered.';

				 

            } else {

				

				 if($user_id) $user_account = 'user logged in.';

				}

			

			 $expiration = time() + apply_filters('auth_cookie_expiration', 1209600, $user_id, true);

    	     $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');

        

		$response['msg'] = $user_account;

		$response['wp_user_id'] = $user_id;

		$response['cookie'] = $cookie;

		$response['user_login'] = $user_name;	

		

		}

		else {

			$response['msg'] = "Your 'access_token' did not return email of the user. Without 'email' user can't be logged in or registered. Get user email extended permission while joining the Facebook app.";

           

			}

	

	}	



 $response_json = array("status" => "success", "data" => $response);
			return new WP_REST_Response($response_json, 200);

	  

	  }
    public function twitter_connect( WP_REST_Request $request ){

		

		$enable_ssl = true;

	

	if (!$_REQUEST[ 'consumer_key']) {

			
			$message = "You must include a 'consumer_key' variable. Get the valid access_token for this app from Twitter API.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $ConsumerKey = sanitize_text_field( $_REQUEST['consumer_key'] );
		
		if (!$_REQUEST[ 'consumerSecret_key']) {

			$message = "You must include a 'consumerSecret_key' variable. Get the valid access_token for this app from Twitter API.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $ConsumerSecretKey = sanitize_text_field( $_REQUEST['consumerSecret_key'] );
		
		if (!$_REQUEST[ 'access_token']) {

			$message = "You must include a 'access_token' variable. Get the valid access_token for this app from Twitter API.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $access_token = sanitize_text_field( $_REQUEST['access_token'] );
		
		if (!$_REQUEST[ 'token_secret']) {

			
			$message = "You must include a 'token_secret' variable. Get the valid access_token for this app from Twitter API.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $token_secret = sanitize_text_field( $_REQUEST['token_secret'] );
		
		if (!$_REQUEST[ 'oauth_verifier']) {

			$message = "You must include a 'oauth_verifier' variable. Get the valid access_token for this app from Twitter API.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $oauth_verifier = sanitize_text_field( $_REQUEST['oauth_verifier'] );

			

		############ Set twitter access token ############
$twitter = new TwitterOAuth($ConsumerKey, $ConsumerSecretKey, $access_token , $token_secret);
$access_token = $twitter->getAccessToken($oauth_verifier);

if($twitter->http_code == '200'){
		
		############ Get userdata from twitter api ############
		$params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');
		$userInfo = $twitter->get('account/verify_credentials', $params);

		$name = explode(" ",$userInfo->name);
		$fname = $name[0] ?? '';
		$lname = $name[1] ?? '';

		$oauthpro = "twitter";
		$oauthid = $userInfo->id  ?? '';
		$f_name = $fname;
		$l_name = $lname;
		$gender = '';
		$email_id = $userInfo->email;
		$locale = $userInfo->lang  ?? '';
		$cover = $userInfo->profile_banner_url  ?? '';
		$picture =str_replace("_normal","",$userInfo->profile_image_url  ?? '');
		$url = 'https://twitter.com/'.$userInfo->screen_name;


		
		 if(isset($email_id)){

          

            $user_email = $email_id;

           	$email_exists = email_exists($user_email);

			

			if($email_exists) {

				$user = get_user_by( 'email', $user_email );

			  $user_id = $user->ID;

			  $user_name = $user->user_login;

			 }

			

         

		   

		    if ( !$user_id && $email_exists == false ) {

				

			  $user_name = strtolower($f_name.'.'.$l_name);

               				

				while(username_exists($user_name)){		        

				$i++;

				$user_name = strtolower($f_name.'.'.$l_name).'.'.$i;			     

	

					}

				

			 $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );

      		   $userdata = array(

                           'user_login'    => $user_name,

						   'user_email'    => $user_email,

                           'user_pass'  => $random_password,

						   'display_name'  => $f_name,

						   'first_name'  => $f_name,

						   'last_name'  => $l_name

                                     );



                   $user_id = wp_insert_user( $userdata ) ;				   

				 if($user_id) $user_account = 'user registered.';

				 

            } else {

				

				 if($user_id) $user_account = 'user logged in.';

				}

			

			 $expiration = time() + apply_filters('auth_cookie_expiration', 1209600, $user_id, true);

    	     $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');

        

		$response['msg'] = $user_account;

		$response['wp_user_id'] = $user_id;

		$response['cookie'] = $cookie;

		$response['user_login'] = $user_name;	

		

		}

		else {

			$response['msg'] = "Your 'access_token' did not return email of the user. Without 'email' user can't be logged in or registered. Get user email extended permission while joining the Twitter app.";



			}
	}
	else{
		$response['msg'] = "Your 'access_token' did not return email of the user. Without 'email' user can't be logged in or registered. Get user email extended permission while joining the Twitter app.";
	}




 $response_json = array("status" => "success", "data" => $response);
			return new WP_REST_Response($response_json, 200);

	  

	  }
	public function google_connect( WP_REST_Request $request ){

		

		$enable_ssl = true;

	

	if (!$_REQUEST[ 'client_id']) {

			$message = "You must include a 'access_token' variable. Get the valid access_token for this app from Twitter API.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}else{

			

		$url = 'https://www.googleapis.com/oauth2/v4/token?client_id=' . $_REQUEST[ 'client_id'] . '&redirect_uri=' . $_REQUEST[ 'redirect_uri'] . '&client_secret=' . $_REQUEST[ 'client_secret'] . '&code='. $_REQUEST[ 'code'] . '&grant_type=authorization_code';
		//  Initiate curl
		
		$ch = curl_init();
		
		// Enable SSL verification
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $enable_ssl);
		
		// Will return the response, if false it print the response
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// Set the url
		
		curl_setopt($ch, CURLOPT_URL,$url);
		
		// Execute
		
		$data=curl_exec($ch);
		
	
	
	curl_close($ch);



	$data = json_decode($data, true);
	
	$access_token = $data['access_token'];

	$url = 'https://www.googleapis.com/oauth2/v2/userinfo?fields=name,email,gender,id,picture,verified_email';	
	
	$ch = curl_init();
		
		// Enable SSL verification
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $enable_ssl);
		
		// Will return the response, if false it print the response
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		// Set the url
		
		curl_setopt($ch, CURLOPT_URL,$url);
		
		// Execute
		
		$result=curl_exec($ch);
	
		
	// Closing
		
		curl_close($ch);



	$result = json_decode($result, true);

   if(isset($result["email"])){

          

            $user_email = $result["email"];

           	$email_exists = email_exists($user_email);

			

			if($email_exists) {

				$user = get_user_by( 'email', $user_email );

			  $user_id = $user->ID;

			  $user_name = $user->user_login;

			 }

			

         

		   

		    if ( !$user_id && $email_exists == false ) {

				

			  $user_name = strtolower($result['name']);

               				

				while(username_exists($user_name)){		        

				$i++;

				$user_name = strtolower($result['name']).'.'.$i;			     

	

					}

				

			 $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );

      		   $userdata = array(

                           'user_login'    => $user_name,

						   'user_email'    => $user_email,

                           'user_pass'  => $random_password,

						   'display_name'  => $result["name"],

						   'first_name'  => $result['name'],

                                     );



                   $user_id = wp_insert_user( $userdata ) ;				   

				 if($user_id) $user_account = 'user registered.';

				 

            } else {

				

				 if($user_id) $user_account = 'user logged in.';

				}

			

			 $expiration = time() + apply_filters('auth_cookie_expiration', 1209600, $user_id, true);

    	     $cookie = wp_generate_auth_cookie($user_id, $expiration, 'logged_in');

        

		$response['msg'] = $user_account;

		$response['wp_user_id'] = $user_id;

		$response['cookie'] = $cookie;

		$response['user_login'] = $user_name;	

		

		}

		else {

			$response['msg'] = "Your 'access_token' did not return email of the user. Without 'email' user can't be logged in or registered. Get user email extended permission while joining the Google app.";



			}

	

	}	



 $response_json = array("status" => "success", "data" => $response);
			return new WP_REST_Response($response_json, 200);

	  

	  }
	    /*
    * RETURN THE menu
    * endpoint: /nav_menus
    */
    public function get_page_contents( WP_REST_Request $request ) {

        //
		if (!$_REQUEST[ 'page_id']) {

			$message = "You must include a 'post id' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $page_id = intval( $_REQUEST['page_id'] );
        $data = array();
			$post   = get_post( $page_id );
			if (is_null($post)) {
	
				$message = "There is no data found.";
				$response = array("status" => "failure", "message" => $message);
				return new WP_REST_Response($response, 200);
	
			}
			
			 //$page_contents = get_the_content();
			 $page_contents =  apply_filters( 'the_content', $post->post_content );

            $temp = array();
            $temp['id'] = $post->ID;
			$temp['title'] = $post->post_title;
            $temp['contents'] = html_entity_decode($page_contents);
			$temp['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
			array_push($data, $temp);

			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
			
		
          

    }
	public function get_rides_content( WP_REST_Request $request ) {
        
			$data = array();
			$data_child = array();
			$data_categories = array();
            $temp = array();
			$term_list = get_terms( array(
				'taxonomy' => 'tax_ride_type',
				'hide_empty' => false,
			) ); 
			if($term_list){
				foreach($term_list as $t){
					$temp = array();
					
					$temp['id'] = $t->term_id;
					$temp['title'] = $t->name;
					$temp['slug'] = $t->slug;
					$temp['content'] = $t->description;
					$temp['posts'] = array();
					//$temp['thumbnail'] = get_the_post_thumbnail_url(get_The_ID(), 'post-thumbnail');
		            
					
			$args = array( 'post_type' => 'rdsn_ride','post_status' => 'publish','orderby' => 'menu_order',
    'order' => 'ASC', 'posts_per_page' => -1,'tax_query' => array(
            array(
                'taxonomy' => 'tax_ride_type',
                'field' => 'term_id',
                'terms' => $t->term_id,
            )
        ) );
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) { $the_query->the_post(); 
					
				
				 //$page_contents = get_the_content();
				 $page_contents =  apply_filters( 'the_content', get_the_content() );
			 
			        $tempt = array();
					$tempt['id'] = get_the_ID();
					$tempt['title'] = get_the_title();
					$tempt['content'] = $page_contents;
					$tempt['url'] = get_permalink(get_the_ID());
					$tempt['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail');
					$tempt['ride_height'] = array();
					
		           
					$terms = get_the_terms( get_the_ID(), 'tax_ride_height' );
                         
					if ( $terms && ! is_wp_error( $terms ) ) { 
					 
					 
						foreach ( $terms as $term ) {
							$tempt_p = array();
							$tempt_p['id'] = $term->term_id;
							$tempt_p['title'] = $term->name;
							$tempt_p['slug'] = $term->slug;
							$tempt_p['count'] = $term->count;
							array_push($tempt['ride_height'], $tempt_p);
						}
				   } 
				   else {
						array_push($temp['posts']['ride_height'], array());
						
					}
					array_push($temp['posts'], $tempt);
				
			}
			}
			else {
				array_push($temp['posts'], array());
				
			}
			array_push($data, $temp);
			
				}
				
			//array_push($data, $data_subpages);
		    
			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
				
			}
			else {
				$message = "There is no data found.";
						$response = array("status" => "failure", "message" => $message);
						return new WP_REST_Response($response, 200);
			}
			
		
          

    }
	    /*
    * RETURN Contact page content
    * endpoint: /get_in_touch
    */
    public function get_in_touch_content( WP_REST_Request $request ) {

		$page_id = 123;
        $data = array();
		$page_contents = '';
		$form_html = '';
		$dept = '';
		$dept_html = '';
			$post   = get_post( $page_id );
			if (is_null($post)) {
	
				$message = "There is no data found.";
				$response = array("status" => "failure", "message" => $message);
				return new WP_REST_Response($response, 200);
	
			}
			$page_contents =  strip_shortcodes( $post->post_content );
			$page_contents =  apply_filters( 'the_content', $page_contents );
			
	
			// find all iframes generated by php or that are in html    
			preg_match_all('/<iframe[^>]+src="([^"]+)"/', $page_contents, $match);
			//$page_contents = get_the_content($post->ID);
		   $page_contents =  preg_replace('/<iframe.*?\/iframe>/i','', $page_contents);
			//print_r($match[0]);die();
			if(have_rows('rpt_contact', 'option')):
			$dept_html .= '<select id="department-menu" class="rdsn-select" name="department"><option value="">Select Department</option>';
				//
				while (have_rows('rpt_contact', 'option')) : the_row();
				$dept = get_sub_field('rpt_ct_department');
				$dept_html .= '<option value="'.$dept.'">'.$dept.'</option>';		
			endwhile;
			$dept_html .= '</select>';			
			endif;
			$form_html .='<form action="/no-js.php" method="post" name="contact_form" id="contact-form" class="rdsn-form">
        <div class="group">
            <div class="row">'.$dept_html.'</div>
            <div class="row"><label>Name*</label><input class="input" name="name" type="text" placeholder="NAME*" /></div>
            <div class="row"><label>Email*</label><input class="input" name="email" type="email" placeholder="EMAIL*" /></div>
            <div class="row"><label>Phone*</label><input class="input" name="phone" type="text" placeholder="PHONE" /></div>
            <div class="row"><label>Message</label><textarea class="input" name="message" rows="5" placeholder="MESSAGE" ></textarea></div>
            <div class="row"><input class="btn-solid btn-form trans-0-3" type="submit" value="Send Message" onClick="return contactApprove()"/></div>
            <input type="hidden" id="department-row" name="department_row" />
        </div>
    </form>';
			$data = array();
				$temp = array();
				$temp['post_title'] = $post->post_title;
				$temp['post_id'] = $post->ID;
				$temp['post_contents'] = $page_contents;
				$temp['form_html'] = $form_html;
				$temp['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
				$temp['video'] = array();
	
			   
				if(!empty($match[1])){
					foreach($match[1] as $video){
					array_push($temp['video'], $video);
					}
				}
			   array_push($data, $temp);

			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
			
		
          

    }
	public function get_events_content( WP_REST_Request $request ) {
        
			$data = array();
			$args = array( 'post_type' => 'rdsn_event','orderby' => 'menu_order',
    'order' => 'ASC', 'posts_per_page' => -1);
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) { $the_query->the_post(); 
					
				
				// $page_contents = get_the_content();
				 $page_contents =  apply_filters( 'the_content', get_the_content() );
			 
			        $temp = array();
					$temp['id'] = get_the_ID();
					$temp['title'] = get_the_title();
					$temp['content'] = html_entity_decode($page_contents);
					$temp['url'] = get_permalink(get_the_ID());
					$temp['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail');
					array_push($data, $temp);
					
		           
					//$terms = get_the_terms( get_the_ID(), 'tax_ride_height' );
                     
				
			}
			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
			}
			else {
				$message = "There is no data found.";
						$response = array("status" => "failure", "message" => $message);
						return new WP_REST_Response($response, 200);
				
			}
			
		
          

    }
	public function get_offers_content( WP_REST_Request $request ) {
        
			$data = array();
			$args = array( 'post_type' => 'rdsn_offer','post_status' => 'publish','orderby' => 'menu_order',
    'order' => 'ASC', 'posts_per_page' => -1 );
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) { $the_query->the_post(); 
					
				
				 //$page_contents = get_the_content();
				 $page_contents =  apply_filters( 'the_content', get_the_content() );
			 
			        $temp = array();
					$temp['id'] = get_the_ID();
					$temp['title'] = get_the_title();
					$temp['content'] = $page_contents;
					$temp['url'] = get_permalink(get_the_ID());
					$temp['thumbnail'] = get_the_post_thumbnail_url(get_the_ID(), 'post-thumbnail');
					array_push($data, $temp);
			}
			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
			}
			else {
				$message = "There is no data found.";
						$response = array("status" => "failure", "message" => $message);
						return new WP_REST_Response($response, 200);
				
			}
			
		
          

    }
	public function get_attractions_content( WP_REST_Request $request ) {
        
			$data = array();
			$data_child = array();
			$data_categories = array();
            
			
                 
			$argsp = array(
				'post_type'      => 'page',
				'posts_per_page' => -1,
				'post__in'    => array(111),
				'order'          => 'ASC',
			 );
			
			
			$the_query = get_posts( $argsp );
					if ( $the_query ) {
				   foreach ( $the_query as $t ) { 
				   $page_contents_t = get_the_content($t->ID);
							$temp = array();
							$temp['id'] = $t->ID;
							$temp['title'] = $t->post_title;
							$temp['slug'] = $t->post_name;
							$temp['content'] = $page_contents_t;
							$temp['url'] = get_permalink($t->ID);
							$temp['thumbnail'] = get_the_post_thumbnail_url($t->ID, 'post-thumbnail');
							$temp['sub_pages'] = array();
							
		            
			$child_pages = query_posts('orderby=menu_order&order=asc&post_type=page&post_parent='.$t->ID);		
			//$args_p = array( 'post_type' => 'page','post_status' => 'publish','orderby' => 'menu_order',
    //'order' => 'ASC', 'posts_per_page' => -1,'parent' => $t->ID );
			//$pageChild = get_posts( $child_pages );
					if ( $child_pages ) {
				   foreach ( $child_pages as $pageChild ) { 
				    setup_postdata( $pageChild );
				   $page_contents = get_the_content($pageChild->ID);
			 
			        $tempt = array();
					$tempt['id'] = $pageChild->ID;
							$tempt['title'] = $pageChild->post_title;
							$tempt['slug'] = $pageChild->post_name;
							$tempt['content'] = $page_contents;
							$tempt['url'] = get_permalink($pageChild->ID);
							$tempt['thumbnail'] = get_the_post_thumbnail_url($pageChild->ID, 'post-thumbnail');
							$tempt['sub_sub_pages'] = array();
							
					
		           
					$child_pages_c = query_posts('orderby=menu_order&order=asc&post_type=page&post_parent='.$pageChild->ID);
					//$parent_c = get_posts( $args_c );
					if ( $child_pages_c ) {
				   foreach ( $child_pages_c as $pageChild_c ) { 
				   $page_contents_c = get_the_content($pageChild_c->ID);
							$tempt_p = array();
							$tempt_p['id'] = $pageChild_c->ID;
							$tempt_p['title'] = $pageChild_c->post_title;
							$tempt_p['slug'] = $pageChild_c->post_name;
							$tempt_p['content'] = $page_contents_c;
							$tempt_p['url'] = get_permalink($pageChild_c->ID);
							$tempt_p['thumbnail'] = get_the_post_thumbnail_url($pageChild_c->ID, 'post-thumbnail');
							
		            
							array_push($tempt['sub_sub_pages'], $tempt_p);
						}
				   } 
				   else {
						array_push($tempt['sub_sub_pages'], array());
						
					}
					
					array_push($temp['sub_pages'], $tempt);
				
			}
			}
			else {
				
				array_push($temp['sub_pages'], array());
				
			}
			
			array_push($data, $temp);
			
				}
				
			//array_push($data, $data_subpages);
		    
			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
				wp_reset_postdata();
			}
			else {
				$message = "There is no data found.";
						$response = array("status" => "failure", "message" => $message);
						return new WP_REST_Response($response, 200);
			}
			
		
          

    }
	  public function get_post_contents( WP_REST_Request $request ) {

        //
		if (!$_REQUEST[ 'post_id']) {

			$message = "You must include a 'post id' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $post_id = intval( $_REQUEST['post_id'] );
		
		$post   = get_post( $post_id );
		if (is_null($post)) {

			$message = "There is no data found.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
        $page_contents =  apply_filters( 'the_content', $post->post_content );
		

		// find all iframes generated by php or that are in html    
		preg_match_all('/<iframe[^>]+src="([^"]+)"/', $page_contents, $match);
		//$page_contents = get_the_content($post->ID);
       $page_contents =  preg_replace('/<iframe.*?\/iframe>/i','', $page_contents);
        //print_r($match[0]);die();
		
		$data = array();
            $temp = array();
			$temp['post_title'] = $post->post_title;
            $temp['post_id'] = $post->ID;
            $temp['post_contents'] = html_entity_decode($page_contents);
			$temp['url'] = get_permalink($post->ID);
			$temp['thumbnail'] = get_the_post_thumbnail_url($post->ID, 'post-thumbnail');
			$temp['video'] = array();

           
			if(!empty($match[1])){
				foreach($match[1] as $video){
				array_push($temp['video'], $video);
				}
			}
           array_push($data, $temp);
          $response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);

    }
	public function get_banner( WP_REST_Request $request ) {
		$page_id = '';
	if (!$_REQUEST[ 'page_id']) {

			$message = "You must include a 'page id' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $page_id = intval( $_REQUEST['page_id'] );
	
	$data = array();
	
	$temp_img = '';
	$img_arr = array();
	if(have_rows('banner',$page_id)){
		while(have_rows('banner',$page_id)):the_row();
			$temp = array();
			$temp['image'] = wp_get_attachment_image_src(get_sub_field('banner_image'), 'banner-image')[0];		
			$temp['v_align'] = get_sub_field('banner_alignment');
			$temp['title'] = get_sub_field('banner_title');
			$temp['show_title'] = get_sub_field('banner_show_title');
			$temp['overlay'] = get_sub_field('banner_overlay');
			array_push( $data , $temp);
		endwhile;	
	}
	else{
		$temp['image'] = get_template_directory_uri().'/assets/img/default-banner.jpg';
		$temp['v_align'] = '';
		$temp['title'] = '';
		$temp['show_title'] = false;
		$temp['overlay'] = '';
		array_push( $data , $temp);
	}
		/*$banner_vid_poster_frame = wp_get_attachment_image_src(get_sub_field('banner_vid_poster_frame_x'), 'full');
		if ($banner_vid_poster_frame) { $temp['banner_vid_poster'] = $banner_vid_poster_frame[0]; } else { $temp['banner_vid_poster'] = get_template_directory_uri().'/assets/img/default-banner.jpg'; }*/
		$response_json = array("status" => "success", "data" => $data);
	    return new WP_REST_Response($response_json, 200);return;
	
	
	
	
}

public function get_food_drinks( WP_REST_Request $request ) {

		$data = array();

			$menuMidLevel = get_pages( array( 'include' => array(115), 'sort_column' => 'post_date', 'sort_order' => 'desc','hierarchical' => 1, 'post_status' => 'publish', 'post_type' => 'page', ) );
		foreach($menuMidLevel as $ms){
			$page_contents =  apply_filters( 'the_content', $ms->post_content );
			
	
			// find all iframes generated by php or that are in html    
			preg_match_all('/<iframe[^>]+src="([^"]+)"/', $page_contents, $match);
			//$page_contents = get_the_content($post->ID);
            $page_contents =  preg_replace('/<iframe.*?\/iframe>/i','', $page_contents);
		    $temp_s = array();
             
            $temp_s['id'] = $ms->ID;
            $temp_s['title'] = $ms->post_title;
            $temp_s['slug'] = $ms->post_name;
			$temp_s['content'] = $page_contents;
			$temp_s['url'] = get_permalink($ms->ID);
			$temp_s['thumbnail'] = get_the_post_thumbnail_url($ms->ID, 'post-thumbnail');
			$temp_s['subpages'] = array();
            $menuMidLevel_d = get_pages( array( 'parent' => $ms->ID, 'sort_column' => 'post_date', 'sort_order' => 'desc','hierarchical' => 2, 'post_status' => 'publish', 'post_type' => 'page', ) );
		if(!empty($menuMidLevel_d)){
		foreach($menuMidLevel_d as $md){
			$page_contents_s =  apply_filters( 'the_content', $md->post_content );
			
	
			// find all iframes generated by php or that are in html    
			preg_match_all('/<iframe[^>]+src="([^"]+)"/', $page_contents_s, $match);
			//$page_contents = get_the_content($post->ID);
            $page_contents_s =  preg_replace('/<iframe.*?\/iframe>/i','', $page_contents_s);
		    $temp_s_1 = array();
             
            $temp_s_1['id'] = $md->ID;
            $temp_s_1['title'] = $md->post_title;
            $temp_s_1['slug'] = $md->post_name;
			$temp_s_1['content'] = $page_contents_s;
			$temp_s_1['url'] = get_permalink($md->ID);
			$temp_s_1['thumbnail'] = get_the_post_thumbnail_url($md->ID, 'post-thumbnail');
			$temp_s_1['video'] = array();

           
			if(!empty($match[1])){
				foreach($match[1] as $video){
				array_push($temp_s_1['video'], $video);
				}
			}

            array_push($temp_s['subpages'], $temp_s_1);
		}
		}
            array_push($data, $temp_s);
		}

			$response = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response, 200);


    }
public function get_opening_times( WP_REST_Request $request ) {
	$data = array();
	if (!$_REQUEST[ 'dayValue']) {

			$message = "You must include a 'dayValue' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $dayValue = intval( $_REQUEST['dayValue'] );
		if (!$_REQUEST[ 'monthValue']) {

			$message = "You must include a 'monthValue' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $monthValue = intval( $_REQUEST['monthValue'] );
		if (!$_REQUEST[ 'dateValue']) {

			$message = "You must include a 'dateValue' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $dateValue = intval( $_REQUEST['dateValue'] );
		$this_day = $_REQUEST['dayValue'];
		$this_month = $_REQUEST['monthValue'];
		$date_unformatted = $_REQUEST['dateValue'];
		$date_formatted = date('l, jS F',strtotime($date_unformatted));	
		$date_short = date('jS F',strtotime($date_unformatted));
		$content_html = '';
		switch ($this_month) {  // associate month number with custom post type month
			case 1: $post_month = 458;  break;
			case 2: $post_month = 457;  break;
			case 3: $post_month = 456;  break;
			case 4: $post_month = 455;  break;
			case 5: $post_month = 452;  break;
			case 6: $post_month = 453;  break;
			case 7: $post_month = 452;  break;
			case 8: $post_month = 451;  break;
			case 9: $post_month = 450;  break;
			case 10: $post_month = 449;  break;
			case 11: $post_month = 448;  break;
			case 12: $post_month = 443;  break;
		}
		//
		$rep_rows = get_field('rpt_ot_date',$post_month);
		$day_row = $rep_rows[$this_day - 1];
		$park_ot_val = $day_row['rpt_ot_times']['value'];
		$park_ot_label = $day_row['rpt_ot_times']['label'];
		$day_content = $day_row['rpt_ot_notes'];
		$day_events = $day_row['rpt_ot_events'];
		$ticket_link =get_field('main_ticket_url','option');	

		//OK

		//
		if ($park_ot_val != 0) {
			$content_html .='Our theme park is open on '.$date_short.', <br />from '.$park_ot_label.'.</div>';
		} else {
			$content_html .='Our theme park is closed today but the following attractions and events are open.';	
		}
		 $temp = array();
		 
             
			$temp['contents'] = strip_tags($content_html);
			$temp['ticket_link'] = '';
			$temp['day_content'] = '';
			$temp['events'] = array();
			$temp['attractions'] = array();
			$temp['food_drinks'] = array();
		//if ($park_ot_val != 0) {
		if ($ticket_link) { $temp['ticket_link'] = $ticket_link; }
		
		//
		if ($day_content) { $temp['day_content'] = $day_content;}		
		//
		if ($day_events) {
		$content_html .='<h3 class="events-title">Special Events</h3>';
		$content_html .='<div id="e-grid" class="events-modal grid-wrapper">';
		foreach($day_events as $post) : setup_postdata($post);
		$temp_e = array();
			$temp_e['title'] = html_entity_decode(get_the_title($page->ID));
			$temp_e['link'] = get_the_permalink($post->ID);
			$image_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'large');
			if ($image_src) { $temp_e['image'] = $image_src[0]; } else { $temp_e['image'] = get_bloginfo('stylesheet_directory').'/assets/img/default-square-02.jpg'; }
			$temp_e['placeholder'] = get_bloginfo('stylesheet_directory').'/assets/img/placeholder-square-trans.png';
			$temp_e['show_title'] = get_field('rdsn_list_show_title',$post->ID);
			$temp_e['show_overlay'] = get_field('rdsn_list_show_overlay',$post->ID);



			$temp_e['days'] = array();
			if(!empty(get_field('ot_monday',$page->ID))){
				array_push($temp_e['days'], get_field('ot_monday',$page->ID));

			}

			
			if(!empty(get_field('ot_tuesday',$page->ID))){
				array_push($temp_e['days'], get_field('ot_tuesday',$page->ID));
			}
			if(!empty(get_field('ot_wednesday',$page->ID))){
				array_push($temp_e['days'], get_field('ot_wednesday',$page->ID));
			}
			if(!empty(get_field('ot_thursday',$page->ID))){
				array_push($temp_e['days'], get_field('ot_thursday',$page->ID));
			}
			if(!empty(get_field('ot_friday',$page->ID))){
				array_push($temp_e['days'], get_field('ot_friday',$page->ID));
			}
			if(!empty(get_field('ot_saturday',$page->ID))){
				array_push($temp_e['days'], get_field('ot_saturday',$page->ID));
			}
			if(!empty(get_field('ot_sunday',$page->ID))){
				array_push($temp_e['days'], get_field('ot_sunday',$page->ID));
			}
			if(!empty(get_field('ot_notes',$page->ID))){
				array_push($temp_e['days'], get_field('ot_notes',$page->ID));
			}
			array_push($temp['events'], $temp_e);
			endforeach;
		wp_reset_postdata();
		
		}
	$childPages = get_pages( array( 'parent' => 111, 'sort_column' => 'menu_order'));
		
if ($childPages):
$content_html .= '<div class="list-wrapper">';
$content_html .= '<h2>Attractions</h2>';
	foreach($childPages as $page) : setup_postdata($page);
$temp_a = array();
		if($page->ID == 147 && $park_ot_val == 0 ){
        //

	      }
	      else
	      {


		
	    
		$temp_a['title'] = html_entity_decode(get_the_title($page->ID));
		$temp_a['link'] = get_the_permalink($page->ID);
		$temp_a['days'] = array();
		if(!empty(get_field('ot_monday',$page->ID))){
			array_push($temp_a['days'], get_field('ot_monday',$page->ID));
		}
		if(!empty(get_field('ot_tuesday',$page->ID))){
			array_push($temp_a['days'], get_field('ot_tuesday',$page->ID));
		}
		if(!empty(get_field('ot_wednesday',$page->ID))){
			array_push($temp_a['days'], get_field('ot_wednesday',$page->ID));
		}
		if(!empty(get_field('ot_thursday',$page->ID))){
			array_push($temp_a['days'], get_field('ot_thursday',$page->ID));
		}
		if(!empty(get_field('ot_friday',$page->ID))){
			array_push($temp_a['days'], get_field('ot_friday',$page->ID));
		}
		if(!empty(get_field('ot_saturday',$page->ID))){
			array_push($temp_a['days'], get_field('ot_saturday',$page->ID));
		}
		if(!empty(get_field('ot_sunday',$page->ID))){
			array_push($temp_a['days'], get_field('ot_sunday',$page->ID));
		}
		if(!empty(get_field('ot_notes',$page->ID))){
			array_push($temp_a['days'], get_field('ot_notes',$page->ID));
		}
		array_push($temp['attractions'], $temp_a);
	}

	endforeach;
	wp_reset_postdata();

endif;
$childPages = get_pages(array( 'parent' => 115, 'sort_column' => 'menu_order' ) );

if ($childPages):
$content_html .= '<div class="list-wrapper">';
$content_html .= '<h2>Food &amp; Drink</h2>';
	foreach($childPages as $page) : setup_postdata($page);

	$temp_f = array();
		$temp_f['title'] = html_entity_decode(get_the_title($page->ID));
		$temp_f['link']  = get_the_permalink($page->ID);
		$temp_f['days']  = array();
		if(!empty(get_field('ot_monday',$page->ID))){
			array_push($temp_f['days'], get_field('ot_monday',$page->ID));
		}
		
		if(!empty(get_field('ot_tuesday',$page->ID))){
			array_push($temp_f['days'], get_field('ot_tuesday',$page->ID));
		}
		if(!empty(get_field('ot_wednesday',$page->ID))){
			array_push($temp_f['days'], get_field('ot_wednesday',$page->ID));
		}
		if(!empty(get_field('ot_thursday',$page->ID))){
			array_push($temp_f['days'], get_field('ot_thursday',$page->ID));
		}
		if(!empty(get_field('ot_friday',$page->ID))){
			array_push($temp_f['days'], get_field('ot_friday',$page->ID));
		}
		if(!empty(get_field('ot_saturday',$page->ID))){
			array_push($temp_f['days'], get_field('ot_saturday',$page->ID));
		}
		if(!empty(get_field('ot_sunday',$page->ID))){
			array_push($temp_f['days'], get_field('ot_sunday',$page->ID));
		}
		if(!empty(get_field('ot_notes',$page->ID))){
			array_push($temp_f['days'], get_field('ot_notes',$page->ID));
		}
		
	
		array_push($temp['food_drinks'], $temp_f);
	endforeach;
	wp_reset_postdata();

endif;
		//$content_html .= rdsn_attractions_ot();
		//$content_html .= rdsn_food_drink_ot();
		//}

		
            array_push($data, $temp);
	$response_json = array("status" => "success", "data" => $data);
	return new WP_REST_Response($response_json, 200);
}
public function post_submit_data( WP_REST_Request $request ) {	// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function


// Remove $_COOKIE elements from $_REQUEST.
if(count($_COOKIE)){foreach(array_keys($_COOKIE) as $value){unset($_REQUEST[$value]);}}
// Check referrer is from same site.
if(!(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']) && stristr($_SERVER['HTTP_REFERER'],$_SERVER['HTTP_HOST']))){$errors[] = "You must enable referrer logging to use the form";}
        if (!isset($_REQUEST[ 'department'])) {

			$message = "You must include a 'department' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $department = sanitize_text_field( $_REQUEST['department'] );
		if (!$_REQUEST[ 'name']) {

			$message = "You must include a 'name' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $name = sanitize_text_field( $_REQUEST['name'] );
		
		
		if (!$_REQUEST[ 'email']) {

			$message = "You must include a 'email' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $email = sanitize_email( $_REQUEST['email'] );
		if (!$_REQUEST[ 'phone']) {

			$message = "You must include a 'phone' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $phone = sanitize_email( $_REQUEST['phone'] );
		$data = array();
		$parameters = $request->get_params();
			//user posted variables
		
		$html_message = '
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Contact</title>
		<style>
		body,div,dl,dt,dd,ul,ol,li,h1,h2,h3,h4,h5,h6,pre,form,fieldset,input,button,textarea,p,blockquote {margin:0;padding:0;}
		table {border-collapse:collapse;border-spacing:0;}
		fieldset,img {border:0;}
		address,caption,cite,code,dfn,th,var {font-style:normal;font-weight:normal;}
		caption,th{text-align:left;}
		h1,h2,h3,h4,h5,h6 {font-size:100%;font-weight:normal;}
		q:before,q:after {content:"";}
		abbr,acronym {border:0;}
		form {margin-top:0;margin-bottom:0;}
		object {outline:none;}
		html {overflow-y:scroll;}
		img {max-width:100%;height:auto;}
		@media \0screen {img { width:auto;}}
		a {outline-style:none;}
		textarea {resize:vertical;}
		textarea, input {outline:none;}
		.clearboth {clear:both;height:0;font-size:1px;line-height:0px;}
		body {font-family:Arial,Helvetica,sans-serif;font-size:12px;font-weight:normal;line-height:normal;margin:0;padding:25px;color:#000000;background:#FFFFFF;overflow-x:hidden;}
		table {max-width:600px;border-left:1px solid #000000;border-top:1px solid #000000;}
		td {padding:10px 20px;border-bottom:1px solid #000000;border-right:1px solid #000000;}
		td.lft {width:150px;font-weight:bold;}
		</style>
		</head>
		<body>
		<h2 style="font-size:18px;font-weight:bold;margin:0;padding:10px 0 20px 0;">Department: '.$department.'</h2>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="section">
		  <tr>
			<td valign="top" class="lft">Name</td>
			<td valign="top" class="rgt">'.$name.'</td>
		  </tr>
		  <tr>
			<td valign="top" class="lft">Email</td>
			<td valign="top" class="rgt"><a href="mailto:'.$email.'">'.$email.'</a></td>	
		  </tr>
		  <tr>
			<td valign="top" class="lft">Phone</td>
			<td valign="top" class="rgt">'.$phone.'</td>
		  </tr>
		  <tr>
			<td valign="top" class="lft">Message</td>
			<td valign="top" class="rgt">'.$message.'</td>
		  </tr>
		</table>
		<p style="margin:0;padding:20px 0;font-size:11px;">Please do not reply to this message, it is from an unmonitored mailbox.<br />Click the email address in the body of the message to reply to the sender.</p>
		</body>
		</html>
		';
		
		//echo $html_message;
		
		// ********************************************** MAIL SETTINGS
		$subject = "Contact from the M&D's web site - ".$department; //Enter e-mail subject
		$recipient = $email;
		
		$mail = new PHPMailer;                              	// Passing `true` enables exceptions
		//Server settings - TEST
		$mail->SMTPDebug = 0;                                 	// Enable verbose debug output
		$mail->isSMTP();                                      	// Set mailer to use SMTP
		$mail->Host = 'mail.design-files.co.uk';  				// Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               	// Enable SMTP authentication
		$mail->Username = 'mailer@design-files.co.uk';			// SMTP username
		$mail->Password = 'YCFff!w!B';                          // SMTP password
		$mail->SMTPAutoTLS = false;								// Heart was throwing a wobbler
		$mail->Port = 587;                                    	// TCP port to connect to
		
		// From
		$mail->setFrom("mailer@design-files.co.uk", "M&D's web mailer");
		$mail->addReplyTo('mailer@design-files.co.uk');
		$mail->addAddress($recipient); 
		
		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $subject;
		$mail->Body    = $html_message;
		$mail->AltBody = 'Please set your email programme to receive HTML email content.';
		
		if(!$mail->send()) {
			$message = "Email not sent.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);
		}
		else{
			$message = "Your information successfully submited.";
			$response_json = array("status" => "success", "message" => $message);
			return new WP_REST_Response($response_json, 200);
		}
}
   public function post_device_configuration( WP_REST_Request $request ) {

        //
		$data = array();
		$parameters = $request->get_params();
		if (!$parameters['device_id']) {

			$message = "You must include a 'device_id' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $device_id = sanitize_text_field( $parameters['device_id'] );
		if (!$parameters['device_token']) {

			$message = "You must include a 'device_token' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $device_token = sanitize_text_field( $parameters['device_token'] );
		if (!$parameters['os_type']) {

			$message = "You must include a 'os_type' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $os_type = sanitize_text_field( $parameters['os_type'] );

	
		global $wpdb;
	     $query_n = "SELECT * FROM " .$wpdb->prefix . "themepark_device_configuration where device_id = '".$device_id."'";
				$query_result_n = $wpdb->get_results($query_n);
				if($query_result_n){
						foreach( $query_result_n as $n ){
							$list_id_u = $wpdb->update( $wpdb->prefix . "themepark_device_configuration", 
								array( 
									'device_id' => $device_id,
									'device_token' => $device_token,
									'os_type' => $os_type,
									'date_created' => date('Y-m-d H:i:s'),
								), 
								array( 'id' => $n->id ), 
								array( 
									'%s',	// value1
									'%s',	// value1
									'%s',	// value1
									'%s',	// value1
								), 
								array( '%d' ) 
							);
							if ( is_wp_error( $list_id_u ) ) {
								$message = "Fail to process";
								$response = array("status" => "failure", "message" => $message);
								return new WP_REST_Response($response, 200);
							}
							else{
					
								
								$temp = array();
								$temp['id'] = $list_id;
								array_push($data, $temp);
								$response_json = array("status" => "success", "data" => $data);
								return new WP_REST_Response($response_json, 200);
					
							}
						}
				}
				else{
					$table_name = $wpdb->prefix.'themepark_device_configuration';
					   
					$wpdb->insert($table_name, array(
						'device_id' => $device_id,
						'device_token' => $device_token,
						'os_type' => $os_type,
						'date_created' => date('Y-m-d H:i:s'),
						
						
					));
					
					
					
					$list_id = intval($wpdb->insert_id);
					if ( is_wp_error( $list_id ) ) {
						$message = "Fail to process";
						$response = array("status" => "failure", "message" => $message);
						return new WP_REST_Response($response, 200);
					}
					else{
			
						
						$temp = array();
						$temp['id'] = $list_id;
						array_push($data, $temp);
						$response_json = array("status" => "success", "data" => $data);
						return new WP_REST_Response($response_json, 200);
			
					}
				}

    }
	
	

	public function func_push_notifications( WP_REST_Request $request ) {
		define('API_ACCESS_KEY','AAAA7eqoQws:APA91bGVuOQlHikmp7SEAf5JvAPodxzsrv5oF_EPMJJMO5GE9fl0nAL6L6JEKlGuI3KprNRs1FjcBm8pAvvKaa_7iKNrVz1mjTzQy0IJeYAAN7IiUo3uQ17nchmF4IDYuRftt7qZ_TVh');
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		
		$token='eG2dtRIrLII:APA91bH4Vv1Lhcp-PfCdi5ebuFwWvsn9J8NPHCnTDa2E3inp8WgubMM69_6Vqq1UzskCvgM-yMA5Ir06E3OQNIvVIe0igV3w1MLjs9EQjh5QdB8ljSJrU5DRQhLO277Am3xWxb1Z68po';
		
		$notification = [
			'title' =>'title',
			'body' => 'body of message.',
			'icon' =>'myIcon', 
			'sound' => 'mySound'
		];
		
		$extraNotificationData = [
			"message" => $notification, 
			"moredata" =>'dd'
		];
		
		$fcmNotification = [
			//'registration_ids' => $tokenList, //multple token array
			'to'        => $token, //single token
			'notification' => $notification,
			'data' => $extraNotificationData
		];
		
		$headers = [
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		];
		
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$fcmUrl);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
		$result = curl_exec($ch);
		curl_close($ch);
		
		print_r( $result );
	}
	public function get_departments_content( WP_REST_Request $request ) {
		
		    $data = array();

			if(have_rows('rpt_contact', 'option')):
				//
				while (have_rows('rpt_contact', 'option')) : the_row();
				array_push($data, get_sub_field('rpt_ct_department'));	
			endwhile;
			else:
			$message = "There is no data found.";
				$response = array("status" => "failure", "message" => $message);
				return new WP_REST_Response($response, 200);
			endif;
			
			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
	}
	public function get_locations_data( WP_REST_Request $request ) {
		
		    $data = array();
			$args = array( 'post_type' => 'rdsn_locations','post_status' => 'publish','orderby' => 'menu_order',
    'order' => 'ASC', 'posts_per_page' => -1 );
			$the_query = new WP_Query( $args );
			if ( $the_query->have_posts() ) {
				while ( $the_query->have_posts() ) { $the_query->the_post(); 
					
				if(!get_field('google_map', get_the_ID())){
				$message = "Location Data Missing.";
				$response = array("status" => "failure", "message" => $message);
				return new WP_REST_Response($response, 200);
			}
			//$temp = array();
			$temp['location'] = array();
			$temp['location']['lication_id'] = get_the_ID();
			$map_data = get_field('google_map', get_the_ID());
			$temp['location']['address']= $map_data['address'];
			$temp['location']['lat']= $map_data['lat'];
			$temp['location']['lng']= $map_data['lng'];
			//array_push($temp['location'], get_field('google_map', get_the_ID()));
			array_push($data, $temp['location']);

			}
			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
			}
			else {
				$message = "There is no data found.";
						$response = array("status" => "failure", "message" => $message);
						return new WP_REST_Response($response, 200);
				
			}
			
	}
	
	// **************************************************************** CUSTOM POST TYPES AND TAXONOMIES ********
	
	public function create_post_location() {
		register_post_type( 'rdsn_locations',
			array(
				'labels' => array(
					'name' => __( 'Locations' ),
					'singular_name' => __( 'Location' ),
					'add_new' => __( 'Add a Location' ),
					'add_new_item' => __( 'Add a Location' ),
					'edit_item' => __( 'Edit Location' ),
					'new_item' => __( 'New Location' ),
					'view_item' => __( 'View Location' )
				),
			'public' => true,
			'has_archive' => true,
			'menu_icon'=>'dashicons-buddicons-alt',
			'rewrite' => array( 'slug' => 'location' ),
			'supports' => array(
					'title',
					'editor',
					'thumbnail'
				),
			)
		);
	}
	 public function get_user_location_data( WP_REST_Request $request ) {

        //
		$data = array();
		$parameters = $request->get_params();
		if (!$parameters['device_id']) {

			$message = "You must include a 'device_id' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $device_id = sanitize_text_field( $parameters['device_id'] );
		if (!$parameters['location_latitude']) {

			$message = "You must include a 'location_latitude' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $location_latitude = sanitize_text_field( $parameters['location_latitude'] );
		if (!$parameters['location_longitude']) {

			$message = "You must include a 'location_longitude' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $location_longitude	 = sanitize_text_field( $parameters['location_longitude'] );

	
		global $wpdb;
	    $query_n = "SELECT * FROM " .$wpdb->prefix . "themepark_user_location_information where device_id = '".$device_id."'";
				$query_result_n = $wpdb->get_results($query_n);
				if($query_result_n){
						foreach( $query_result_n as $n ){
							$list_id_u = $wpdb->update( $wpdb->prefix . "themepark_user_location_information", 
								array( 
									'location_latitude' => $location_latitude,
									'location_longitude' => $location_longitude,
									'date_created' => date('Y-m-d H:i:s'),
								), 
								array( 'id' => $n->id ), 
								array( 
									'%s',	// value1
									'%s',	// value1
									'%s',	// value1
								), 
								array( '%d' ) 
							);
							if ( is_wp_error( $list_id_u ) ) {
								$message = "Fail to process";
								$response = array("status" => "failure", "message" => $message);
								return new WP_REST_Response($response, 200);
							}
							else{
					
								
								$temp = array();
								$temp['id'] = $list_id;
								array_push($data, $temp);
								$response_json = array("status" => "success", "data" => $data);
								return new WP_REST_Response($response_json, 200);
					
							}
						}
				}
						else{
							$table_name = $wpdb->prefix.'themepark_user_location_information';
							   
							$wpdb->insert($table_name, array(
								'device_id' => $device_id,
								'location_latitude' => $location_latitude,
								'location_longitude' => $location_longitude,
								'date_created' => date('Y-m-d H:i:s'),
								
								
							));
							
							
							
							$list_id = intval($wpdb->insert_id);
							if ( is_wp_error( $list_id ) ) {
								$message = "Fail to process";
								$response = array("status" => "failure", "message" => $message);
								return new WP_REST_Response($response, 200);
							}
							else{
					
								
								$temp = array();
								$temp['id'] = $list_id;
								array_push($data, $temp);
								$response_json = array("status" => "success", "data" => $data);
								return new WP_REST_Response($response_json, 200);
					
							}
						}

    } 
	
	// SEND LOCATION BASE NOTIFICATION
	function func_locationbase_push_notifications(WP_REST_Request $request) {
		global $wpdb;
		$data = array();
		$parameters = $request->get_params();
		if (!$parameters['device_id']) {

			$message = "You must include a 'device_id' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $device_id = sanitize_text_field( $parameters['device_id'] );
		if (!$parameters['location_id']) {

			$message = "You must include a 'location_id' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $location_id = intval( $parameters['location_id'] );
		
		if (!$parameters['last_checkin_time']) {

			$message = "You must include a 'last_checkin_time' variable.";
			$response = array("status" => "failure", "message" => $message);
			return new WP_REST_Response($response, 200);

		}
		else $last_checkin_time	 = sanitize_text_field( $parameters['last_checkin_time'] );
		define('API_ACCESS_KEY','AAAA7eqoQws:APA91bGVuOQlHikmp7SEAf5JvAPodxzsrv5oF_EPMJJMO5GE9fl0nAL6L6JEKlGuI3KprNRs1FjcBm8pAvvKaa_7iKNrVz1mjTzQy0IJeYAAN7IiUo3uQ17nchmF4IDYuRftt7qZ_TVh');
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		
		
		
		
		$token = '';
		$query_f = "SELECT * FROM " .$wpdb->prefix . "themepark_device_configuration where device_id = '".$device_id."'";
		$query_result_f = $wpdb->get_results($query_f);
		if($query_result_f){
				foreach( $query_result_f as $f ){
					$token = $f->device_token;
					
				}
		}
		else{
			echo "Device not registered"; return;
		}
		$table_name = $wpdb->prefix.'themepark_user_device_information';
		
		
				$rdsn_location = get_field('google_map', $location_id);
		      
				$query = "SELECT * FROM " .$wpdb->prefix . "themepark_push_notification where status = 'pending'  AND location_id = '".$location_id."' AND device_id = '".$device_id."'";
								$query_result = $wpdb->get_results($query);
				if($query_result){
						foreach( $query_result as $n ){
							
							
							if($last_checkin_time > strtotime($n->checkin_date_time)){
								
								$radius = distance($n->location_latitude, $n->location_longitude, $rdsn_location['lat'], $rdsn_location['lng']);                           if($radius <= 100){
									
								$n_count = 0;
								$message_n = 'Fail to process';
								
									$notification = [
										'title' => $n->title,
										'body' => $n->notification,
										'icon' =>'myIcon', 
										'sound' => 'mySound'
									];
									
									$extraNotificationData = [
										"message" => $notification, 
										"moredata" =>'dd'
									];
									
											$status = 'pending';
											$fcmNotification = [
												//'registration_ids' => $tokenList, //multple token array
												'to'        => $token, //single token
												'notification' => $notification,
												'data' => $extraNotificationData
											];
											
											$headers = [
												'Authorization: key=' . API_ACCESS_KEY,
												'Content-Type: application/json'
											];
							
											$ch = curl_init();
											curl_setopt($ch, CURLOPT_URL,$fcmUrl);
											curl_setopt($ch, CURLOPT_POST, true);
											curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
											curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
											$result = curl_exec($ch);
											curl_close($ch);
											
											$result_arr = json_decode($result);
											
											if ($result_arr->success) {  
											  $status = 'sent';
											}
									
											
											$wpdb->update( 
												$wpdb->prefix . "themepark_push_notification", 
												array( 
													'status' => $status,	// string
													'checkin_date_time' => date('Y-m-d H:i:s', $last_checkin_time),
												), 
												array( 'id' => $n->id ), 
												array( 
													'%s',	// value1
													'%s',	// value1
												), 
												array( '%s' ) 
											);
											

								
								
							}
							}
							else{
								$message = "Notification already sent";
								$response = array("status" => "success", "message" => $message);
								return new WP_REST_Response($response, 200);
								
							}
						
							
							
						
					}
					
				}
				
				
				
		
		
		}
		public function get_stylesheet_themepark() {
	
		 $css_file_path = get_template_directory() . '/assets/css/style.css';
	
			if ( file_exists( $css_file_path ) ) {
			$contents = file_get_contents( $css_file_path );
			$temp = array();
			$data = array();
			$temp['content'] = $contents;
			array_push($data, $temp);
			$response_json = array("status" => "success", "data" => $data);
			return new WP_REST_Response($response_json, 200);
			}
			else{
				$message = "No such file exist.";
			    $response = array("status" => "failure", "message" => $message);
			    return new WP_REST_Response($response, 200);
			}
		}
	
}
 
/*
 * START THE MAIN PLUGIN
 */
new ThemeParkAPIMod();
if (!function_exists('rdsn_push_notifications_page')) {
	function rdsn_push_notifications_page()
	{
	   include(dirname (__FILE__) . '/includes/rdsn_push_notifications.php');
		
	}
}
if (!function_exists('rdsn_app_devices_information')) {
	function rdsn_app_devices_information()
	{
	  include(dirname (__FILE__) . '/includes/class-devices-list.php');
		
	}
}
if (!function_exists('rdsn_app_notification_page')) {
	function rdsn_app_notification_page()
	{
	  include(dirname (__FILE__) . '/includes/class-notification-list.php');
		
	}
}
function rdsn_send_notification_admin() {
		global $wpdb;
		
		define('API_ACCESS_KEY','AAAA7eqoQws:APA91bGVuOQlHikmp7SEAf5JvAPodxzsrv5oF_EPMJJMO5GE9fl0nAL6L6JEKlGuI3KprNRs1FjcBm8pAvvKaa_7iKNrVz1mjTzQy0IJeYAAN7IiUo3uQ17nchmF4IDYuRftt7qZ_TVh');
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		
		
		
		$notification = [
			'title' => $_REQUEST['rdsn_notification_title'],
			'body' => $_REQUEST['rdsn_notification'],
			'icon' =>'myIcon', 
			'sound' => 'mySound'
		];
		
		$extraNotificationData = [
			"message" => $notification, 
			"moredata" =>'dd'
		];
		$query = "SELECT * FROM " .$wpdb->prefix . "themepark_device_configuration";
		$query_result = $wpdb->get_results($query);
		$n_count = 0;
		//$message_n = 'Fail to process';
			if($query_result){
				foreach( $query_result as $r ){
					$status = 'pending';
					$token = $r->device_token;
		$fcmNotification = [
			//'registration_ids' => $tokenList, //multple token array
			'to'        => $token, //single token
			'notification' => $notification,
			'data' => $extraNotificationData
		];
		
		$headers = [
			'Authorization: key=' . API_ACCESS_KEY,
			'Content-Type: application/json'
		];
		
		
					
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$fcmUrl);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
					$result = curl_exec($ch);
					curl_close($ch);
					
					$result_arr = json_decode($result);
					$table_name = $wpdb->prefix.'themepark_push_notification';
					if ($result_arr->success) {  
				     $status = 'sent';
					}
					else{
					  $status = 'pending';
					}
					
					$wpdb->insert($table_name, array(
						'device_id' => $r->device_id,
						'title' => $_REQUEST['rdsn_notification_title'],
						'notification' => $_REQUEST['rdsn_notification'],
						'status' => $status,
						'checkin_date_time' => date('Y-m-d H:i:s'),
						
						
					));
					
					$list_id = intval($wpdb->insert_id);
					if ( is_wp_error( $list_id ) ) {
						
					}
					else{
						
						//$message_n = "Notification sent";
					}
				
			}
		//	echo $message_n;
		}
		else{
			echo "No device registered";
		}
		
		
}
function rdsn_send_notification_location_base_admin() {
		global $wpdb;
		$devices = array();
		define('API_ACCESS_KEY','AAAA7eqoQws:APA91bGVuOQlHikmp7SEAf5JvAPodxzsrv5oF_EPMJJMO5GE9fl0nAL6L6JEKlGuI3KprNRs1FjcBm8pAvvKaa_7iKNrVz1mjTzQy0IJeYAAN7IiUo3uQ17nchmF4IDYuRftt7qZ_TVh');
		$fcmUrl = 'https://fcm.googleapis.com/fcm/send';
		
		
		
		$notification = [
			'title' => $_REQUEST['rdsn_notification_title'],
			'notification' => $_REQUEST['rdsn_notification'],
			'icon' =>'myIcon', 
			'sound' => 'mySound'
		];
		
		$extraNotificationData = [
			"message" => $notification, 
			"moredata" =>'dd'
		];
		$token = '';
		$args = array( 'post_type' => 'rdsn_locations', 'post__in' => array($_REQUEST['rdsn_location_id']), 'post_status' => 'publish', 'numberposts' => -1 );
			$the_query = new WP_Query( $args );
			if ( !$the_query->have_posts() ) {
				echo "No location data exist.";exit();
				}
	
		
		
				
					$rdsn_location = get_field('google_map', $_REQUEST['rdsn_location_id']);
	                $table_name = $wpdb->prefix.'themepark_push_notification';
						
									$token = $f->device_token;
									$query = "SELECT * FROM " .$wpdb->prefix . "themepark_user_location_information";
									$query_result = $wpdb->get_results($query);
									$n_count = 0;
									$message_n = 'Notification not sent';
									if($query_result){
										
										foreach( $query_result as $r ){
											$radius = distance($r->location_latitude, $r->location_longitude, $rdsn_location['lat'], $rdsn_location['lng']);                           if($radius <= 100){
											$status = 'pending';
											$fcmNotification = [
												//'registration_ids' => $tokenList, //multple token array
												'to'        => $token, //single token
												'notification' => $notification,
												'data' => $extraNotificationData
											];
											
											$headers = [
												'Authorization: key=' . API_ACCESS_KEY,
												'Content-Type: application/json'
											];
						
						
											
											$ch = curl_init();
											curl_setopt($ch, CURLOPT_URL,$fcmUrl);
											curl_setopt($ch, CURLOPT_POST, true);
											curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
											curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
											curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
											curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
											$result = curl_exec($ch);
											curl_close($ch);
											
											$result_arr = json_decode($result);
											
											if ($result_arr->success) {  
											  $status = 'sent';
											}
									
											$wpdb->insert($table_name, array(
												'device_id' => $r->device_id,
												'title' => $_REQUEST['rdsn_notification_title'],
												'notification' => $_REQUEST['rdsn_notification'],
												'location_id' => $_REQUEST['rdsn_location_id'],
												'location_latitude' => $r->location_latitude,
						                        'location_longitude' => $r->location_longitude,
												'status' => $status,
												'checkin_date_time' => date('Y-m-d H:i:s'),
												
												
											));
											
											$list_id = intval($wpdb->insert_id);
											if ( is_wp_error( $list_id ) ) {
												
											}
											else{
												array_push($devices, $r->device_token);
												$message_n = "Notification sent";
											}
										
									
											}
											 else{
												$status = 'pending';
												$wpdb->insert($table_name, array(
															'device_id' => $r->device_id,
															'title' => $_REQUEST['rdsn_notification_title'],
															'notification' => $_REQUEST['rdsn_notification'],
															'location_id' => $_REQUEST['rdsn_location_id'],
															'location_latitude' => $r->location_latitude,
						                                    'location_longitude' => $r->location_longitude,
															'status' => $status,
															'checkin_date_time' => date('Y-m-d H:i:s'),
															
															
														));
														$message_n = "Notification saved";
											  }
										}
								 }
								 else{
									/*$status = 'pending';
									$wpdb->insert($table_name, array(
												'device_id' => $f->device_id,
												'title' => $_REQUEST['rdsn_notification_title'],
												'notification' => $_REQUEST['rdsn_notification'],
												'location_id' => get_the_ID(),
												'status' => $status,
												'checkin_date_time' => date('Y-m-d H:i:s'),
												
												
											));*/
											$message_n = "No user locations exist";
								  }
								
				
		echo $message_n;
	
	
	}
 function distance($lat1, $lon1, $lat2, $lon2) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);
  return ($miles * 1.609344);
 
}