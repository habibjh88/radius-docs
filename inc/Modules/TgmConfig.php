<?php
/**
 * @author  RadiusTheme
 * @since   1.0.0
 * @version 1.1.0
 */

namespace RT\RadiusDocs\Modules;
use RT\RadiusDocs\Traits\SingletonTraits;

require_once get_stylesheet_directory() . '/inc/Lib/class-tgm-plugin-activation.php';
class TgmConfig {

	use SingletonTraits;

	public $base;
	public $path;

	public function __construct() {
		$this->base = 'radius-docs';
		$this->path = get_template_directory() . '/plugin-bundle/';

		add_action( 'tgmpa_register', [ $this, 'register_required_plugins' ] );
	}

	public function register_required_plugins() {
		$plugins = [
			// Bundled
			[
				'name'     => 'RadiusDocs Core',
				'slug'     => 'radius-docs-core',
				'source'   => 'radius-docs-core.zip',
				'required' => true,
				'version'  => '1.0.0'
			],
			[
				'name'     => 'DOWP Framework',
				'slug'     => 'dowp-framework',
				'source'   => 'dowp-framework.zip',
				'required' => true,
				'version'  => '2.8'
			],
			[
				'name'     => 'DOWP Demo Importer',
				'slug'     => 'dowp-demo-importer',
				'source'   => 'dowp-demo-importer.zip',
				'required' => false,
				'version'  => '6.0.1'
			],

			// Repository
			[
				'name'     => esc_html__('Breadcrumb NavXT','radius-docs'),
				'slug'     => 'breadcrumb-navxt',
				'required' => false,
			],
			[
				'name'     => esc_html__('Elementor Page Builder','radius-docs'),
				'slug'     => 'elementor',
				'required' => false,
			],
			[
				'name'     => esc_html__('WP Fluent Forms','radius-docs'),
				'slug'     => 'fluentform',
				'required' => false,
			],
		];

		$config = [
			'id'           => $this->base,
			// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => $this->path,
			// Default absolute path to bundled plugins.
			'menu'         => $this->base . '-install-plugins',
			// Menu slug.
			'has_notices'  => true,
			// Show admin notices or not.
			'dismissable'  => true,
			// If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',
			// If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,
			// Automatically activate plugins after installation or not.
			'message'      => '',
			// Message to output right before the plugins table.
		];

		tgmpa( $plugins, $config );
	}
}
