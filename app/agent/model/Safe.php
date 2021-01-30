<?php
namespace app\agent\model;
use app\agent\Auth;
class Safe extends Common {
	function __construct() {
		parent::init();
	}
	public function passwordChange($opwd,$npwd) {
		$res = $this->con->select('menber','id=' . Auth::get('id'));
		if(!$res) {
			exit (bx_msg('参数错误','参数错误','error'));
		}
		if(md5($opwd . $res['0']['salt']) == $res['0']['password']) {
			$salt = create_rand_str(6);
			$password = md5($npwd . $salt);
			$this->con->update('menber', array('password'=>$password,'salt'=>$salt),'id=' . Auth::get('id'));
			$this->log->menber('4',"修改密码:{$npwd}, 成功!",'2');
			Auth::logout();
			exit(bx_msg('修改成功','修改密码成功！请重新登陆','success'));
		} else {
			exit (bx_msg('密码不符','密码不符','error'));
		}
	}
	public function moneyRecharge($card) {
		$card_res = $this->con->select('agent_card',"cardnum='{$card}'");
		if(!$card_res) {
			exit (bx_msg('失败','充值卡不存在!','error'));
		}
		if($card_res['0']['state'] == '2') {
			exit (bx_msg('失败','充值卡已停止使用!','error'));
		}
		if($card_res['0']['used'] == '2') {
			exit (bx_msg('失败','充值卡已被使用!','error'));
		}
		$user_res = $this->con->select('menber','id=' . Auth::get('id'));
		$money = $user_res['0']['money'] + $card_res['0']['money'];
		$this->con->update('agent_card',array('used'=>'2','used_id'=>Auth::get('id')),"cardnum='{$card}'");
		$this->con->update('menber',array('money'=>$money),'id=' . Auth::get('id'));
		$this->log->menber('4',"卡密充值余额:{$card_res['0']['money']}元, 成功!",'2');
		exit (bx_msg('充值成功',"成功充值{$card_res['0']['money']}元",'success','alert'));
	}
}
?>