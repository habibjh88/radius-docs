<?php
/**
 * Template part for displaying footer
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

$footer_width     = 'container' . radius_docs_option( 'radius_docs_footer_width' );
$copyright_center = radius_docs_option( 'radius_docs_contact_footer' ) ? 'justify-content-between' : 'justify-content-center';

use RT\RadiusDocs\Modules\Svg;

?>
<?php if ( ! empty( radius_docs_option( 'radius_docs_footer_copyright' ) ) ) : ?>
	<div class="footer-top-wrapper">
		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">
			<div class="tooter-top-inner">

				<div class="promo-text-wrap d-flex align-items-center <?php echo esc_attr( $copyright_center ); ?>">
					<?php if ( radius_docs_option( 'radius_docs_contact_footer' ) ) { ?>
						<div class="footer-promo-title"><?php radius_docs_html( radius_docs_option( 'radius_docs_ready_label' ), false ); ?></div>
						<div class="radius-docs-button">
							<a href="<?php echo esc_url( radius_docs_option( 'radius_docs_contact_button_url' ) ) ?>"
							   class="btn button-2">
								<?php radius_docs_html( radius_docs_option( 'radius_docs_contact_button_text' ), false ); ?>
								<i class="raw-icon-arrow-right"></i>
							</a>
						</div>
					<?php } ?>
				</div>

				<div class="radius-docs-footer-star-shape">
					<i class="raw-icon-star"></i>
				</div>
			</div>
		</div>

	</div>
<?php endif; ?>

<?php if ( is_active_sidebar( 'radius-docs-footer-sidebar' ) ) : ?>
	<div class="footer-widgets-wrapper">

		<div class="footer-shape">
			<ul>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
			</ul>
		</div>
		<div class="radius-docs-footer-shape">
			<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 296.789 296.789" style="enable-background:new 0 0 512 512" xml:space="preserve"><g>
					<path
						d="m55.093 110.761 6.544 17.743a1.697 1.697 0 0 0 3.186 0l6.544-17.743a52.313 52.313 0 0 1 30.983-30.983l17.743-6.544a1.698 1.698 0 0 0 0-3.186l-17.744-6.544a52.312 52.312 0 0 1-30.982-30.982l-6.544-17.743a1.698 1.698 0 0 0-3.186 0l-6.544 17.743A52.314 52.314 0 0 1 24.11 63.504L6.366 70.048a1.698 1.698 0 0 0 0 3.186l17.743 6.544a52.31 52.31 0 0 1 30.984 30.983zM198.948 185.703l-17.742-6.543a52.311 52.311 0 0 1-30.983-30.982l-6.544-17.743a1.698 1.698 0 0 0-3.186 0l-6.544 17.742a52.316 52.316 0 0 1-30.983 30.983l-17.743 6.543a1.698 1.698 0 0 0 0 3.186l17.744 6.545a52.315 52.315 0 0 1 30.982 30.982l6.544 17.744a1.698 1.698 0 0 0 3.186 0l6.544-17.744a52.312 52.312 0 0 1 30.982-30.982l17.744-6.545a1.698 1.698 0 0 0-.001-3.186zM290.778 109.811l-12.059-4.447a35.557 35.557 0 0 1-21.056-21.056l-4.447-12.058a1.156 1.156 0 0 0-1.083-.755c-.483 0-.915.302-1.083.755l-4.446 12.057a35.555 35.555 0 0 1-21.057 21.057l-12.058 4.447a1.154 1.154 0 0 0 0 2.165l12.059 4.446a35.56 35.56 0 0 1 21.056 21.057l4.446 12.06c.168.453.6.755 1.083.755s.915-.302 1.083-.755l4.447-12.06a35.551 35.551 0 0 1 21.056-21.056l12.059-4.447a1.155 1.155 0 0 0 0-2.165zM261.567 268.552l-8.412-3.103a24.8 24.8 0 0 1-14.687-14.686l-3.103-8.41a.804.804 0 0 0-1.51 0l-3.103 8.41a24.795 24.795 0 0 1-14.686 14.686l-8.412 3.103a.804.804 0 0 0 0 1.51l8.411 3.103a24.8 24.8 0 0 1 14.688 14.688l3.103 8.411a.804.804 0 0 0 1.51 0l3.103-8.411a24.8 24.8 0 0 1 14.688-14.688l8.411-3.103a.804.804 0 0 0-.001-1.51zM199.533 26.726l-8.412-3.102a24.794 24.794 0 0 1-14.686-14.687l-3.103-8.41a.804.804 0 0 0-1.51-.001l-3.102 8.409a24.802 24.802 0 0 1-14.688 14.688l-8.412 3.102a.804.804 0 0 0 0 1.51l8.411 3.103a24.8 24.8 0 0 1 14.689 14.689l3.102 8.41a.804.804 0 0 0 1.51 0l3.103-8.411a24.792 24.792 0 0 1 14.688-14.687l8.411-3.103a.804.804 0 0 0-.001-1.51zM96.359 251.26l-10.58-3.9a31.201 31.201 0 0 1-18.476-18.475l-3.901-10.58a1.014 1.014 0 0 0-1.9 0l-3.901 10.579a31.195 31.195 0 0 1-18.476 18.476l-10.578 3.9a1.012 1.012 0 0 0 0 1.9l10.579 3.902a31.197 31.197 0 0 1 18.475 18.475l3.901 10.58a1.013 1.013 0 0 0 1.9 0l3.902-10.581a31.194 31.194 0 0 1 18.474-18.474l10.581-3.902a1.012 1.012 0 0 0 0-1.9z"
						fill="currentColor" opacity="1" data-original="currentColor"></path>
				</g></svg>
		</div>

		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">
			<div class="footer-widgets row">
				<?php dynamic_sidebar( 'radius-docs-footer-sidebar' ); ?>
			</div>
		</div>
	</div><!-- .site-info -->
<?php endif; ?>
<?php if ( ! empty( radius_docs_option( 'radius_docs_footer_copyright' ) ) ) : ?>
	<div class="footer-copyright-wrapper">
		<div class="footer-container <?php echo esc_attr( $footer_width ) ?>">
			<div class="copyright-text-wrap d-flex align-items-center <?php echo esc_attr( $copyright_center ); ?>">
				<div class="copyright-text">
					<?php radius_docs_html( str_replace( '[y]', date( 'Y' ), radius_docs_option( 'radius_docs_footer_copyright' ) ) ); ?>
				</div>
				<?php if ( radius_docs_option( 'radius_docs_social_footer' ) ) { ?>
					<div class="social-icon d-flex gap-20 align-items-center">
						<div class="social-icon d-flex column-gap-10">
							<?php if ( radius_docs_option( 'radius_docs_follow_us_label' ) ) { ?><label><?php radius_docs_html( radius_docs_option( 'radius_docs_follow_us_label' ), 'allow_title' ) ?></label><?php } ?>
							<?php radius_docs_get_social_html( '#555' ); ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>

	</div>
<?php endif; ?>
