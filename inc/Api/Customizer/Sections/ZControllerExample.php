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
 * ZControllerExample class for check
 */
class ZControllerExample extends Customizer {

	protected $section_test = 'radius_docs_test_test_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_test,
			'title'       => __( 'Test Controls', 'radius-docs' ),
			'description' => __( 'Customize the Test', 'radius-docs' ),
			'priority'    => 9999
		] );
		Customize::add_controls( $this->section_test, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {
		return apply_filters( 'radius_docs_test_test_controls', [

			//Reset button
			'radius_docs_reset_customize' => [
				'type'  => 'heading',
				'reset' => '1',
			],
			//Reset button

			'radius_docs_test_heading1' => [
				'type'        => 'heading',
				'label'       => __( 'All controls', 'radius-docs' ),
				'description' => __( 'All controls are here', 'radius-docs' ),
			],

			'radius_docs_test_switch' => [
				'type'  => 'switch',
				'label' => __( 'Choose switch', 'radius-docs' ),
			],

			'radius_docs_test_text' => [
				'type'      => 'text',
				'label'     => __( 'Text Default', 'radius-docs' ),
				'default'   => __( 'Text Default', 'radius-docs' ),
				'transport' => '',
				'condition' => [ 'radius_docs_test_switch' ]
			],


			'radius_docs_test_switch2' => [
				'type'  => 'switch',
				'label' => __( 'Choose switch2', 'radius-docs' ),
			],
			'radius_docs_test_url'     => [
				'type'      => 'url',
				'label'     => __( 'url', 'radius-docs' ),
				'default'   => __( 'url Default', 'radius-docs' ),
				'transport' => '',
				'condition' => [ 'radius_docs_test_switch2', '!==', 1 ]
			],

			'radius_docs_test_select'   => [
				'type'        => 'select',
				'label'       => __( 'Select a Val', 'radius-docs' ),
				'description' => __( 'Select Discription', 'radius-docs' ),
				'default'     => 'menu-left',
				'choices'     => [
					'menu-left'   => __( 'Left Alignment', 'radius-docs' ),
					'menu-center' => __( 'Center Alignment', 'radius-docs' ),
					'menu-right'  => __( 'Right Alignment', 'radius-docs' ),
				]
			],
			'radius_docs_test_textarea' => [
				'type'      => 'textarea',
				'label'     => __( 'Textarea', 'radius-docs' ),
				'default'   => __( 'Textarea Default', 'radius-docs' ),
				'transport' => '',
			],

			'radius_docs_test_select5' => [
				'type'        => 'select',
				'label'       => __( 'Select a Val2', 'radius-docs' ),
				'description' => __( 'Select Discription', 'radius-docs' ),
				'default'     => 'menu-center',
				'choices'     => [
					'menu-left'   => __( 'Left Alignment', 'radius-docs' ),
					'menu-center' => __( 'Center Alignment', 'radius-docs' ),
					'menu-right'  => __( 'Right Alignment', 'radius-docs' ),
				]
			],

			'radius_docs_test_textarea2' => [
				'type'      => 'textarea',
				'label'     => __( 'Textarea2', 'radius-docs' ),
				'default'   => __( 'Textarea Default', 'radius-docs' ),
				'transport' => '',
			],


			'radius_docs_test_checkbox' => [
				'type'  => 'checkbox',
				'label' => __( 'Choose checkbox', 'radius-docs' ),
			],

			'radius_docs_test_textarea22' => [
				'type'      => 'textarea',
				'label'     => __( 'Checkbox Textarea2', 'radius-docs' ),
				'transport' => '',
				'condition' => [ 'radius_docs_test_checkbox', '==', '1' ]
			],


			'radius_docs_test_radio' => [
				'type'    => 'radio',
				'label'   => __( 'Choose radio', 'radius-docs' ),
				'choices' => [
					'menu-left'   => __( 'Left Alignment', 'radius-docs' ),
					'menu-center' => __( 'Center Alignment', 'radius-docs' ),
					'menu-right'  => __( 'Right Alignment', 'radius-docs' ),
				]
			],

			'radius_docs_test_textarea222' => [
				'type'      => 'textarea',
				'label'     => __( 'radius_docs_test_radio Textarea2 - menu-center', 'radius-docs' ),
				'transport' => '',
			],

			'radius_docs_test_image_choose' => [
				'type'    => 'image_select',
				'label'   => __( 'Choose Layout', 'radius-docs' ),
				'default' => '1',
				'choices' => $this->get_header_presets()
			],

			'radius_docs_test_image' => [
				'type'         => 'image',
				'label'        => __( 'Choose Image', 'radius-docs' ),
				'button_label' => __( 'Logo', 'radius-docs' ),
			],

			'radius_docs_test_image_attr' => [
				'type'      => 'bg_attribute',
				'condition' => [ 'radius_docs_banner' ],
				'default'   => json_encode(
					[
						'position'   => 'center center',
						'attachment' => 'scroll',
						'repeat'     => 'no-repeat',
						'size'       => 'auto',
					]
				)
			],

			'radius_docs_test_number' => [
				'type'        => 'number',
				'label'       => __( 'Select a Number', 'radius-docs' ),
				'description' => __( 'Select Number', 'radius-docs' ),
				'default'     => '5',
			],

			'radius_docs_test_pages' => [
				'type'  => 'pages',
				'label' => __( 'Choose page', 'radius-docs' ),
			],


			'radius_docs_test_color'      => [
				'type'  => 'color',
				'label' => __( 'Choose color', 'radius-docs' ),
			],
			'radius_docs_test_alfa_color' => [
				'type'  => 'alfa_color',
				'label' => __( 'Choose alfa_color', 'radius-docs' ),
			],
			'radius_docs_test_datetime'   => [
				'type'  => 'datetime',
				'label' => __( 'Choose datetime', 'radius-docs' ),
			],


			'radius_docs_test_select2' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Meta', 'radius-docs' ),
				'placeholder' => __( 'Choose Meta', 'radius-docs' ),
				'multiselect' => true,
				'choices'     => [
					'author'   => __( 'Author', 'radius-docs' ),
					'date'     => __( 'Date', 'radius-docs' ),
					'category' => __( 'Category', 'radius-docs' ),
					'tag'      => __( 'Tag', 'radius-docs' ),
					'comment'  => __( 'Comment', 'radius-docs' ),
				],
			],

			'radius_docs_test_repeater' => [
				'type'  => 'repeater',
				'label' => __( 'Choose repeater', 'radius-docs' ),
			],

			'radius_docs_test_blog_meta_order1' => [
				'type'    => 'repeater',
				'label'   => __( 'Meta Order', 'radius-docs' ),
				'default' => 'one, two, three, four',
				'use_as'  => 'sort',
			],

			'radius_docs_test_blog_meta_order2' => [
				'type'    => 'repeater',
				'label'   => __( 'Meta Order', 'radius-docs' ),
				'default' => 'one, two, three, four',
			],

			'radius_docs_test_typography2' => [
				'type'    => 'typography',
				'label'   => __( 'Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => 'Open Sans',
						'regularweight' => 'normal',
						'size'          => '16',
						'lineheight'    => '26',
					]
				)
			],

			'radius_docs_test_typography3' => [
				'type'    => 'typography',
				'label'   => __( 'Typography', 'radius-docs' ),
				'default' => json_encode(
					[
						'font'          => 'Open Sans',
						'regularweight' => 'normal',
						'size'          => '16',
						'lineheight'    => '26',
					]
				)
			],
		] );
	}

	/**
	 * Get Header Presets
	 * @return array[]
	 */
	public function get_header_presets() {
		if ( ! defined( 'radius_docs_FRAMEWORK_DIR_URL' ) ) {
			return [];
		}

		return [
			'1' => [
				'image' => radius_docs_FRAMEWORK_DIR_URL . '/assets/images/header-1.png',
				'name'  => __( 'Style 1', 'radius-docs' ),
			],
			'2' => [
				'image' => radius_docs_FRAMEWORK_DIR_URL . '/assets/images/header-1.png',
				'name'  => __( 'Style 2', 'radius-docs' ),
			],
			'3' => [
				'image' => radius_docs_FRAMEWORK_DIR_URL . '/assets/images/header-1.png',
				'name'  => __( 'Style 3', 'radius-docs' ),
			],
		];
	}

}
