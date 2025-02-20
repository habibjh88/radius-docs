<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RadiusDocs
 */
use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Modules\Svg;
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
// Preloader
if ( radius_docs_option( 'radius_docs_preloader' ) ) {
	if ( ! empty( radius_docs_option( 'radius_docs_preloader_logo' ) ) ) { ?>
		<div
			id="preloader"><?php echo wp_get_attachment_image( radius_docs_option( 'radius_docs_preloader_logo' ), 'full', true ); ?></div>
	<?php } else { ?>
		<div id="preloader" class="loader">
			<div class="cssload-loader">
				<div class="cssload-inner cssload-one"></div>
				<div class="cssload-inner cssload-two"></div>
				<div class="cssload-inner cssload-three"></div>
			</div>
		</div>
	<?php }
}
?>
<div id="radius-docs-sticky-placeholder"></div>
<div class="radius-docs-focus"></div>
<div id="page" class="site">

	<header id="masthead" class="site-header" role="banner">
		<?php get_template_part( 'template-parts/header/topbar', Opt::$topbar_style ); ?>
		<?php get_template_part( 'template-parts/header/header', Opt::$header_style ); ?>
	</header><!-- #masthead -->

	<?php get_template_part( 'template-parts/header/offcanvas', 'drawer' ); ?>

	<div id="radius-docs-header-search" class="header-search">
		<button type="button" aria-label="close button" class="close">×</button>
		<form role="search" method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" value="<?php echo get_search_query(); ?>" name="s"
				   placeholder="<?php esc_html_e( 'Type your search........', 'radius-docs' ); ?>">
			<button type="submit" aria-label="submit button" class="search-btn"><i class="raw-icon-search"></i></button>
		</form>
	</div>

	<div style="opacity:0" id="content" class="site-content <?php echo esc_attr( radius_docs_option( 'radius_docs_blend' ) ); ?>">
		<?php get_template_part( 'template-parts/content-banner', Opt::$banner_style ); ?>
