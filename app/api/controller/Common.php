<?php
namespace app\api\controller;
use core\lib\Db;
use app\common\lib\InsertLog;
class Common {
	protected $con;
	protected $log;
	protected $software;
	protected $data;
	protected function init() {
		require BX_ROOT . 'app/api/api_function.php';
		$id = !empty($_POST['id']) ? $_POST['id'] : exit(api_json('400','',false));
		$data = !empty($_POST['data']) ? $_POST['data'] : exit(api_json('400','',false));
		$this->con = Db::getInstance();
		$this->software = $this->con->select('software',"id={$id}");
		if(!$this->software) {
			exit(api_json('404','',false));
		}
		$this->isBlackIp();
		$this->log = new InsertLog($this->software['0']['id']);
		define('API_ENCRYPT',$this->software['0']['encrypt']);
		define('API_KEY',$this->software['0']['s_key']);
		if(API_ENCRYPT == 'defined_encrypt') {
			eval($this->software['0']['defined_encrypt']);
		}
		$this->data = bx_decrypt($data,API_KEY,API_ENCRYPT);
		if(!$this->data) {
			exit(api_json('444','',false));
		}
		if($this->getState() == '2') {
			exit(api_json('403','',false));
		}
		do_action('api_common');
	}
	protected function getState() {
		return $this->software['0']['software_state'];
	}
	protected function parseData() {
		return json_decode($this->data,TRUE);
	}
	protected function getCardTime($time,$type) {
		switch ($type) {
			case '2': $time = $time*60;
			break;
			case '3': $time = $time*3600;
			break;
			case '4': $time = $time*86400;
			break;
			case '5': $time = $time*604800;
			break;
			case '6': $time = $time*2592000;
			break;
			case '7': $time = $time*31536000;
			break;
			default: $time = $card_res['0']['time'];
			break;
		}
		return $time;
	}
	protected function isBlackIp() {
		$ip = get_ip();
		$res = $this->getBlack($ip,2);
		if($res) {
			exit(api_json('405','',false));
		}
	}
	protected function isBlackMachineCode($machine_code) {
		$res = $this->getBlack($machine_code,1);
		if($res) {
			exit(api_json('406','',false));
		}
	}
	private function getBlack($feature,$type) {
		return $this->con->select('black',"feature='{$feature}' and type={$type} and (software_id=0 or software_id={$this->software['0']['id']})");
	}
}
?>