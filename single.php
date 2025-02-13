<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Modules\RelatedPost;

$single_style = isset( $_GET['style'] ) ? sanitize_text_field( $_GET['style'] ) : Opt::$single_style;
get_header();
?>
	<div id="primary" class="content-area">
		<div class="single-post-container">
			<?php while ( have_posts() ) :
				the_post();
				$thumbnail_height = Fns::layout_meta( get_the_ID(), 'post_img_ratio' ); ?>
				<div class="single-inner <?php echo esc_attr( $thumbnail_height ) ?>">
					<?php do_action( 'radius_docs_before_single_content', get_the_ID() ); ?>
					<div class="container">
						<div class="row content-row">
							<div class="content-col <?php echo esc_attr( Fns::single_content_colums() ); ?>">
								<main id="main" class="site-main single-content" role="main">
									<?php
									get_template_part( 'template-parts/blog-details/content-single', $single_style );
									//post thumbnail navigation
									get_template_part( 'template-parts/custom/single', 'pagination' );

									// If comments are open or we have at least one comment, load up the comment template.
									if ( comments_open() || get_comments_number() ) :
										comments_template();
									endif;
									?>
								</main><!-- #main -->
							</div><!-- .col- -->
							<?php get_sidebar(); ?>
						</div><!-- .row -->
						<?php do_action( 'radius_docs_after_single_content' ); ?>
					</div><!-- .container -->
				</div>
			<?php endwhile; ?>
			<?php RelatedPost::radius_docs_post_related('default'); ?>
		</div>
	</div><!-- #primary -->
<?php
get_footer();
