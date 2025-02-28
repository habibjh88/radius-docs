<?php

namespace RT\RadiusDocs\Custom;

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Modules\PostMeta;
use RT\RadiusDocs\Modules\Svg;
use RT\RadiusDocs\Modules\Thumbnail;
use RT\RadiusDocs\Traits\SingletonTraits;
use RT\RadiusDocs\Options\Opt;

/**
 * Hooks Class
 */
class Hooks {

	use SingletonTraits;

	/**
	 * register default hooks and actions for WordPress
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'meta_css' ] );
		add_action( 'radius_docs_before_single_content', [ __CLASS__, 'before_single_content' ] );
		add_filter( 'wp_calculate_image_srcset_meta', '__return_null' );
		add_filter( 'wp_kses_allowed_html', [ __CLASS__, 'custom_wpkses_post_tags' ], 10, 2 );
		add_action( 'wp_footer', [ __CLASS__, 'wp_footer_hook' ] );
		add_action( 'template_redirect', [ __CLASS__, 'change_post_type_safely' ] );

		add_action( 'restrict_manage_posts', [ __CLASS__, 'add_docs_category_filter' ] );
		add_action( 'pre_get_posts', [ __CLASS__, 'filter_docs_by_category' ], 9999 );
	}

	public static function add_docs_category_filter() {
		global $typenow;
		if ( $typenow == 'docs' ) {
			$taxonomy      = 'doc_category'; // Change this to the correct taxonomy if different
			$selected      = isset( $_GET[ $taxonomy ] ) ? $_GET[ $taxonomy ] : '';
			$info_taxonomy = get_taxonomy( $taxonomy );

			wp_dropdown_categories( [
				'show_option_all' => __( "Show All {$info_taxonomy->label}" ),
				'taxonomy'        => $taxonomy,
				'name'            => $taxonomy,
				'orderby'         => 'name',
				'selected'        => $selected,
				'hierarchical'    => true,
				'show_count'      => true,
				'hide_empty'      => false,
			] );
		}
	}

	public static function filter_docs_by_category( $query ) {
		global $pagenow;
		if (
			is_admin() &&
			$pagenow === 'edit.php' &&
			isset( $_GET['doc_category'] ) &&
			! empty( $_GET['doc_category'] ) &&
			isset( $_GET['post_type'] ) &&
			$_GET['post_type'] === 'docs' &&
			$query->is_main_query()
		) {
			$query->set( 'tax_query', [
				'relation' => 'OR',
				[
					'taxonomy' => 'doc_category',
					'field'    => 'term_id', // Use 'term_id' instead of 'id'
					'terms'    => $_GET['doc_category'],
				],
			] );
		}
	}

	public static function change_post_type_safely() {


        if ( ! empty( $_GET['rt_migration'] ) && $_GET['rt_migration'] == 1 && current_user_can( 'manage_options' ) ) {
			$args = [
				'post_type'      => 'post',
				'posts_per_page' => - 1,
				'fields'         => 'ids',
			];

			$posts = get_posts( $args );

			foreach ( $posts as $post_id ) {
				set_post_type( $post_id, 'docs' );
			}

			flush_rewrite_rules();
		}

		if ( ! empty( $_GET['rt_migration_back'] ) && $_GET['rt_migration_back'] == 1 && current_user_can( 'manage_options' ) ) {
			$args = [
				'post_type'      => 'docs',
				'posts_per_page' => - 1,
				'fields'         => 'ids',
			];

			$posts = get_posts( $args );

			foreach ( $posts as $post_id ) {
				set_post_type( $post_id, 'post' );
			}

			flush_rewrite_rules();
		}




		if ( ! empty( $_GET['docs_parent_remove'] ) && $_GET['docs_parent_remove'] == 1 && current_user_can( 'manage_options' ) ) {
			global $wpdb;

			// Update all child posts under 'docs' to remove parent association
			$wpdb->query( "
                UPDATE $wpdb->posts 
                SET post_parent = 0 
                WHERE post_type = 'docs' 
                AND post_parent > 0
            " );

			// Optional: Clear cache to ensure changes take effect
			wp_cache_flush();
		}
	}

	/**
	 * Single post meta visibility
	 *
	 * @param $screen
	 *
	 * @return void
	 */
	public static function meta_css( $screen ) {
		if ( 'post.php' !== $screen ) {
			return;
		}
		global $typenow;
		$display = 'post' === $typenow ? 'table-row' : 'none';
		echo '<style>.single_post_style {display: ' . esc_attr( $display ) . '}</style>';
	}

	/**
	 * Single post top markup for style 2, 3, 4
	 *
	 * @return void
	 */
	public static function before_single_content() {
		$style = Opt::$single_style;
		if ( in_array( $style, [ '2', '3', '4' ] ) ) {
			$has_container = '';
			if ( '2' == $style ) {
				$has_container = 'container';
			}
			?>
            <div class="content-top-area <?php echo esc_attr( $has_container ); ?>">
				<?php Thumbnail::get_thumbnail( 'full', true ); ?>
				<?php if ( $style == '3' ) : ?>
                    <div class='single-top-header'>
                        <div class='container'>


                            <header class="entry-header">
								<?php
								if ( is_singular( 'post' ) && radius_docs_option( 'radius_docs_single_above_meta_visibility' ) ) {
									radius_docs_single_separate_meta();
								}

								the_title( '<h1 class="entry-title default-max-width">', '</h1>' );

								if ( is_singular( 'post' ) && ! empty( Fns::single_meta_lists() ) && radius_docs_option( 'radius_docs_single_meta_visibility' ) ) {
									PostMeta::get_meta( 'post', [
										'include' => Fns::single_meta_lists(),
									] );
								} elseif ( is_singular( 'radius-docs-project' ) && radius_docs_option( 'radius_docs_project_meta_visibility' ) ) {
									PostMeta::get_meta( 'radius-docs-project', [ 'force_exclude' => false ] );
								} elseif ( is_singular( 'radius-docs-service' ) && radius_docs_option( 'radius_docs_service_meta_visibility' ) ) {
									PostMeta::get_meta( 'radius-docs-service', [ 'force_exclude' => false ] );
								}
								?>
                            </header>

                        </div>
                    </div>
				<?php endif; ?>
            </div>
			<?php
		}
	}

	/**
	 * Add exceptions in wp_kses_post tags.
	 *
	 * @param array $tags Allowed tags, attributes, and/or entities.
	 * @param string $context Context to judge allowed tags by. Allowed values are 'post'.
	 *
	 * @return array
	 */
	public static function custom_wpkses_post_tags( $tags, $context ) {
		if ( 'post' === $context ) {
			$tags['iframe'] = [
				'src'             => true,
				'height'          => true,
				'width'           => true,
				'frameborder'     => true,
				'allowfullscreen' => true,
			];

			$tags['svg'] = [
				'class'           => true,
				'aria-hidden'     => true,
				'aria-labelledby' => true,
				'role'            => true,
				'xmlns'           => true,
				'width'           => true,
				'height'          => true,
				'viewbox'         => true,
				'stroke'          => true,
				'fill'            => true,
			];

			$tags['g']     = [ 'fill' => true ];
			$tags['title'] = [ 'title' => true ];
			$tags['path']  = [
				'class'           => true,
				'd'               => true,
				'fill'            => true,
				'stroke-width'    => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'fill-rule'       => true,
				'clip-rule'       => true,
				'stroke'          => true,
			];
		}

		return $tags;
	}

	/**
	 * push style in wp_footer
	 *
	 * @return void
	 */
	public static function wp_footer_hook() {
		echo '<style>#page {opacity: 1 !important;transition: opacity 0.5s 0.1s;}</style>';
	}

}
