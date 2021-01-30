<?php
namespace core\lib;
define('CHARSET','UTF-8');
class Hook {
	private static $actions = array();
	public static function add_action($hook,$function) {
		$hook=mb_strtolower($hook,CHARSET);
		if(!self::exists_action($hook)) {
			self::$actions[$hook] = array();
		}
		if (is_callable($function)) {
			self::$actions[$hook][] = $function;
			return TRUE;
		}
		return FALSE ;
	}
	public static function do_action($hook,$params=NULL) {
		$hook=mb_strtolower($hook,CHARSET);
		if(isset(self::$actions[$hook])) {
			foreach(self::$actions[$hook] as $function) {
				if (is_array($params)) {
					call_user_func_array($function,$params);
				} else {
					call_user_func($function);
				}
			}
			return TRUE;
		}
		return FALSE;
	}
	public static function get_action($hook) {
		$hook=mb_strtolower($hook,CHARSET);
		return (isset(self::$actions[$hook]))? self::$actions[$hook]:FALSE;
	}
	public static function exists_action($hook) {
		$hook=mb_strtolower($hook,CHARSET);
		return (isset(self::$actions[$hook]))? TRUE:FALSE;
	}
}
?>