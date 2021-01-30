<?php
namespace app\verifycode\controller;
use core\lib\ValidateCode;
class Index {
	function index() {
		session_start();
		$_vc = new ValidateCode;
		$_vc->doimg();
		$_SESSION['bx']['verifycode'] = $_vc->getCode();
	}
}
?>