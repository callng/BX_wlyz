<?php
namespace app\admin\controller;
use core\lib\Db;
use app\admin\model\User as model;
class User extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function lists() {
		$lists = post_lists();
		$where[] = isset($_POST['software_id']) && $_POST['software_id'] != '' ? "pre_user.software_id = {$_POST['software_id']}" : '';
		$where[] = isset($_POST['congeal']) && $_POST['congeal'] != '' ? "pre_user.congeal = {$_POST['congeal']}" : '';
		if(isset($_POST['state']) && $_POST['state'] != '') {
			if($_POST['state'] == '1') {
				$where[] = 'pre_user.heart_beat < ' . time();
			} else {
				$where[] = 'pre_user.state = 2 and pre_user.heart_beat >= ' . time();
			}
		}
		if(isset($_POST['menber_name']) && $_POST['menber_name'] != '') {
			$con = Db::getInstance();
			$menber = $con->select('menber',"username='{$_POST['menber_name']}'",'','','','id');
			$where[] = 'pre_user.menber_id = ' . (isset($menber['0']['id']) ? $menber['0']['id'] : '0');
		}
		$where[] = isset($_POST['username']) && $_POST['username'] != '' ? "pre_user.username = '{$_POST['username']}'" : '';
		if(isset($_POST['regtime_start']) && $_POST['regtime_start'] != '') {
			$_POST['regtime_start'] = strtotime($_POST['regtime_start']);
			if($_POST['regtime_start'] === FALSE) {
				exit (bx_msg('参数错误','请填写正确的时间格式','error'));
			}
			$where[] = "pre_user.regtime >= {$_POST['regtime_start']}";
		}
		if(isset($_POST['regtime_end']) && $_POST['regtime_end'] != '') {
			$_POST['regtime_end'] = strtotime($_POST['regtime_end']);
			if($_POST['regtime_end'] === FALSE) {
				exit (bx_msg('参数错误','请填写正确的时间格式','error'));
			}
			$where[] = "pre_user.regtime <= {$_POST['regtime_end']}";
		}
		if(isset($_POST['endtime_start']) && $_POST['endtime_start'] != '') {
			$_POST['endtime_start'] = strtotime($_POST['endtime_start']);
			if($_POST['endtime_start'] === FALSE) {
				exit (bx_msg('参数错误','请填写正确的时间格式','error'));
			}
			$where[] = "pre_user.endtime >= {$_POST['endtime_start']}";
		}
		if(isset($_POST['endtime_end']) && $_POST['endtime_end'] != '') {
			$_POST['endtime_end'] = strtotime($_POST['endtime_end']);
			if($_POST['endtime_end'] === FALSE) {
				exit (bx_msg('参数错误','请填写正确的时间格式','error'));
			}
			$where[] = "pre_user.endtime <= {$_POST['endtime_end']}";
		}
		if(isset($_POST['point_start']) && $_POST['point_start'] != '' && is_numeric($_POST['point_start'])) {
			$where[] = "pre_user.point >= {$_POST['point_start']}";
		}
		if(isset($_POST['point_end']) && $_POST['point_end'] != '' && is_numeric($_POST['point_end'])) {
			$where[] = "pre_user.point <= {$_POST['point_end']}";
		}
		$search = sql_and($where);
		$this->model->lists($search, $lists['page'],$lists['limit']);
	}
	public function getInfo() {
		$user_id = post_id();
		$this->model->getInfo($user_id);
	}
	public function edit() {
		$user_id = post_id();
		$edit['congeal'] = isset($_POST['congeal'])?$_POST['congeal']:'';
		$edit['endtime'] = isset($_POST['endtime'])?$_POST['endtime']:'';
		$edit['point'] = isset($_POST['point']) && is_numeric($_POST['point']) ? $_POST['point']:exit(bx_msg('参数错误','参数错误','error'));
		$edit['user_data'] = isset($_POST['user_data'])?$_POST['user_data']:'';
		$edit['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		$machine_code = isset($_POST['machine_code'])?$_POST['machine_code']:'';
		$state = isset($_POST['state'])?$_POST['state']:'';
		if($edit['congeal'] != '' && $edit['endtime'] != '' && $edit['point'] != '') {
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
			$this->model->edit($user_id, $edit);
		} else {
			exit(bx_msg('参数错误','参数错误','error'));
		}
	}
	public function delete() {
		$user_id = post_id();
		$this->model->delete($user_id);
	}
}
?>