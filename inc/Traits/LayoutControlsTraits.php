<?php
/**
 * LayoutControls
 */

namespace RT\RadiusDocs\Traits;

// Do not allow directly accessing this file.
use RT\RadiusDocs\Helpers\Fns;

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * LayoutControlsTraits Trait for customize layout
 */
trait LayoutControlsTraits {
	public function get_layout_controls( $prefix = '' ) {

		$_left_text  = __( 'Left Sidebar', 'radius-docs' );
		$_right_text = __( 'Right Sidebar', 'radius-docs' );
		$left_text   = $_left_text;
		$right_text  = $_right_text;
		$image_left  = 'sidebar-left.png';
		$image_right = 'sidebar-right.png';

		if ( is_rtl() ) {
			$left_text   = $_right_text;
			$right_text  = $_left_text;
			$image_left  = 'sidebar-right.png';
			$image_right = 'sidebar-left.png';
		}

		return apply_filters( "radius_docs_{$prefix}_layout_controls", [

			$prefix . '_layout' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'radius-docs' ),
				'default' => 'right-sidebar',
				'choices' => [
					'left-sidebar'  => [
						'image' => radius_docs_get_img( $image_left ),
						'name'  => $left_text,
					],
					'full-width'    => [
						'image' => radius_docs_get_img( 'sidebar-full.png' ),
						'name'  => __( 'Full Width', 'radius-docs' ),
					],
					'right-sidebar' => [
						'image' => radius_docs_get_img( $image_right ),
						'name'  => $right_text,
					],
				]
			],

			$prefix . '_sidebar' => [
				'type'    => 'select',
				'label'   => __( 'Choose a Sidebar', 'radius-docs' ),
				'default' => 'default',
				'choices' => Fns::sidebar_lists()
			],

			$prefix . '_page_bg_image' => [
				'type'         => 'image',
				'label'        => __( 'Page Background Image', 'radius-docs' ),
				'description'  => __( 'Upload Background Image', 'radius-docs' ),
				'button_label' => __( 'Background Image', 'radius-docs' ),
			],

			$prefix . '_page_bg_color' => [
				'type'         => 'color',
				'label'        => __( 'Page Background Color', 'radius-docs' ),
				'description'  => __( 'Inter Background Color', 'radius-docs' ),
			],

			$prefix . '_header_heading' => [
				'type'  => 'heading',
				'label' => __( 'Header Settings', 'radius-docs' ),
			],

			$prefix . '_header_style' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Header Layout', 'radius-docs' ),
				'choices' => [
					'default' => __( '--Default--', 'radius-docs' ),
					'1'       => __( 'Layout 1', 'radius-docs' ),
					'2'       => __( 'Layout 2', 'radius-docs' ),
					'3'       => __( 'Layout 3', 'radius-docs' ),
					'4'       => __( 'Layout 4', 'radius-docs' ),
					'5'       => __( 'Layout 5', 'radius-docs' ),
					'6'       => __( 'Layout 6', 'radius-docs' ),
				],
			],

			$prefix . '_top_bar' => [
				'type'    => 'select',
				'label'   => __( 'Top Bar', 'radius-docs' ),
				'default' => 'default',
				'choices' => [
					'default' => __( '--Default--', 'radius-docs' ),
					'on'      => __( 'On', 'radius-docs' ),
					'off'     => __( 'Off', 'radius-docs' ),
				]
			],

			$prefix . '_banner_heading' => [
				'type'  => 'heading',
				'label' => __( 'Banner Settings', 'radius-docs' ),
			],

			$prefix . '_banner' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Visibility', 'radius-docs' ),
				'choices' => [
					'default' => __( '--Default--', 'radius-docs' ),
					'on'      => __( 'On', 'radius-docs' ),
					'off'     => __( 'Off', 'radius-docs' ),
				],
			],

			$prefix . '_banner_style' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Layout', 'radius-docs' ),
				'choices' => [
					'default' => __( '--Default--', 'radius-docs' ),
					'1'       => __( 'Layout 1', 'radius-docs' ),
					'2'       => __( 'Layout 2', 'radius-docs' ),
				],
			],

			$prefix . '_breadcrumb_title' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Title', 'radius-docs' ),
				'choices' => [
					'default' => __( '--Default--', 'radius-docs' ),
					'on'      => __( 'On', 'radius-docs' ),
					'off'     => __( 'Off', 'radius-docs' ),
				],
			],

			$prefix . '_breadcrumb' => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Banner Breadcrumb', 'radius-docs' ),
				'choices' => [
					'default' => __( '--Default--', 'radius-docs' ),
					'on'      => __( 'On', 'radius-docs' ),
					'off'     => __( 'Off', 'radius-docs' ),
				],
			],

			$prefix . '_banner_image' => [
				'type'         => 'image',
				'label'        => __( 'Banner Image', 'radius-docs' ),
				'description'  => __( 'Upload Banner Image', 'radius-docs' ),
				'button_label' => __( 'Banner Image', 'radius-docs' ),
			],

			$prefix . '_banner_color' => [
				'type'         => 'color',
				'label'        => __( 'Banner Background Color', 'radius-docs' ),
				'description'  => __( 'Inter Background Color', 'radius-docs' ),
			],

			$prefix . '_footer_heading' => [
				'type'  => 'heading',
				'label' => __( 'Footer Settings', 'radius-docs' ),
			],

			$prefix . '_footer_style'  => [
				'type'    => 'select',
				'default' => 'default',
				'label'   => __( 'Footer Layout', 'radius-docs' ),
				'choices' => [
					'default' => __( '--Default--', 'radius-docs' ),
					'1'       => __( 'Layout 1', 'radius-docs' ),
					'2'       => __( 'Layout 2', 'radius-docs' ),
					'3'       => __( 'Layout 3', 'radius-docs' ),
					'4'       => __( 'Layout 4', 'radius-docs' ),
					'5'       => __( 'Layout 5', 'radius-docs' ),
				],
			],

		] );
	}

}
