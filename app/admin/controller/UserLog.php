<?php
namespace app\admin\controller;
use app\admin\model\UserLog as model;
class UserLog extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function lists() {
		$lists = post_lists();
		$this->model->lists($lists['page'], $lists['limit']);
	}
	public function delete() {
		$user_log_id = post_id();
		$this->model->delete($user_log_id);
	}
}
?>