<?php
namespace core\lib;
class Config {
	private static $config = [];
	public static function set($value) {
		self::$config = $value;
	}
	public static function get($name = null) {
		if (empty($name)) {
			return self::$config;
		}
		if (!strpos($name, '.')) {
			return isset(self::$config[$name]) ? self::$config[$name] : null;
		} else {
			$name = explode('.', $name, 2);
			return isset(self::$config[$name[0]][$name[1]]) ? self::$config[$name[0]][$name[1]] : null;
		}
	}
}
?>