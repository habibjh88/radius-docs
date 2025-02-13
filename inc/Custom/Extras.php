<?php

namespace RT\RadiusDocs\Custom;

use RT\RadiusDocs\Modules\Svg;
use RT\RadiusDocs\Traits\SingletonTraits;
use RT\RadiusDocs\Options\Opt;

/**
 * Extras.
 */
class Extras {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 */
	public function __construct() {
		add_filter( 'body_class', [ $this, 'body_class' ] );
		add_action( 'after_switch_theme', [ $this, 'rewrite_flush' ] );
		add_action( 'pre_get_posts', [ $this, 'custom_pagesize' ], 1 );
		add_action( 'wp_head', [ $this, 'social_share_meta' ] );
		add_action( 'template_redirect', [ $this, 'w3c_validator' ] );
	}

	/**
	 * Body Class added
	 *
	 * @param $classes
	 *
	 * @return mixed
	 */
	public function body_class( $classes ) {

		// Adds a class of group-blog to blogs with more than 1 published author.
		$classes[] = 'radius-docs-theme';

		$classes[] = 'radius-docs-header-' . Opt::$header_style;
		$classes[] = 'radius-docs-footer-' . Opt::$footer_style;
		$classes[] = 'radius-docs-banner-' . Opt::$banner_style;

		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		if ( Opt::$has_tr_header ) {
			$classes[] = 'has-trheader';
		} else {
			$classes[] = 'no-trheader';
		}

		if ( Opt::$has_tr_header && ! empty( Opt::$header_tr_color ) ) {
			$classes[] = Opt::$header_tr_color;
		}

		if ( radius_docs_option( 'radius_docs_tr_header_shadow' ) ) {
			$classes[] = 'has-menu-shadow';
		}

		if ( Opt::$has_banner && ! is_front_page() ) {
			$classes[] = 'has-banner';
		} else {
			$classes[] = 'no-banner';
		}

		if ( Opt::$layout ) {
			$classes[] = 'layout-' . Opt::$layout;
		}

		if ( radius_docs_option( 'radius_docs_sticy_header' ) ) {
			$classes[] = 'has-sticky-header';
		}

		if ( is_singular() && Opt::$single_style ) {
			$classes[] = 'radius-docs-single-' . Opt::$single_style;
		}

		return $classes;
	}


	/**
	 * Modify Main Query
	 *
	 * @param $query
	 *
	 * @return void
	 */
	function custom_pagesize( $query ) {

		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		if ( is_post_type_archive( 'radius-docs-service' ) || is_tax( "radius-docs-service-category" ) ) {
			$service_post_number = radius_docs_option( 'radius_docs_service_item_number' );
			$query->set( 'posts_per_page', $service_post_number );
		}

		if ( is_post_type_archive( 'radius-docs-project' ) || is_tax( "radius-docs-project-category" ) ) {
			$project_post_number = radius_docs_option( 'radius_docs_project_item_number' );
			$query->set( 'posts_per_page', $project_post_number );
		}

	}


	/**
	 * Flush Rewrite on CPT activation
	 *
	 * @return empty
	 */
	public function rewrite_flush() {
		// Flush the rewrite rules only on theme activation
		flush_rewrite_rules();
	}


	/**
	 * Input meta code in head for social share
	 *
	 * @return void
	 */
	public function social_share_meta() {
		global $post;

		if ( ! isset( $post ) ) {
			return;
		}

		$title = get_the_title();

		if ( is_singular( 'post' ) ) {
			$link = get_the_permalink() . '?v=' . time();
			echo '<meta property="og:url" content="' . $link . '" />';
			echo '<meta property="og:type" content="article" />';
			echo '<meta property="og:title" content="' . $title . '" />';

			if ( ! empty( $post->post_content ) ) {
				echo '<meta property="og:description" content="' . wp_trim_words( $post->post_content,
						150 ) . '" />';
			}
			$attachment_id = get_post_thumbnail_id( $post->ID );
			if ( ! empty( $attachment_id ) ) {
				$thumbnail = wp_get_attachment_image_src( $attachment_id, 'full' );
				if ( ! empty( $thumbnail ) ) {
					$attachment   = get_post( $attachment_id );
					$thumbnail[0] .= '?v=' . time();
					echo '<meta property="og:image" content="' . $thumbnail[0] . '" />';
					echo '<link itemprop="thumbnailUrl" href="' . $thumbnail[0] . '">';
					echo '<meta property="og:image:type" content="' . $attachment->post_mime_type . '">';
				}
			}
			echo '<meta property="og:site_name" content="' . get_bloginfo( 'name' ) . '" />';
			echo '<meta name="twitter:card" content="summary" />';
			echo '<meta property="og:updated_time" content="' . time() . '" />';
		}
	}

	/**
	 * W3C validator passing code
	 *
	 * @return void
	 */
	public function w3c_validator() {
		ob_start( function ( $buffer ) {
			return str_replace( array( '<script type="text/javascript">', "<script type='text/javascript'>" ), '<script>', $buffer );
		} );
		ob_start( function ( $buffer ) {
			return str_replace( array( "<script type='text/javascript' src" ), '<script src', $buffer );
		} );
		ob_start( function ( $buffer ) {
			return str_replace( array( 'type="text/css"', "type='text/css'", 'type="text/css"', ), '', $buffer );
		} );
		ob_start( function ( $buffer ) {
			return str_replace( array( '<iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0"', ), '<iframe', $buffer );
		} );
		ob_start( function ( $buffer ) {
			return str_replace( array( 'aria-required="true"', ), '', $buffer );
		} );
	}

}
