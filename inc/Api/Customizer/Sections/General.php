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
 * General class
 */
class General extends Customizer {
	protected $section_general = 'radius_docs_general_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_general,
			'title'       => __( 'General', 'radius-docs' ),
			'description' => __( 'General Section', 'radius-docs' ),
			'priority'    => 20
		] );
		Customize::add_controls( $this->section_general, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_general_controls', [

			'container_width' => [
				'type'        => 'number',
				'label'       => __( 'Container Width', 'radius-docs' ),
				'default'     => '1280',
				'description' => __( 'Enter more than 1024', 'radius-docs' ),
			],

			'radius_docs_svg_enable'  => [
				'type'  => 'switch',
				'label' => __( 'Enable SVG Upload', 'radius-docs' ),
			],
			'radius_docs_back_to_top' => [
				'type'  => 'switch',
				'label' => __( 'Back to Top', 'radius-docs' ),
			],

			'radius_docs_remove_admin_bar' => [
				'type'        => 'switch',
				'label'       => __( 'Remove Admin Bar', 'radius-docs' ),
				'description' => __( 'This option not work for administrator role.', 'radius-docs' ),
			],

			'radius_docs_preloader' => [
				'type'  => 'switch',
				'label' => __( 'Preloader', 'radius-docs' ),
			],

			'radius_docs_preloader_logo' => [
				'type'         => 'image',
				'label'        => __( 'Preloader Logo', 'radius-docs' ),
				'description'  => __( 'Upload preloader logo for your site.', 'radius-docs' ),
				'button_label' => __( 'Logo', 'radius-docs' ),
				'condition'    => [ 'radius_docs_preloader' ]
			],

			'preloader_bg_color' => [
				'type'      => 'color',
				'label'     => __( 'Preloader Background Color', 'radius-docs' ),
				'condition' => [ 'radius_docs_preloader' ]
			],

			'radius_docs_blend' => [
				'type'    => 'select',
				'label'   => __( 'Full Site Image Blend', 'radius-docs' ),
				'default' => 'default',
				'choices' => [
					'default'      => esc_html__( 'Default', 'radius-docs' ),
					'radius-docs-blend' => esc_html__( 'Blend (Grayscale)', 'radius-docs' ),
				]
			],

		] );

	}

}
