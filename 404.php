<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package RadiusDocs
 */

get_header();

?>

<div id="primary" class="content-area">
	<div class="container">
		<main id="main" class="site-main error-404" role="main">
			<?php
			if ( ! empty( radius_docs_option( 'radius_docs_error_image' ) ) ) {
				echo wp_get_attachment_image( radius_docs_option( 'radius_docs_error_image' ), 'full', true );
			} else {
				radius_docs_get_img( '404.svg', true, 'width="1007" height="530"' ) . "' alt='";
			}
			?>

			<div class="error-info">
				<h2 class="error-title"><?php radius_docs_html( radius_docs_option( 'radius_docs_error_heading' ), 'allow_title' ); ?></h2>
				<p><?php radius_docs_html( radius_docs_option( 'radius_docs_error_text' ), 'allow_title' ); ?></p>

				<div class="radius-docs-button">
					<a class="btn button-2" href="<?php echo esc_url( home_url() ) ?>">
						<div class="btn-wrap">
							<?php radius_docs_html( radius_docs_option( 'radius_docs_error_button_text' ), 'allow_title' ); ?>
						</div>
					</a>
				</div>

			</div>
		</main><!-- #main -->
	</div><!-- container - -->
</div><!-- #primary -->

<?php
get_footer();
