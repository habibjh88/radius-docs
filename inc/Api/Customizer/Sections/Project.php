<?php
/**
 * Theme Customizer - Project
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Framework\Customize\Customize;
use RT\RadiusDocs\Helpers\Fns;

/**
 * Project class
 */
class Project extends Customizer {

	protected $section_project = 'radius_docs_project_section';


	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_project,
			'title'       => __( 'Project', 'radius-docs' ),
			'description' => __( 'Project Section', 'radius-docs' ),
			'priority'    => 27
		] );

		Customize::add_controls( $this->section_project, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {
		$meta_list = Fns::blog_meta_list();
		unset( $meta_list['tag'] );

		return apply_filters( 'radius_docs_project_controls', [

			'radius_docs_project_visibility' => [
				'type'  => 'heading',
				'label' => __( 'Visibility Section', 'radius-docs' ),
			],

			'radius_docs_project_meta_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Meta Visibility', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_project_content_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Entry Content Visibility', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_project_footer_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Entry Footer Visibility', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_project_hr1' => [
				'type' => 'separator',
			],

			'radius_docs_project_style' => [
				'type'        => 'select',
				'label'       => __( 'Blog Style', 'radius-docs' ),
				'description' => __( 'This option works only for project layout', 'radius-docs' ),
				'default'     => 'default',
				'choices'     => [
					'default' => __( 'Grid 1', 'radius-docs' ),
					'grid-2'  => __( 'Grid 2', 'radius-docs' ),
					'grid-3'  => __( 'Grid 3', 'radius-docs' ),
					'grid-4'  => __( 'Grid 4', 'radius-docs' ),
					'list'    => __( 'List 1', 'radius-docs' ),
					'list-2'  => __( 'List 2', 'radius-docs' ),
				]
			],

			'radius_docs_project_column' => [
				'type'        => 'select',
				'label'       => __( 'Grid Column', 'radius-docs' ),
				'description' => __( 'This option works only for large device', 'radius-docs' ),
				'default'     => 'default',
				'choices'     => [
					'default'   => __( 'Default From Theme', 'radius-docs' ),
					'col-lg-12' => __( '1 Column', 'radius-docs' ),
					'col-lg-6'  => __( '2 Column', 'radius-docs' ),
					'col-lg-4'  => __( '3 Column', 'radius-docs' ),
					'col-lg-3'  => __( '4 Column', 'radius-docs' ),
					'col-lg-20' => __( '5 Column', 'radius-docs' ),
				]
			],

			'radius_docs_project_excerpt_limit' => [
				'type'    => 'text',
				'label'   => __( 'Content Limit', 'radius-docs' ),
				'default' => '20',
			],

			'radius_docs_project_btn_radius' => [
				'type'    => 'number',
				'label'   => __( 'Readmore Button Radius', 'radius-docs' ),
				'default' => 6,
			],

			'radius_docs_project_pagination_style' => [
				'type'        => 'select',
				'label'       => __( 'Pagination Style', 'radius-docs' ),
				'description' => __( 'This option works only for project pagination style', 'radius-docs' ),
				'default'     => 'pagination-area',
				'choices'     => [
					'pagination-area'   => __( 'Default', 'radius-docs' ),
					'pagination-area-2' => __( 'Style 2', 'radius-docs' ),
				]
			],

			'radius_docs_project_masonry' => [
				'type'  => 'switch',
				'label' => __( 'Enable Masonry Layout', 'radius-docs' ),
			],

			'radius_docs_project_banner_title' => [
				'type'    => 'text',
				'label'   => __( 'Archive Banner Title', 'radius-docs' ),
				'default' => __( 'Our Projects', 'radius-docs' ),
			],

			'radius_docs_project_slug' => [
				'type'    => 'text',
				'label'   => __( 'Archive Slug', 'radius-docs' ),
				'default' => 'project',
			],

			'radius_docs_project_cat_slug' => [
				'type'    => 'text',
				'label'   => __( 'Category Slug', 'radius-docs' ),
				'default' => 'project-category',
			],

			'radius_docs_project_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Meta', 'radius-docs' ),
				'description' => __( 'You can sort meta by drag and drop', 'radius-docs' ),
				'placeholder' => __( 'Choose Meta', 'radius-docs' ),
				'multiselect' => true,
				'default'     => 'author,date,category',
				'choices'     => $meta_list,
			],

			'radius_docs_project_meta_heading' => [
				'type'  => 'heading',
				'label' => __( 'Details Page', 'radius-docs' ),
			],

			'radius_docs_project_single_post_style' => [
				'type'    => 'select',
				'label'   => __( 'Post View Style', 'radius-docs' ),
				'default' => '1',
				'choices' => Fns::single_post_style()
			],

			'radius_docs_project_single_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Single Meta', 'radius-docs' ),
				'description' => __( 'You can sort meta by drag and drop', 'radius-docs' ),
				'placeholder' => __( 'Choose Meta', 'radius-docs' ),
				'multiselect' => true,
				'default'     => 'author,date,category,comment',
				'choices'     => $meta_list,
			],
		] );
	}
}
