<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Options\Opt;

if ( ! Opt::$has_top_bar ) {
	return;
}
$_fullwidth = Opt::$header_width == 'full' ? '-fluid' : '';
?>

<div class="radius-docs-topbar">
	<div class="topbar-container container<?php echo esc_attr( $_fullwidth ) ?>">
		<div class="row topbar-row">
			<nav id="topbar-menu" class="radius-docs-navigation pr-10" role="navigation">
				<?php
				wp_nav_menu( [
					'theme_location' => 'topbar',
					'menu_class'     => 'radius-docs-navbar',
					'items_wrap'     => '<ul id="%1$s" class="%2$s radius-docs-topbar-menu">%3$s</ul>',
					'fallback_cb'    => 'radius_docs_custom_menu_cb',
					'walker'         => has_nav_menu( 'primary' ) ? new RT\RadiusDocs\Core\WalkerNav() : '',
				] );
				?>
			</nav><!-- .topbar-navigation -->

			<ul class="topbar-right d-flex gap-15 align-items-center">
				<li class="social-icon">
					<?php if ( radius_docs_option( 'radius_docs_follow_us_label' ) ) { ?>
						<label><?php echo radius_docs_option( 'radius_docs_follow_us_label' ) ?></label>
					<?php } ?>
					<?php radius_docs_get_social_html(); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
