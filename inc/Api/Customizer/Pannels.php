<?php
/**
 * Theme Customizer Pannels
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer;

use RT\RadiusDocs\Traits\SingletonTraits;
use RT\RadiusDocs\Framework\Customize\Customize;

/**
 * Pannels class
 */
class Pannels {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		$this->add_panels();
	}

	/**
	 * Add Panels
	 * @return void
	 */
	public function add_panels() {
		Customize::add_panels(
			[
				[
					'id'          => 'radius_docs_header_panel',
					'title'       => esc_html__( 'Header', 'radius-docs' ),
					'description' => esc_html__( 'RadiusDocs Header', 'radius-docs' ),
					'priority'    => 22,
				],
				[
					'id'          => 'radius_docs_typography_panel',
					'title'       => esc_html__( 'Typography', 'radius-docs' ),
					'description' => esc_html__( 'RadiusDocs Typography', 'radius-docs' ),
					'priority'    => 24,
				],
				[
					'id'          => 'radius_docs_color_panel',
					'title'       => esc_html__( 'Colors', 'radius-docs' ),
					'description' => esc_html__( 'RadiusDocs Color Settings', 'radius-docs' ),
					'priority'    => 28,
				],
				[
					'id'          => 'radius_docs_layouts_panel',
					'title'       => esc_html__( 'Layout Settings', 'radius-docs' ),
					'description' => esc_html__( 'RadiusDocs Layout Settings', 'radius-docs' ),
					'priority'    => 34,
				],
				[
					'id'          => 'radius_docs_contact_social_panel',
					'title'       => esc_html__( 'Contact & Socials', 'radius-docs' ),
					'description' => esc_html__( 'RadiusDocs Contact & Socials', 'radius-docs' ),
					'priority'    => 24,
				],

			]
		);
	}

}
