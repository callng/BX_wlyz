<?php
namespace app\common\lib;
use core\lib\Db;
class InsertLog {
	private $id;
	private $con;
	public function __construct($id) {
		$this->id = $id;
		$this->con = Db::getInstance();
	}
	public function menber($type,$details,$direction='1') {
		$this->con->insert('menber_log',array('direction'=>$direction,'menber_id'=>$this->id,'type'=>$type,'details'=>$details,'ip'=>get_ip(),'time'=>time()));
	}
	public function user($id,$type,$details) {
		$this->con->insert('user_log',array('user_id'=>$id,'software_id'=>$this->id,'type'=>$type,'details'=>$details,'ip'=>get_ip(),'time'=>time()));
	}
	public function recharge($id,$m_id,$time,$time_type,$point,$r_time,$e_time,$cardnum) {
		$this->con->insert('recharge_log',array('user_id'=>$id,'software_id'=>$this->id,'menber_id'=>$m_id,'time'=>$time,'time_type'=>$time_type,'point'=>$point,'recharge_time'=>$r_time,'endtime'=>$e_time,'cardnum'=>$cardnum));
	}
}
?>