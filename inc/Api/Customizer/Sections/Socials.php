<?php
/**
 * Theme Customizer - Header
 *
 * @package RadiusDocs
 */

namespace RT\RadiusDocs\Api\Customizer\Sections;

use RT\RadiusDocs\Api\Customizer;
use RT\RadiusDocs\Helpers\Fns;
use RT\RadiusDocs\Framework\Customize\Customize;

/**
 * Socials class
 */
class Socials extends Customizer {

	protected $section_socials = 'radius_docs_socials_section';

	/**
	 * Register controls
	 * @return void
	 */
	public function register() {
		Customize::add_section( [
			'id'          => $this->section_socials,
			'panel'       => 'radius_docs_contact_social_panel',
			'title'       => __( 'Socials Information', 'radius-docs' ),
			'description' => __( 'Socials Section', 'radius-docs' ),
			'priority'    => 2
		] );

		Customize::add_controls( $this->section_socials, $this->get_controls() );
	}

	/**
	 * Get controls
	 * @return array
	 */
	public function get_controls() {
		$social_list      = Fns::get_socials();
		$social_icon_list = [];
		$count            = 1;
		foreach ( $social_list as $id => $social ) {
			$social_icon_list[ $id ] = [
				'type'    => 'text',
				'label'   => $social['title'],
				'default' => in_array( $id, [ 'facebook', 'twitter', 'linkedin' ] ) ? '#' : ''
			];
			if ( $count == 1 ) {
				$social_icon_list[ $id ]['edit-link'] = '.topbar-row .social-icon, .footer-social';
			}
			$count ++;
		}

		return apply_filters( 'radius_docs_socials_controls', $social_icon_list );
	}
}
