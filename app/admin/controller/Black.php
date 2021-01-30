<?php
namespace app\admin\controller;
use core\lib\Db;
use app\admin\model\Black as model;
class Black extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function add() {
		$add['type'] = isset($_POST['type'])?$_POST['type']:'';
		$add['software_id'] = isset($_POST['software_id'])?$_POST['software_id']:'';
		$add['feature'] = isset($_POST['feature'])?$_POST['feature']:'';
		$add['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		if($add['type'] != '' && $add['software_id'] != '' && $add['feature'] != '') {
			$this->model->add($add);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function lists() {
		$lists = post_lists();
		$where[] = isset($_POST['type']) && $_POST['type'] != '' ? "pre_black.type = {$_POST['type']}" : '';
		$where[] = isset($_POST['software_id']) && $_POST['software_id'] != '' ? "pre_black.software_id = {$_POST['software_id']}" : '';
		if(isset($_POST['menber_name']) && $_POST['menber_name'] != '') {
			$con = Db::getInstance();
			$menber = $con->select('menber',"username='{$_POST['menber_name']}'",'','','','id');
			$where[] = 'pre_black.menber_id = ' . (isset($menber['0']['id']) ? $menber['0']['id'] : '-1');
		}
		$where[] = isset($_POST['feature']) && $_POST['feature'] != '' ? "pre_black.feature = '{$_POST['feature']}'" : '';
		$where[] = isset($_POST['comment']) && $_POST['comment'] != '' ? "pre_black.comment = '{$_POST['comment']}'" : '';
		$search = sql_and($where);
		$this->model->lists($search,$lists['page'], $lists['limit']);
	}
	public function getInfo() {
		$black_id = post_id();
		$this->model->getInfo($black_id);
	}
	public function edit() {
		$black_id = post_id();
		$edit['type'] = isset($_POST['type'])?$_POST['type']:'';
		$edit['software_id'] = isset($_POST['software_id'])?$_POST['software_id']:'';
		$edit['feature'] = isset($_POST['feature'])?$_POST['feature']:'';
		$edit['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		if($edit['type'] != '' && $edit['software_id'] != '' && $edit['feature'] != '') {
			$this->model->edit($black_id,$edit);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function delete() {
		$black_id = post_id();
		$this->model->delete($black_id);
	}
}
?>