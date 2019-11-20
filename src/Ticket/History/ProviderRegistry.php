<?php

namespace Isitirio\Ticket\History;

class ProviderRegistry {
	private static $provider;

	public static function set(ProviderInterface $provider) {
		self::$provider = $provider;
	}
	public static function get() : ProviderInterface {
		return self::$provider;
	}
}

