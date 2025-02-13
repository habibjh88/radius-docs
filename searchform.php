<?php
/**
 * @author  RadiusTheme
 * @since   1.0
 * @version 1.0
 */

use RT\RadiusDocs\Modules\Svg;

?>

<form role="search" method="get" class="radius-docs-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<div class="search-box">
		<input type="text" class="search-query form-control" placeholder="<?php esc_attr_e( 'Search here ...', 'radius-docs' ) ?>" value="<?php echo get_search_query(); ?>" name="s">
		<button class="item-btn" type="submit">
			<span class="radius-docs-icon-search"><i class="raw-icon-search"></i></span>
		</button>
	</div>
</form>
