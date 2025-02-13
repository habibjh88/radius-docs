<?php
/**
 * Template part for displaying header
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package RadiusDocs
 */

use RT\RadiusDocs\Modules\Svg;
use RT\RadiusDocs\Options\Opt;

if ( ! Opt::$has_top_bar ) {
	return;
}
$topinfo    = ( radius_docs_option( 'radius_docs_contact_address' ) || radius_docs_option( 'radius_docs_phone' ) || radius_docs_option( 'radius_docs_email' ) ) ? true : false;
$_fullwidth = Opt::$header_width == 'full' ? '-fluid' : '';
?>

<div class="radius-docs-topbar">
	<div class="topbar-container container<?php echo esc_attr( $_fullwidth ) ?>">
		<div class="row topbar-row">
			<?php if ( $topinfo ) { ?>
				<div class="topbar-contact mr-auto">
					<?php
					$address = radius_docs_option( 'radius_docs_topbar_address' );
					$phone   = radius_docs_option( 'radius_docs_topbar_phone' );
					$email   = radius_docs_option( 'radius_docs_topbar_email' );

					radius_docs_contact_info( $address, $phone, $email )
					?>
				</div>
			<?php } ?>
			<ul class="topbar-right ml-auto">
				<li class="social-icon">
					<?php if ( radius_docs_option( 'radius_docs_follow_us_label' ) ) { ?>
						<label><?php echo radius_docs_option( 'radius_docs_follow_us_label' ) ?></label>
					<?php } ?>
					<?php radius_docs_get_social_html(); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
