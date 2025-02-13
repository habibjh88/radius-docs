<?php
/**
 * Theme Customizer
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api;

use RT\RadiusDocs\Api\Customizer\Pannels;
use RT\RadiusDocs\Traits\SingletonTraits;

/**
 * Customizer class
 */
class Customizer {
	use SingletonTraits;

	public static $default_value = [];

	/**
	 * register default hooks and actions for WordPress
	 * @return
	 */
	public function __construct() {
		new Pannels();
		add_action( 'after_setup_theme', [ $this, 'register_controls' ] );
		add_action( 'after_setup_theme', [ $this, 'get_controls_default_value' ] );
	}

	/**
	 * Add customize controls
	 * @return string[]
	 */
	public static function add_controls() {
		$classess = [
			Customizer\Sections\General::class,
			Customizer\Sections\SiteIdentity::class,
			Customizer\Sections\Header::class,
			Customizer\Sections\Topbar::class,
			Customizer\Sections\Banner::class,
			Customizer\Sections\TypographyBody::class,
			Customizer\Sections\TypographyHeading::class,
			Customizer\Sections\TypographyMenu::class,
			Customizer\Sections\Blog::class,
			Customizer\Sections\BlogSingle::class,
			Customizer\Sections\Service::class,
			Customizer\Sections\Project::class,
			Customizer\Sections\Contact::class,
			Customizer\Sections\Socials::class,
			Customizer\Sections\ColorSite::class,
			Customizer\Sections\ColorTopbar::class,
			Customizer\Sections\ColorHeader::class,
			Customizer\Sections\ColorBanner::class,
			Customizer\Sections\ColorFooter::class,
			Customizer\Sections\Labels::class,
			Customizer\Sections\LayoutsPage::class,
			Customizer\Sections\LayoutsBlogs::class,
			Customizer\Sections\LayoutsSingle::class,
			Customizer\Sections\LayoutsService::class,
			Customizer\Sections\LayoutsServiceSingle::class,
			Customizer\Sections\LayoutsProject::class,
			Customizer\Sections\LayoutsProjectSingle::class,
			Customizer\Sections\LayoutsError::class,
			Customizer\Sections\Footer::class,
			Customizer\Sections\ZControllerExample::class,
			Customizer\Sections\Error::class,
		];

		if ( class_exists( 'WooCommerce' ) ) {
			$classess[] = Customizer\Sections\LayoutsWooSingle::class;
			$classess[] = Customizer\Sections\LayoutsWooArchive::class;
		}


		return $classess;
	}

	/**
	 * Register all controls dynamically
	 *
	 * @param string $section_general
	 */
	public function register_controls() {
		foreach ( self::add_controls() as $class ) {
			$control = new $class();
			if ( method_exists( $control, 'register' ) ) {
				$control->register();
			}
		}
	}

	/**
	 * Get controls default value
	 * @return void
	 */
	public function get_controls_default_value() {
		foreach ( self::add_controls() as $class ) {
			$control = new $class();
			if ( method_exists( $control, 'get_controls' ) ) {
				$controls = $control->get_controls();
				foreach ( $controls as $id => $control ) {
					self::$default_value[ $id ] = $control['default'] ?? '';
				}
			}
		}

	}
}
