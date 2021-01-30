<?php
namespace app\admin\controller;
use core\lib\Db;
use app\admin\model\Card as model;
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
			$this->model->add($add);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function lists() {
		$lists = post_lists();
		$where[] = isset($_POST['software_id']) && $_POST['software_id'] != '' ? "pre_card.software_id = {$_POST['software_id']}" : '';
		$where[] = isset($_POST['state']) && $_POST['state'] != '' ? "pre_card.state = {$_POST['state']}" : '';
		$where[] = isset($_POST['used']) && $_POST['used'] != '' ? "pre_card.used = {$_POST['used']}" : '';
		$where[] = isset($_POST['name']) && $_POST['name'] != '' ? "pre_card.name = '{$_POST['name']}'" : '';
		if(isset($_POST['menber_name']) && $_POST['menber_name'] != '') {
			$con = Db::getInstance();
			$menber = $con->select('menber',"username='{$_POST['menber_name']}'",'','','','id');
			$where[] = 'pre_card.menber_id = ' . (isset($menber['0']['id']) ? $menber['0']['id'] : '0');
		}
		$where[] = isset($_POST['cardnum']) && $_POST['cardnum'] != '' ? "pre_card.cardnum = '{$_POST['cardnum']}'" : '';
		$search = sql_and($where);
		$this->model->lists($search, $lists['page'], $lists['limit']);
	}
	public function getInfo() {
		$card_id = post_id();
		$this->model->getInfo($card_id);
	}
	public function edit() {
		$card_id = post_id();
		$edit['name'] = isset($_POST['name'])?$_POST['name']:'';
		$edit['time'] = isset($_POST['time'])?$_POST['time']:'';
		$edit['time_type'] = isset($_POST['time_type'])?$_POST['time_type']:'';
		$edit['point'] = isset($_POST['point']) && is_numeric($_POST['point']) ? $_POST['point']:exit(bx_msg('参数错误','参数错误','error'));
		;
		$edit['state'] = isset($_POST['state'])?$_POST['state']:'';
		$edit['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		if($edit['name'] != '' && $edit['time'] != '' && $edit['time_type'] != '' && $edit['point'] != ''&& $edit['state'] != '') {
			$this->model->edit($card_id,$edit);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function delete() {
		$card_id = post_id();
		$this->model->delete($card_id);
	}
}
?>