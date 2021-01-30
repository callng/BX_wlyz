<?php
namespace app\admin\controller;
use app\admin\Auth;
class Common {
	protected $model;
	protected function isLogin() {
		if(!Auth::check()) {
			exit;
		}
	}
}
?>