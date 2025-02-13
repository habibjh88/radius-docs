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
 * Contact class
 */
class Contact extends Customizer {
	protected $section_contact = 'radius_docs_contact_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_contact,
			'panel'       => 'radius_docs_contact_social_panel',
			'title'       => __( 'Contact Information', 'radius-docs' ),
			'description' => __( 'Contact Address Section', 'radius-docs' ),
			'priority'    => 1
		] );
		Customize::add_controls( $this->section_contact, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_contact_controls', [

			'radius_docs_phone' => [
				'type'  => 'text',
				'label' => __( 'Phone', 'radius-docs' ),
			],

			'radius_docs_email' => [
				'type'  => 'text',
				'label' => __( 'Email', 'radius-docs' ),
			],

			'radius_docs_website' => [
				'type'  => 'text',
				'label' => __( 'Website', 'radius-docs' ),
			],

			'radius_docs_contact_address' => [
				'type'        => 'textarea',
				'label'       => __( 'Address', 'radius-docs' ),
				'description' => __( 'Enter company address here.', 'radius-docs' ),
			],

		] );
	}
}
