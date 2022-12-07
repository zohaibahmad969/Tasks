<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://zohaibahmad.com
 * @since      1.0.0
 *
 * @package    Za_Plugin
 * @subpackage Za_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Za_Plugin
 * @subpackage Za_Plugin/admin
 * @author     Zohaib Ahmad <za.solutions55@gmail.com>
 */
class Za_Plugin_Admin
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
     * @param      string    $plugin_name       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {

        $this->plugin_name = $plugin_name;
        $this->version = $version;

        add_action('init', array($this, 'create_post_websites'));

        add_action('admin_menu', array($this, 'disable_add_new_posts'));

        add_action('add_meta_boxes', array($this, 'print_meta_box_for_website_post'));

    }

    /**
     * Register the stylesheets for the admin area.
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

        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/za-plugin-admin.css', array(), $this->version, 'all');

    }

    /**
     * Register the JavaScript for the admin area.
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

        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/za-plugin-admin.js', array('jquery'), $this->version, false);

    }

    /**
     * Register the Custom post type for websites.
     *
     * @since    1.0.0
     */
    public function create_post_websites()
    {

        register_post_type('za_websites',
            array(
                'labels' => array(
                    'name' => __('Websites'),
                    'singular_name' => __('Website'),
                ),
                'public' => true,
                'has_archive' => true,
                'menu_icon' => 'dashicons-admin-site',
                'rewrite' => array('slug' => 'Website'),
                'supports' => array(
                ),
            )
        );
    }

    /**
     * Hide the Add New button.
     *
     * @since    1.0.0
     */
    public function disable_add_new_posts()
    {
        // Hide sidebar link
        global $submenu;
        unset($submenu['edit.php?post_type=za_websites'][10]);

        // Hide link on listing page
        if (isset($_GET['post_type']) && $_GET['post_type'] == 'za_websites') {
            echo '<style type="text/css">
			.page-title-action { display:none; }
			</style>';
        }
    }

    /**
     * Add Meta Box for Website PostType.
     *
     * @since    1.0.0
     */
    public function print_meta_box_for_website_post()
    {
        add_meta_box(
            'website-data-box',
            'Website Data',
            array($this, 'website_data_box_callback'),
            'za_websites',
            'normal',
        );
    }

    public function website_data_box_callback($post)
    {
        global $post;

		// Getting source code of webiste
        $data = file_get_contents("https://www.lipsum.com/");
        $html_sourcecode_get = htmlentities($data);

		// Getting user role
		$user = wp_get_current_user();
		$roles = ( array ) $user->roles;
        ?>
		<style type="text/css">
			.page-title-action, #submitdiv, #astra_settings_meta_box {
				display: none;
			}
		</style>
		<div>
			<h2>User Website Data</h2>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<label for="posts_per_rss">Username</label>
						</th>
						<td>
							<?php echo get_post_meta($post->ID, 'username', true); ?>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="posts_per_rss">Website Url</label>
						</th>
						<td>
							<?php echo get_post_meta($post->ID, 'website_url', true); ?>
						</td>
					</tr>
					<?php 
					if( $roles[0] == "administrator"){
					?>
					<tr>
						<th scope="row">
							<label for="posts_per_rss">Source Code of Website</label>
						</th>
					</tr>
					<tr>
						<th scope="row" colspan="2">
							<textarea rows="20"><?php echo $html_sourcecode_get; ?></textarea>
						</th>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
		<?php
	}

}