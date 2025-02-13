<?php

namespace RT\RadiusDocs\Custom;

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Traits\SingletonTraits;

/**
 * DynamicStyles Class
 */
class DynamicStyles {

	use SingletonTraits;

	protected $meta_data;

	/**
	 * Class Construct
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ], 20 );
	}

	/**
	 * Enqueue Scripts
	 *
	 * @return void
	 */
	public function enqueue_scripts() {
		$this->meta_data = get_post_meta( get_the_ID(), "radius_docs_layout_meta_data", true );
		$dynamic_css     = $this->inline_style();
		wp_register_style( 'radius-docs-dynamic', false, 'radius-docs-main' );
		wp_enqueue_style( 'radius-docs-dynamic' );
		wp_add_inline_style( 'radius-docs-dynamic', $this->minify_css( $dynamic_css ) );
	}

	/**
	 * Minify CSS
	 *
	 * @param $css
	 *
	 * @return array|string|string[]|null
	 */
	function minify_css( $css ) {
		$css = preg_replace( '/\/\*[^*]*\*+([^\/][^*]*\*+)*\//', '', $css ); // Remove comments
		$css = preg_replace( '/\s+/', ' ', $css ); // Remove multiple spaces
		$css = preg_replace( '/\s*([\{\};])\s*/', '$1', $css ); // Remove spaces around { } ; : ,

		return $css;
	}

	/**
	 * Make Inline CSS
	 *
	 * @return false|string
	 */
	private function inline_style() {

		$primary_color     = radius_docs_option( 'radius_docs_primary_color', '#FF1212' );
		$primary_dark      = radius_docs_option( 'radius_docs_primary_dark', '#da0c0c' );
		$primary_light     = radius_docs_option( 'radius_docs_primary_light', '#ff3838' );
		$secondary_color   = radius_docs_option( 'radius_docs_secondary_color', '#111111' );
		$body_bg_color     = radius_docs_option( 'radius_docs_body_bg_color', '#FFFFFF' );
		$body_color        = radius_docs_option( 'radius_docs_body_color', '#343C4D' );
		$border_color      = radius_docs_option( 'radius_docs_border_color', '#e7e7e7' );
		$title_color       = radius_docs_option( 'radius_docs_title_color', '#111111' );
		$rating_color      = radius_docs_option( 'radius_docs_rating_color', '#F9BA19' );
		$button_color      = radius_docs_option( 'radius_docs_button_color', '#ffffff' );
		$button_text_color = radius_docs_option( 'radius_docs_button_text_color', '#00030C' );
		$meta_color        = radius_docs_option( 'radius_docs_meta_color', '#47494c' );
		$meta_light        = radius_docs_option( 'radius_docs_meta_light', '#d3d9e1' );
		$gray10            = radius_docs_option( 'radius_docs_gray10_color', '#f8f8f8' );
		$gray20            = radius_docs_option( 'radius_docs_gray20_color', '#7a7d81' );

		//Transparent Menu
		$tr_menu_color  = radius_docs_option( 'radius_docs_tr_menu_color', '#FFFFFF' );
		$tr_menu_active = radius_docs_option( 'radius_docs_tr_menu_active_color', $primary_light );

		$container_width = radius_docs_option( 'container_width', '1280' );
		//phpcs:disable
		ob_start(); ?>

		:root {
		--radius-docs-primary-color: <?php echo esc_html( $primary_color ); ?>;
		--radius-docs-primary-dark: <?php echo esc_html( $primary_dark ); ?>;
		--radius-docs-primary-light: <?php echo esc_html( $primary_light ); ?>;
		--radius-docs-secondary-color: <?php echo esc_html( $secondary_color ); ?>;
		--radius-docs-body-bg-color: <?php echo esc_html( $body_bg_color ); ?>;
		--radius-docs-body-color: <?php echo esc_html( $body_color ); ?>;
		--radius-docs-border-color: <?php echo esc_html( $border_color ); ?>;
		--radius-docs-title-color: <?php echo esc_html( $title_color ); ?>;
		--radius-docs-rating-color: <?php echo esc_html( $rating_color ); ?>;
		--radius-docs-button-color: <?php echo esc_html( $button_color ); ?>;
		--radius-docs-button-text-color: <?php echo esc_html( $button_text_color ); ?>;
		--radius-docs-meta-color: <?php echo esc_html( $meta_color ); ?>;
		--radius-docs-meta-light: <?php echo esc_html( $meta_light ); ?>;
		--radius-docs-gray10: <?php echo esc_html( $gray10 ); ?>;
		--radius-docs-gray20: <?php echo esc_html( $gray20 ); ?>;
		--radius-docs-gray30: <?php echo esc_html( "#e5e5e5" ); ?>;
		--radius-docs-tr-1: <?php echo esc_html( "rgba(0, 0, 0, 0.1)" ); ?>;
		--radius-docs-tr-2: <?php echo esc_html( "rgba(0, 0, 0, 0.2)" ); ?>;
		--radius-docs-tr-3: <?php echo esc_html( "rgba(0, 0, 0, 0.3)" ); ?>;
		--radius-docs-body-rgb: <?php echo esc_html( Fns::hex2rgb( $body_color ) ); ?>;
		--radius-docs-title-rgb: <?php echo esc_html( Fns::hex2rgb( $title_color ) ); ?>;
		--radius-docs-primary-rgb: <?php echo esc_html( Fns::hex2rgb( $primary_color ) ); ?>;
		--radius-docs-secondary-rgb: <?php echo esc_html( Fns::hex2rgb( $secondary_color ) ); ?>;
		--radius-docs-container-width: <?php echo( $container_width < 992 ? 992 : $container_width ); ?>px;
		--radius-docs-tr-menu: <?php echo esc_html( $tr_menu_color ); ?>;
		--radius-docs-tr-menu-hover: <?php echo esc_html( $tr_menu_active ); ?>;
		}

		body {
		color: <?php echo esc_html( $body_color ); ?>;
		}

		<?php
		//phpcs:enable
		$this->site_fonts();
		$this->topbar_css();
		$this->header_css();
		$this->banner_css();
		$this->content_padding_css();
		$this->footer_css();
		$this->site_background();

		return ob_get_clean();
	}

	/**
	 * Topbar Style
	 *
	 * @return void
	 */
	protected function topbar_css() {
		$_topbar_active_color = radius_docs_option( 'radius_docs_topbar_active_color' );
		echo self::css( 'body .site-header .radius-docs-topbar .topbar-container *:not(.dropdown-menu *)', 'color', 'radius_docs_topbar_color' );
		echo self::css( 'body .site-header .radius-docs-topbar .topbar-container svg:not(.dropdown-menu svg)', 'fill', 'radius_docs_topbar_color' );

		if ( ! empty( $_topbar_active_color ) ) : ?>
			body .site-header .radius-docs-topbar .topbar-container a:hover:not(.dropdown-menu a:hover),
			body .radius-docs-topbar #topbar-menu ul ul li.current_page_item > a,
			body .radius-docs-topbar #topbar-menu ul ul li.current-menu-ancestor > a,
			body .radius-docs-topbar #topbar-menu ul.radius-docs-topbar-menu > li.current-menu-item > a,
			body .radius-docs-topbar #topbar-menu ul.radius-docs-topbar-menu > li.current-menu-ancestor > a {
			color: <?php echo esc_attr( $_topbar_active_color ); ?>;
			}

			body .site-header .radius-docs-topbar .topbar-container a:hover:not(.dropdown-menu a:hover svg) svg,
			body .radius-docs-topbar #topbar-menu ul ul li.current-menu-ancestor > a svg,
			body .radius-docs-topbar #topbar-menu ul.radius-docs-topbar-menu > li.current-menu-item > a svg,
			body .radius-docs-topbar #topbar-menu ul.radius-docs-topbar-menu > li.current-menu-ancestor > a svg {
			fill: <?php echo esc_attr( $_topbar_active_color ); ?>;
			}
		<?php endif; ?>

		<?php
		echo self::css( 'body .radius-docs-topbar', 'background-color', 'radius_docs_topbar_bg_color' );

	}


	/**
	 * Menu Color Style
	 *
	 * @return void
	 */
	protected function header_css() {
		//Logo CSS
		$logo_width        = '';
		$logo_mobile_width = '';

		$logo_dimension        = radius_docs_option( 'radius_docs_logo_width_height' );
		$logo_mobile_dimension = radius_docs_option( 'radius_docs_mobile_logo_width_height' );
		$menu_border_bottom    = radius_docs_option( 'radius_docs_menu_border_color' );

		if ( strpos( $logo_dimension, ',' ) ) {
			$logo_width = explode( ',', $logo_dimension );
		}
		if ( strpos( $logo_mobile_dimension, ',' ) ) {
			$logo_mobile_width = explode( ',', $logo_mobile_dimension );
		}

		//Default Menu
		$_menu_color        = radius_docs_option( 'radius_docs_menu_color' );
		$_menu_active_color = radius_docs_option( 'radius_docs_menu_active_color' );
		$_menu_bg_color     = radius_docs_option( 'radius_docs_menu_bg_color' );
		$_sub_menu_bg_color = radius_docs_option( 'radius_docs_sub_menu_bg_color' );

		$_header_border      = radius_docs_option( 'radius_docs_header_border' );
		$_breadcrumb_border  = radius_docs_option( 'radius_docs_breadcrumb_border' );
		$_preloader_bg_color = radius_docs_option( 'preloader_bg_color' );
		?>

		<?php //Header Logo CSS ?>
		<?php if ( Opt::$header_width == 'full' ) :
			$h_width = '100%';
			if ( ( $header_width = radius_docs_option( 'radius_docs_header_max_width' ) ) > 768 ) {
				$h_width = $header_width . 'px';
			}
			?>
			.header-container,
			.topbar-container {
			width: <?php echo esc_attr( $h_width ); ?>;
			max-width: 100%;
			}
		<?php endif; ?>

		<?php if ( ! empty( $logo_width ) ) : ?>
			.site-branding .site-logo {
			max-width: <?php echo esc_attr( $logo_width[0] ?? '100%' ) ?>;
			max-height: <?php echo esc_attr( $logo_width[1] ?? 'auto' ) ?>;
			object-fit: contain;
			}
		<?php endif; ?>

		<?php
		if ( ! empty( $logo_mobile_width ) ) : ?>
			.site-branding .site-mobile-logo {
			max-width: <?php echo esc_attr( $logo_mobile_width[0] ?? '100%' ) ?>;
			max-height: <?php echo esc_attr( $logo_mobile_width[1] ?? 'auto' ) ?>;
			object-fit: contain;
			}
		<?php endif; ?>

		<?php //Default Header ?>
		<?php if ( ! empty( $_menu_color ) ) : ?>
			body .main-header-section .radius-docs-navigation ul li a,
			body .radius-docs-offcanvas-drawer ul.menu li a {
			color: <?php echo esc_attr( $_menu_color ) ?>;
			}
			body .main-header-section svg {
			fill: <?php echo esc_attr( $_menu_color ) ?>;
			}
			body .ham-burger .btn-hamburger span,
			body .menu-icon-wrapper .has-separator li:not(:last-child):after {
			background-color: <?php echo esc_attr( $_menu_color ) ?>;
			}
		<?php endif; ?>

		<?php if ( ! empty( $_menu_active_color ) ) : ?>
			body .main-header-section .radius-docs-navigation ul li a:hover,
			body .main-header-section .radius-docs-navigation ul li.current-menu-item > a,
			body .main-header-section .radius-docs-navigation ul li.current-menu-ancestor > a,
			body .radius-docs-offcanvas-drawer ul li.current-menu-ancestor > a,
			body .radius-docs-offcanvas-drawer ul.menu li a:hover {
			color: <?php echo esc_attr( $_menu_active_color ) ?>;
			}
			body .main-header-section .radius-docs-navigation ul li.current-menu-item > a svg,
			body .main-header-section .radius-docs-navigation ul li.current-menu-ancestor > a svg {
			fill: <?php echo esc_attr( $_menu_active_color ) ?>;
			}
			body .menu-icon-wrapper .menu-bar:hover .btn-hamburger span {
			background-color: <?php echo esc_attr( $_menu_active_color ) ?>;
			}
			body .main-header-section a:hover [class*=radius-docs-icon] svg {
			fill: <?php echo esc_attr( $_menu_active_color ) ?>;
			}
		<?php endif; ?>

		<?php if ( ! empty( $_menu_bg_color ) ) : ?>
			body .main-header-section {
			background-color: <?php echo esc_attr( $_menu_bg_color ) ?>;
			}
		<?php endif; ?>

		<?php if ( ! empty( $_sub_menu_bg_color ) ) : ?>
			body .radius-docs-navigation ul > li > ul,
			body .radius-docs-navigation ul li.mega-menu > ul.dropdown-menu{
			background-color: <?php echo esc_attr( $_sub_menu_bg_color ) ?>;
			}
		<?php endif; ?>

		<?php if ( ! empty( $_tr_menu_active_color ) ) : ?>
			body.has-trheader .site-header .radius-docs-navigation ul li a:hover,
			body.has-trheader .site-header .radius-docs-navigation ul li.current-menu-item > a,
			body.has-trheader .site-header .radius-docs-navigation ul li.current-menu-ancestor > a {
			color: <?php echo esc_attr( $_tr_menu_active_color ); ?>
			}
			body.has-trheader .menu-icon-wrapper .menu-bar:hover .btn-hamburger span {
			background-color: <?php echo esc_attr( $_tr_menu_active_color ); ?> !important;
			}
			body.has-trheader .main-header-section a:hover [class*=radius-docs-icon] svg,
			body.has-trheader .site-header .radius-docs-navigation ul li.current-menu-ancestor > a svg,
			body.has-trheader .site-header .radius-docs-navigation ul li.current-menu-item > a svg {
			fill: <?php echo esc_attr( $_tr_menu_active_color ); ?>
			}
		<?php endif; ?>
		<?php if ( ! empty( $menu_border_bottom ) ) : ?>
			body .radius-docs-topbar,
			body .main-header-section,
			body .radius-docs-breadcrumb-wrapper {
			border-bottom-color: <?php echo esc_attr( $menu_border_bottom ); ?>;
			}
		<?php endif; ?>

		<?php if ( ! $_header_border ) : ?>
			body .main-header-section {border-bottom: none;}
		<?php endif; ?>
		<?php if ( ! $_breadcrumb_border ) : ?>
			body .radius-docs-breadcrumb-wrapper {border-bottom: none;}
		<?php endif; ?>

		<?php if ( ! empty( $_preloader_bg_color ) ) : ?>
			#preloader {
			background-color: <?php echo esc_attr( $_preloader_bg_color ); ?>;
			}
		<?php endif; ?>

		<?php
	}

	/**
	 * Breadcrumb CSS
	 *
	 * @return void
	 */
	protected function banner_css() {
		$breadcrumb_color            = radius_docs_option( 'radius_docs_breadcrumb_color' );
		$radius_docs_breadcrumb_hover       = radius_docs_option( 'radius_docs_breadcrumb_hover' );
		$breadcrumb_active           = radius_docs_option( 'radius_docs_breadcrumb_active' );
		$radius_docs_breadcrumb_title_color = radius_docs_option( 'radius_docs_breadcrumb_title_color' );
		$radius_docs_banner_overlay         = radius_docs_option( 'radius_docs_banner_overlay' );

		$radius_docs_banner_height         = radius_docs_option( 'radius_docs_banner_height' );
		$radius_docs_banner_padding_top    = radius_docs_option( 'radius_docs_banner_padding_top' );
		$radius_docs_banner_padding_bottom = radius_docs_option( 'radius_docs_banner_padding_bottom' );

		if ( ! empty( $radius_docs_banner_height ) ) { ?>
			.radius-docs-breadcrumb-wrapper {
			height: <?php echo esc_attr( $radius_docs_banner_height ) ?>px;
			}
		<?php }

		if ( ! empty( $radius_docs_breadcrumb_title_color ) ) { ?>
			.radius-docs-breadcrumb-wrapper .entry-title {
			color: <?php echo esc_attr( $radius_docs_breadcrumb_title_color ) ?> !important;
			}
		<?php }

		if ( ! empty( $radius_docs_banner_overlay ) ) { ?>
			.radius-docs-breadcrumb-wrapper.has-bg::before {
			background-color: <?php echo esc_attr( $radius_docs_banner_overlay ) ?>;
			}
			<?php
		}

		if ( ! empty( $breadcrumb_color ) ) { ?>
			.radius-docs-breadcrumb-wrapper .breadcrumb a,
			.radius-docs-breadcrumb-wrapper .entry-breadcrumb span a,
			.radius-docs-breadcrumb-wrapper .entry-breadcrumb .dvdr {
			color: <?php echo esc_attr( $breadcrumb_color ) ?>;
			}
		<?php }

		if ( ! empty( $radius_docs_breadcrumb_hover ) ) { ?>
			.radius-docs-breadcrumb-wrapper .breadcrumb a:hover,
			.radius-docs-breadcrumb-wrapper .entry-breadcrumb span a:hover {
			color: <?php echo esc_attr( $radius_docs_breadcrumb_hover ) ?>;
			}
		<?php }

		if ( ! empty( $breadcrumb_active ) ) { ?>
			.radius-docs-breadcrumb-wrapper .breadcrumb li.active .title,
			.radius-docs-breadcrumb-wrapper .breadcrumb a:hover,
			.radius-docs-breadcrumb-wrapper .entry-breadcrumb span a:hover,
			.radius-docs-breadcrumb-wrapper .entry-breadcrumb .current-item,
			.has-trheader .radius-docs-breadcrumb-wrapper .breadcrumb li.active .title,
			.has-trheader .radius-docs-breadcrumb-wrapper .breadcrumb a:hover {
			color: <?php echo esc_attr( $breadcrumb_active ) ?>;
			}
		<?php }

		if ( ! empty( Opt::$banner_color ) ) { ?>
			.radius-docs-breadcrumb-wrapper,
			.radius-docs-banner-2 .radius-docs-breadcrumb-wrapper {
			background-color: <?php echo esc_attr( Opt::$banner_color ); ?>;
			}
		<?php }

		if ( ! empty( $radius_docs_banner_padding_top ) ) { ?>
			.radius-docs-breadcrumb-wrapper {
			padding-top: <?php echo esc_attr( $radius_docs_banner_padding_top ) ?>px !important;
			}
		<?php }

		if ( ! empty( $radius_docs_banner_padding_bottom ) ) { ?>
			.radius-docs-breadcrumb-wrapper {
			padding-bottom: <?php echo esc_attr( $radius_docs_banner_padding_bottom ) ?>px !important;
			}
		<?php }

	}

	/**
	 * Content CSS
	 *
	 * @return void
	 */
	protected function content_padding_css() {

		if ( ! empty( Opt::$padding_top ) && 'default' !== Opt::$padding_top ) { ?>
			.content-area {padding-top: <?php echo esc_attr( Opt::$padding_top ); ?>px;}
		<?php }

		if ( ! empty( Opt::$padding_bottom ) && 'default' !== Opt::$padding_bottom ) { ?>
			.content-area {padding-bottom: <?php echo esc_attr( Opt::$padding_bottom ); ?>px;}
		<?php }

	}

	/**
	 * Footer CSS
	 *
	 * @return void
	 */
	protected function footer_css() {
		if ( radius_docs_option( 'radius_docs_footer_width' ) && radius_docs_option( 'radius_docs_footer_max_width' ) > 1400 ) {
			echo self::css( '.site-footer .footer-container', 'width', 'radius_docs_footer_max_width', 'px;max-width: 100%' );
		}
		echo self::css( 'body .site-footer *:not(a), body .site-footer .widget', 'color', 'radius_docs_footer_text_color' );
		echo self::css( 'body .site-footer .footer-sidebar a, body .site-footer .footer-sidebar .widget a, body .site-footer .footer-sidebar .phone-no a', 'color', 'radius_docs_footer_link_color' );
		echo self::css( 'body .site-footer a:hover, body .site-footer .footer-sidebar a:hover', 'color', 'radius_docs_footer_link_hover_color' );
		echo self::css( 'body .site-footer .footer-widgets-wrapper', 'background-color', 'radius_docs_footer_bg' );
		echo self::css( 'body .site-footer .widget :is(td, th, select, .search-box)', 'border-color', 'radius_docs_footer_input_border_color' );
		echo self::css( 'body .site-footer .widget-title', 'color', 'radius_docs_footer_widget_title_color' );
		echo self::css( 'body .site-footer .footer-copyright-wrapper, body .site-footer label, body .footer-copyright-wrapper .copyright-text', 'color', 'radius_docs_copyright_text_color' );
		echo self::css( 'body .site-footer .footer-copyright-wrapper a', 'color', 'radius_docs_copyright_link_color' );
		echo self::css( 'body .site-footer .footer-copyright-wrapper a:hover', 'color', 'radius_docs_copyright_link_hover_color' );
		echo self::css( 'body .site-footer .footer-copyright-wrapper', 'background-color', 'radius_docs_copyright_bg' );
	}


	/**
	 * Load site fonts
	 *
	 * @return void
	 */
	protected function site_fonts() {

		$typo_body           = json_decode( radius_docs_option( 'radius_docs_body_typo' ), true );
		$typo_menu           = json_decode( radius_docs_option( 'radius_docs_menu_typo' ), true );
		$typo_heading        = json_decode( radius_docs_option( 'radius_docs_all_heading_typo' ), true );
		$body_font_family    = $typo_body['font'] ?? 'Urbanist';
		$heading_font_family = $typo_heading['font'] ?? $body_font_family;
		?>
		:root{
		--radius-docs-body-font: '<?php echo esc_html( $typo_body['font'] ); ?>', sans-serif;
		--radius-docs-body-fs: <?php echo esc_html( $typo_body['size'] ); ?>px;
		--radius-docs-heading-font: '<?php echo esc_html( $heading_font_family ); ?>', sans-serif;
		--radius-docs-menu-font: '<?php echo esc_html( $typo_body['font'] ); ?>', sans-serif;
		}

		<?php
		echo self::font_css( 'body', $typo_body );
		echo self::font_css( '.site-header', [ 'font' => $typo_menu['font'] ] );
		echo self::font_css( '.radius-docs-navigation ul li a', [
			'size'          => $typo_menu['size'],
			'regularweight' => $typo_menu['regularweight'],
			'lineheight'    => $typo_menu['lineheight']
		] );
		echo self::font_css( '.h1,.h2,.h3,.h4,.h5,.h6,h1,h2,h3,h4,h5,h6', [
			'font'          => $typo_heading['font'],
			'regularweight' => $typo_heading['regularweight']
		] );

		$heading_fonts = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' ];
		foreach ( $heading_fonts as $heading ) {
			$font = json_decode( radius_docs_option( "radius_docs_heading_{$heading}_typo" ), true );
			if ( ! empty( $font['font'] ) ) {
				$selector = "$heading, .$heading";
				echo self::font_css( $selector, $font );
			}
		}
	}


	/**
	 * Generate CSS
	 *
	 * @param $selector
	 * @param $property
	 * @param $theme_mod
	 *
	 * @return string|void
	 */
	public static function css( $selector, $property, $theme_mod, $after_css = '' ) {
		$theme_mod = radius_docs_option( $theme_mod );

		if ( ! empty( $theme_mod ) ) {
			return sprintf( '%s { %s:%s%s; }', $selector, $property, $theme_mod, $after_css );
		}
	}

	/**
	 * Font CSS
	 *
	 * @param $selector
	 * @param $property
	 * @param $theme_mod
	 * @param $after_css
	 *
	 * @return string
	 */
	public static function font_css( $selector, $font ) {
		$css = '';
		$css .= $selector . '{'; //Start CSS
		$css .= ! empty( $font['font'] ) ? "font-family: '" . $font['font'] . "', sans-serif;" : '';
		$css .= ! empty( $font['size'] ) ? "font-size: {$font['size']}px;" : '';
		$css .= ! empty( $font['lineheight'] ) ? "line-height: {$font['lineheight']}px;" : '';
		$css .= ! empty( $font['regularweight'] ) ? "font-weight: {$font['regularweight']};" : '';
		$css .= '}'; //End CSS

		return $css;
	}

	/**
	 * Site background
	 *
	 * @return string
	 */

	function site_background() {
		if ( ! empty( Opt::$pagebgimg ) ) {
			$bg = wp_get_attachment_image_src( Opt::$pagebgimg, 'full' );
			if ( ! empty( $bg[0] ) ) { ?>
				body {
				background-image: url(<?php echo esc_url( $bg[0] ) ?>);
				background-repeat: repeat;
				background-position: top center;
				background-size: 100%;
				}
				<?php
			}
		}
		if ( ! empty( Opt::$pagebgcolor ) && 'default' !== Opt::$pagebgcolor ) { ?>
			body {
			background-color: <?php echo esc_attr( Opt::$pagebgcolor ); ?>;
			}
		<?php }
	}
}
