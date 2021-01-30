<?php
namespace app\admin\controller;
use app\admin\model\MenberLog as model;
class MenberLog extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function lists() {
		$lists = post_lists();
		$agent = isset($_GET['agent']) ? $_GET['agent'] : '';
		$agent == 'yes' ? $where = 'direction=2' : $where = 'direction=1';
		$this->model->lists($where,$lists['page'], $lists['limit']);
	}
	public function delete() {
		$menber_log_id = post_id();
		$this->model->delete($menber_log_id);
	}
}
?>