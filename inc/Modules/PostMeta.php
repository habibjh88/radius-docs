<?php

namespace RT\RadiusDocs\Modules;

use RT\RadiusDocs\Helpers\Fns;
use RawAddons\Helper\Fns as RawFns;

/**
 * PostMeta Class
 */
class PostMeta {

	/**
	 * Get Post Meta
	 *
	 * @param $args
	 *
	 * @return void
	 */
	public static function get_meta( $post_tyle = 'post', $args = [] ) {

		if ( 'radius-docs-project' === $post_tyle ) {
			$meta_list       = radius_docs_option( 'radius_docs_project_meta', '', true );
			$category_source = self::posted_in( 'radius-docs-project-category' );
			$tag_source      = false;
		} elseif ( 'radius-docs-service' === $post_tyle ) {
			$meta_list       = radius_docs_option( 'radius_docs_service_meta', '', true );
			$category_source = self::posted_in( 'radius-docs-service-category' );
			$tag_source      = false;
		} else {
			$meta_list       = radius_docs_option( 'radius_docs_blog_meta', '', true );
			$category_source = self::posted_in();
			$tag_source      = self::posted_in( 'post_tag' );
		}

		$default_args = [
			'with_list'     => true,
			'with_icon'     => true,
			'include'       => $meta_list,
			'class'         => '',
			'author_prefix' => radius_docs_option( 'radius_docs_author_prefix' ),
			'with_avatar'   => radius_docs_option( 'radius_docs_meta_user_avatar' ),
			'avatar_size'   => 30,
			'category'      => 'category',
			'tag'           => 'post_tag',
		];

		$args = wp_parse_args( $args, $default_args );

		$comments_number = get_comments_number();
		/* translators: used comment as singular and plular */
		$comments_text = sprintf( _n( '%s Comment', '%s Comments', $comments_number, 'radius-docs' ), number_format_i18n( $comments_number ) );

		$_meta_data = [];
		$output     = '';

		$_meta_data['author'] = self::posted_by( $args['author_prefix'] );
		$_meta_data['date']   = self::posted_on();
		if ( ! empty( $category_source ) ) {
			$_meta_data['category'] = $category_source;
		}
		if ( ! empty( $tag_source ) ) {
			$_meta_data['tag'] = $tag_source;
		}
		$_meta_data['comment'] = $comments_text;
		
		if ( is_raw_addons() ) {
			$_meta_data['view']    = RawFns::post_views_count();
			$_meta_data['reading'] = RawFns::reading_time_count( get_the_content(), true );
		}

		$meta_list = $args['include'] ?? array_keys( $_meta_data );

		if ( $args['with_list'] ) {
			$output .= '<div class="blog-post-meta ' . $args['class'] . '"><ul class="entry-meta">';
		}
		foreach ( $meta_list as $key ) {
			if ( empty( $_meta_data[ $key ] ) ) {
				continue;
			}
			$meta = $_meta_data[ $key ];
			$icons = self::get_icon( $key );

			if ( $args['with_avatar'] && 'author' === $key ) {
				$icons = get_avatar( get_the_author_meta( 'ID' ), $args['avatar_size'], '', 'Avater Image' );
			}

			$output .= ( $args['with_list'] ) ? '<li class="' . $key . '">' : '';
			$output .= '<span class="meta-inner ' . $key . '">';
			$output .= $args['with_icon'] ? $icons : null;
			$output .= $meta;
			$output .= '</span>';
			$output .= ( $args['with_list'] ) ? '</li>' : '';
		}

		if ( $args['with_list'] ) {
			$output .= '</ul></div>';
		}

		Fns::print_html_all( $output );
	}

	/**
	 * Get Post Author
	 *
	 * @param $prefix
	 *
	 * @return string
	 */
	public static function posted_by( $prefix = '' ) {

		return sprintf(
		// Translators: %1$s is the prefix, %2$s is the author's byline.
			esc_html__( '%1$s %2$s', 'radius-docs' ),
			$prefix ? '<span class="prefix">' . $prefix . '</span>' : '',
			'<span class="byline"><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" rel="author">' . esc_html( get_the_author() ) . '</a></span>'
		);
	}

	/**
	 * Prints HTML with meta information for the current post-date/time.
	 *
	 * @return string
	 */
	public static function posted_on() {
		$time_string = sprintf(
			'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() )
		);

		return sprintf( '<span class="posted-on">%s</span>', $time_string );
	}


	/*	public static function posted_in_old( $tax_id = 'category' ) {
			$tax = get_the_term_list( 0, $tax_id, '', self::list_item_separator(), '' );

			$meta_color = get_term_meta( $term->term_id, 'radius_docs_category_color', true );

			if ( $tax && ! is_wp_error( $tax ) ) {
				return sprintf(
					'<span class="%s-links">%s</span>',
					$tax_id,
					$tax
				);
			}

			return '';
		}*/


	public static function posted_in( $taxonomy = 'category' ) {
		$post_id = get_the_ID();
		$terms   = get_the_terms( $post_id, $taxonomy );

		if ( is_wp_error( $terms ) ) {
			return $terms;
		}

		if ( empty( $terms ) ) {
			return false;
		}

		$links = [];

		foreach ( $terms as $term ) {
			$meta_color      = get_term_meta( $term->term_id, 'radius_docs_category_color', true );
			$color_pref      = Fns::isColorDark( $meta_color ) ? 'dark-bg' : 'bright-bg';
			$meta_color_code = $meta_color ? '--radius-docs-cat-color:#' . ltrim( $meta_color, '#' ) : '';
			$has_bg          = $meta_color ? "has-bg $color_pref" : '';
			$link            = get_term_link( $term, $taxonomy );
			if ( is_wp_error( $link ) ) {
				return $link;
			}

			$links[] = '<a class="' . esc_attr( $term->slug . ' ' . $has_bg ) . '" style="' . esc_attr( $meta_color_code ) . '" href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';

		}

		$before = "<span class='{$taxonomy}-links'>";
		$after  = "</span>";
		$sep    = self::list_item_separator();

		return $before . implode( $sep, $links ) . $after;
	}

	/**
	 * List Itesm Separator
	 *
	 * @return string
	 */
	public static function list_item_separator() {
		/* translators: Used between list items, there is a space after the comma. */
		return sprintf(
			"<span class='%s'>%s</span>",
			'sp',
			__( ', ', 'radius-docs' )
		);
	}


	public static function get_icon( $icon ) {
		switch ( $icon ) {
			case 'author':
				return "<i class='raw-icon-user'></i>";
			case 'date' :
				return "<i class='raw-icon-calendar'></i>";
			case 'category' :
				return "<i class='raw-icon-folder'></i>";
			case 'tag' :
				return "<i class='raw-icon-tags'></i>";
			case 'view' :
				return "<i class='raw-icon-eye'></i>";
			case 'reading' :
				return "<i class='raw-icon-signal-alt'></i>";
			default:
				return "<i class='raw-icon-{$icon}'></i>";
		}

	}
}
