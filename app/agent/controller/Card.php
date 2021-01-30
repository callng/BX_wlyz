<?php
namespace app\agent\controller;
use app\agent\Auth;
use app\agent\model\Card as model;
class Card extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function add() {
		$add['card_type_id'] = isset($_POST['card_type_id'])?$_POST['card_type_id']:'';
		$add['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		$add['count'] = isset($_POST['count'])?$_POST['count']:'';
		if($add['card_type_id'] != '' && $add['count'] != '') {
			$add['count'] = round($add['count']);
			if($add['count'] <= 0) {
				exit(bx_msg('参数错误','请输入一个有效的数','error'));
			}
			$this->model->add($add);
		} else {
			exit(bx_msg('参数错误','请填写正确','error'));
		}
	}
	public function lists() {
		$lists = post_lists();
		$where[] = "pre_card.menber_id=" . Auth::get('id');
		$where[] = isset($_POST['software_id']) && $_POST['software_id'] != '' ? "pre_card.software_id = {$_POST['software_id']}" : '';
		$where[] = isset($_POST['state']) && $_POST['state'] != '' ? "pre_card.state = {$_POST['state']}" : '';
		$where[] = isset($_POST['used']) && $_POST['used'] != '' ? "pre_card.used = {$_POST['used']}" : '';
		$where[] = isset($_POST['name']) && $_POST['name'] != '' ? "pre_card.name = '{$_POST['name']}'" : '';
		$where[] = isset($_POST['cardnum']) && $_POST['cardnum'] != '' ? "pre_card.cardnum = '{$_POST['cardnum']}'" : '';
		$search = sql_and($where);
		$this->model->lists($search,$lists['page'], $lists['limit']);
	}
	public function delete() {
		$card_id = post_id();
		$this->model->delete($card_id);
	}
}
?>