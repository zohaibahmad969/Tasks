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
class Elementor_Custom_Testimonial_Grid_Widget extends Widget_Base {

	public function get_name() {
		return 'elementor-kd-testimonials';
	}

	public function get_title() {
		return __( 'Custom Testimonial Grid', 'elementor' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return [ 'wpkd-items' ];
	}

	protected function register_controls() {

		$this->wpkd_content_layout_options();
		$this->wpkd_content_query_options();

		$this->wpkd_style_layout_options();
		$this->wpkd_style_box_options();
		$this->wpkd_style_image_options();

		$this->wpkd_style_title_options();
		$this->wpkd_style_content_options();
		$this->wpkd_style_readmore_options();
		$this->wpkd_style_position_options();

	}

	/**
	 * Content Layout Options.
	 */
	private function wpkd_content_layout_options() {

		$this->start_controls_section(
			'section_layout',
			[
				'label' => esc_html__( 'Layout', 'elementor' ),
			]
		);

		$this->add_control(
			'grid_style',
			[
				'label' => __( 'Grid Style', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => '1',
				'options' => [
					'1' => esc_html__( 'Layout 1', 'elementor' ),
					'2' => esc_html__( 'Layout 2', 'elementor' ),
					'3' => esc_html__( 'Layout 3', 'elementor' ),
					'4' => esc_html__( 'Layout 4', 'elementor' ),
					'5' => esc_html__( 'Layout 5', 'elementor' ),
					'6' => esc_html__( 'Carousel', 'elementor' ),
				],
			]
		);

		$this->add_responsive_control(
			'columns',
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
		

		$this->add_control(
			'posts_per_page',
			[
				'label' => __( 'Posts Per Page', 'post-grid-elementor-addon' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 3,
		'condition' => [
			'posts_post_type' => [ 'kd_testimonial' ],
		],
		'condition' => [
			'show_pagination' => 'no',
		],
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Image', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
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
			'show_title',
			[
				'label' => __( 'Title', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'title_tag',
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
				'condition' => [
					'show_title' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_excerpt',
			[
				'label' => __( 'Excerpt', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label' => __( 'Excerpt Length', 'elementor' ),
				'type' => Controls_Manager::NUMBER,
				/** This filter is documented in wp-includes/formatting.php */
				'default' => apply_filters( 'excerpt_length', 25 ),
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);

		$this->add_control(
			'excerpt_append',
			[
				'label' => __( 'Excerpt Append', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => '&hellip;',
				'condition' => [
					'show_excerpt' => 'yes',
				],
			]
		);
        $this->add_control(
			'show_person_position',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => __( 'Show Position', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
		
		'frontend_available' => true,
			]
		);
		$this->add_control(
			'show_person_rating',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => __( 'Show Rating', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
		
		'frontend_available' => true,
			]
		);
		$this->add_control(
			'show_read_more',
			[
				'label' => __( 'Read More', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_control(
			'read_more_text',
			[
				'label' => __( 'Read More Text', 'elementor' ),
				'type' => Controls_Manager::TEXT,
				'default' => __( 'Read More »', 'elementor' ),
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		$this->add_control(
			'content_align',
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
	 * Content Query Options.
	 */
	private function wpkd_content_query_options() {

		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query', 'elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
        
		$this->add_control(
			'advanced',
			[
				'label' => __( 'Advanced', 'elementor' ),
				'type' => Controls_Manager::HEADING,
			]
		);

		$this->add_control(
			'orderby',
			[
				'label' => __( 'Order By', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'post_date',
				'options' => [
					'post_date' => __( 'Date', 'elementor' ),
					'post_title' => __( 'Title', 'elementor' ),
					'rand' => __( 'Random', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label' => __( 'Order', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'desc',
				'options' => [
					'asc' => __( 'ASC', 'elementor' ),
					'desc' => __( 'DESC', 'elementor' ),
				],
			]
		);
		$this->add_control(
			'show_pagination',
			[
				'label' => __( 'Pagination', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'elementor' ),
				'label_off' => __( 'Hide', 'elementor' ),
				'default' => 'no',
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Style Layout Options.
	 */
	private function wpkd_style_layout_options() {

		// Layout.
		$this->start_controls_section(
			'section_layout_style',
			[
				'label' => __( 'Layout', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Columns margin.
		$this->add_control(
			'grid_style_columns_margin',
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
			'grid_style_rows_margin',
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
	private function wpkd_style_box_options() {

		// Box.
		$this->start_controls_section(
			'section_box',
			[
				'label' => __( 'Box', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_box_border_width',
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
			'grid_style_border_radius',
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
			'grid_items_style_padding',
			[
				'label'      => __( 'Padding', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		$this->start_controls_tabs( 'grid_button_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_button_style_normal',
			[
				'label'     => __( 'Normal', 'elementor' ),
			]
		);

		// Normal background color.
		$this->add_control(
			'grid_button_style_normal_bg_color',
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
			'grid_button_style_normal_border_color',
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
				'name'      => 'grid_button_style_normal_box_shadow',
				'selector'  => '{{WRAPPER}} .wpkd-grid-container .wpkd-post',
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_button_style_hover',
			[
				'label'     => __( 'Hover', 'elementor' ),
			]
		);

		// Hover background color.
		$this->add_control(
			'grid_button_style_hover_bg_color',
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
			'grid_button_style_hover_border_color',
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
				'name'      => 'grid_button_style_hover_box_shadow',
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
	private function wpkd_style_image_options() {

		// Box.
		$this->start_controls_section(
			'section_image',
			[
				'label' => __( 'Image', 'elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Image border radius.
		$this->add_control(
			'grid_image_border_radius',
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
			'grid_style_image_margin',
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
			'grid_style_image_size',
			[
				'label'      => __( 'Width', 'elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 80,
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
	private function wpkd_style_title_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_title_style',
			[
				'label'     => __( 'Title', 'elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Title typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'grid_title_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				],
				'selector' => '{{WRAPPER}} .wpkd-grid-container .wpkd-post .title, {{WRAPPER}} .wpkd-grid-container .wpkd-post .title > a',
			]
		);

		$this->start_controls_tabs( 'grid_title_color_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_title_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'elementor' ),
			)
		);

		// Title color.
		$this->add_control(
			'grid_title_style_color',
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
			'grid_title_style_hover_color',
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
			'grid_title_style_margin',
			[
				'label'      => __( 'Margin', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .title, {{WRAPPER}} .wpkd-grid-container .wpkd-post .title > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		// Title margin.
		$this->add_responsive_control(
			'grid_title_style_padding',
			[
				'label'      => __( 'Padding', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .title, {{WRAPPER}} .wpkd-grid-container .wpkd-post .title > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Meta.
	 */
	private function wpkd_style_position_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_position_style',
			[
				'label'     => __( 'Position', 'elementor' ),
				'tab'       => Controls_Manager::TAB_STYLE,
			]
		);

		// Meta Position margin.
		$this->add_responsive_control(
			'grid_position_style_margin',
			[
				'label'      => __( 'Margin', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-person-position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		// Meta Position typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'ggrid_position_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector' => '{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-person-position span',
			]
		);

		// Meta Position color.
		$this->add_control(
			'grid_position_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-person-position span' => 'color: {{VALUE}};',
				],
			]
		);
		

		$this->end_controls_section();
	}

	/**
	 * Style > Content.
	 */
	private function wpkd_style_content_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_content_style',
			[
				'label' => __( 'Content', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Content typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_content_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
				'selector'  => '{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-excerpt p',
			]
		);

		// Content color.
		$this->add_control(
			'grid_content_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-excerpt p' => 'color: {{VALUE}};',
				],
			]
		);

		// Content margin
		$this->add_responsive_control(
			'grid_content_style_margin',
			[
				'label'      => __( 'Margin', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post .post-grid-excerpt' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Style > Readmore.
	 */
	private function wpkd_style_readmore_options() {
		// Tab.
		$this->start_controls_section(
			'section_grid_readmore_style',
			[
				'label' => __( 'Read More', 'elementor' ),
				'tab'   => Controls_Manager::TAB_STYLE,
				'condition' => [
					'show_read_more' => 'yes',
				],
			]
		);

		// Readmore typography.
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'      => 'grid_readmore_style_typography',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				],
				'selector'  => '{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn',
			]
		);

		$this->start_controls_tabs( 'grid_readmore_color_style' );

		// Normal tab.
		$this->start_controls_tab(
			'grid_readmore_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'elementor' ),
			)
		);

		// Readmore color.
		$this->add_control(
			'grid_readmore_style_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Color', 'elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_TEXT,
				],
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn' => 'color: {{VALUE}};',
				],
			]
		);

		// Readmore background color.
		$this->add_control(
			'grid_readmore_style_background_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Readmore border color.
		$this->add_control(
			'grid_readmore_style_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover tab.
		$this->start_controls_tab(
			'grid_readmore_style_color_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'elementor' ),
			)
		);

		// Readmore hover color.
		$this->add_control(
			'grid_readmore_style_hover_color',
			array(
				'type'      => Controls_Manager::COLOR,
				'label'     => esc_html__( 'Color', 'elementor' ),
				'global' => [
					'default' => Global_Colors::COLOR_PRIMARY,
				],
				'selectors' => array(
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn:hover' => 'color: {{VALUE}};',
				),
			)
		);

		// Readmore hover background color.
		$this->add_control(
			'grid_readmore_style_hover_background_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Background Color', 'elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Readmore hover border color.
		$this->add_control(
			'grid_readmore_style_hover_border_color',
			[
				'type'      => Controls_Manager::COLOR,
				'label'     => __( 'Border Color', 'elementor' ),
				'selectors' => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn:hover' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		// Readmore border width.
		$this->add_control(
			'grid_readmore_style_border_width',
			[
				'type'       => Controls_Manager::DIMENSIONS,
				'label'      => __( 'Border Width', 'elementor' ),
				'separator'  => 'before',
				'size_units' => array( 'px' ),
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn' => 'border-style: solid; border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				],
			]
		);

		// Readmore border radius.
		$this->add_control(
			'grid_readmore_style_border_radius',
			array(
				'label'     => esc_html__( 'Border Radius', 'elementor' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 0,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
			)
		);

		// Readmore button padding.
		$this->add_responsive_control(
			'grid_readmore_style_button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
				),
			)
		);

		// Readmore margin.
		$this->add_responsive_control(
			'grid_readmore_style_margin',
			[
				'label'      => __( 'Margin', 'elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px' ],
				'selectors'  => [
					'{{WRAPPER}} .wpkd-grid-container .wpkd-post a.read-more-btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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

			$grid_style = $settings['grid_style'];

			$grid_class = '';

			if( 5 == $grid_style ){

				$grid_class = ' grid-meta-bottom';

			}
			if( 6 != $grid_style ){
				$grid_elem_class = ' elementor-grid';
			}
			?>
			
			<div class="wpkd-grid-container <?php echo $grid_elem_class.' '.$columns_desktop.$columns_tablet.$columns_mobile.$grid_class; ?>">

				<?php

				$posts_per_page = ( ! empty( $settings['posts_per_page'] ) ?  $settings['posts_per_page'] : $GLOBALS['wp_query']->posts_per_page );

				$posts_post_type = 'kd_testimonial';
				$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		        $query_args = array(
					        	'posts_per_page' 		=> absint( $posts_per_page ),
					        	'post_status'         	=> 'publish',
					        	'ignore_sticky_posts'   => true,
					        	'post_type' 		=> $posts_post_type,
								'paged'                 => $paged
				        	);
							if (is_category()) {
							    $query_args['tax_query'] = array(
									array (
										'taxonomy' => 'category',
										'field' => 'id',
										'terms' => get_query_var('cat'),
									)
								);
							} elseif (is_tag()) {
								$term_obj = get_queried_object();
							    $query_args['tax_query'] = array(
									array (
										'taxonomy' => 'post_tag',
										'field' => 'id',
										'terms' => $term_obj->term_id,
									)
								);
							}
		        // Order by.
		        if ( ! empty( $settings['orderby'] ) ) {
		        	$query_args['orderby'] = $settings['orderby'];
		        }

		        // Order .
		        if ( ! empty( $settings['order'] ) ) {
		        	$query_args['order'] = $settings['order'];
		        }

		        $all_posts = new \WP_Query( $query_args );

		        if ( $all_posts->have_posts() ) :

		        	if( 6 == $grid_style ){

		        		include( __DIR__ . '/layouts/client/layout-carousel.php' );

		        	}elseif( 5 == $grid_style ){

		        		include( __DIR__ . '/layouts/client/layout-5.php' );

		        	}elseif( 4 == $grid_style ){

		        		include( __DIR__ . '/layouts/client/layout-4.php' );

		        	}elseif( 3 == $grid_style ){

		        		include( __DIR__ . '/layouts/client/layout-3.php' );

		        	}elseif( 2 == $grid_style ){

		        		include( __DIR__ . '/layouts/client/layout-2.php' );

		        	}else{

		        		include( __DIR__ . '/layouts/client/layout-1.php' );

		        	}
              
//$GLOBALS['wp_query']->max_num_pages = $all_posts->max_num_pages;
                else:
				echo 'No data found';
		        endif; ?>

			</div>
		</div>
		<?php

	}

	public function wpkd_filter_excerpt_length( $length ) {

		$settings = $this->get_settings();

		$excerpt_length = (!empty( $settings['excerpt_length'] ) ) ? absint( $settings['excerpt_length'] ) : 25;

		return absint( $excerpt_length );
	}

	public function wpkd_filter_excerpt_more( $more ) {
		$settings = $this->get_settings();

		return $settings['excerpt_append'];
	}

	protected function render_thumbnail() {

		$settings = $this->get_settings();

		$show_image = $settings['show_image'];

		if ( 'yes' !== $show_image ) {
			return;
		}

		$post_thumbnail_size = $settings['post_thumbnail_size'];

		if ( has_post_thumbnail() ) :  ?>
			<div class="post-grid-thumbnail">
				<a href="<?php the_permalink(); ?>">
					<?php the_post_thumbnail( $post_thumbnail_size ); ?>
				</a>
			</div>
        <?php endif;
	}

	protected function render_title() {

		$settings = $this->get_settings();

		$show_title = $settings['show_title'];

		if ( 'yes' !== $show_title ) {
			return;
		}

		$title_tag = $settings['title_tag'];

		?>
		<<?php echo $title_tag; ?> class="title">
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</<?php echo $title_tag; ?>>
		<?php
	}
	protected function render_author_box() {

		$settings = $this->get_settings();

		$show_author_box = $settings['show_author_box'];

		if ( 'yes' !== $show_author_box ) {
			return;
		}

		echo '<div class="post-grid-author">';
				 if(get_avatar(get_the_author_meta('ID')) !== FALSE): 
					echo get_avatar( get_the_author_meta( 'ID' ), 16 );
				 else:
					echo '<img src="'.get_stylesheet_directory_uri() . '/img/user.png">';
				endif;
			echo '<h5 class="author-post__title">';
					echo get_the_author();
				echo '</h5>
		</div>';
	}

	protected function render_meta() {

		$settings = $this->get_settings();

		$meta_data = $settings['meta_data'];

		if ( empty( $meta_data ) ) {
			return;
		}

		?>
		<div class="post-grid-meta">
			<?php
			if ( in_array( 'author', $meta_data ) ) { ?>

				<span class="post-author"><?php the_author(); ?></span>

				<?php
			}

			if ( in_array( 'date', $meta_data ) ) { ?>

				<span class="post-author"><?php echo apply_filters( 'the_date', get_the_date(), get_option( 'date_format' ), '', '' ); ?></span>

				<?php
			}

			if ( in_array( 'categories', $meta_data ) ) {

				$categories_list = get_the_category_list( esc_html__( ', ', 'elementor' ) );

				if ( $categories_list ) {
				    printf( '<span class="post-categories">%s</span>', $categories_list ); // WPCS: XSS OK.
				}

			}

			if ( in_array( 'comments', $meta_data ) ) { ?>

				<span class="post-comments"><?php comments_number(); ?></span>

				<?php
			}
			?>
		</div>
		<?php

	}

	protected function render_excerpt() {

		$settings = $this->get_settings();

		$show_excerpt = $settings['show_excerpt'];

		if ( 'yes' !== $show_excerpt ) {
			return;
		}

		add_filter( 'excerpt_more', [ $this, 'wpkd_filter_excerpt_more' ], 20 );
		add_filter( 'excerpt_length', [ $this, 'wpkd_filter_excerpt_length' ], 9999 );

		?>
		<div class="post-grid-excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php

		remove_filter( 'excerpt_length', [ $this, 'wpkd_filter_excerpt_length' ], 9999 );
		remove_filter( 'excerpt_more', [ $this, 'wpkd_filter_excerpt_more' ], 20 );
	}

	protected function render_readmore() {

		$settings = $this->get_settings();

		$show_read_more = $settings['show_read_more'];
		$read_more_text = $settings['read_more_text'];

		if ( 'yes' !== $show_read_more ) {
			return;
		}

		?>
		<a class="read-more-btn" href="<?php the_permalink(); ?>"><?php echo esc_html( $read_more_text ); ?></a>
		<?php

	}
	
	protected function render_person_position() {

		$settings = $this->get_settings();

		$show_person_position = $settings['show_person_position'];

		if ( 'yes' !== $show_person_position ) {
			return;
		}

		?>
		<div class="post-grid-person-position">
			<span><?php echo get_field('person_position'); ?></span>
		</div>
		<?php

	}
	
	protected function render_person_rating() {

		$settings = $this->get_settings();

		$show_person_rating = $settings['show_person_rating'];

		if ( 'yes' !== $show_person_rating ) {
			return;
		}

		?>
		<div class="post-grid-person-rating">
			<div class="star-rating" title="3.5 rating based on 1,234 ratings">
				<?php for ($i=1; $i<=5; $i++) {
					if ($i == get_field('kd_buyer_rating')) {?>
						<div class="fa fa-star checked"></div>
					<?php } else {?>
						<div class="fa fa-star"></div>
					<?php }
				}?>
				</div>
		</div>
		<?php

	}
	
}
