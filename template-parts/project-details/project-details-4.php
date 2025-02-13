<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Modules\PostMeta;

?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( radius_docs_cpt_class( 'project', true ) ); ?>>
	<div class="single-inner-wrapper">
		<div class="entry-wrapper">
			<header class="entry-header">
				<?php
				the_title( '<h1 class="entry-title default-max-width">', '</h1>' );

				$single_meta = radius_docs_option( 'radius_docs_project_single_meta', '', true );
				if ( ! empty( $single_meta ) ) {
					PostMeta::get_meta( 'radius-docs-project', [
						'force_exclude' => false,
						'include'       => $single_meta
					] );
				}
				?>
			</header>
			<div class="entry-content">
				<?php the_content(); ?>
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

