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
 * ColorBanner class
 */
class ColorBanner extends Customizer {

	protected $section_banner_color = 'radius_docs_banner_color_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_banner_color,
			'panel'       => 'radius_docs_color_panel',
			'title'       => __( 'Banner / Breadcrumb Colors', 'radius-docs' ),
			'description' => __( 'Banner Color Section', 'radius-docs' ),
			'priority'    => 6
		] );

		Customize::add_controls( $this->section_banner_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_site_color_controls', [

			'radius_docs_banner_color' => [
				'type'         => 'color',
				'label'        => __( 'Banner Background Color', 'radius-docs' ),
			],

			'radius_docs_banner_overlay' => [
				'type'         => 'color',
				'label'        => __( 'Banner Overlay Color', 'radius-docs' ),
			],

			'radius_docs_banner_hr' => [
				'type'         => 'separator',
			],

			'radius_docs_breadcrumb_color' => [
				'type'    => 'color',
				'label'   => __( 'Link Color', 'radius-docs' ),
			],

			'radius_docs_breadcrumb_hover' => [
				'type'    => 'color',
				'label'   => __( 'Link Hover Color', 'radius-docs' ),
			],

			'radius_docs_breadcrumb_active' => [
				'type'    => 'color',
				'label'   => __( 'Link Active Color', 'radius-docs' ),
			],

			'radius_docs_breadcrumb_title_color' => [
				'type'    => 'color',
				'label'   => __( 'Title Color', 'radius-docs' ),
			],

		] );
	}

}
