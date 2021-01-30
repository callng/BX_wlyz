<?php
namespace app\admin;
use core\lib\Db;
class Auth {
	public static $menber = array();
	public static function login($u,$pw) {
		$con = Db::getInstance();
		$user = $con->select('menber',"username='{$u}' and power=1");
		if(!$user) {
			return 1;
		}
		if(md5($pw . $user['0']['salt']) == $user['0']['password']) {
			setcookie('admin_u',$user['0']['username'],time()+3600,'/');
			setcookie('admin_p',authcode($pw,'',$user['0']['salt']),time()+3600,'/');
			self::$menber = $user;
			return 2;
		} else {
			return 3;
		}
	}
	public static function check() {
		if(isset($_COOKIE['admin_u']) && isset($_COOKIE['admin_p'])) {
			$con = Db::getInstance();
			$user = $con->select('menber',"username='{$_COOKIE['admin_u']}' and power=1");
			if(!$user) {
				return false;
			}
			if(md5(authcode($_COOKIE['admin_p'],'DECODE',$user['0']['salt']) . $user['0']['salt']) != $user['0']['password']) {
				return false;
			}
			setcookie('admin_u',$user['0']['username'],time()+3600,'/');
			setcookie('admin_p',$_COOKIE['admin_p'],time()+3600,'/');
			self::$menber = $user;
			return true;
		}
		return false;
	}
	public static function logout() {
		setcookie('admin_u','',time()-3600,'/');
		setcookie('admin_p','',time()-3600,'/');
	}
	public static function get($a) {
		return self::$menber['0'][$a];
	}
}
?>