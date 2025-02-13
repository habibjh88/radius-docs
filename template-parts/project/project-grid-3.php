<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */


use RT\RadiusDocs\Modules\PostMeta;
use RT\RadiusDocs\Modules\Thumbnail;

?>

<article data-post-id="<?php the_ID(); ?>" <?php post_class( radius_docs_cpt_class( 'project' ) ); ?>>
	<div class="article-inner-wrapper">

		<?php Thumbnail::get_thumbnail(); ?>

		<div class="entry-wrapper">
			<header class="entry-header">

				<?php the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );

				if ( radius_docs_option( 'radius_docs_meta_visibility' ) ) {
					PostMeta::get_meta();
				}
				?>
			</header>
			<?php if ( radius_docs_option( 'radius_docs_blog_content_visibility' ) ) : ?>
				<div class="entry-content">
					<?php radius_docs_entry_content() ?>
				</div>
			<?php endif; ?>

			<?php
			if ( radius_docs_option( 'radius_docs_project_footer_visibility' ) ) {
				radius_docs_entry_footer( radius_docs_option( 'radius_docs_project_read_more' ) );
			}
			?>
		</div>
	</div>
</article>
