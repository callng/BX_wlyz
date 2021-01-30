<?php
namespace app\admin\controller;
use app\admin\Auth;
use core\lib\Db;
use core\lib\Template;
class Home {
	public function show() {
		$config = get_config();
		Template::set("template/{$config['template_admin']}/admin/");
		if(!Auth::check()) {
			require Template::load('login.php');
			exit;
		}
		require BX_ROOT . 'app/admin/template_function.php';
		require Template::load('load_config.php');
	}
	public function login() {
		session_start();
		$verifycode = isset($_POST['verifycode'])?$_POST['verifycode']:'';
		$verifycode = strtolower($verifycode);
		if(!isset($_SESSION['bx']['verifycode']) || $verifycode != $_SESSION['bx']['verifycode']) {
			exit (bx_msg('验证码错误','验证码错误','error'));
		}
		unset($_SESSION['bx']['verifycode']);
		$username = isset($_POST['username'])?$_POST['username']:'';
		$password = isset($_POST['password'])?$_POST['password']:'';
		if ($username == '' || $password == '') {
			exit (bx_msg('参数错误',"用户名或密码不能为空",'error'));
		}
		$con = Db::getInstance();
		$res = Auth::login($username, $password);
		if($res == 1) {
			$con->insert('menber_log',array('direction'=>'1','menber_id'=>'0','type'=>'1','details'=>"登录失败! 账号:{$username}, 密码:{$password}",'ip'=>get_ip(),'time'=>time()));
			echo bx_msg('登录失败','账号或密码错误','error');
		} elseif($res == 2) {
			$con->insert('menber_log',array('direction'=>'1','menber_id'=>Auth::get('id'),'type'=>'1','details'=>'成功登录系统后台','ip'=>get_ip(),'time'=>time()));
			echo bx_msg('登录成功','登录成功','success');
		} else {
			$con->insert('menber_log',array('direction'=>'1','menber_id'=>'0','type'=>'1','details'=>"登录失败! 账号:{$username}, 密码:{$password}",'ip'=>get_ip(),'time'=>time()));
			echo bx_msg('登录失败','账号或密码错误','error');
		}
	}
	public function logout() {
		Auth::logout();
		echo bx_msg('退出成功','退出成功','success');
	}
}
?>