<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */
use RT\RadiusDocs\Modules\Pagination;

get_header();

if ( is_post_type_archive( "radius-docs-service" ) || is_tax( "radius-docs-service-category" ) ) {
	get_template_part( 'template-parts/archive', 'service' );
	return;
}
if ( is_post_type_archive( "radius-docs-project" ) || is_tax( "radius-docs-project-category" ) ) {
	get_template_part( 'template-parts/archive', 'project' );
	return;
}

?>
	<div id="primary" class="content-area">
		<div class="container">

			<?php radius_docs_author_info(); ?>

			<div class="row">
				<div class="<?php echo esc_attr( Fns::content_columns() ); ?>">
					<main id="main" class="site-main" role="main">
						<div class="row radius-docs-masonry-grid">
							<?php
							if ( have_posts() ) :
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'template-parts/content', radius_docs_option( 'radius_docs_blog_style' ) );
								endwhile;
							else :
								get_template_part( 'template-parts/content', 'none' );
							endif;
							?>
						</div>
						<?php Pagination::pagination(); ?>
					</main><!-- #main -->
				</div><!-- .col- -->
				<?php get_sidebar(); ?>
			</div><!-- .row -->
		</div><!-- .container -->
	</div><!-- #primary -->
<?php
get_footer();
