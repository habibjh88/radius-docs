<?php
/**
 * Template part for single service related
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Modules;

class ServiceRelated {

	public static function radius_docs_service_related() {
		$post_id = get_the_id();
		$current_post = array( $post_id );
		$related_item_number = radius_docs_option( 'radius_docs_service_related_limit' );

		$icon_class 			= '' ;
		if ( !empty( $radius_docs_service_icon ) ) {
			$icon_class 		= 'service-item-icon';
		} else {
			$icon_class 		= 'service-item-image';
		}

		# Making ready to the Query ...
		$query_type = radius_docs_option( 'radius_docs_service_related_query' );

		$args = array(
			'post_type'				 => 'radius-docs-service',
			'post__not_in'           => $current_post,
			'posts_per_page'         => $related_item_number,
			'no_found_rows'          => true,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => true,
			'update_post_term_cache' => false,
		);

		# Checking Related Posts Order ----------
		if( radius_docs_option( 'radius_docs_service_related_sort' ) ){

			$post_order = radius_docs_option( 'radius_docs_service_related_sort' );

			if( $post_order == 'rand' ){

				$args['orderby'] = 'rand';
			}
			elseif( $post_order == 'views' ){

				$args['orderby']  = 'meta_value_num';
			}
			elseif( $post_order == 'popular' ){

				$args['orderby'] = 'comment_count';
			}
			elseif( $post_order == 'modified' ){

				$args['orderby'] = 'modified';
				$args['order']   = 'ASC';
			}
			elseif( $post_order == 'recent' ){

				$args['orderby'] = '';
				$args['order']   = '';
			}
		}


		# Get related posts by author ----------
		if( $query_type == 'author' ){
			$args['author'] = get_the_author_meta( 'ID' );
		}

		# Get related posts by tags ----------
		elseif( $query_type == 'tag' ){
			$tags_ids  = array();
			$post_tags = get_the_terms( $post_id, 'post_tag' );

			if( ! empty( $post_tags ) ){
				foreach( $post_tags as $individual_tag ){
					$tags_ids[] = $individual_tag->term_id;
				}

				$args['tag__in'] = $tags_ids;
			}
		}

		# Get related posts by categories ----------
		else {

			$terms = get_the_terms( $post_id, 'radius-docs-service-category' );
			if ( $terms && ! is_wp_error( $terms ) ) {

				$port_cat_links = array();

				foreach ( $terms as $term ) {
					$port_cat_links[] = $term->term_id;
				}

				$args['tax_query'] = array (
					array (
						'taxonomy' => 'radius-docs-service-category',
						'field'    => 'ID',
						'terms'    => $port_cat_links,
					)
				);
			}

		}

		# Get the posts ----------
		$related_query = new \WP_Query( $args );
		if( $related_query->have_posts() && radius_docs_option( 'radius_docs_service_related' ) ) { ?>
			<div class="radius-docs-service-default radius-docs-service-multi-layout-1 radius-docs-related-service">
				<div class="container">
					<h2 class="related-title"><?php radius_docs_html( radius_docs_option( 'radius_docs_service_related_title' ) , 'allow_title' );?></h2>
					<div class="row">
						<?php while ( $related_query->have_posts() ) {
						$related_query->the_post();

						$content = get_the_content();
						$content = apply_filters( 'the_content', $content );
						$content = wp_trim_words( get_the_excerpt(), radius_docs_option( 'radius_docs_service_excerpt_limit' ), '' );

						$id = get_the_ID();
						$radius_docs_service_icon= get_post_meta( $id, 'radius_docs_service_icon', true );
						?>
						<div class="col-sm-6 col-xl-4 col-lg-4" >
							<article id="post-<?php the_ID(); ?>">
								<div class="service-item <?php echo esc_attr( $icon_class ); ?>">
									<div class="service-thumbs">
										<?php
										if( has_post_thumbnail() ) {
											radius_docs_post_thumbnail('');
										} else if (!empty( $radius_docs_service_icon )  ) { ?>
											<div class="service-icon"><i class="<?php radius_docs_html( $radius_docs_service_icon , false );?>"></i></div>
										<?php } ?>
									</div>
									<div class="service-content">
										<div class="service-info">
											<h3 class="service-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
											<?php if ( radius_docs_option( 'radius_docs_service_ar_excerpt' ) ) { ?>
												<p><?php radius_docs_html( $content , false ); ?></p>
											<?php } if ( radius_docs_option( 'radius_docs_service_read_more' ) ) { ?>
											<div class="radius-docs-button">
												<a class="btn button-2" href="<?php the_permalink();?>">
													<div class="btn-wrap">
														<?php esc_html_e('See Details' , 'radius-docs' ); ?><i class="icon-radius-docs-arrow-right-1"></i>
													</div>
												</a>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</article>
						</div>
					<?php } ?>
					</div>
				</div>
			</div>
		<?php }
		wp_reset_postdata();
	}
}
?>
