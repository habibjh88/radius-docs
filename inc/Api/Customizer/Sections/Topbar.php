<?php
/**
 * Theme Customizer - Header
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Framework\Customize\Customize;

/**
 * HeaderTopbar class
 */
class Topbar extends Customizer {
	protected $section_topbar = 'radius_docs_top_bar_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_topbar,
			'panel'       => 'radius_docs_header_panel',
			'title'       => __( 'Topbar Section', 'radius-docs' ),
			'description' => __( 'Top Bar Section', 'radius-docs' ),
			'priority'    => 2
		] );

		Customize::add_controls( $this->section_topbar, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_top_bar_controls', [

			'radius_docs_top_bar' => [
				'type'      => 'switch',
				'label'     => __( 'Topbar Visibility', 'radius-docs' ),
				'default'   => 0,
				'edit-link' => '.topbar-row',
			],
			'radius_docs_topbar_style' => [
				'type'      => 'image_select',
				'label'     => __( 'Topbar Style', 'radius-docs' ),
				'default'   => '1',
				'choices'   => Fns::image_placeholder( 'topbar', 2, 'svg' ),
				'condition' => [ 'radius_docs_top_bar' ]
			],
			'radius_docs_topbar_address' => [
				'type'    => 'switch',
				'label'   => __( 'Topbar Address ?', 'radius-docs' ),
				'default' => 1,
				'condition' => [ 'radius_docs_top_bar' ]
			],
			'radius_docs_topbar_phone' => [
				'type'    => 'switch',
				'label'   => __( 'Topbar Phone ?', 'radius-docs' ),
				'default' => 1,
				'condition' => [ 'radius_docs_top_bar' ]
			],
			'radius_docs_topbar_email' => [
				'type'    => 'switch',
				'label'   => __( 'Topbar Email ?', 'radius-docs' ),
				'default' => 1,
				'condition' => [ 'radius_docs_top_bar' ]
			],

		] );

	}

}
