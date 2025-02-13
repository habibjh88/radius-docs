<?php

namespace RT\RadiusDocs\Helpers;

class Constants {

	const RADIUS_DOCS_VERSION = '1.0.0';

	public static function get_version() {
		return WP_DEBUG ? time() : self::RADIUS_DOCS_VERSION;
	}
}

