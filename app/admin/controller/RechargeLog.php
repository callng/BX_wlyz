<?php
namespace app\admin\controller;
use app\admin\model\RechargeLog as model;
class RechargeLog extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function lists() {
		$lists = post_lists();
		$this->model->lists($lists['page'], $lists['limit']);
	}
	public function delete() {
		$recharge_log_id = post_id();
		$this->model->delete($recharge_log_id);
	}
}
?>