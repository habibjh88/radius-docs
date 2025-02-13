<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Options\Opt;

$logo_h1      = ! is_singular( [ 'post' ] );
$menu_classes = Fns::menu_alignment( 'end' );
$_fullwidth   = Opt::$header_width == 'full' ? '-fluid' : '';
?>

	<div class="main-header-section">
		<div class="header-container container<?php echo esc_attr( $_fullwidth ) ?>">
			<div class="d-flex navigation-menu-wrap align-middle m-0">
				<div class="site-branding">
					<?php radius_docs_site_logo(); ?>
				</div>
				<nav class="radius-docs-navigation  <?php echo esc_attr( $menu_classes ) ?>" role="navigation">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'menu_class'     => 'radius-docs-navbar',
						'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
						'fallback_cb'    => 'radius_docs_custom_menu_cb',
						'walker'         => has_nav_menu( 'primary' ) ? new RT\RadiusDocs\Core\WalkerNav() : '',
					] );
					?>
				</nav><!-- .radius-docs-navigation -->
				<?php radius_docs_menu_icons_group(); ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div>
<?php
