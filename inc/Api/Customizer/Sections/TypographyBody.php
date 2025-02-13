<?php
/**
 * Theme Customizer - Body Typography
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Framework\Customize\Customize;

/**
 * TypographyBody class
 */
class TypographyBody extends Customizer {

	protected $section_id = 'radius_docs_body_typo_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_id,
			'title'       => __( 'Body Typography', 'radius-docs' ),
			'description' => __( 'Body Typography Section', 'radius-docs' ),
			'panel'       => 'radius_docs_typography_panel',
			'priority'    => 1
		] );

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_body_typo_section', [

			'radius_docs_body_typo' => [
				'type'    => 'typography',
				'label'   => __( 'Body Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => 'Inter',
						'regularweight' => '400',
						'size'          => '15',
						'lineheight'    => '26',
					]
				)
			],

		] );

	}

}
