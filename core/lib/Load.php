<?php
namespace core\lib;
class Load {
	static function autoload($name) {
		$name = strtr($name, '\\', DS);
		$filename = BX_ROOT . $name . '.php';
		if (is_file($filename)) {
			include_once $filename;
		} else {
			show_error('file ' . $name . '.php is not exists');
		}
	}
}
?>