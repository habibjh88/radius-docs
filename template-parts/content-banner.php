<?php
/**
 * Template part for displaying banner content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Modules\Breadcrumb;
use RT\RadiusDocs\Modules\Svg;
use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Helpers\Fns;


if ( ! Opt::$has_banner ) {
	return;
}

$image_url        = wp_get_attachment_image_src( Opt::$banner_image, 'full' );
$banner_image_css = '';
$banner_image_css .= isset( $image_url[0] ) ? "background-image:url({$image_url[0]});" : '';
$banner_image_css .= ! empty( Opt::$banner_height ) ? "min-height:" . rtrim( Opt::$banner_height, 'px' ) . "px;" : "";
$banner_image_css .= Fns::customize_image_attr_css( 'radius_docs_banner_image_attr' );
$has_image        = isset( $image_url[0] );
$classes          = Fns::class_list( [
	'radius-docs-breadcrumb-wrapper',
	$has_image ? 'has-bg' : 'no-bg',
	Opt::$banner_color ? 'has-color' : 'no-color',
	radius_docs_option( 'radius_docs_banner_color_mode' ),
] );

$args        = [
	'delimiter' => "<i class='raw-icon-angle-right'></i>",
	'before'    => '',
	'after'     => '',
];
$breadcrumbs = new Breadcrumb();
$home_title  = _x( 'Home', 'breadcrumb', 'radius-docs' );
$breadcrumbs->add_crumb( $home_title, home_url() ); //Home crumb
$args['breadcrumb'] = $breadcrumbs->generate();

if ( empty( $args['breadcrumb'] ) ) {
	return;
}
if ( is_single() && ! radius_docs_option( 'radius_docs_breadcrumb' ) ) {
	return;
}
?>

<div class="<?php echo esc_attr( $classes ) ?>">
	<?php if ( $has_image ) : ?>
		<span class="banner-image" style="<?php echo esc_attr( $banner_image_css ) ?>"></span>
	<?php endif; ?>
	<div class="container d-flex flex-column <?php echo esc_attr( radius_docs_option( 'radius_docs_breadcrumb_alignment' ) ) ?>">
		<?php if ( Opt::$breadcrumb_title && ! is_single() ) : ?>
			<h1 class="bread-title">
				<?php
				$page_title = end( $args['breadcrumb'] );
				if ( is_post_type_archive() ) {
					$post_type = str_replace('-', '_', get_post_type());
					$archive_title = radius_docs_option( "{$post_type}_banner_title" );
					if ( $archive_title ) {
						echo $archive_title;
					} else if ( is_array( $page_title ) && isset( $page_title[0] ) ) {
						echo esc_html( $page_title[0] );
					}
				} else if ( is_array( $page_title ) && isset( $page_title[0] ) ) {
					echo esc_html( $page_title[0] );
				}
				?>
			</h1>
		<?php endif; ?>

		<?php
		if ( radius_docs_option( 'radius_docs_breadcrumb' ) ) {
			$breadcrumbs->print_breadcrumb( $args );
		}
		?>
	</div>
</div>
