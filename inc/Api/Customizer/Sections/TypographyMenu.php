<?php
/**
 * Theme Customizer - Menu Typography
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Framework\Customize\Customize;

/**
 * TypographyMenu class
 */
class TypographyMenu extends Customizer {

	protected $section_id = 'radius_docs_menu_typo_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_id,
			'title'       => __( 'Menu Typography', 'radius-docs' ),
			'description' => __( 'Menu Typography Section', 'radius-docs' ),
			'panel'       => 'radius_docs_typography_panel',
			'priority'    => 3
		] );

		Customize::add_controls( $this->section_id, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_menu_typo_section', [

			'radius_docs_menu_typo' => [
				'type'    => 'typography',
				'label'   => __( 'Menu Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => 'Urbanist',
						'regularweight' => '600',
						'size'          => '15',
						'lineheight'    => '22',
					]
				)
			],

		] );

	}

}
