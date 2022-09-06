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
class Elementor_Custom_Support_Categories_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'elementor-kd-support-cats';
	}

	public function get_title() {
		return __( 'Custom Support Categories Grid', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'wpkd-items' ];
	}

	protected function register_controls() {

		$this->wpkd_support_content_layout_options();

		$this->wpkd_support_style_layout_options();
		$this->wpkd_support_style_box_options();
		$this->wpkd_support_style_image_options();

		$this->wpkd_support_style_title_options();
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

		$this->add_responsive_control(
			'columns_support',
			[
				'label' => __( 'Columns', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options' => [
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
				],
				'prefix_class' => 'elementor-grid%s-',
				'frontend_available' => true,
				'selectors' => [
					'.elementor-msie {{WRAPPER}} .elementor-portfolio-item' => 'width: calc( 100% / {{SIZE}} )',
				],
			]
		);
		

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'post_thumbnail',
				'exclude' => [ 'custom' ],
				'default' => 'full',
				'prefix_class' => 'post-thumbnail-size-',
			]
		);

		$this->add_control(
			'title_tag_support',
			[
				'label' => __( 'Title HTML Tag', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
					'div' => 'div',
					'span' => 'span',
					'p' => 'p',
				],
				'default' => 'h3',
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
			'post_count_text',
			[
				'label' => __( 'Count Text', 'elementor' ),
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
					'{{WRAPPER}} .post-grid-inner' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Layout Options.
	 */
	private function wpkd_support_style_layout_options() {

		// Layout.
		$this->start_controls_section(
			'section_layout_style_support',
			[
				'label' => __( 'Layout', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Columns margin.
		$this->add_control(
			'grid_style_support_columns_margin',
			[
				'label'     => __( 'Columns margin', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 15,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container' => 'grid-column-gap: {{SIZE}}{{UNIT}}',

				],
			]
		);

		// Row margin.
		$this->add_control(
			'grid_style_support_rows_margin',
			[
				'label'     => __( 'Rows margin', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 30,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container' => 'grid-row-gap: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Box Options.
	 */
	private function wpkd_support_style_box_options() {

		// Box.
		$this->start_controls_section(
			'section_box_support',
			[
				'label' => __( 'Box', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_box_support_border_width',
			[
				'label'      => __( 'Border Widget', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Border Radius.
		$this->add_control(
			'grid_style_support_border_radius',
			[
				'label'     => __( 'Border Radius', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => [
					'size' => 0,
				],
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post' => 'border-radius: {{SIZE}}{{UNIT}}',
				],
			]
		);

		// Box internal padding.
		$this->add_responsive_control(
			'grid_items_style_support_padding',
			[
				'label'      => __( 'Padding', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style_support' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_button_style_support_normal',
			[
				'label'     => __( 'Normal', 'elementor' ),
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_button_style_support_normal_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Normal border color.
		$this->add_control(
			'grid_button_style_support_normal_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Normal box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_support_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .wpkd-grid-container .wpkd-post',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_button_style_support_hover',
			[
				'label'     => __( 'Hover', 'elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_button_style_support_hover_bg_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Hover border color.
		$this->add_control(
			'grid_button_style_support_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'elementor' ),
				'separator' => '',
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		// Hover box shadow.
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'      => 'grid_button_style_support_hover_box_shadow',
				'selector'  => '{{WRAPPER}} .wpkd-grid-container .wpkd-post:hover',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

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
					'{{WRAPPER}} .post-grid-inner .post-grid-thumbnail img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .post-grid-inner .post-grid-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .post-grid-inner .post-grid-thumbnail img' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

	}
	
	/**
	 * Style > Title.
	 */
	private function wpkd_support_style_title_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_title_style_support',
			[
				'label'     => __( 'Title', 'elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_support_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .wpkd-grid-container .wpkd-post .title, {{WRAPPER}} .wpkd-grid-container .wpkd-post .title > a',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style_support' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_title_style_support_normal',
			array(
				'label' => esc_html__( 'Normal', 'elementor' ),
			)
		);

		// Title color.
		$this->add_control(
			'grid_title_style_support_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_SECONDARY,
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .title, {{WRAPPER}} .wpkd-grid-container .wpkd-post .title > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_title_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'elementor' ),
			)
		);

		// Title hover color.
		$this->add_control(
			'grid_title_style_support_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .title, {{WRAPPER}} .wpkd-grid-container .wpkd-post .title > a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Title margin.
		$this->add_responsive_control(
			'grid_title_style_support_margin',
			[
				'label'      => __( 'Margin', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .title, {{WRAPPER}} .wpkd-grid-container .wpkd-post .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-meta span',
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
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-meta span' => 'color: {{VALUE}};',
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
			<?php

			$columns_desktop = ( ! empty( $settings['columns'] ) ? 'wpcap-grid-desktop-' . $settings['columns'] : 'wpcap-grid-desktop-3' );

			$columns_tablet = ( ! empty( $settings['columns_tablet'] ) ? ' wpcap-grid-tablet-' . $settings['columns_tablet'] : ' wpcap-grid-tablet-2' );

			$columns_mobile = ( ! empty( $settings['columns_mobile'] ) ? ' wpcap-grid-mobile-' . $settings['columns_mobile'] : ' wpcap-grid-mobile-1' );

			$grid_class = '';

			$grid_elem_class = ' elementor-grid';
			?>
			
			<div class="wpkd-grid-container <?php echo $grid_elem_class.' '.$columns_desktop.$columns_tablet.$columns_mobile.$grid_class; ?>">

				<?php

				$supportterms = get_terms( 'kd_support_cat', array(
					'hide_empty' => false,
				) );
				

		        if ( $supportterms ) :

		        	include( __DIR__ . '/layouts/support/layout_types.php' );
              
                else:
				echo 'No data found';
		        endif; ?>

			</div>
		</div>
		<?php

	}

	protected function render_thumbnail($term) {

		$settings = $this->get_settings();

		$post_thumbnail_size = $settings['post_thumbnail_size'];?>
			<div class="post-grid-thumbnail">
				<a href="<?php echo get_term_link($term->term_id); ?>">
					<img src="<?php echo get_field('support_thumbnail',$term); ?>" />
				</a>
			</div>
        <?php
	}

	protected function render_title($term) {

		$settings = $this->get_settings();

		$title_tag = $settings['title_tag_support'];

		?>
		<<?php echo $title_tag; ?> class="title">
			<a href="<?php echo get_term_link($term->term_id); ?>"><?php echo $term->name; ?></a>
		</<?php echo $title_tag; ?>>
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
		<div class="post-grid-meta">
			<span class="kd-post-count"><?php echo $term->count." ".$count_text; ?></span>
		</div>
		<?php

	}

}
