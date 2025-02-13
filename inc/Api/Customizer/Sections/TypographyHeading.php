<?php
/**
 * Theme Customizer - Heading Typography
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Framework\Customize\Customize;

/**
 * TypographyHeading class
 */
class TypographyHeading extends Customizer {

	protected $section_id = 'radius_docs_heading_typo_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_id,
			'title'       => __( 'Heading Typography', 'radius-docs' ),
			'description' => __( 'Heading Typography Section', 'radius-docs' ),
			'panel'       => 'radius_docs_typography_panel',
			'priority'    => 2
		] );

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_heading_typo_section', [

			'radius_docs_all_heading_typo' => [
				'type'    => 'typography',
				'label'   => __( 'All Headings Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => 'Roboto',
						'regularweight' => '600',
						'size'          => '44',
						'lineheight'    => '54',
					]
				)
			],

			'radius_docs_heading_h1_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H1 Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'radius_docs_heading_h2_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H2 Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'radius_docs_heading_h3_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H3 Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'radius_docs_heading_h4_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H4 Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'radius_docs_heading_h5_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H5 Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

			'radius_docs_heading_h6_typo' => [
				'type'    => 'typography',
				'label'   => __( 'H6 Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => '',
						'regularweight' => '',
						'size'          => '',
						'lineheight'    => '',
					]
				)
			],

		] );

	}

}
