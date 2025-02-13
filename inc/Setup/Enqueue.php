<?php

namespace RT\RadiusDocs\Setup;

use RT\RadiusDocs\Helpers\Constants;
use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Traits\SingletonTraits;

/**
 * Enqueue Class
 */
class Enqueue {
	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ], 12 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 15 );
	}

	/**
	 * Register all scripts
	 *
	 * @return void
	 */
	function register_scripts() {
		wp_register_style( 'radius-docs-gfonts', $this->fonts_url(), [], Constants::get_version() );

		wp_register_script( 'radius-docs-counterup', radius_docs_get_js( 'counterup' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-newsticker', radius_docs_get_js( 'newsticker' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-waypoints', radius_docs_get_js( 'waypoints' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-parallex', radius_docs_get_js( 'parallex' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-appear', radius_docs_get_js( 'appear' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-magnific-popup', radius_docs_get_js( 'magnific-popup' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-nice-select', radius_docs_get_js( 'nice-select' ), [ 'jquery' ], Constants::get_version(), true );
		//wp_register_script( 'radius-docs-isotope', radius_docs_get_js( 'isotope.min' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-slick', radius_docs_get_js( 'slick' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-wow', radius_docs_get_js( 'wow.min' ), [ 'jquery' ], Constants::get_version(), true );
		wp_register_script( 'radius-docs-script', radius_docs_get_js( 'scripts' ), [ 'jquery' ], Constants::get_version(), true );

	}

	/**
	 * Enqueue all necessary scripts and styles for the theme
	 * @return void
	 */
	public function enqueue_scripts() {


		// CSS
		wp_enqueue_style( 'radius-docs-gfonts' );
		wp_enqueue_style( 'radius-docs-main', radius_docs_get_css( 'style', true ), [], Constants::get_version() );

		// JS
		if ( radius_docs_option( 'radius_docs_blog_masonry' ) && ( is_home() || is_archive() ) ) {
			wp_enqueue_script( 'jquery-masonry' );
		}
		wp_enqueue_script( 'radius-docs-appear', radius_docs_get_js( 'appear' ), [ 'jquery' ], Constants::get_version(), true );
		//wp_enqueue_script( 'radius-docs-isotope', radius_docs_get_js( 'isotope.min' ), [ 'jquery' ], Constants::get_version(), true );
//		wp_enqueue_script( 'radius-docs-slick' );
//		wp_enqueue_script( 'radius-docs-magnific-popup' );
		wp_enqueue_script( 'radius-docs-wow' );
		wp_enqueue_script( 'radius-docs-script' );

		// Extra
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}


	/**
	 * Making google font url
	 *
	 * @return string
	 */
	public function fonts_url() {

		if ( 'off' === _x( 'on', 'Google font: on or off', 'radius-docs' ) ) {
			return '';
		}

		//Default variable.
		$subsets = '';

		$body_font = json_decode( radius_docs_option( 'radius_docs_body_typo' ), true );
		$menu_font = json_decode( radius_docs_option( 'radius_docs_menu_typo' ), true );
		$h_font    = json_decode( radius_docs_option( 'radius_docs_all_heading_typo' ), true );

		$bodyFont = $body_font['font'] ?? 'Urbanist'; // Body Font
		$menuFont = $menu_font['font'] ?? $bodyFont; // Menu Font
		$hFont    = $h_font['font'] ?? $body_font; // Heading Font
		$hFontW   = $h_font['regularweight'] ?? null;

		$heading_fonts = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];

		foreach ( $heading_fonts as $heading ) {
			$heading_font         = json_decode( radius_docs_option( "radius_docs_heading_{$heading}_typo" ), true );
			${$heading . '_font'} = $heading_font;
			${$heading . 'Font'}  = ''; //Assign default value if not exist the value
			if ( ! empty( $heading_font['font'] ) ) {
				${$heading . 'Font'}  = $heading_font['font'] == 'Inherit' ? $hFont : $heading_font['font'];
				${$heading . 'FontW'} = $heading_font['font'] == 'Inherit' ? $hFontW : $heading_font['regularweight'];
			}
		}

		$check_families = [];
		$font_families  = [];

		// Body Font
		$font_families[]  = $bodyFont . ':300,400,500,600,700,800,900';
		$check_families[] = $bodyFont;

		// Menu Font
		if ( ! in_array( $menuFont, $check_families ) ) {
			$font_families[]  = $menuFont . ':300,400,500,600,700,800,900';
			$check_families[] = $menuFont;
		}

		// Heading Font
		if ( ! in_array( $hFont, $check_families ) ) {
			$font_families[]  = $hFont . ':300,400,500,600,700,800,900';
			$check_families[] = $hFont;
		}

		//Check all heading fonts
		foreach ( $heading_fonts as $heading ) {
			$hDynamic = ${$heading . '_font'};
			if ( ! empty( $hDynamic['font'] ) ) {
				if ( ! in_array( ${$heading . 'Font'}, $check_families ) ) {
					$font_families[]  = ${$heading . 'Font'} . ':' . ${$heading . 'FontW'};
					$check_families[] = ${$heading . 'Font'};
				}
			}
		}

		$final_fonts = array_unique( $font_families );
		$query_args  = [
			'family'  => urlencode( implode( '|', $final_fonts ) ),
			'display' => urlencode( 'fallback' ),
		];

		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );

		return esc_url_raw( $fonts_url );
	}
}


