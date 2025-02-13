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

<article data-post-id="<?php the_ID(); ?>" <?php post_class( radius_docs_post_class('archive-post') ); ?>>
	<div class="article-inner-wrapper">

		<?php Thumbnail::get_thumbnail(); ?>

		<div class="entry-wrapper">
			<header class="entry-header">

				<?php
				if ( radius_docs_option( 'radius_docs_blog_above_meta_visibility' ) ) {
					radius_docs_separate_meta();
				}

				the_title( sprintf( '<h3 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h3>' );
				?>
			</header>

			<?php

			if ( radius_docs_option( 'radius_docs_blog_content_visibility' ) ) : ?>
				<div class="entry-content">
					<?php radius_docs_entry_content() ?>
				</div>
			<?php endif; ?>

			<?php if ( radius_docs_option( 'radius_docs_meta_visibility' ) ) {
				PostMeta::get_meta();
			} ?>

			<?php
			if ( radius_docs_option( 'radius_docs_blog_readmore_visibility' ) ) {
				radius_docs_entry_footer();
			}
			?>
		</div>
	</div>
</article>
