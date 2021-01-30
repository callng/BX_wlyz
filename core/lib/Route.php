<?php
namespace core\lib;
class Route {
	private static $rule = [];
	public static $PathParam;
	public static $pathInfo;
	public static $moduel;
	public static $controller;
	public static $action;
	public static function init() {
		self::parseUrlPath();
		@self::ruleInit();
		self::$moduel = (isset(self::$pathInfo[0]) && self::$pathInfo[0] != '') ? self::$pathInfo[0] : Config::get('default_module');
		self::$controller = (isset(self::$pathInfo[1]) && self::$pathInfo[1] != '') ? self::$pathInfo[1] : Config::get('default_controller');
		self::$action = (isset(self::$pathInfo[2]) && self::$pathInfo[2] != '') ? self::$pathInfo[2] : Config::get('default_action');
	}
	public static function load() {
		if(!is_dir(BX_ROOT . "app/" . self::$moduel)) {
			show_error('moduel ' . self::$moduel . ' is not exists!');
		}
		$controller = 'app\\' . self::$moduel . '\controller\\' . self::$controller;
		$action = self::$action;
		if (!class_exists($controller)) {
			show_error('class ' . $controller . ' is not exists');
		}
		include BX_ROOT . 'app/common.php';
		$object = new $controller();
		if(!is_callable(array($object, $action))) {
			show_error('method ' . $action . ' is not exists');
		}
		;
		$reflect = new \ReflectionMethod($object,$action);
		$arg = $reflect->getParameters();
		$param = self::getPathParam();
		$bindParam = [];
		foreach ($arg as $key => $value) {
			if(isset($param[$key])) {
				$bindParam[] = $param[$key];
			} elseif($value->isDefaultValueAvailable()) {
				$bindParam[] = $value->getDefaultValue();
			} else {
				show_error('method  param ' . $value . ' error');
			}
		}
		call_user_func_array( array($object, $action), $bindParam );
	}
	protected static function ruleInit() {
		if(isset(self::$rule[self::$pathInfo[0] . '/' . self::$pathInfo[1] . '/' . self::$pathInfo[2]])) {
			self::$pathInfo[0] = self::$rule[self::$pathInfo[0] . '/' . self::$pathInfo[1] . '/' . self::$pathInfo[2]];
			unset(self::$pathInfo[1]);
			unset(self::$pathInfo[2]);
		} elseif(in_array(self::$pathInfo[0] . '/' . self::$pathInfo[1] . '/' . self::$pathInfo[2],self::$rule)) {
			show_error('rule ' . self::$pathInfo[0] . '/' . self::$pathInfo[1] . '/' . self::$pathInfo[2] .' access denied');
		} elseif(isset(self::$rule[self::$pathInfo[0] . '/' . self::$pathInfo[1]])) {
			self::$pathInfo[0] = self::$rule[self::$pathInfo[0] . '/' . self::$pathInfo[1]];
			unset(self::$pathInfo[1]);
		} elseif(in_array(self::$pathInfo[0] . '/' . self::$pathInfo[1],self::$rule)) {
			show_error('rule ' . self::$pathInfo[0] . '/' . self::$pathInfo[1] .' access denied');
		} elseif(isset(self::$rule[self::$pathInfo[0]])) {
			self::$pathInfo[0] = self::$rule[self::$pathInfo[0]];
		} elseif(in_array(self::$pathInfo[0],self::$rule)) {
			show_error('rule ' . self::$pathInfo[0] .' access denied');
		} else {
			return;
		}
		self::$pathInfo = implode('/', self::$pathInfo);
		self::$pathInfo = explode('/',self::$pathInfo);
	}
	public static function addRule($rule) {
		self::$rule = array_merge(self::$rule,$rule);
	}
	public static function getPathParam() {
		if(is_null(self::$PathParam)) {
			return self::$PathParam = array_slice(self::$pathInfo,3);
		}
		return self::$PathParam;
	}
	private static function parseUrlPath() {
		@self::$pathInfo = explode('/', trim($_SERVER['PATH_INFO'], '/'));
	}
}
?>