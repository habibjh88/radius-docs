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
 * Banner class
 */
class Banner extends Customizer {

	protected $section_breadcrumb = 'radius_docs_breadcrumb_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_breadcrumb,
			'title'       => __( 'Banner - Breadcrumb', 'radius-docs' ),
			'description' => __( 'Banner Section', 'radius-docs' ),
			'priority'    => 23
		] );

		Customize::add_controls( $this->section_breadcrumb, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		$baradcrumbSettings = [
			'radius_docs_banner' => [
				'type'    => 'switch',
				'label'   => __( 'Banner Visibility', 'radius-docs' ),
				'default' => 0
			],

			'radius_docs_banner_color_mode' => [
				'type'      => 'select',
				'label'     => __( 'Banner Color Mode', 'radius-docs' ),
				'default'   => '',
				'choices'   => [
					''             => __( 'Default', 'radius-docs' ),
					'banner-dark'  => __( 'Dark', 'radius-docs' ),
					'banner-light' => __( 'Light', 'radius-docs' ),
					'banner-primary' => __( 'Primary', 'radius-docs' ),
				],
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_breadcrumb_alignment' => [
				'type'      => 'select',
				'label'     => __( 'Banner Alignment', 'radius-docs' ),
				'default'   => '',
				'choices'   => [
					''                   => __( 'Alignment Default', 'radius-docs' ),
					'align-items-left'   => __( 'Alignment Left', 'radius-docs' ),
					'align-items-center' => __( 'Alignment Center', 'radius-docs' ),
					'align-items-end'    => __( 'Alignment right', 'radius-docs' ),
				],
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_banner_image' => [
				'type'         => 'image',
				'label'        => __( 'Banner Background Image', 'radius-docs' ),
				'description'  => __( 'Upload Banner Image', 'radius-docs' ),
				'button_label' => __( 'Banner', 'radius-docs' ),
				'condition'    => [ 'radius_docs_banner' ]
			],

			'radius_docs_banner_image_attr' => [
				'type'      => 'bg_attribute',
				'condition' => [ 'radius_docs_banner' ],
				'default'   => json_encode(
					[
						'position'   => 'center center',
						'attachment' => 'scroll',
						'repeat'     => 'no-repeat',
						'size'       => 'cover',
					]
				)
			],

			'radius_docs_banner_height' => [
				'type'        => 'number',
				'label'       => __( 'Banner Height (px)', 'radius-docs' ),
				'description' => __( 'Height can be differ for transparent header.', 'radius-docs' ),
				'default'     => '',
				'condition'   => [ 'radius_docs_banner' ]
			],

			'radius_docs_banner_padding_top' => [
				'type'      => 'number',
				'label'     => __( 'Banner Padding Top (px)', 'radius-docs' ),
				'default'   => '',
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_banner_padding_bottom' => [
				'type'      => 'number',
				'label'     => __( 'Banner Padding Bottom (px)', 'radius-docs' ),
				'default'   => '',
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_banner1' => [
				'type'      => 'heading',
				'label'     => __( 'Breadcrumb Settings', 'radius-docs' ),
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_breadcrumb_title' => [
				'type'      => 'switch',
				'label'     => __( 'Banner Title', 'radius-docs' ),
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_breadcrumb' => [
				'type'      => 'switch',
				'label'     => __( 'Banner Breadcrumb', 'radius-docs' ),
				'default'   => 1,
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_breadcrumb_border' => [
				'type'      => 'switch',
				'label'     => __( 'Breadcrumb Border', 'radius-docs' ),
				'default'   => 1,
				'condition' => [ 'radius_docs_banner' ]
			],

			'radius_docs_banner2' => [
				'type'      => 'heading',
				'label'     => __( 'Breadcrumb Title', 'radius-docs' ),
				'condition' => [ 'radius_docs_banner' ]
			],

		];

		foreach ( Fns::get_post_types() as $ptype => $ptype_name ) {
			$baradcrumbSettings[ 'radius_docs_archive_' . trim( $ptype ) ] = [
				'type'      => 'text',
				'label'     => $ptype_name . __( ' Title', 'radius-docs' ),
				'condition' => [ 'radius_docs_banner' ]
			];
		}

		return apply_filters( 'radius_docs_top_bar_controls', $baradcrumbSettings );

	}

}
