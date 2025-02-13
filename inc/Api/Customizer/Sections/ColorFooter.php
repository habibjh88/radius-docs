<?php
/**
 * Theme Customizer - Header
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Framework\Customize\Customize;

/**
 * ColorFooter class
 */
class ColorFooter extends Customizer {
	protected $section_footer_color = 'radius_docs_footer_color_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_footer_color,
			'panel'       => 'radius_docs_color_panel',
			'title'       => __( 'Footer Colors', 'radius-docs' ),
			'description' => __( 'Footer Color Section', 'radius-docs' ),
			'priority'    => 8
		] );

		Customize::add_controls( $this->section_footer_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_footer_color_controls', [
			'radius_docs_footer_color1'           => [
				'type'  => 'heading',
				'label' => __( 'Main Footer', 'radius-docs' ),
			],
			'radius_docs_footer_bg'               => [
				'type'  => 'color',
				'label' => __( 'Footer Background', 'radius-docs' ),
			],
			'radius_docs_footer_text_color'             => [
				'type'  => 'color',
				'label' => __( 'Footer Text', 'radius-docs' ),
			],
			'radius_docs_footer_link_color'             => [
				'type'  => 'color',
				'label' => __( 'Footer Link', 'radius-docs' ),
			],
			'radius_docs_footer_link_hover_color'       => [
				'type'  => 'color',
				'label' => __( 'Footer Link - Hover', 'radius-docs' ),
			],
			'radius_docs_footer_widget_title_color'     => [
				'type'  => 'color',
				'label' => __( 'Widget Title', 'radius-docs' ),
			],
			'radius_docs_footer_input_border_color'     => [
				'type'  => 'color',
				'label' => __( 'Input/List/Table Border Color', 'radius-docs' ),
			],
			'radius_docs_footer_copyright_color1' => [
				'type'  => 'heading',
				'label' => __( 'Copyright Area', 'radius-docs' ),
			],
			'radius_docs_copyright_bg'            => [
				'type'  => 'color',
				'label' => __( 'Copyright Background', 'radius-docs' ),
			],
			'radius_docs_copyright_text_color'          => [
				'type'  => 'color',
				'label' => __( 'Copyright Text', 'radius-docs' ),
			],
			'radius_docs_copyright_link_color'          => [
				'type'  => 'color',
				'label' => __( 'Copyright Link', 'radius-docs' ),
			],
			'radius_docs_copyright_link_hover_color'    => [
				'type'  => 'color',
				'label' => __( 'Copyright Link - Hover', 'radius-docs' ),
			],
		] );


	}

}
