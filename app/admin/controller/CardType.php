<?php
namespace app\admin\controller;
use app\admin\model\CardType as model;
class CardType extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function add() {
		$add;
		self::add_edit($add);
		if($add['software_id'] != '' && $add['name'] != '' && $add['state'] != '' && $add['time'] != '' && $add['time_type'] != '' && $add['point'] != '' && $add['money'] != '') {
			$this->model->add($add);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function lists() {
		$lists = post_lists();
		$this->model->lists($lists['page'], $lists['limit']);
	}
	public function getInfo() {
		$card_id = post_id();
		$this->model->getInfo($card_id);
	}
	public function edit() {
		$card_id = post_id();
		$edit;
		self::add_edit($edit);
		if($edit['software_id'] != '' && $edit['name'] != '' && $edit['state'] != '' && $edit['time'] != '' && $edit['time_type'] != '' && $edit['point'] != '' && $edit['money'] != '') {
			$this->model->edit($card_id, $edit);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function delete() {
		$card_id = post_id();
		$this->model->delete($card_id);
	}
	public function softwareLists() {
		$card_id = post_id();
		$this->model->softwareLists($card_id);
	}
	private function add_edit(&$val) {
		$val['software_id'] = isset($_POST['software_id'])?$_POST['software_id']:'';
		$val['name'] = isset($_POST['name'])?$_POST['name']:'';
		$val['state'] = isset($_POST['state'])?$_POST['state']:'';
		$val['head'] = isset($_POST['head'])?$_POST['head']:'';
		$val['time'] = isset($_POST['time'])?$_POST['time']:'';
		$val['time_type'] = isset($_POST['time_type'])?$_POST['time_type']:'';
		$val['point'] = isset($_POST['point']) && is_numeric($_POST['point']) ? $_POST['point']:exit(bx_msg('参数错误','参数错误','error'));
		;
		$val['money'] = isset($_POST['money'])?$_POST['money']:'';
		$val['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
	}
}
?>