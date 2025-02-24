<?php

namespace RT\RadiusDocs\Custom;

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Modules\PostMeta;
use RT\RadiusDocs\Modules\Thumbnail;
use RT\RadiusDocs\Traits\SingletonTraits;
use RT\RadiusDocs\Options\Opt;

/**
 * Hooks Class
 */
class PostAttribute {

	use SingletonTraits;

	protected $allowPostType;

	/**
	 * Register default hooks and actions for WordPress
	 */
	public function __construct() {
		$this->allowPostType = [ 'post', 'docs' ];
		add_action( 'init', [ $this, 'add_post_attributes' ], 500 );
		add_action( 'registered_post_type', [ $this, 'hierarchy_for_custom_post' ], 123, 2 );
		add_filter( 'post_type_labels_post', [ $this, 'enable_hierarchy_fields_for_js' ], 11, 2 );
		add_filter( 'pre_post_link', [ $this, 'change_permalinks' ], 8, 3 );
		add_filter( 'pre_get_posts', [ $this, 'method__query' ], 888 );
	}

	/**
	 * Modify post permalinks to include parent slugs
	 */
	public function change_permalinks( $permalink, $post = false, $leavename = false ) {
		if ( is_object( $post ) && in_array( $post->post_type, $this->allowPostType ) ) {
			if ( false === strpos( $permalink, '%postname%' ) ) {
				return $permalink;
			}
			$path      = str_replace( '%postname%', $this->get_parent_slugs( $post ) . '/' . '%postname%', $permalink );
			$permalink = str_replace( '//', '/', $path );
		}

		return $permalink;
	}

	/**
	 * Make posts and docs hierarchical
	 */
	public function hierarchy_for_custom_post( $post_type, $post_type_object ) {
		if ( in_array( $post_type, $this->allowPostType ) ) {
			$post_type_object->hierarchical = true;
		}
	}

	/**
	 * Enable parent field in the admin UI
	 */
	public function enable_hierarchy_fields_for_js( $labels ) {
		$labels->parent_item_colon = 'Parent Post';

		return $labels;
	}

	/**
	 * Modify main query to detect custom paths
	 */
	public function method__query( $query ) {
		if ( $query->is_main_query() && ! is_admin() ) {
			$possible_post_path = trailingslashit( preg_replace_callback( '/(.*?)\/(page|feed|rdf|rss|rss2|atom)\/.*?/i', function( $matches ) {
				return $matches[1];
			}, $this->path_after_blog_s() ) );

			if ( substr_count( $possible_post_path, '/' ) >= 2 ) {
				$post = get_page_by_path( $possible_post_path, OBJECT, $this->allowPostType );
				if ( $post ) {
					$query->set( 'post_type', array_merge( (array) $query->get( 'post_type' ), [ $post->post_type ] ) );
					$query->is_home           = false;
					$query->is_single         = true;
					$query->is_singular       = true;
					$query->queried_object_id = $post->ID;
					$query->set( 'page_id', $post->ID );
				}
			}
		}
	}

	/**
	 * Retrieve parent slugs for hierarchical post types
	 */
	public function get_parent_slugs( $post ) {
		$final_SLUGG = '';
		if ( ! empty( $post->post_parent ) ) {
			$parent_post = get_post( $post->post_parent );
			while ( ! empty( $parent_post ) ) {
				$final_SLUGG = $parent_post->post_name . '/' . $final_SLUGG;
				$parent_post = ! empty( $parent_post->post_parent ) ? get_post( $parent_post->post_parent ) : null;
			}
			if ( ! empty( $final_SLUGG ) ) {
				$final_SLUGG = '/' . trim( $final_SLUGG, '/' );
			}
		}

		return $final_SLUGG;
	}

	/**
	 * Extract path after the blog prefix
	 */
	public function path_after_blog_s() {
		$prf  = $this->get_blog_prefix_s();
		$path = isset( $_SERVER['REQUEST_URI'] ) ? substr( $_SERVER['REQUEST_URI'], strlen( home_url( '/', 'relative' ) ) ) : '';

		return ( ( $prf == '/blog' ) ? str_replace( '/blog/', '', '/' . $path ) : $path );
	}

	/**
	 * Get blog prefix if applicable
	 */
	private function get_blog_prefix_s() {
		$blog_prefix = '';
		if ( is_multisite() && ! is_subdomain_install() && is_main_site() && 0 === strpos( get_option( 'permalink_structure' ), '/blog/' ) ) {
			$blog_prefix = '/blog';
		}

		return $blog_prefix;
	}

	/**
	 * Add page attributes to post and docs
	 */
	public function add_post_attributes() {
		foreach ( $this->allowPostType as $post_type ) {
			add_post_type_support( $post_type, 'page-attributes' );
		}
	}

}
