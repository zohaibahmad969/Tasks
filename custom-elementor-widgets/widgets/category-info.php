<?php
namespace Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * @since 1.1.0
 */
class Elementor_Custom_Categories_Info_Widget extends Widget_Base {

	public function get_name() {
		return 'elementor-kd-cats-count';
	}

	public function get_title() {
		return __( 'Custom Categories Info', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'wpkd-items' ];
	}

	protected function register_controls() {

		$this->wpkd_support_content_layout_options();

		$this->wpkd_support_style_image_options();
		$this->wpkd_support_style_count_options();

	}

	/**
	 * Content Layout Options.
	 */
	private function wpkd_support_content_layout_options() {

		$this->start_controls_section(
			'section_support_layout',
			[
				'label' => esc_html__( 'Layout', 'elementor' ),
			]
		);

		$this->add_control(
			'show_post_count',
			[
				'label' => __( 'Posts Count', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Image', 'post-grid-elementor-addon' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'post-grid-elementor-addon' ),
				'label_off' => __( 'Hide', 'post-grid-elementor-addon' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'full',
				'prefix_class' => 'post-thumbnail-size-',
				'condition' => [
					'show_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'post_count_text',
			[
				'label' => __( 'Count', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'items', 'elementor' ),
				'condition' => [
					'show_post_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_align_support',
			[
				'label' => __( 'Alignment', 'elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'elementor' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'elementor' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'elementor' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'left',
				'selectors' => [
					'{{WRAPPER}} .cat-grid-text-wrap' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Image Options.
	 */
	private function wpkd_support_style_image_options() {

		// Box.
		$this->start_controls_section(
			'section_image_support',
			[
				'label' => __( 'Image', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_image_support_border_radius',
			[
				'label'      => __( 'Border Radius', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .cat-grid-text-wrap .cat-grid-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'grid_style_support_image_margin',
			[
				'label'      => __( 'Margin', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .cat-grid-text-wrap .cat-grid-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'grid_style_support_image_size',
			[
				'label'      => __( 'Size', 'elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 83,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => [
					'{{WRAPPER}} .cat-grid-text-wrap .cat-grid-thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}
	
	/**
	 * Style > Meta.
	 */
	private function wpkd_support_style_count_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_count_style_support',
			[
				'label'     => __( 'Count', 'elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Meta typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_count_style_support_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .wpkd-grid-container .cat-grid-text-wrap .cat-grid-meta span',
			]
		);

		// Meta color.
		$this->add_control(
			'grid_count_style_support_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .cat-grid-text-wrap .cat-grid-meta span' => 'color: {{VALUE}};',
				],
			]
		);
		

		$this->end_controls_section();
	}

	protected function render( $instance = [] ) {

		// Get settings.
		$settings = $this->get_settings();

		?>
		<div class="wpkd-grid">
			<div class="wpkd-grid-container">

				<?php

				if ( is_tax( 'kd_support_cat' ) ) :
                 $term = get_queried_object();?>
		        	 <div class="cat-grid-text-wrap">
						<?php $this->render_thumbnail($term); ?>
						<?php $this->render_count($term); ?>
					</div>
              
               <?php  endif; ?>

			</div>
		</div>
		<?php

	}

	protected function render_thumbnail($term) {

		$settings = $this->get_settings();
        $show_image = $settings['show_image'];

		if ( 'yes' !== $show_image ) {
			return;
		}
		$post_thumbnail_size = $settings['post_thumbnail_size'];?>
			<div class="cat-grid-thumbnail">
				<a href="<?php echo get_term_link($term->term_id); ?>">
					<img src="<?php echo get_field('support_thumbnail',$term); ?>" />
				</a>
			</div>
        <?php
	}

	protected function render_count($term) {

		$settings = $this->get_settings();
		$show_count = $settings['show_post_count'];
		$count_text = $settings['post_count_text'];

		if ( 'yes' !== $show_count ) {
			return;
		}

		?>
		<div class="cat-grid-meta">
			<span class="kd-cat-count"><?php echo $term->count." ".$count_text; ?></span>
		</div>
		<?php

	}

}
