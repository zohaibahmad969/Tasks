<?php
/**
 * Class Elementor_Custom_Post_Grid_Main
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Elementor_Custom_Post_Grid_Main {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @since 1.2.0
	 * @access private
	 */
	private function include_widgets_files() {
		require_once( __DIR__ . '/widgets/post-grid.php' );
		require_once( __DIR__ . '/widgets/client-grid.php' );
		require_once( __DIR__ . '/widgets/support-grid.php' );
		require_once( __DIR__ . '/widgets/category-info.php' );
	}

	/**
	 * widget_style
	 *
	 * Load main style files.
	 *
	 * @since 1.0.0
	 * @access public
	 */

	public function widget_styles() {
		wp_register_style( 'kd-post-grid-elementor-addon-main', get_stylesheet_directory_uri().'/custom-elementor-widgets/assets/css/main.css' );
		wp_enqueue_style( 'kd-post-grid-elementor-addon-main' );
		if ( is_single() ) {
		wp_enqueue_style( 'kd-child-swiper-css', get_stylesheet_directory_uri() . '/custom-elementor-widgets/assets/css/swiper-bundle.min.css', array(), '1.0', true );
		wp_enqueue_script( 'kd-child-swiper-js', get_stylesheet_directory_uri() . '/custom-elementor-widgets/assets/js/swiper-bundle.min.js', array(), '1.0', true );
	}
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Elementor_Custom_Post_Grid_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Elementor_Custom_Testimonial_Grid_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Elementor_Custom_Support_Categories_Grid_Widget() );
		\Elementor\Plugin::instance()->widgets_manager->register( new Widgets\Elementor_Custom_Categories_Info_Widget() );
	}

	public function register_widget_category( $elements_manager ) {

		$elements_manager->add_category(
			'wpkd-items',
			[
				'title' => __( 'Kidsadmin Elements', 'elementor' ),
				'icon' => 'fa fa-plug',
			]
		);
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget style
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		add_action( 'elementor/elements/categories_registered', [ $this, 'register_widget_category' ] );
		
	}
}

// Instantiate Plugin Class
Elementor_Custom_Post_Grid_Main::instance();
