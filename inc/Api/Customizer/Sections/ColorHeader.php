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
 * ColorHeader class
 */
class ColorHeader extends Customizer {
	protected $section_header_color = 'radius_docs_header_color_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {

		Customize::add_section( [
			'id'          => $this->section_header_color,
			'panel'       => 'radius_docs_color_panel',
			'title'       => __( 'Header Colors', 'radius-docs' ),
			'description' => __( 'Header Color Section', 'radius-docs' ),
			'priority'    => 4
		] );

		Customize::add_controls( $this->section_header_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_header_color_controls', [

			'radius_docs_menu_heading1' => [
				'type'  => 'heading',
				'label' => __( 'Default Menu', 'radius-docs' ),
			],

			'radius_docs_menu_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Menu Color', 'radius-docs' ),
			],

			'radius_docs_menu_active_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Menu Hover & Active Color', 'radius-docs' ),
			],

			'radius_docs_menu_bg_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Menu Background Color', 'radius-docs' ),
			],

			'radius_docs_sub_menu_bg_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Sub Menu Background Color', 'radius-docs' ),
			],

			'radius_docs_menu_heading2' => [
				'type'  => 'heading',
				'label' => __( 'Transparent Menu', 'radius-docs' ),
			],

			'radius_docs_tr_menu_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'TR Menu Color', 'radius-docs' ),
			],

			'radius_docs_tr_menu_active_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'TR Menu Hover & Active Color', 'radius-docs' ),
			],

			'radius_docs_menu_heading4' => [
				'type'  => 'heading',
				'label' => __( 'Others Style', 'radius-docs' ),
			],

			'radius_docs_menu_border_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Menu Border Color', 'radius-docs' ),
			],


		] );


	}

}
