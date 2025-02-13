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
 * Labels class
 */
class Labels extends Customizer {
	protected $section_labels = 'radius_docs_labels_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_labels,
			'title'       => __( 'Modify Static Text', 'radius-docs' ),
			'description' => __( 'You can change all static text of the theme.', 'radius-docs' ),
			'priority'    => 999
		] );
		Customize::add_controls( $this->section_labels, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_labels_controls', [

			'radius_docs_header_labels' => [
				'type'  => 'heading',
				'label' => __( 'Header Labels', 'radius-docs' ),
			],

			'radius_docs_get_menu_label' => [
				'type'        => 'text',
				'label'       => __( 'Menu Text', 'radius-docs' ),
				'default'     => __( 'Menu', 'radius-docs' ),
				'description' => __( 'Context: Menu Button', 'radius-docs' ),
			],

			'radius_docs_get_login_label' => [
				'type'        => 'text',
				'label'       => __( 'Sign In', 'radius-docs' ),
				'default'     => __( 'Sign In', 'radius-docs' ),
				'description' => __( 'Context: SignIn Button', 'radius-docs' ),
			],

			'radius_docs_get_started_label' => [
				'type'        => 'text',
				'label'       => __( 'Get Started', 'radius-docs' ),
				'default'     => __( 'Get Started', 'radius-docs' ),
				'description' => __( 'Context: Get Started', 'radius-docs' ),
				'condition' => [ 'radius_docs_get_started_button' ],
			],

			'radius_docs_contact_info_label' => [
				'type'        => 'text',
				'label'       => __( 'Contact Info', 'radius-docs' ),
				'default'     => __( 'Contact Info', 'radius-docs' ),
				'description' => __( 'Context: Contact Info', 'radius-docs' ),
			],

			'radius_docs_follow_us_label' => [
				'type'        => 'text',
				'label'       => __( 'Follow Us On', 'radius-docs' ),
				'default'     => __( 'Follow Us On', 'radius-docs' ),
				'description' => __( 'Context: Follow Us On', 'radius-docs' ),
			],

			'radius_docs_about_label' => [
				'type'        => 'text',
				'label'       => __( 'About Us', 'radius-docs' ),
				'description' => __( 'Context: About Us', 'radius-docs' ),
			],

			'radius_docs_about_text' => [
				'type'        => 'textarea',
				'label'       => __( 'About Text', 'radius-docs' ),
				'description' => __( 'Enter about text here.', 'radius-docs' ),
			],

			'radius_docs_footer_labels' => [
				'type'  => 'heading',
				'label' => __( 'Footer Labels', 'radius-docs' ),
			],

			'radius_docs_ready_label' => [
				'type'        => 'text',
				'label'       => __( 'Are You Ready', 'radius-docs' ),
				'default'     => __( 'ARE YOU READY TO GET STARTED?', 'radius-docs' ),
				'description' => __( 'Context: Footer Are You Ready', 'radius-docs' ),
			],

			'radius_docs_contact_button_text' => [
				'type'        => 'text',
				'label'       => __( 'Contact Us', 'radius-docs' ),
				'default'     => __( 'Contact Us', 'radius-docs' ),
				'description' => __( 'Context: Footer contact button', 'radius-docs' ),
			],

			'radius_docs_blog_labels' => [
				'type'  => 'heading',
				'label' => __( 'Blog Labels', 'radius-docs' ),
			],
			'radius_docs_author_prefix' => [
				'type'        => 'text',
				'label'       => __( 'By', 'radius-docs' ),
				'default'     => 'by',
				'description' => __( 'Context: Meta Author Prefix', 'radius-docs' ),
			],
			'radius_docs_tags_label'         => [
				'type'        => 'text',
				'label'       => __( 'Tags:', 'radius-docs' ),
				'default'     => __( 'Tags:', 'radius-docs' ),
				'description' => __( 'Context: Single blog footer tags label', 'radius-docs' ),
			],
			'radius_docs_social' => [
				'type'        => 'text',
				'label'       => __( 'Socials:', 'radius-docs' ),
				'default'     => __( 'Socials:', 'radius-docs' ),
				'description' => __( 'Context: Single blog footer Socials label', 'radius-docs' ),
			],
			'radius_docs_blog_read_more' => [
				'type'        => 'text',
				'label'       => __( 'Blog Read More:', 'radius-docs' ),
				'default'     => __( 'Read More', 'radius-docs' ),
				'description' => __( 'Context: Blog read more text', 'radius-docs' ),
			],
			'radius_docs_project_read_more' => [
				'type'        => 'text',
				'label'       => __( 'Project Read More:', 'radius-docs' ),
				'description' => __( 'Context: Project read more text', 'radius-docs' ),
			],
			'radius_docs_service_read_more' => [
				'type'        => 'text',
				'label'       => __( 'Service Read More:', 'radius-docs' ),
				'description' => __( 'Context: Service read more text', 'radius-docs' ),
			],

		] );
	}


}
