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
 * ColorTopbar class
 */
class ColorTopbar extends Customizer {
	protected $section_topbar_color = 'radius_docs_top_bar_color_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_topbar_color,
			'panel'       => 'radius_docs_color_panel',
			'title'       => __( 'Top Bar Colors', 'radius-docs' ),
			'description' => __( 'Top Bar Color Section', 'radius-docs' ),
			'priority'    => 3
		] );

		Customize::add_controls( $this->section_topbar_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_header_color_controls', [


			'radius_docs_topbar_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Topbar Color', 'radius-docs' ),
			],

			'radius_docs_topbar_active_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Hover Color', 'radius-docs' ),
			],

			'radius_docs_topbar_bg_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Topbar Background', 'radius-docs' ),
			],


		] );


	}

}
