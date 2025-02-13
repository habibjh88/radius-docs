<?php

namespace RT\RadiusDocs\Custom;

use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Modules\Svg;
use RT\RadiusDocs\Modules\Thumbnail;
use RT\RadiusDocs\Traits\SingletonTraits;
use RT\RadiusDocs\Options\Opt;

/**
 * MenuMeta Class
 */
class MenuMeta {
	use SingletonTraits;

	/**
	 * Hooks for Menu Meta
	 */
	public function __construct() {
		//Menu Customization
		add_action( 'wp_nav_menu_item_custom_fields', [ $this, 'menu_customize' ], 10, 2 );
		add_action( 'wp_update_nav_menu_item', [ $this, 'menu_update' ], 10, 2 );
		add_filter( 'wp_get_nav_menu_items', [ $this, 'menu_modify' ], 11, 3 );
	}

	/**
	 * Menu Customize
	 *
	 * @param $item_id
	 * @param $item
	 *
	 * @return void
	 */
	function menu_customize( $item_id, $item ) {
		// Mega menu
		$_mega_menu = get_post_meta( $item_id, 'radius_docs_mega_menu', true );
		// Query string
		$menu_query_string = get_post_meta( $item_id, 'radius_docs_menu_qs', true );
		?>

		<?php if ( $item->menu_item_parent < 1 ) : ?>
			<p class="description mega-menu-wrapper widefat">
				<label for="radius_docs_mega_menu-<?php echo $item_id; ?>" class="widefat">
					<?php _e( 'Make as Mega Menu', 'radius-docs' ); ?><br>
					<select class="widefat" id="radius_docs_mega_menu-<?php echo esc_attr( $item_id ); ?>" name="radius_docs_mega_menu[<?php echo esc_attr( $item_id ); ?>]">
						<?php
						$options = [
							''                      => __( 'Choose Mega Menu', 'radius-docs' ),
							'mega-menu'             => __( 'Mega menu', 'radius-docs' ),
							'mega-menu hide-header' => __( 'Mega menu - Hide Col Title', 'radius-docs' )
						];

						foreach ( $options as $value => $label ) {
							$selected = ( $_mega_menu == $value ) ? ' selected="selected"' : '';
							echo '<option value="' . esc_attr( $value ) . '"' . esc_attr( $selected ) . '>' . esc_html( $label ) . '</option>';
						}
						?>
					</select>
				</label>
			</p>
		<?php endif; ?>

		<p class="description widefat">
			<label class="widefat" for="radius-docs-menu-qs-<?php echo $item_id; ?>">
				<?php echo esc_html__( 'Query String', 'radius-docs' ); ?><br>
				<input type="text"
				       class="widefat"
				       id="radius-docs-menu-qs-<?php echo $item_id; ?>"
				       name="radius-docs-menu-qs[<?php echo $item_id; ?>]"
				       value="<?php echo esc_html( $menu_query_string ); ?>"
				/>
			</label>
		</p>
		<?php
	}

	/**
	 * Menu Update
	 *
	 * @param $menu_id
	 * @param $menu_item_db_id
	 *
	 * @return void
	 */
	function menu_update( $menu_id, $menu_item_db_id ) {
		$_mega_menu         = isset( $_POST['radius_docs_mega_menu'][ $menu_item_db_id ] ) ? sanitize_text_field( $_POST['radius_docs_mega_menu'][ $menu_item_db_id ] ) : '';
		$query_string_value = isset( $_POST['radius-docs-menu-qs'][ $menu_item_db_id ] ) ? sanitize_text_field( $_POST['radius-docs-menu-qs'][ $menu_item_db_id ] ) : '';

		update_post_meta( $menu_item_db_id, 'radius_docs_mega_menu', $_mega_menu );
		update_post_meta( $menu_item_db_id, 'radius_docs_menu_qs', $query_string_value );
	}

	/**
	 * Modify Menu item
	 *
	 * @param $items
	 * @param $menu
	 * @param $args
	 *
	 * @return mixed
	 */
	function menu_modify( $items, $menu, $args ) {
		foreach ( $items as $item ) {
			$menu_query_string = get_post_meta( $item->ID, 'radius_docs_menu_qs', true );
			if ( $menu_query_string ) {
				$item->url = add_query_arg( $menu_query_string, '', $item->url );
			}
		}

		return $items;
	}
}
