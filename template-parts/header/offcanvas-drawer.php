<?php
/**
 * Template part for displaying header offcanvas
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Helpers\Fns;

$logo_h1 = ! is_singular( [ 'post' ] );
$topinfo = ( radius_docs_option( 'radius_docs_contact_address' ) || radius_docs_option( 'radius_docs_phone' ) || radius_docs_option( 'radius_docs_email' ) ) ? true : false;
?>


<div class="radius-docs-offcanvas-drawer">
	<div class="offcanvas-logo site-branding">
		<?php radius_docs_site_logo( 'main' ); ?>
		<a class="trigger-icon trigger-off-canvas" href="#">×</a>
	</div>
	<?php if ( radius_docs_option( 'radius_docs_about_label' ) || radius_docs_option( 'radius_docs_about_text' ) ) { ?>
		<div class="offcanvas-about offcanvas-address">
			<?php if ( radius_docs_option( 'radius_docs_about_label' ) ) { ?><label><?php echo radius_docs_option( 'radius_docs_about_label' ) ?></label><?php } ?>
			<?php if ( radius_docs_option( 'radius_docs_about_text' ) ) { ?><p><?php echo radius_docs_option( 'radius_docs_about_text' ) ?></p><?php } ?>
		</div>
	<?php } ?>

	<nav class="offcanvas-navigation" role="navigation">
		<?php
		if ( has_nav_menu( 'primary' ) ) :
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'walker'         => new RT\RadiusDocs\Core\WalkerNav(),
				)
			);
		endif;
		?>
	</nav><!-- .radius-docs-navigation -->

	<div class="offcanvas-address">
		<?php if ( $topinfo ) { ?>
			<?php if ( radius_docs_option( 'radius_docs_contact_info_label' ) ) { ?><label><?php echo radius_docs_option( 'radius_docs_contact_info_label' ) ?></label><?php } ?>
			<ul class="offcanvas-info">
				<?php if ( radius_docs_option( 'radius_docs_topbar_address' ) && radius_docs_option( 'radius_docs_contact_address' ) ) { ?>
					<li><i class="icon-radius-docs-location-4"></i><?php radius_docs_html( radius_docs_option( 'radius_docs_contact_address' ), false ); ?> </li>
				<?php }
				if ( radius_docs_option( 'radius_docs_topbar_phone' ) && radius_docs_option( 'radius_docs_phone' ) ) { ?>
					<li><i class="icon-radius-docs-phone-2"></i><a href="tel:<?php echo esc_attr( radius_docs_option( 'radius_docs_phone' ) ); ?>"><?php radius_docs_html( radius_docs_option( 'radius_docs_phone' ), false ); ?></a></li>
				<?php }
				if ( radius_docs_option( 'radius_docs_topbar_email' ) && radius_docs_option( 'radius_docs_email' ) ) { ?>
					<li><i class="icon-radius-docs-email"></i><a href="mailto:<?php echo esc_attr( radius_docs_option( 'radius_docs_email' ) ); ?>"><?php radius_docs_html( radius_docs_option( 'radius_docs_email' ), false ); ?></a></li>
				<?php } ?>
			</ul>
		<?php } ?>

		<?php if ( radius_docs_option( 'radius_docs_offcanvas_social' ) ) { ?>
			<div class="offcanvas-social-icon">
				<?php radius_docs_get_social_html( '#555' ); ?>
			</div>
		<?php } ?>
	</div>

</div><!-- .container -->

<div class="radius-docs-body-overlay"></div>
