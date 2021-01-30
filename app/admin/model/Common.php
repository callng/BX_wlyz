<?php
namespace app\admin\model;
use app\admin\Auth;
use core\lib\Db;
use app\common\lib\InsertLog;
class Common {
	protected $con;
	protected $log;
	protected function init() {
		$this->con = Db::getInstance();
		$this->log = new InsertLog(Auth::get('id'));
	}
}
?>