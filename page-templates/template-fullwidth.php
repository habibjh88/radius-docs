<?php
/**
 * Template Name: Fullwidth Template
 *
 * @link https://developer.wordpress.org/themes/template-files-section/page-template-files/
 *
 * @package RadiusDocs
 */


use RT\RadiusDocs\Helpers\Fns;

get_header(); ?>
	<div id="primary" class="content-area">
		<div class="container">

			<div class="row">
				<div class="<?php echo esc_attr( Fns::content_columns() ); ?>">
					<main id="main" class="site-main" role="main">

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();

							get_template_part( 'template-parts/content', 'page' );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;

						endwhile;

						?>

					</main><!-- #main -->

				</div><!-- .col- -->

				<?php get_sidebar(); ?>

			</div><!-- .row -->

		</div><!-- .container -->
	</div>

<?php
get_footer();
