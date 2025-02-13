<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Options\Opt;
use RT\RadiusDocs\Helpers\Fns;

$classes = Fns::class_list( [
	'site-footer',
	Opt::$footer_schema
] );
?>
</div><!-- #content -->
<?php if ( radius_docs_option( 'radius_docs_footer_display' ) ) { ?>
	<footer class="<?php echo esc_attr( $classes ); ?>" role="contentinfo">
		<?php get_template_part( 'template-parts/footer/footer', Opt::$footer_style ); ?>
	</footer><!-- #colophon -->
<?php } ?>

</div><!-- #page -->
<?php radius_docs_scroll_top(); ?>
<?php wp_footer();
//$elementor_settings = get_option('elementor_settings');
//error_log(print_r($elementor_settings, true)."\n\n", 3, __DIR__.'/log.txt');;

?>

</body>
</html>
