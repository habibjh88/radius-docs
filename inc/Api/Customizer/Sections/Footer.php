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
 * Footer class
 */
class Footer extends Customizer {
	protected $section_footer = 'radius_docs_footer_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_footer,
			'title'       => __( 'Footer', 'radius-docs' ),
			'description' => __( 'Footer Section', 'radius-docs' ),
			'priority'    => 38
		] );

		Customize::add_controls( $this->section_footer, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_footer_controls', [

			'radius_docs_footer_display' => [
				'type'        => 'switch',
				'label'       => __( 'Footer Display', 'radius-docs' ),
				'description' => __( 'Show footer display', 'radius-docs' ),
				'default'     => 1,
			],

			'radius_docs_footer_style' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'radius-docs' ),
				'default' => '1',
				'choices' => Fns::image_placeholder( 'footer', 3 )
			],

			'radius_docs_footer_width' => [
				'type'    => 'select',
				'label'   => __( 'Footer Width', 'radius-docs' ),
				'default' => '',
				'choices' => [
					''       => __( 'Box Width', 'radius-docs' ),
					'-fluid' => __( 'Full Width', 'radius-docs' ),
				]
			],

			'radius_docs_footer_max_width' => [
				'type'        => 'number',
				'label'       => __( 'Footer Max Width (PX)', 'radius-docs' ),
				'description' => __( 'Enter a number greater than 992.', 'radius-docs' ),
				'condition'   => [ 'radius_docs_footer_width', '==', '-fluid' ]
			],

			'radius_docs_sticy_footer' => [
				'type'        => 'switch',
				'label'       => __( 'Sticky Footer', 'radius-docs' ),
				'description' => __( 'Show footer at the top when scrolling down', 'radius-docs' ),
			],

			'radius_docs_social_footer' => [
				'type'    => 'switch',
				'label'   => __( 'Copyright Social Icon', 'radius-docs' ),
				'default' => 1,
			],

			'radius_docs_contact_footer' => [
				'type'        => 'switch',
				'label'       => __( 'Get Started Button', 'radius-docs' ),
				'description' => __( 'Show footer at Get Started Button. This options available for only Footer layout 3.', 'radius-docs' ),
				'default'     => 1,
			],

			'radius_docs_contact_button_url' => [
				'type'      => 'text',
				'label'     => __( 'Contact Link', 'radius-docs' ),
				'condition' => [ 'radius_docs_contact_footer' ]
			],

			'radius_docs_footer_copyright' => [
				'type'        => 'tinymce',
				'label'       => __( 'Footer Copyright Text', 'radius-docs' ),
				'default'     => __( 'Copyright© [y] RadiusDocs by <a href="https://radiustheme.com/">RadiusTheme</a>', 'radius-docs' ),
				'description' => __( 'Add [y] flag anywhere for dynamic year.', 'radius-docs' ),
			],

		] );

	}


}
