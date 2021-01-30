<?php
namespace app\agent\controller;
use app\agent\Auth;
use core\lib\Db;
use core\lib\Template;
class Home {
	public function show() {
		$config = get_config();
		Template::set("template/{$config['template_agent']}/agent/");
		if(!Auth::check()) {
			require Template::load('login.php');
			exit;
		}
		require BX_ROOT . 'app/agent/template_function.php';
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
			$con->insert('menber_log',array('direction'=>'2','menber_id'=>'0','type'=>'1','details'=>"登陆失败! 账号:{$username}, 密码:{$password}",'ip'=>get_ip(),'time'=>time()));
			echo bx_msg('登录失败','账号或密码错误','error');
		} elseif($res == 2) {
			$con->insert('menber_log',array('direction'=>'2','menber_id'=>Auth::get('id'),'type'=>'1','details'=>'成功登陆代理后台','ip'=>get_ip(),'time'=>time()));
			echo bx_msg('登录成功','登录成功','success');
		} elseif($res == 4) {
			echo bx_msg('登录失败','您的账号已被停封','error');
		} else {
			$con->insert('menber_log',array('direction'=>'2','menber_id'=>'0','type'=>'1','details'=>"登陆失败! 账号:{$username}, 密码:{$password}",'ip'=>get_ip(),'time'=>time()));
			echo bx_msg('登录失败','账号或密码错误','error');
		}
	}
	public function logout() {
		Auth::logout();
		echo bx_msg('退出成功','退出成功','success');
	}
}
?>