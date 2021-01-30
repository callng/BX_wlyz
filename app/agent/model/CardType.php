<?php
namespace app\agent\model;
use app\agent\Auth;
class CardType extends Common {
	function __construct() {
		parent::init();
	}
	public function softwareLists($id) {
		$res = $this->con->select('card_type',"software_id={$id} and state=1",'','','','name,id,money');
		foreach ($res as $k => $v) {
			$res[$k]['money'] = $res[$k]['money']*(Auth::get('rate')/100);
		}
		echo json_encode($res);
	}
}
?>