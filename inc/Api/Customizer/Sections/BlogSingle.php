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
 * BlogSingle class
 */
class BlogSingle extends Customizer {
	protected $section_blog_single = 'radius_docs_blog_single_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_blog_single,
			'title'       => __( 'Blog Single', 'radius-docs' ),
			'description' => __( 'Blog Single Section', 'radius-docs' ),
			'priority'    => 26
		] );

		Customize::add_controls( $this->section_blog_single, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {
		return apply_filters( 'radius_docs_single_controls', [

			'radius_docs_single_post_style' => [
				'type'    => 'select',
				'label'   => __( 'Post View Style', 'radius-docs' ),
				'default' => '1',
				'choices' => Fns::single_post_style()
			],

			'radius_docs_single_meta' => [
				'type'        => 'select2',
				'label'       => __( 'Choose Single Meta', 'radius-docs' ),
				'description' => __( 'You can sort meta by drag and drop', 'radius-docs' ),
				'placeholder' => __( 'Choose Meta', 'radius-docs' ),
				'multiselect' => true,
				'default'     => 'author,date,category,comment',
				'choices'     => Fns::blog_meta_list(),
			],

			'radius_docs_single_meta_style' => [
				'type'    => 'select',
				'label'   => __( 'Meta Style', 'radius-docs' ),
				'default' => 'meta-style-default',
				'choices' => Fns::meta_style()
			],

			'radius_docs_post_banner_single_title' => [
				'type'    => 'text',
				'label'   => __( 'Single Banner Title', 'radius-docs' ),
				'default' => __( 'Post Details', 'radius-docs' ),
			],

			'radius_docs_single_visibility_heading' => [
				'type'  => 'heading',
				'label' => __( 'Visibility Section', 'radius-docs' ),
			],

			'radius_docs_single_meta_visibility' => [
				'type'    => 'switch',
				'label'   => __( 'Meta Visibility', 'radius-docs' ),
				'default' => 1
			],

			'radius_docs_single_above_meta_visibility' => [
				'type'  => 'switch',
				'label' => __( 'Above Meta Visibility', 'radius-docs' ),
			],
			'radius_docs_single_tag_visibility'        => [
				'type'  => 'switch',
				'label' => __( 'Tag Visibility', 'radius-docs' ),
			],
			'radius_docs_single_share_visibility'      => [
				'type'  => 'switch',
				'label' => __( 'Share Visibility', 'radius-docs' ),
			],
			'radius_docs_single_profile_visibility'    => [
				'type'  => 'switch',
				'label' => __( 'Author Profile Visibility', 'radius-docs' ),
			],
			'radius_docs_single_caption_visibility'    => [
				'type'  => 'switch',
				'label' => __( 'Caption Visibility', 'radius-docs' ),
			],
			'radius_docs_single_navigation_visibility' => [
				'type'  => 'switch',
				'label' => __( 'Navigation Visibility', 'radius-docs' ),
			],
			'radius_docs_post_share'                   => [
				'type'        => 'select2',
				'label'       => __( 'Choose Share Media', 'radius-docs' ),
				'description' => __( 'You can sort meta by drag and drop', 'radius-docs' ),
				'placeholder' => __( 'Choose Media', 'radius-docs' ),
				'multiselect' => true,
				'default'     => 'facebook,twitter,linkedin',
				'choices'     => Fns::post_share_list(),
				'condition'   => [ 'radius_docs_single_share_visibility' ]
			],

			'radius_docs_post_single_related_heading' => [
				'type'  => 'heading',
				'label' => __( 'Post Single Related Option', 'radius-docs' ),
			],

			'radius_docs_post_related' => [
				'type'    => 'switch',
				'label'   => __( 'Related Visibility', 'radius-docs' ),
				'default' => 0
			],

			'radius_docs_post_related_title' => [
				'type'      => 'text',
				'label'     => __( 'Post Related Title', 'radius-docs' ),
				'default'   => __( 'Related Post', 'radius-docs' ),
				'condition' => [ 'radius_docs_post_related' ]
			],

			'radius_docs_post_related_limit' => [
				'type'      => 'number',
				'label'     => __( 'Related Item Limit', 'radius-docs' ),
				'default'   => 3,
				'condition' => [ 'radius_docs_post_related' ]
			],

			'radius_docs_post_related_query' => [
				'type'        => 'select',
				'label'       => __( 'Query Type', 'radius-docs' ),
				'description' => __( 'Post Query Type', 'radius-docs' ),
				'default'     => 'cat',
				'choices'     => [
					'cat'    => esc_html__( 'Posts in the same Categories', 'radius-docs' ),
					'tag'    => esc_html__( 'Posts in the same Tags', 'radius-docs' ),
					'author' => esc_html__( 'Posts by the same Author', 'radius-docs' ),
				],
				'condition'   => [ 'radius_docs_post_related' ]
			],

			'radius_docs_post_related_sort' => [
				'type'        => 'select',
				'label'       => __( 'Sort Order', 'radius-docs' ),
				'description' => __( 'Display Post Order', 'radius-docs' ),
				'default'     => 'recent',
				'choices'     => [
					'recent'   => esc_html__( 'Recent Posts', 'radius-docs' ),
					'rand'     => esc_html__( 'Random Posts', 'radius-docs' ),
					'modified' => esc_html__( 'Last Modified Posts', 'radius-docs' ),
					'popular'  => esc_html__( 'Most Commented posts', 'radius-docs' ),
					'views'    => esc_html__( 'Most Viewed posts', 'radius-docs' ),
				],
				'condition'   => [ 'radius_docs_post_related' ]
			],

		] );
	}


}
