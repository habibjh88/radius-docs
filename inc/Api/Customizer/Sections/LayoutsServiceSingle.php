<?php
/**
 * Theme Customizer - Service Single
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Framework\Customize\Customize;
use RT\RadiusDocs\Traits\LayoutControlsTraits;

/**
 * LayoutsServiceSingle class
 */
class LayoutsServiceSingle extends Customizer {

	use LayoutControlsTraits;

	protected $section_service_single_layout = 'radius_docs_service_single_layout_section';


	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'    => $this->section_service_single_layout,
			'title' => __( 'Service Single Layout', 'radius-docs' ),
			'panel' => 'radius_docs_layouts_panel',
		] );

		Customize::add_controls( $this->section_service_single_layout, $this->get_controls() );
	}

	public function get_controls() {
		return $this->get_layout_controls( 'service-single' );
	}

}
