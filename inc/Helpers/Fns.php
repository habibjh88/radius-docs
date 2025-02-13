<?php

namespace RT\RadiusDocs\Helpers;

use RT\RadiusDocs\Options\Opt;

/**
 * Theme Functions
 */
class Fns {

	/**
	 * Filters whether post thumbnail can be displayed.
	 *
	 * @param bool $show_post_thumbnail Whether to show post thumbnail.
	 *
	 */
	public static function can_show_post_thumbnail() {
		return apply_filters(
			'radius_docs_can_show_post_thumbnail',
			! post_password_required() && ! is_attachment() && has_post_thumbnail()
		);
	}

	/**
	 * Social icon for the site
	 * @return mixed|null
	 */
	public static function get_socials() {
		return apply_filters( 'radius_docs_socials_icon', [
			'facebook'  => [
				'title' => __( 'Facebook', 'radius-docs' ),
				'url'   => radius_docs_option( 'facebook' ),
			],
			'twitter'   => [
				'title' => __( 'Twitter', 'radius-docs' ),
				'url'   => radius_docs_option( 'twitter' ),
			],
			'linkedin'  => [
				'title' => __( 'Linkedin', 'radius-docs' ),
				'url'   => radius_docs_option( 'linkedin' ),
			],
			'youtube'   => [
				'title' => __( 'Youtube', 'radius-docs' ),
				'url'   => radius_docs_option( 'youtube' ),
			],
			'pinterest' => [
				'title' => __( 'Pinterest', 'radius-docs' ),
				'url'   => radius_docs_option( 'pinterest' ),
			],
			'instagram' => [
				'title' => __( 'Instagram', 'radius-docs' ),
				'url'   => radius_docs_option( 'instagram' ),
			],
			'skype'     => [
				'title' => __( 'Skype', 'radius-docs' ),
				'url'   => radius_docs_option( 'skype' ),
			],
			'tiktok'    => [
				'title' => __( 'TikTok', 'radius-docs' ),
				'url'   => radius_docs_option( 'tiktok' ),
			],
		] );

	}

	/**
	 * Get Sidebar lists
	 *
	 * @return array
	 */
	public static function sidebar_lists( $default_title = null ) {
		$sidebar_fields            = [];
		$sidebar_fields['default'] = $default_title ?? esc_html__( 'Choose Sidebar', 'radius-docs' );

		foreach ( self::default_sidebar() as $id => $sidebar ) {
			$sidebar_fields[ $sidebar['id'] ] = $sidebar['name'];
		}

		return $sidebar_fields;
	}

	/**
	 * Get image presets
	 *
	 * @param $name
	 * @param int $total
	 * @param string $type
	 *
	 * @return array
	 */
	public static function image_placeholder( $name, $total = 1, $type = 'png' ) {
		$presets = [];
		for ( $i = 1; $i <= $total; $i ++ ) {
			$image_name    = "customize/$name-$i.$type";
			$presets[ $i ] = [
				'image' => radius_docs_get_img( $image_name ),
				'name'  => __( 'Style', 'radius-docs' ) . ' ' . $i,
			];
		}

		return apply_filters( 'radius_docs_image_placeholder', $presets );
	}


	/**
	 * Convert HEX to RGB color
	 *
	 * @param $hex
	 *
	 * @return string
	 */
	public static function hex2rgb( $hex ) {
		$hex = str_replace( "#", "", $hex );
		if ( strlen( $hex ) == 3 ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgb = "$r, $g, $b";

		return $rgb;
	}

	/**
	 * Modify Color
	 * Add positive or negative $steps. Ex: 30, -50 etc
	 *
	 * @param $hex
	 * @param $steps
	 *
	 * @return string
	 */
	public static function modify_color( $hex, $steps ) {
		$steps = max( - 255, min( 255, $steps ) );
		// Format the hex color string
		$hex = str_replace( '#', '', $hex );
		if ( strlen( $hex ) == 3 ) {
			$hex = str_repeat( substr( $hex, 0, 1 ), 2 ) . str_repeat( substr( $hex, 1, 1 ), 2 ) . str_repeat( substr( $hex, 2, 1 ), 2 );
		}
		// Get decimal values
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
		// Adjust number of steps and keep it inside 0 to 255
		$r     = max( 0, min( 255, $r + $steps ) );
		$g     = max( 0, min( 255, $g + $steps ) );
		$b     = max( 0, min( 255, $b + $steps ) );
		$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
		$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
		$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

		return '#' . $r_hex . $g_hex . $b_hex;
	}


	/**
	 * Return Sidebar Column
	 * @return string
	 */
	public static function sidebar_columns() {
		$columns = "col-xl-4";

		return $columns;
	}

	/**
	 * Return content columns
	 * @return string
	 */
	public static function content_columns( $full_width_col = 'col-12' ) {
		$sidebar = Opt::$sidebar === 'default' ? 'radius-docs-sidebar' : Opt::$sidebar;
		$columns = ! is_active_sidebar( $sidebar ) ? $full_width_col : 'col-xl-8';
		if ( Opt::$layout === 'full-width' ) {
			$columns = $full_width_col;
		}

		return $columns;
	}

	public static function single_content_colums() {
		$sidebar = Opt::$sidebar === 'default' ? 'radius-docs-single-sidebar' : Opt::$sidebar;
		$columns = is_active_sidebar( $sidebar ) ? "col-xl-8" : "col-xl-10 col-md-offset-1";

		if ( Opt::$layout === 'full-width' ) {
			$columns = "col-xl-10 col-md-offset-1";
		}

		return $columns;
	}


	/**
	 * Get blog colum
	 * @return mixed|string
	 */
	public static function blog_column() {
		if ( ! empty( $_REQUEST['column'] ) ) {
			return sanitize_text_field( $_REQUEST['column'] );
		}
		$blog_colum_opt = radius_docs_option( 'radius_docs_blog_column' ) !== 'default' ? radius_docs_option( 'radius_docs_blog_column' ) : '';
		$blog_sidebar   = Opt::$sidebar === 'default' ? 'radius-docs-sidebar' : Opt::$sidebar;
		$blog_layout    = Opt::$layout ?? 'right-sidebar';

		$output = 'col-lg-4';
		if ( $blog_colum_opt ) {
			$output = $blog_colum_opt;
		} elseif ( radius_docs_option( 'radius_docs_blog_style' ) === 'list' ) {
			$output = 'col-lg-12';
		} elseif ( in_array( $blog_layout, [
				'left-sidebar',
				'right-sidebar'
			] ) && is_active_sidebar( $blog_sidebar ) ) {
			$output = 'col-lg-6';
		}

		return $output;
	}


	/**
	 * Get Archive colum
	 *
	 * @param $column
	 * @param $blog_style
	 *
	 * @return mixed|string
	 */
	public static function archive_column( $column, $blog_style ) {
		if ( ! empty( $_REQUEST['column'] ) ) {
			return sanitize_text_field( $_REQUEST['column'] );
		}
		$blog_colum_opt = $column !== 'default' ? $column : '';
		$blog_sidebar   = Opt::$sidebar === 'default' ? 'radius-docs-sidebar' : Opt::$sidebar;
		$blog_layout    = Opt::$layout ?? 'right-sidebar';
		$output         = 'col-lg-4';
		if ( $blog_colum_opt ) {
			$output = $blog_colum_opt;
		} else {
			$output = 'col-lg-12';
		}

		return $output;
	}

	/**
	 * Get all post type
	 * @return array
	 */
	public static function get_post_types() {
		$post_types = get_post_types(
			[
				'public' => true,
			],
			'objects'
		);
		$post_types = wp_list_pluck( $post_types, 'label', 'name' );

		$exclude = apply_filters( 'radius_docs_exclude_post_type', [
			'attachment',
			'revision',
			'nav_menu_item',
			'elementor_library',
			'e-landing-page',
		] );

		foreach ( $exclude as $ex ) {
			unset( $post_types[ $ex ] );
		}

		return $post_types;
	}

	/**
	 * Meta Style
	 * @return array
	 */
	public static function meta_style( $exclude = [] ) {
		$meta_style = [
			'meta-style-default' => __( 'Default From Theme', 'radius-docs' ),
			'meta-style-border'  => __( 'Border Style', 'radius-docs' ),
			'meta-style-dash'    => __( 'Before Dash ( — )', 'radius-docs' ),
			'meta-style-dash-bg' => __( 'Before Dash with BG ( — )', 'radius-docs' ),
			'meta-style-pipe'    => __( 'After Pipe ( | )', 'radius-docs' ),
		];

		if ( ! empty( $exclude ) && is_array( $exclude ) ) {
			foreach ( $exclude as $item ) {
				unset( $meta_style[ $item ] );
			}
		}

		return $meta_style;
	}

	/**
	 * Menu Alignment Dynamically
	 *
	 * @param $default_align
	 *
	 * @return mixed|string
	 */
	public static function menu_alignment( $default_align = '' ) {
		$default_align = "justify-content-$default_align";
		$menu_align    = radius_docs_option( 'radius_docs_menu_alignment' );
		if ( $menu_align ) {
			return $menu_align;
		} else {
			return $default_align;
		}
	}

	/**
	 * Single Style
	 * @return array
	 */
	public static function single_post_style( $exclude = [] ) {
		$meta_style = [
			'1' => __( 'Style 1 (Default From Theme)', 'radius-docs' ),
			'2' => __( 'Style 2 (Full-width Thumbnail)', 'radius-docs' ),
			'3' => __( 'Style 3 (Transparent Menu)', 'radius-docs' ),
			'4' => __( 'Style 4 (Content over on Thumb)', 'radius-docs' ),
		];

		if ( ! empty( $exclude ) && is_array( $exclude ) ) {
			foreach ( $exclude as $item ) {
				unset( $meta_style[ $item ] );
			}
		}

		return $meta_style;
	}

	/**
	 * Blog Meta Style
	 * @return array
	 */
	public static function blog_meta_list() {
		$meta_list = [
			'author'   => __( 'Author', 'radius-docs' ),
			'date'     => __( 'Date', 'radius-docs' ),
			'category' => __( 'Category', 'radius-docs' ),
			'tag'      => __( 'Tag', 'radius-docs' ),
			'comment'  => __( 'Comment', 'radius-docs' ),
		];

		if ( is_raw_addons() ) {
			$meta_list['reading'] = __( 'Reading', 'radius-docs' );
			$meta_list['view']    = __( 'Views', 'radius-docs' );
		}

		return $meta_list;
	}

	/**
	 * Post Social Meta
	 * @return array
	 */
	public static function post_share_list() {
		return [
			'facebook'  => __( 'Facebook', 'radius-docs' ),
			'twitter'   => __( 'Twitter X', 'radius-docs' ),
			'linkedin'  => __( 'Linkedin', 'radius-docs' ),
			'pinterest' => __( 'Pinterest', 'radius-docs' ),
			'whatsapp'  => __( 'Whatsapp', 'radius-docs' ),
			'youtube'   => __( 'Youtube', 'radius-docs' ),
		];
	}

	public static function single_meta_lists() {
		$meta_list = radius_docs_option( 'radius_docs_single_meta', '', true );
		if ( radius_docs_option( 'radius_docs_single_above_meta_visibility' ) ) {
			$category_index = array_search( 'category', $meta_list );
			unset( $meta_list[ $category_index ] );
		}

		return $meta_list;
	}

	/**
	 * Class list
	 *
	 * @param $clsses
	 *
	 * @return string
	 */
	public static function class_list( $clsses ): string {
		return trim( implode( ' ', $clsses ) );
	}

	/**
	 * Get all default sidebar args for theme
	 *
	 * @param $id
	 *
	 * @return array|mixed|null
	 */
	public static function default_sidebar( $id = '' ) {
		$sidebar_lists = [
			'main'    => [
				'id'    => 'radius-docs-sidebar',
				'name'  => __( 'Main Sidebar', 'radius-docs' ),
				'class' => 'radius-docs-sidebar',
			],
			'single'  => [
				'id'    => 'radius-docs-single-sidebar',
				'name'  => __( 'Single Sidebar', 'radius-docs' ),
				'class' => 'radius-docs-single-sidebar',
			],
			'page'    => [
				'id'    => 'radius-docs-page-sidebar',
				'name'  => __( 'Page Sidebar', 'radius-docs' ),
				'class' => 'radius-docs-page-sidebar',
			],
			'service' => [
				'id'    => 'radius-docs-service-sidebar',
				'name'  => __( 'Service Sidebar', 'radius-docs' ),
				'class' => 'radius-docs-service-sidebar',
			],
			'project' => [
				'id'    => 'radius-docs-project-sidebar',
				'name'  => __( 'Project Sidebar', 'radius-docs' ),
				'class' => 'radius-docs-project-sidebar',
			],
			'footer'  => [
				'id'    => 'radius-docs-footer-sidebar',
				'name'  => 'Footer Sidebar',
				'class' => 'footer-sidebar col-lg-3 col-md-6',
			],
		];
		if ( class_exists( 'WooCommerce' ) ) {
			$sidebar_lists['woo-archive'] = [
				'id'    => 'radius-docs-woo-archive-sidebar',
				'name'  => __( 'WooCommerce Archive Sidebar', 'radius-docs' ),
				'class' => 'woo-archive-sidebar',
			];
			$sidebar_lists['woo-single']  = [
				'id'    => 'radius-docs-woo-single-sidebar',
				'name'  => __( 'WooCommerce Single Sidebar', 'radius-docs' ),
				'class' => 'woo-single-sidebar',
			];
		}
		$sidebar_lists = apply_filters( 'radius_docs_sidebar_lists', $sidebar_lists );
		if ( ! $id ) {
			return $sidebar_lists;
		}
		if ( isset( $sidebar_lists[ $id ] ) ) {
			return $sidebar_lists[ $id ]['id'];
		}

		return [];
	}

	/**
	 * Custom Image Attributes
	 *
	 * @param $key
	 *
	 * @return string
	 */
	public static function customize_image_attr_css( $key ) {

		if ( empty( radius_docs_option( $key ) ) ) {
			return '';
		}

		$bg_attr = json_decode( radius_docs_option( $key ), ARRAY_A );

		$css = '';
		if ( ! empty( $bg_attr['position'] ) ) {
			$css .= "background-position:{$bg_attr['position']};";
		}
		if ( ! empty( $bg_attr['attachment'] ) ) {
			$css .= "background-attachment:{$bg_attr['attachment']};";
		}
		if ( ! empty( $bg_attr['repeat'] ) ) {
			$css .= "background-repeat:{$bg_attr['repeat']};";
		}
		if ( ! empty( $bg_attr['size'] ) ) {
			$css .= "background-size:{$bg_attr['size']};";
		}

		return $css;
	}

	/**
	 * Sanitize Text Field
	 *
	 * @param $input
	 * @param $default
	 * @param $mode
	 *
	 * @return mixed|string
	 */
	public static function sanitize( $input, $default = '', $mode = '' ) {

		$data = $input ?? $default;

		if ( 'html' === $mode ) {
			return radius_docs_html( $data, false );
		}

		return sanitize_text_field( $data );
	}

	/**
	 * Prints HTMl.
	 *
	 * @param $html
	 * @param $allHtml
	 *
	 * @return void
	 */
	public static function print_html_all( $html, $allHtml = false ) {
		if ( ! $html ) {
			return;
		}
		if ( $allHtml ) {
			echo stripslashes_deep( $html ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		} else {
			echo wp_kses_post( stripslashes_deep( $html ) );
		}
	}

	/**
	 * Get Layout Meta
	 *
	 * @param $post_id
	 * @param $key
	 *
	 * @return mixed|string
	 */
	public static function layout_meta( $post_id, $key ) {
		$meta = get_post_meta( $post_id, "radius_docs_layout_meta_data", true );

		return $meta[ $key ] ?? '';
	}

	public static function isColorDark( $hex = '' ) {
		if ( '' == $hex ) {
			return;
		}
		// Remove the hash at the start if it's there
		$hex = str_replace( '#', '', $hex );

		// Convert hex to RGB
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );

		// Calculate the brightness (luminance)
		// Using the formula for luminance: (0.299 * R + 0.587 * G + 0.114 * B)
		$luminance = ( 0.299 * $r + 0.587 * $g + 0.114 * $b ) / 255;

		// Return true if the color is dark, otherwise false
		return $luminance < 0.8;
	}

}
