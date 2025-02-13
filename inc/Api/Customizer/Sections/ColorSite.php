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
 * ColorSite class
 */
class ColorSite extends Customizer {
	protected $section_site_color = 'radius_docs_site_color_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_site_color,
			'panel'       => 'radius_docs_color_panel',
			'title'       => __( 'Site Colors', 'radius-docs' ),
			'description' => __( 'Site Color Section', 'radius-docs' ),
			'priority'    => 2
		] );
		Customize::add_controls( $this->section_site_color, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_site_color_controls', [

			'radius_docs_site_color1'       => [
				'type'  => 'heading',
				'label' => __( 'Site Ascent Color', 'radius-docs' ),
			],
			'radius_docs_primary_color'     => [
				'type'  => 'color',
				'label' => __( 'Primary Color', 'radius-docs' ),
			],
			'radius_docs_primary_dark'     => [
				'type'  => 'color',
				'label' => __( 'Primary Color', 'radius-docs' ),
			],
			'radius_docs_primary_light'     => [
				'type'  => 'color',
				'label' => __( 'Primary Light', 'radius-docs' ),
			],
			'radius_docs_color_separator2'  => [
				'type' => 'separator',
			],
			'radius_docs_secondary_color'   => [
				'type'  => 'color',
				'label' => __( 'Secondary Color', 'radius-docs' ),
			],
			'radius_docs_site_color2'       => [
				'type'  => 'heading',
				'label' => __( 'Others Color', 'radius-docs' ),
			],
			'radius_docs_body_bg_color'     => [
				'type'  => 'color',
				'label' => __( 'Body BG Color', 'radius-docs' ),
			],
			'radius_docs_body_color'        => [
				'type'  => 'color',
				'label' => __( 'Body Color', 'radius-docs' ),
			],
			'radius_docs_border_color'      => [
				'type'  => 'color',
				'label' => __( 'Border Color', 'radius-docs' ),
			],
			'radius_docs_title_color'       => [
				'type'  => 'color',
				'label' => __( 'Title Color', 'radius-docs' ),
			],
			'radius_docs_rating_color'      => [
				'type'  => 'color',
				'label' => __( 'Rating Color', 'radius-docs' ),
			],
			'radius_docs_button_color'      => [
				'type'  => 'color',
				'label' => __( 'Button Color', 'radius-docs' ),
			],
			'radius_docs_button_text_color' => [
				'type'  => 'color',
				'label' => __( 'Button Text Color', 'radius-docs' ),
			],
			'radius_docs_meta_color'        => [
				'type'  => 'color',
				'label' => __( 'Meta Color', 'radius-docs' ),
			],
			'radius_docs_meta_light'        => [
				'type'  => 'color',
				'label' => __( 'Meta Light', 'radius-docs' ),
			],
			'radius_docs_gray10_color'      => [
				'type'  => 'color',
				'label' => __( 'Gray # 1', 'radius-docs' ),
			],
			'radius_docs_gray20_color'      => [
				'type'  => 'color',
				'label' => __( 'Gray # 2', 'radius-docs' ),
			],
		] );


	}

}
