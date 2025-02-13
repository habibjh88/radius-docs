<?php

namespace RT\RadiusDocs\Options;

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Traits\SingletonTraits;

/**
 * Layouts Class
 */
class Layouts {

	use SingletonTraits;

	public $base;
	public $type;
	public $meta_value;

	/**
	 * Class Constructor
	 */
	public function __construct() {
		add_action( 'template_redirect', [ $this, 'set_options_value' ] );
		add_action( 'template_redirect', [ $this, 'overwrite_options_value' ] );
	}

	/**
	 * Set Options value
	 *
	 * @return void
	 */
	public function set_options_value() {

		// Single Pages
		if ( ( is_single() || is_page() ) ) {
			$post_type        = get_post_type();
			$post_id          = get_the_id();
			$this->meta_value = get_post_meta( $post_id, "radius_docs_layout_meta_data", true );

			switch ( $post_type ) {
				case 'post':
					$this->type = 'single_post';
					break;
				case 'product' :
					$this->type = 'woocommerce_single';
					break;
				case 'radius-docs-service' :
					$this->type = 'service-single';
					break;
				case 'radius-docs-project' :
					$this->type = 'project-single';
					break;
				default:
					$this->type = 'page';
			}

			Opt::$layout           = $this->check_meta_and_layout_value( 'layout', false, true );
			Opt::$topbar_style     = $this->check_meta_and_layout_value( 'topbar_style', false, true );
			Opt::$header_style     = $this->check_meta_and_layout_value( 'header_style', false, true );
			Opt::$sidebar          = $this->check_meta_and_layout_value( 'sidebar', false, true );
			Opt::$header_width     = $this->check_meta_and_layout_value( 'header_width' );
			Opt::$menu_alignment   = $this->check_meta_and_layout_value( 'menu_alignment' );
			Opt::$padding_top      = $this->check_meta_and_layout_value( 'padding_top' );
			Opt::$padding_bottom   = $this->check_meta_and_layout_value( 'padding_bottom' );
			Opt::$banner_style     = $this->check_meta_and_layout_value( 'banner_style', false, true );
			Opt::$banner_image     = $this->check_meta_and_layout_value( 'banner_image', false, true );
			Opt::$banner_color     = $this->check_meta_and_layout_value( 'banner_color', false, true );
			Opt::$banner_height    = $this->check_meta_and_layout_value( 'banner_height', false, true );
			Opt::$footer_style     = $this->check_meta_and_layout_value( 'footer_style', false, true );
			Opt::$footer_schema    = $this->check_meta_and_layout_value( 'footer_schema', false, true );
			Opt::$has_top_bar      = $this->check_meta_and_layout_value( 'top_bar', true, true );
			Opt::$has_tr_header    = $this->check_meta_and_layout_value( 'tr_header', true, true );
			Opt::$breadcrumb_title = $this->check_meta_and_layout_value( 'breadcrumb_title', true, true );
			Opt::$has_breadcrumb   = $this->check_meta_and_layout_value( 'breadcrumb', true, true );
			Opt::$has_banner       = $this->check_meta_and_layout_value( 'banner', true, true );
			Opt::$single_style     = $this->check_meta_option_value( 'single_post_style' );
			Opt::$pagebgimg        = $this->check_meta_and_layout_value( 'page_bg_image', false, true );
			Opt::$pagebgcolor      = $this->check_meta_and_layout_value( 'page_bg_color', false, true );
			Opt::$header_tr_color  = $this->check_meta_and_layout_value( 'tr_header_color' );

		} // Blog and Archive
		elseif ( is_home() || is_archive() || is_search() || is_404() ) {
			if ( class_exists( 'WooCommerce' ) && is_shop() ) {
				$this->type = 'woo-archive';
			} elseif ( is_post_type_archive( "radius-docs-service" ) || is_tax( "radius-docs-service-category" ) ) {
				$this->type = 'radius-docs-service';
			} elseif ( is_post_type_archive( "radius-docs-project" ) || is_tax( "radius-docs-project-category" ) ) {
				$this->type = 'radius-docs-project';
			} elseif ( is_404() ) {
				$this->type = 'error';
			} else {
				$this->type = 'blog';
			}

			Opt::$layout           = $this->check_option_value( 'layout', false, true );
			Opt::$topbar_style     = $this->check_option_value( 'topbar_style', false, true );
			Opt::$header_style     = $this->check_option_value( 'header_style', false, true );
			Opt::$sidebar          = $this->check_option_value( 'sidebar', false, true );
			Opt::$header_width     = $this->check_option_value( 'header_width' );
			Opt::$menu_alignment   = $this->check_option_value( 'menu_alignment' );
			Opt::$padding_top      = $this->check_option_value( 'padding_top' );
			Opt::$padding_bottom   = $this->check_option_value( 'padding_bottom' );
			Opt::$banner_style     = $this->check_option_value( 'banner_style', false, true );
			Opt::$banner_image     = $this->check_option_value( 'banner_image', false, true );
			Opt::$banner_color     = $this->check_option_value( 'banner_color', false, true );
			Opt::$banner_height    = $this->check_option_value( 'banner_height', false, true );
			Opt::$footer_style     = $this->check_option_value( 'footer_style', false, true );
			Opt::$footer_schema    = $this->check_option_value( 'footer_schema', false, true );
			Opt::$has_top_bar      = $this->check_option_value( 'top_bar', true, true );
			Opt::$has_tr_header    = $this->check_option_value( 'tr_header', true, true );
			Opt::$breadcrumb_title = $this->check_option_value( 'breadcrumb_title', true, true );
			Opt::$has_breadcrumb   = $this->check_option_value( 'breadcrumb', true, true );
			Opt::$has_banner       = $this->check_option_value( 'banner', true, true );
			Opt::$pagebgimg        = $this->check_option_value( 'page_bg_image', false, true );
			Opt::$pagebgcolor      = $this->check_option_value( 'page_bg_color', false, true );
			Opt::$header_tr_color  = $this->check_option_value( 'tr_header_color' );

		}
	}

	/**
	 * Get Meta and Options value conditionally
	 *
	 * @param $key
	 * @param $is_bool
	 *
	 * @return bool|mixed|string
	 */
	private function check_meta_and_layout_value( $key, $is_bool = false, $check_layout = false ) {
		$option_key      = $this->type . '_' . $key;
		$meta_value      = $this->meta_value[ $key ] ?? 'default';
		$opt_from_layout = Opt::$options[ $option_key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'radius_docs_' . $key ] ?? 'default';

		if ( ! empty( $meta_value ) && $meta_value != 'default' ) { //Check from Meta
			$result = $meta_value;
		} elseif ( $check_layout && ! empty( $opt_from_layout ) && $opt_from_layout != 'default' ) { //Check from Layout
			$result = $opt_from_layout;
		} else { //Set global option
			$result = $opt_from_global;
		}

		if ( $is_bool ) {
			if ( $result == 1 ) {
				$result = intval( $result );
			}

			return $result === 1 || $result === 'on';
		}

		return $result;
	}

	/**
	 * Get Options value only
	 *
	 * @param $key
	 * @param bool $is_bool
	 *
	 * @return bool|mixed|string
	 */
	private function check_option_value( $key, $is_bool = false, $check_layout = false ) {
		$option_key = $this->type . '_' . $key;

		$opt_from_layout = Opt::$options[ $option_key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'radius_docs_' . $key ] ?? 'default';

		if ( $check_layout && ! empty( $opt_from_layout ) && $opt_from_layout != 'default' ) {
			$result = $opt_from_layout;
		} else {
			$result = $opt_from_global;
		}

		if ( $is_bool ) {
			if ( $result == 1 ) {
				$result = intval( $result );
			}

			return $result === 1 || $result === 'on';
		}

		return $result;
	}

	/**
	 * Check meta vs options value
	 *
	 * @param $key
	 *
	 * @return mixed|string
	 */
	private function check_meta_option_value( $key ) {
		$meta_value      = $this->meta_value[ $key ] ?? 'default';
		$opt_from_global = Opt::$options[ 'radius_docs_' . $key ] ?? 'default';

		if ( ! empty( $meta_value ) && $meta_value != 'default' ) { //Check from Meta
			$result = $meta_value;
		} else {
			$result = $opt_from_global;
		}

		return $result;
	}

	/**
	 * Overwrite option value forcefully in the runtime
	 *
	 * @return void
	 */
	public function overwrite_options_value() {

		//Single layout
		if ( '3' == Opt::$single_style ) {
			Opt::$has_tr_header = '1';
		}
		if ( '4' == Opt::$single_style ) {
			Opt::$layout = 'full-width';
		}

		if ( is_single() && ! is_active_sidebar( Fns::default_sidebar( 'single' ) ) ) {
			Opt::$layout = 'full-width';
		}

		//Change layout with query string
		if ( ! empty( $_GET['layout'] ) ) {
			Opt::$layout = sanitize_text_field( $_GET['layout'] );
		}

		if ( is_page() && ! is_active_sidebar( Fns::default_sidebar( 'page' ) ) ) {
			Opt::$layout = 'full-width';
		}

		//Blog
		if ( ! is_front_page() && ( is_home() || is_post_type_archive() || is_tax() || is_archive() || is_search() || is_category() || is_tag() || is_author() ) && ! is_active_sidebar( Fns::default_sidebar( 'main' ) ) ) {
			Opt::$layout = 'full-width';
		}
	}


}
