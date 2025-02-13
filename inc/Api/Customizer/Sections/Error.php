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
 * Error class
 */
class Error extends Customizer {
	protected $section_labels = 'radius_docs_error_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_labels,
			'title'       => __( 'Error Page', 'radius-docs' ),
			'description' => __( 'Error section.', 'radius-docs' ),
			'priority'    => 39
		] );
		Customize::add_controls( $this->section_labels, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_labels_controls', [

			'radius_docs_error_image' => [
				'type'         => 'image',
				'label'        => __( 'Error Image', 'radius-docs' ),
				'description'  => __( 'Upload error image for your site.', 'radius-docs' ),
				'button_label' => __( 'Error image', 'radius-docs' ),
			],

			'radius_docs_error_heading' => [
				'type'        => 'text',
				'label'       => __( 'Error Heading', 'radius-docs' ),
				'default'     => __( 'Oops, something went wrong.', 'radius-docs' ),
			],

			'radius_docs_error_text' => [
				'type'        => 'text',
				'label'       => __( 'Error Text', 'radius-docs' ),
				'default'     => __( 'Sorry! This Page Is Not Available!', 'radius-docs' ),
			],

			'radius_docs_error_button_text' => [
				'type'        => 'text',
				'label'       => __( 'Error Button Text', 'radius-docs' ),
				'default'     => __( 'Back To Home Page', 'radius-docs' ),
			],

		] );
	}


}
