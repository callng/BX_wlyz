<?php
namespace app\admin\controller;
use app\admin\model\Software as model;
class Software extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function add() {
		$add;
		self::add_edit($add);
		if($add['name'] != '' && $add['heart_time'] != '' && $add['version'] != '' && $add['notice'] != '' && $add['static_data'] != '' && $add['give_time'] != '' && $add['give_point'] != '' && $add['login_type'] != '' && $add['update_data'] != '' && $add['update_type'] != '' && $add['trial_interval'] != '' && $add['trial_data'] != '' && $add['software_state'] != '' && $add['binding_type'] != '' && $add['bindingdel_type'] != '' && $add['bindingdel_time'] != '' && $add['bindingdel_point'] != '' && $add['restrict_regtime'] != '' && $add['restrict_regnum'] != '') {
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
		$software_id = post_id();
		$this->model->getInfo($software_id);
	}
	public function edit() {
		$software_id = post_id();
		$edit;
		self::add_edit($edit);
		if($edit['name'] != '' && $edit['heart_time'] != '' && $edit['version'] != '' && $edit['notice'] != '' && $edit['static_data'] != '' && $edit['give_time'] != '' && $edit['give_point'] != '' && $edit['login_type'] != '' && $edit['update_data'] != '' && $edit['update_type'] != '' && $edit['trial_interval'] != '' && $edit['trial_data'] != '' && $edit['software_state'] != '' && $edit['binding_type'] != '' && $edit['bindingdel_type'] != '' && $edit['bindingdel_time'] != '' && $edit['bindingdel_point'] != '' && $edit['restrict_regtime'] != '' && $edit['restrict_regnum'] != '') {
			$this->model->edit($software_id, $edit);
		} else {
			exit(bx_msg('参数错误','请检查是否填写正确','error'));
		}
	}
	public function delete() {
		$software_id = post_id();
		$this->model->delete($software_id);
	}
	public function getRemoteInfo() {
		$software_id = post_id();
		$this->model->getRemoteInfo($software_id);
	}
	public function editRemote() {
		$software_id = post_id();
		$edit['remote'] = isset($_POST['remote']) ? $_POST['remote'] : exit(bx_msg('参数错误','错误','error'));
		$edit['remote'] = stripslashes($edit['remote']);
		$this->model->editRemote($software_id, $edit);
	}
	public function getEncryptInfo() {
		$software_id = post_id();
		$this->model->getEncryptInfo($software_id);
	}
	public function editEncrypt() {
		$software_id = post_id();
		$edit['encrypt'] = isset($_POST['encrypt']) ? $_POST['encrypt'] : exit(bx_msg('参数错误','错误','error'));
		$edit['defined_encrypt'] = isset($_POST['defined_encrypt']) ? $_POST['defined_encrypt'] : exit(bx_msg('参数错误','错误','error'));
		$edit['defined_encrypt'] = stripslashes($edit['defined_encrypt']);
		$this->model->editEncrypt($software_id, $edit);
	}
	public function againKey() {
		$software_id = post_id();
		$this->model->againKey($software_id);
	}
	private function add_edit(&$val) {
		$val['name'] = isset($_POST['name'])?$_POST['name']:'';
		$val['heart_time'] = isset($_POST['heart_time'])?$_POST['heart_time']:'';
		$val['version'] = isset($_POST['version'])?$_POST['version']:'';
		$val['notice'] = isset($_POST['notice'])?$_POST['notice']:'';
		$val['static_data'] = isset($_POST['static_data'])?$_POST['static_data']:'';
		$val['give_time'] = isset($_POST['give_time'])?$_POST['give_time']:'';
		$val['give_point'] = isset($_POST['give_point'])?$_POST['give_point']:'';
		$val['login_type'] = isset($_POST['login_type'])?$_POST['login_type']:'';
		$val['update_data'] = isset($_POST['update_data'])?$_POST['update_data']:'';
		$val['update_type'] = isset($_POST['update_type'])?$_POST['update_type']:'';
		$val['trial_interval'] = isset($_POST['trial_interval'])?$_POST['trial_interval']:'';
		$val['trial_data'] = isset($_POST['trial_data'])?$_POST['trial_data']:'';
		$val['software_state'] = isset($_POST['software_state'])?$_POST['software_state']:'';
		$val['binding_type'] = isset($_POST['binding_type'])?$_POST['binding_type']:'';
		$val['bindingdel_type'] = isset($_POST['bindingdel_type'])?$_POST['bindingdel_type']:'';
		$val['bindingdel_time'] = isset($_POST['bindingdel_time'])?$_POST['bindingdel_time']:'';
		$val['bindingdel_point'] = isset($_POST['bindingdel_point'])?$_POST['bindingdel_point']:'';
		$val['restrict_regtime'] = isset($_POST['restrict_regtime'])?$_POST['restrict_regtime']:'';
		$val['restrict_regnum'] = isset($_POST['restrict_regnum'])?$_POST['restrict_regnum']:'';
	}
}
?>