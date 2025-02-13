<?php
/**
 * Template part for displaying content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */
?>
<article data-post-id="<?php the_ID(); ?>" <?php post_class( radius_docs_post_class( '',true ) ); ?>>
	<div class="single-inner-wrapper">
		<div class="entry-wrapper">
			<?php radius_docs_single_entry_header(); ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			<?php radius_docs_single_entry_footer(); ?>
			<?php radius_docs_author_info(); ?>
		</div>
	</div>
</article>
