<?php
namespace app\api\controller;
use core\lib\Db;
class Plugin {
	public function getApi($id,$name='') {
		$con = Db::getInstance();
		$res = $con->select('plugin',"directory='{$id}'");
		if($res) {
			if($name == '') {
				$name = $res['0']['directory'];
			}
			include BX_ROOT . "app/common/plugin/{$res['0']['directory']}/{$name}.api.php";
		}
		exit;
	}
}
?>