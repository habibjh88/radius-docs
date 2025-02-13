<?php
/**
 * Template part for Related Post
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Modules;

/**
 * RelatedPost Class
 */
class RelatedPost {

	public static function radius_docs_post_related( $style = 'default' ) {
		if ( ! radius_docs_option( 'radius_docs_post_related' ) ) {
			return;
		}
		$post_id             = get_the_id();
		$current_post        = [ $post_id ];
		$related_item_number = radius_docs_option( 'radius_docs_post_related_limit' );
		$post_order          = radius_docs_option( 'radius_docs_post_related_sort', 'recent' );
		$query_type          = radius_docs_option( 'radius_docs_post_related_query' );

		$args = [
			'post_type'              => 'post',
			'post__not_in'           => $current_post,
			'posts_per_page'         => $related_item_number,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => true,
			'update_post_term_cache' => false,
		];

		if ( $post_order == 'rand' ) {
			$args['orderby'] = 'rand';
		} elseif ( $post_order == 'views' ) {
			$args['orderby'] = 'meta_value_num';
		} elseif ( $post_order == 'popular' ) {
			$args['orderby'] = 'comment_count';
		} elseif ( $post_order == 'modified' ) {
			$args['orderby'] = 'modified';
			$args['order']   = 'ASC';
		} elseif ( $post_order == 'recent' ) {
			$args['orderby'] = '';
			$args['order']   = '';
		}

		if ( $query_type == 'author' ) {
			$args['author'] = get_the_author_meta( 'ID' );
		} elseif ( $query_type == 'tag' ) {
			$tags_ids  = [];
			$post_tags = get_the_terms( $post_id, 'post_tag' );

			if ( ! empty( $post_tags ) ) {
				foreach ( $post_tags as $individual_tag ) {
					$tags_ids[] = $individual_tag->term_id;
				}

				$args['tag__in'] = $tags_ids;
			}
		} else {
			$category_ids = [];
			$categories   = get_the_category( $post_id );

			foreach ( $categories as $individual_category ) {
				$category_ids[] = $individual_category->term_id;
			}

			$args['category__in'] = $category_ids;
		}

		// Get the posts
		$related_query = new \WP_Query( $args );
		if ( $related_query->have_posts() ) { ?>
			<div class="blog-default radius-docs-related-post">
				<div class="container">
					<h2 class="related-title"><?php radius_docs_html( radius_docs_option( 'radius_docs_post_related_title' ), 'allow_title' ); ?></h2>
					<div class="row">
						<?php while ( $related_query->have_posts() ) {
							$related_query->the_post();
							?>
							<article data-post-id="<?php the_ID(); ?>" <?php post_class( 'blog-post-card blog-post-card is-above-meta default col-sm-6 col-xl-4 col-lg-4' ); ?>>
								<div class="article-inner-wrapper">
									<?php Thumbnail::get_thumbnail(); ?>
									<div class="entry-wrapper">
										<header class="entry-related-header">
											<?php
											if ( radius_docs_option( 'radius_docs_blog_above_meta_visibility' ) ) {
												radius_docs_separate_meta();
											}
											the_title( sprintf( '<h2 class="entry-title default-max-width"><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' );
											if ( radius_docs_option( 'radius_docs_meta_visibility' ) ) {
												PostMeta::get_meta();
											}
											?>
										</header>
									</div>
								</div>
							</article>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php }
		wp_reset_postdata();
	}

}

?>
