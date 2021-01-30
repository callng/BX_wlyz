<?php
namespace app\agent;
use core\lib\Db;
class Auth {
	public static $menber = array();
	public static function login($u,$pw) {
		$con = Db::getInstance();
		$user = $con->select('menber',"username='{$u}' and (power=10 or power=11)");
		if(!$user) {
			return 1;
		}
		if(md5($pw . $user['0']['salt']) == $user['0']['password']) {
			if($user['0']['congeal'] == '2') {
				return 4;
			}
			setcookie('agent_u',$user['0']['username'],time()+3600,'/');
			setcookie('agent_p',authcode($pw,'',$user['0']['salt']),time()+3600,'/');
			self::$menber = $user;
			return 2;
		} else {
			return 3;
		}
	}
	public static function check() {
		if(isset($_COOKIE['agent_u']) && isset($_COOKIE['agent_p'])) {
			$con = Db::getInstance();
			$user = $con->select('menber',"username='{$_COOKIE['agent_u']}' and (power=10 or power=11)");
			if(!$user) {
				return false;
			}
			if ($user['0']['congeal'] == '2') {
				return false;
			}
			if(md5(authcode($_COOKIE['agent_p'],'DECODE',$user['0']['salt']) . $user['0']['salt']) != $user['0']['password']) {
				return false;
			}
			setcookie('agent_u',$user['0']['username'],time()+3600,'/');
			setcookie('agent_p',$_COOKIE['agent_p'],time()+3600,'/');
			self::$menber = $user;
			return true;
		}
		return false;
	}
	public static function logout() {
		setcookie('agent_u','',time()-3600,'/');
		setcookie('agent_p','',time()-3600,'/');
	}
	public static function get($a) {
		return self::$menber['0'][$a];
	}
}
?>