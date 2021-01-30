<?php
namespace core\lib;
class Template {
	private static $catalog;
	public static function set ($catalog) {
		self::$catalog = BX_ROOT . $catalog;
	}
	public static function load($name) {
		return self::$catalog . $name;
	}
}
?>