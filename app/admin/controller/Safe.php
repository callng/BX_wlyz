<?php
namespace app\admin\controller;
use app\admin\model\Safe as model;
class Safe extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function passwordChange() {
		$opwd = isset($_POST['opwd']) ? $_POST['opwd'] : '';
		$npwd = isset($_POST['npwd']) ? $_POST['npwd'] : '';
		$this->model->passwordChange($opwd, $npwd);
	}
	public function configEdit() {
		$config['sitename'] = isset($_POST['sitename']) ? $_POST['sitename'] : '';
		$config['table_num'] = isset($_POST['table_num']) ? round($_POST['table_num']) : '';
		if(!is_numeric($config['table_num'])) {
			exit (bx_msg('参数错误','参数错误','error'));
		}
		if($config['table_num'] <= 0) {
			exit (bx_msg('参数错误','请不要填写负数','error'));
		}
		$this->model->configEdit($config);
	}
}
?>