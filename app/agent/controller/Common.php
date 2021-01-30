<?php
namespace app\agent\controller;
use app\agent\Auth;
class Common {
	protected $model;
	protected function isLogin() {
		if(!Auth::check()) {
			exit;
		}
	}
	protected function isPower($id) {
		if(Auth::get('power') != $id) {
			exit;
		}
	}
}
?>