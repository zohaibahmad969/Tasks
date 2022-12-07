<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://zohaibahmad.com
 * @since      1.0.0
 *
 * @package    Za_Plugin
 * @subpackage Za_Plugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Za_Plugin
 * @subpackage Za_Plugin/public
 * @author     Zohaib Ahmad <za.solutions55@gmail.com>
 */
class Za_Plugin_Public
{

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_shortcode('website_data_form', array($this, 'create_shortcode_for_form'));

        add_action('wp_ajax_save_websites_post_data', array($this, 'save_websites_post_data'));
        add_action('wp_ajax_nopriv_save_websites_post_data', array($this, 'save_websites_post_data'));

    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Za_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Za_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/za-plugin-public.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Za_Plugin_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Za_Plugin_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) .  'js/za-plugin-public.js', array('jquery'), $this->version, false);

    }

    /**
     * This function is provided for creating shortcode for form.
     *
     * @since    1.0.0
     */
    public function create_shortcode_for_form()
    {

        require_once plugin_dir_path(__FILE__) . "partials/za-plugin-public-display.php";

    }

    /**
     * This function is provided for ajax saving websites data.
     *
     * @since    1.0.0
     */
    public function save_websites_post_data()
    {

        global $user_ID;
        $new_post = array(
			'post_title'   => 'Website Data',
            'post_status' => 'publish',
            'post_date' => date('Y-m-d H:i:s'),
            'post_type' => 'za_websites',
        );
        $post_id = wp_insert_post($new_post);

        add_post_meta($post_id, 'username', $_POST['username']);
        add_post_meta($post_id, 'website_url', $_POST['website_url']);
		if($post_id){
			echo true;
		}else{
			echo false;
		}

        die();
    }
}
