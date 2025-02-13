<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( radius_docs_cpt_class( 'service', true ) ); ?>>
	<div class="single-inner-wrapper">
		<div class="entry-wrapper">
			<div class="entry-content">
				<?php the_content() ?>
			</div>
			<footer class="entry-footer d-flex align-items-start justify-content-between">
				<div class="post-share">
					<?php if ( radius_docs_option( 'radius_docs_social' ) ) {
						printf( "<span class='post-footer-label'>%s</span>", esc_html( radius_docs_option( 'radius_docs_social' ) ) );
					} ?>
					<?php radius_docs_post_share(); ?>
				</div>
			</footer>
		</div>
	</div>
</article>
