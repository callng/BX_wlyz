<?php
namespace app\admin\controller;
use app\admin\model\SingleCard as model;
use core\lib\Db;
class SingleCard extends Common {
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
			exit(bx_msg('参数错误','请填写正确','error'));
		}
	}
	public function lists() {
		$lists = post_lists();
		$where[] = isset($_POST['software_id']) && $_POST['software_id'] != '' ? "pre_single_card.software_id = {$_POST['software_id']}" : '';
		$where[] = isset($_POST['congeal']) && $_POST['congeal'] != '' ? "pre_single_card.congeal = {$_POST['congeal']}" : '';
		if(isset($_POST['state']) && $_POST['state'] != '') {
			if($_POST['state'] == '1') {
				$where[] = 'pre_single_card.heart_beat < ' . time();
			} else {
				$where[] = 'pre_single_card.state = 2 and pre_single_card.heart_beat >= ' . time();
			}
		}
		$where[] = isset($_POST['name']) && $_POST['name'] != '' ? "pre_single_card.name = '{$_POST['name']}'" : '';
		if(isset($_POST['menber_name']) && $_POST['menber_name'] != '') {
			$con = Db::getInstance();
			$menber = $con->select('menber',"username='{$_POST['menber_name']}'",'','','','id');
			$where[] = 'pre_single_card.menber_id = ' . (isset($menber['0']['id']) ? $menber['0']['id'] : '0');
		}
		$where[] = isset($_POST['cardnum']) && $_POST['cardnum'] != '' ? "pre_single_card.cardnum = '{$_POST['cardnum']}'" : '';
		$search = sql_and($where);
		$this->model->lists($search,$lists['page'], $lists['limit']);
	}
	public function getInfo() {
		$card_id = post_id();
		$this->model->getInfo($card_id);
	}
	public function edit() {
		$card_id = post_id();
		$edit['name'] = isset($_POST['name'])?$_POST['name']:'';
		$edit['endtime'] = isset($_POST['endtime'])?$_POST['endtime']:'';
		$edit['time'] = isset($_POST['time'])?$_POST['time']:'';
		$edit['time_type'] = isset($_POST['time_type'])?$_POST['time_type']:'';
		$edit['point'] = isset($_POST['point']) && is_numeric($_POST['point']) ? $_POST['point']:exit(bx_msg('参数错误','参数错误','error'));
		;
		$edit['congeal'] = isset($_POST['congeal'])?$_POST['congeal']:'';
		$edit['card_data'] = isset($_POST['card_data'])?$_POST['card_data']:'';
		$edit['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		$machine_code = isset($_POST['machine_code'])?$_POST['machine_code']:'';
		$state = isset($_POST['state'])?$_POST['state']:'';
		if($edit['name'] != '' && $edit['time'] != '' && $edit['time_type'] != '' && $edit['point'] != ''&& $edit['congeal'] != '' && $edit['endtime'] != '') {
			$edit['endtime'] = strtotime($edit['endtime']);
			if($edit['endtime'] === FALSE) {
				exit (bx_msg('参数错误','请填写正确的时间格式','error'));
			}
			if($machine_code == 'on') {
				$edit['machine_code'] = '';
			}
			if($state == "on") {
				$edit['state'] = '1';
			}
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