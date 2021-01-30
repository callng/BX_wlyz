<?php
namespace app\agent\model;
use app\agent\Auth;
use core\lib\Db;
use app\common\lib\InsertLog;
class Common {
	protected $con;
	protected $log;
	protected function init() {
		$this->con = Db::getInstance();
		$this->log = new InsertLog(Auth::get('id'));
	}
	protected function getAuthority($array=null) {
		if(is_array($array)) {
			return $this->con->select('agent_authority','menber_id = ' . Auth::get('id'),'','','',implode(',',$array));
		} else {
			return $this->con->select('agent_authority','menber_id = ' . Auth::get('id'));
		}
	}
}
?>