<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Modules\Pagination;

get_header();

$blog_style = isset( $_GET['style'] ) ? sanitize_text_field( $_GET['style'] ) : radius_docs_option( 'radius_docs_blog_style' );
$blog_classes = radius_docs_option( 'radius_docs_blog_masonry' ) ? 'radius-docs-masonry-grid' : '';
?>
	<div id="primary" class="content-area">
		<div class="container">
			<div class="row align-stretch">
				<div class="<?php echo esc_attr( Fns::content_columns() ); ?>">
					<main id="main" class="site-main" role="main">
						<div class="row blog-wrapper-row <?php echo esc_attr( $blog_classes ); ?>">
							<?php
							if ( have_posts() ) :
								/* Start the Loop */
								while ( have_posts() ) :
									the_post();
									get_template_part( 'template-parts/blog/content', $blog_style );
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
