<?php
namespace app\admin\controller;
use app\admin\model\AgentCard as model;
class AgentCard extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function add() {
		$add['name'] = isset($_POST['name'])?$_POST['name']:'';
		$add['money'] = isset($_POST['money'])?$_POST['money']:'';
		$add['head'] = isset($_POST['head'])?$_POST['head']:'';
		$add['count'] = isset($_POST['count'])?$_POST['count']:'';
		$add['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		if($add['name'] != '' && $add['money'] != '' && $add['count'] != '') {
			$this->model->add($add);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function lists() {
		$lists = post_lists();
		$where[] = isset($_POST['state']) && $_POST['state'] != '' ? "state = {$_POST['state']}" : '';
		$where[] = isset($_POST['used']) && $_POST['used'] != '' ? "used = {$_POST['used']}" : '';
		$where[] = isset($_POST['name']) && $_POST['name'] != '' ? "name = '{$_POST['name']}'" : '';
		$where[] = isset($_POST['cardnum']) && $_POST['cardnum'] != '' ? "cardnum = '{$_POST['cardnum']}'" : '';
		$search = sql_and($where);
		$this->model->lists($search, $lists['page'], $lists['limit']);
	}
	public function getInfo() {
		$agent_card_id = post_id();
		$this->model->getInfo($agent_card_id);
	}
	public function edit() {
		$agent_card_id = post_id();
		$edit['name'] = isset($_POST['name'])?$_POST['name']:'';
		$edit['money'] = isset($_POST['money'])?$_POST['money']:'';
		$edit['state'] = isset($_POST['state'])?$_POST['state']:'';
		$edit['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		if($edit['name'] != '' && $edit['money'] != '' && $edit['state'] != '') {
			$this->model->edit($agent_card_id,$edit);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function delete() {
		$agent_card_id = post_id();
		$this->model->delete($agent_card_id);
	}
}
?>