<?php

namespace Isitirio\Core;

class UserGroupProviderRegistry {
	private static $provider;

	public static function set(UserGroupProviderInterface $provider) {
		self::$provider = $provider;
	}
	public static function get() : UserGroupProviderInterface {
		return self::$provider;
	}
}

