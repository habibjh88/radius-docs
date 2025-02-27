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
 * Blog class
 */
class Blog extends Customizer {

	protected $section_blog = 'radius_docs_blog_section';


	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_blog,
			'title'       => __( 'Blog Settings', 'radius-docs' ),
			'description' => __( 'Blog Section', 'radius-docs' ),
			'priority'    => 25
		] );

		Customize::add_controls( $this->section_blog, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {
		$blog_layout = [
			'default' => __( 'Default From Theme', 'radius-docs' ),
			'grid-1'  => __( 'Grid 1', 'radius-docs' ),
			'list-1'    => __( 'List 1', 'radius-docs' ),
		];

		return apply_filters( 'radius_docs_blog_controls', [

			'radius_docs_blog_visibility' => [
				'type'  => 'heading',
				'label' => __( 'Visibility Section', 'radius-docs' ),
			],

			'radius_docs_meta_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Meta Visibility', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_blog_above_meta_visibility' => [
				'type'  => 'switch',
				'label' => __( 'Title Above Meta Visibility', 'radius-docs' ),
			],

			'radius_docs_blog_content_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Entry Content Visibility', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_blog_readmore_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Read More Visibility', 'radius-docs' ),
				'default' => 0
			],

			'radius_docs_different_category_color' => [
				'type'    => 'switch',
				'label'   => __( 'Enable Different Category Color', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_blog_hr1' => [
				'type' => 'separator',
			],

			'radius_docs_blog_style' => [
				'type'        => 'select',
				'label'       => __( 'Blog Style', 'radius-docs' ),
				'description' => __( 'This option works only for blog layout', 'radius-docs' ),
				'default'     => 'default',
				'choices'     => $blog_layout
			],

			'radius_docs_blog_column' => [
				'type'        => 'select',
				'label'       => __( 'Grid Column', 'radius-docs' ),
				'description' => __( 'This option works only for large device', 'radius-docs' ),
				'default'     => 'default',
				'choices'     => [
					'default'            => __( 'Default From Theme', 'radius-docs' ),
					'col-lg-12'          => __( '1 Column', 'radius-docs' ),
					'col-lg-6'           => __( '2 Column', 'radius-docs' ),
					'col-lg-4 col-md-6'  => __( '3 Column', 'radius-docs' ),
					'col-lg-3 col-md-6'  => __( '4 Column', 'radius-docs' ),
					'col-lg-20 col-md-4' => __( '5 Column', 'radius-docs' ),
				]
			],

			'radius_docs_excerpt_limit' => [
				'type'    => 'text',
				'label'   => __( 'Content Limit', 'radius-docs' ),
				'default' => '20',
			],

			'radius_docs_blog_pagination_style' => [
				'type'        => 'select',
				'label'       => __( 'Pagination Style', 'radius-docs' ),
				'description' => __( 'This option works only for blog pagination style', 'radius-docs' ),
				'default'     => 'pagination-area',
				'choices'     => [
					'pagination-area'   => __( 'Default', 'radius-docs' ),
					'pagination-area-2' => __( 'Style 2', 'radius-docs' ),
				]
			],

			'radius_docs_blog_masonry' => [
				'type'  => 'switch',
				'label' => __( 'Enable Masonry Layout', 'radius-docs' ),
			],

			'radius_docs_meta_heading' => [
				'type'  => 'heading',
				'label' => __( 'Post Meta Settings', 'radius-docs' ),
			],

			'radius_docs_blog_meta_style' => [
				'type'    => 'select',
				'label'   => __( 'Meta Style', 'radius-docs' ),
				'default' => 'meta-style-default',
				'choices' => Fns::meta_style()
			],

			'radius_docs_blog_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Meta', 'radius-docs' ),
				'description' => __( 'You can sort meta by drag and drop', 'radius-docs' ),
				'placeholder' => __( 'Choose Meta', 'radius-docs' ),
				'multiselect' => true,
				'default'     => 'author,date,category',
				'choices'     => Fns::blog_meta_list(),
			],

			'radius_docs_thumbnail_heading' => [
				'type'  => 'heading',
				'label' => __( 'Thumbnail Gallery Settings', 'radius-docs' ),
			],

			'radius_docs_blog_gallery_arrows' => [
				'type'    => 'switch',
				'label'   => __( 'Thumbnail Gallery Arrows ?', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_blog_gallery_dots' => [
				'type'  => 'switch',
				'label' => __( 'Thumbnail Gallery Dots ?', 'radius-docs' ),
			],

			'radius_docs_blog_gallery_fade' => [
				'type'  => 'switch',
				'label' => __( 'Thumbnail Gallery Fade ?', 'radius-docs' ),
			],

			'radius_docs_blog_gallery_autoplay' => [
				'type'    => 'switch',
				'label'   => __( 'Thumbnail Gallery Autoplay ?', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_blog_gallery_infinite' => [
				'type'    => 'switch',
				'label'   => __( 'Thumbnail Gallery Infinite ?', 'radius-docs' ),
				'default' => 1
			],
		] );
	}


}
