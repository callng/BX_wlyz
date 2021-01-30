<?php
namespace app\admin\model;
use app\admin\Auth;
class Safe extends Common {
	function __construct() {
		parent::init();
	}
	public function passwordChange($opwd,$npwd) {
		$res = $this->con->select('menber','id = ' . Auth::get('id'));
		if(!$res) {
			exit (bx_msg('参数错误','参数错误','error'));
		}
		if(md5($opwd . $res['0']['salt']) == $res['0']['password']) {
			$salt = create_rand_str(6);
			$password = md5($npwd . $salt);
			$this->con->update('menber', array('password'=>$password,'salt'=>$salt),'id = '. Auth::get('id'));
			$this->log->menber('4','修改密码:***, 成功!');
			Auth::logout();
			exit(bx_msg('修改成功','修改密码成功！请重新登陆','success'));
		} else {
			exit (bx_msg('密码不符','密码不符','error'));
		}
	}
	public function configEdit($edit) {
		set_config($edit);
		$this->log->menber('4','修改主题设置, 成功!');
		exit(bx_msg('修改成功','修改主题成功！','success'));
	}
}
?>