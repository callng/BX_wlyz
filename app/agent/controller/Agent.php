<?php
namespace app\agent\controller;
use app\agent\Auth;
use app\agent\model\Agent as model;
class Agent extends Common {
	function __construct() {
		parent::isLogin();
		parent::isPower('10');
		$this->model = new model;
	}
	public function add() {
		$add['username'] = isset($_POST['username'])?$_POST['username']:'';
		$add['password'] = isset($_POST['password'])?$_POST['password']:'';
		$add['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		if($add['username'] != '' && $add['password'] != '') {
			$this->model->add($add);
		}
		exit(bx_msg('参数错误','请全部填写','error'));
	}
	public function lists() {
		$lists = post_lists();
		$where[] = "pre_menber.boss_id=" . Auth::get('id') ." and (pre_menber.power = 10 or pre_menber.power = 11)";
		$where[] = isset($_POST['congeal']) && $_POST['congeal'] != '' ? "pre_menber.congeal = {$_POST['congeal']}" : '';
		$where[] = isset($_POST['username']) && $_POST['username'] != '' ? "pre_menber.username = '{$_POST['username']}'" : '';
		$search = sql_and($where);
		$this->model->lists($search,$lists['page'], $lists['limit']);
	}
	public function recharge() {
		$agent_id = post_id();
		$money = isset($_POST['money'])?$_POST['money']:'';
		$money = round($money, 2);
		if($money <= 0) {
			exit(bx_msg('参数错误','请输入一个有效的数','error'));
		}
		$this->model->recharge($agent_id, $money);
	}
}
?>