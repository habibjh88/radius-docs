<?php
/**
 * Template part for displaying footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

$footer_width     = 'container' . radius_docs_option( 'radius_docs_footer_width' );
$copyright_center = radius_docs_option( 'radius_docs_social_footer' ) ? 'justify-content-between' : 'justify-content-center';
?>

<?php if ( is_active_sidebar( 'radius-docs-footer-sidebar' ) ) : ?>
	<div class="footer-widgets-wrapper">

		<div class="footer-shape">
			<ul>
				<li></li>
				<li></li>
			</ul>
		</div>

		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( 'radius-docs-footer-sidebar' ); ?>
			</div>
		</div>
	</div><!-- .site-info -->
<?php endif; ?>

<?php if ( ! empty( radius_docs_option( 'radius_docs_footer_copyright' ) ) ) : ?>
	<div class="footer-copyright-wrapper text-center">
		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">

				<div class="d-flex align-items-center <?php echo esc_attr( $copyright_center ); ?>">
					<div class="copyright-text">
						<?php radius_docs_html( str_replace( '[y]', date( 'Y' ), radius_docs_option( 'radius_docs_footer_copyright' ) ) ); ?>
					</div>
					<?php if ( radius_docs_option( 'radius_docs_social_footer' ) ) { ?>
						<div class="social-icon d-flex gap-20 align-items-center">
							<div class="social-icon d-flex column-gap-10">
								<?php if ( radius_docs_option( 'radius_docs_follow_us_label' ) ) { ?><label><?php radius_docs_html( radius_docs_option( 'radius_docs_follow_us_label' ), 'allow_title' ) ?></label><?php } ?>
								<?php radius_docs_get_social_html(); ?>
							</div>
						</div>
					<?php } ?>

			</div>
		</div>
	</div>
<?php endif; ?>
