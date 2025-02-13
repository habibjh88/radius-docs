<?php
/**
 * Build Gutenberg Blocks
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api;

use RT\RadiusDocs\Traits\SingletonTraits;

/**
 * Gutenberg class
 */
class Gutenberg {
	use SingletonTraits;

	/**
	 * Register default hooks and actions for WordPress
	 *
	 * @return WordPress add_action()
	 */
	public function __construct() {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		add_action( 'init', [ $this, 'gutenberg_init' ] );

	}

	/**
	 * Custom Gutenberg settings
	 * @return
	 */
	public function gutenberg_init() {
		add_theme_support( 'gutenberg', [
			// Theme supports responsive video embeds
			'responsive-embeds' => true,
			// Theme supports wide images, galleries and videos.
			'wide-images'       => true,
		] );

		add_theme_support( 'editor-color-palette', [
			[
				'name' => esc_html__( 'Primary Color', 'radius-docs' ),
				'slug' => 'radius-docs-primary',
				'color' => '#004BFF',
			],
			[
				'name' => esc_html__( 'Secondary Color', 'radius-docs' ),
				'slug' => 'radius-docs-secondary',
				'color' => '#013bc5',
			],
			[
				'name' => esc_html__( 'Yellow Color', 'radius-docs' ),
				'slug' => 'radius-docs-yellow',
				'color' => '#F9BA19',
			],
			[
				'name' => esc_html__( 'Dark gray', 'radius-docs' ),
				'slug' => 'radius-docs-dark-gray',
				'color' => '#696969',
			],
			[
				'name' => esc_html__( 'light gray', 'radius-docs' ),
				'slug' => 'radius-docs-light-gray',
				'color' => '#f8f8f7',
			],
			[
				'name' => esc_html__( 'white', 'radius-docs' ),
				'slug' => 'radius-docs-white',
				'color' => '#ffffff',
			],
		] );

		add_theme_support( 'editor-font-sizes', [
			[
				'name' => esc_html__( 'Small', 'radius-docs' ),
				'size' => 16,
				'slug' => 'small'
			],
			[
				'name' => esc_html__( 'Normal', 'radius-docs' ),
				'size' => 24,
				'slug' => 'normal'
			],
			[
				'name' => esc_html__( 'Large', 'radius-docs' ),
				'size' => 36,
				'slug' => 'large'
			],
			[
				'name' => esc_html__( 'Huge', 'radius-docs' ),
				'size' => 44,
				'slug' => 'huge'
			]
		] );
	}
}
