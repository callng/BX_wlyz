<?php
namespace app\agent\controller;
use app\agent\model\Safe as model;
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
	public function moneyRecharge() {
		$card = isset($_POST['card']) ? $_POST['card'] : '';
		$this->model->moneyRecharge($card);
	}
}
?>