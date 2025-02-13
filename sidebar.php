<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package RadiusDocs
 */


use RT\RadiusDocs\Helpers\Fns;

if ( is_singular( 'post' ) && is_active_sidebar( Fns::default_sidebar( 'single' ) ) ) {
	radius_docs_sidebar( Fns::default_sidebar( 'single' ) );
} elseif ( ( is_singular( 'radius-docs-service' ) || is_post_type_archive( 'radius-docs-service' ) ) && is_active_sidebar( Fns::default_sidebar( 'service' ) ) ) {
	radius_docs_sidebar( Fns::default_sidebar( 'service' ) );
} elseif ( ( is_singular( 'radius-docs-project' ) || is_post_type_archive( 'radius-docs-project' ) ) && is_active_sidebar( Fns::default_sidebar( 'project' ) ) ) {
	radius_docs_sidebar( Fns::default_sidebar( 'project' ) );
} elseif ( is_page() && is_active_sidebar( Fns::default_sidebar( 'page' ) ) ) {
	radius_docs_sidebar( Fns::default_sidebar( 'page' ) );
} else {
	radius_docs_sidebar( Fns::default_sidebar( 'main' ) );
}

