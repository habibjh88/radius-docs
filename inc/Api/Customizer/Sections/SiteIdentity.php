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
 * SiteIdentity class
 */
class SiteIdentity extends Customizer {

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_controls( 'title_tagline', $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_title_tagline_controls', [

			'radius_docs_logo' => [
				'type'         => 'image',
				'label'        => __( 'Main Logo', 'radius-docs' ),
				'description'  => __( 'Upload main logo for your site.', 'radius-docs' ),
				'button_label' => __( 'Logo', 'radius-docs' ),
			],

			'radius_docs_logo_light' => [
				'type'         => 'image',
				'label'        => __( 'Light Logo', 'radius-docs' ),
				'description'  => __( 'Upload light logo for transparent header. It should a white logo', 'radius-docs' ),
				'button_label' => __( 'Light Logo', 'radius-docs' ),
			],

			'radius_docs_logo_mobile' => [
				'type'         => 'image',
				'label'        => __( 'Mobile Logo', 'radius-docs' ),
				'description'  => __( 'Upload, if you need a different logo for mobile device..', 'radius-docs' ),
				'button_label' => __( 'Mobile Logo', 'radius-docs' ),
			],

			'radius_docs_logo_width_height' => [
				'type'      => 'text',
				'label'     => __( 'Main Logo Dimension', 'radius-docs' ),
				'description'     => __( 'Enter the width and height value separate by comma (,). Eg. 120px,45px', 'radius-docs' ),
				'transport' => '',
				'default' => 'none,42px',
			],

			'radius_docs_mobile_logo_width_height' => [
				'type'      => 'text',
				'label'     => __( 'Mobile Logo Dimension', 'radius-docs' ),
				'description'     => __( 'Enter the width and height value separate by comma (,). Eg. 120px,45px', 'radius-docs' ),
				'transport' => '',
			],

		] );

	}

}
