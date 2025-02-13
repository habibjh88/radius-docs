<?php
/**
 * Theme Customizer - Project Archive
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Framework\Customize\Customize;
use RT\RadiusDocs\Traits\LayoutControlsTraits;

/**
 * LayoutsProject class
 */
class LayoutsProject extends Customizer {

	use LayoutControlsTraits;

	protected $section_project_archive_layout = 'radius_docs_project_archive_layout_section';


	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'    => $this->section_project_archive_layout,
			'title' => __( 'Project Archive Layout', 'radius-docs' ),
			'panel' => 'radius_docs_layouts_panel',
		] );

		Customize::add_controls( $this->section_project_archive_layout, $this->get_controls() );
	}

	public function get_controls() {
		return $this->get_layout_controls( 'radius-docs-project' );
	}

}
