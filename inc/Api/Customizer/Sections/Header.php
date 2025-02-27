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
 * Header class
 */
class Header extends Customizer {
	protected $section_header = 'radius_docs_header_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_header,
			'panel'       => 'radius_docs_header_panel',
			'title'       => __( 'Main Menu Section', 'radius-docs' ),
			'description' => __( 'Header Section', 'radius-docs' ),
			'priority'    => 1,
			'edit-point'  => ''
		] );
		Customize::add_controls( $this->section_header, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {

		return apply_filters( 'radius_docs_header_controls', [

			'radius_docs_header_style' => [
				'type'      => 'image_select',
				'label'     => __( 'Choose Layout', 'radius-docs' ),
				'default'   => '1',
				'edit-link' => '.site-branding',
				'choices'   => Fns::image_placeholder( 'header', 1, 'svg' )
			],

			'radius_docs_menu_alignment' => [
				'type'    => 'select',
				'label'   => __( 'Menu Alignment', 'radius-docs' ),
				'default' => '',
				'choices' => [
					''                       => __( 'Menu Alignment', 'radius-docs' ),
					'justify-content-start'  => __( 'Left Alignment', 'radius-docs' ),
					'justify-content-center' => __( 'Center Alignment', 'radius-docs' ),
					'justify-content-end'    => __( 'Right Alignment', 'radius-docs' ),
				]
			],

			'radius_docs_header_width' => [
				'type'    => 'select',
				'label'   => __( 'Header Width', 'radius-docs' ),
				'default' => 'box',
				'choices' => [
					'box'  => __( 'Box Width', 'radius-docs' ),
					'full' => __( 'Full Width', 'radius-docs' ),
				]
			],

			'radius_docs_header_max_width' => [
				'type'        => 'number',
				'label'       => __( 'Header Max Width (PX)', 'radius-docs' ),
				'description' => __( 'Enter a number greater than 1440. Remove value for 100%', 'radius-docs' ),
				'condition'   => [ 'radius_docs_header_width', '==', 'full' ]
			],

			'radius_docs_sticy_header' => [
				'type'        => 'switch',
				'label'       => __( 'Sticky Header', 'radius-docs' ),
				'description' => __( 'Show header at the top when scrolling down', 'radius-docs' ),
			],

			'radius_docs_tr_header' => [
				'type'    => 'switch',
				'label'   => __( 'Transparent Header', 'radius-docs' ),
				'default' => 0
			],

			'radius_docs_tr_header_shadow' => [
				'type'  => 'switch',
				'label' => __( 'Header Dark Shadow', 'radius-docs' ),
				'default' => 1,
				'description' => __( 'It works only for the transparent header.', 'radius-docs' ),
			],

			'radius_docs_header_border' => [
				'type'    => 'switch',
				'label'   => __( 'Header Border', 'radius-docs' ),
				'default' => 1
			],
			'radius_docs_header_sep1'   => [
				'type'      => 'separator',
				'edit-link' => '.menu-icon-wrapper',
			],
			'radius_docs_header1'       => [
				'type'  => 'heading',
				'label' => __( 'Menu Icon Wrapper', 'radius-docs' ),
			],

			'radius_docs_header_login_link' => [
				'type'    => 'switch',
				'label'   => __( 'User Login ?', 'radius-docs' ),
				'default' => 0,
			],

			'radius_docs_header_search' => [
				'type'    => 'switch',
				'label'   => __( 'Search Icon ?', 'radius-docs' ),
				'default' => 1,
			],

			'radius_docs_header_bar' => [
				'type'        => 'switch',
				'label'       => __( 'Hamburger Menu', 'radius-docs' ),
				'description' => __( 'It will be hide only for desktop.', 'radius-docs' ),
				'default'     => 0,
			],

			'radius_docs_header_separator' => [
				'type'    => 'switch',
				'label'   => __( 'Icon Separator', 'radius-docs' ),
				'default' => 0,
			],

			'radius_docs_offcanvas_social' => [
				'type'    => 'switch',
				'label'   => __( 'Offcanvas Social', 'radius-docs' ),
				'default' => 0,
			],

			'radius_docs_get_started_button' => [
				'type'    => 'switch',
				'label'   => __( 'Get Started Button ?', 'radius-docs' ),
				'default' => 0
			],

			'radius_docs_get_login_url' => [
				'type'      => 'text',
				'label'     => __( 'Custom Login Link', 'radius-docs' ),
				'condition' => [ 'radius_docs_header_login_link' ],
			],

			'radius_docs_get_started_button_url' => [
				'type'      => 'text',
				'label'     => __( 'Button Link', 'radius-docs' ),
				'condition' => [ 'radius_docs_get_started_button' ],
			],

			'radius_docs_hamburger_style' => [
				'type'    => 'select',
				'label'   => __( 'Hamburger icon animation', 'radius-docs' ),
				'default' => '3',
				'choices' => [
					'1' => __( 'Animation 1', 'radius-docs' ),
					'2' => __( 'Animation 2', 'radius-docs' ),
					'3' => __( 'Animation 3', 'radius-docs' ),
					'4' => __( 'Animation 4', 'radius-docs' ),
				]
			],

			'radius_docs_header_sep2' => [
				'type' => 'separator',
			],

			'radius_docs_menu_icon_order' => [
				'type'    => 'repeater',
				'label'   => __( 'Menu Icon Order', 'radius-docs' ),
				'default' => 'hamburg, login, search, button',
				'use_as'  => 'sort',
			],

		] );

	}


}
