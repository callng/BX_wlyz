<?php
namespace app\agent\controller;
use app\agent\model\CardType as model;
class CardType extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function softwareLists() {
		$card_id = post_id();
		$this->model->softwareLists($card_id);
	}
}
?>