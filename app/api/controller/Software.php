<?php
namespace app\api\controller;
class Software extends Common {
	function __construct() {
		parent::init();
	}
	public function getInfo() {
		do_action('api_software_sw');
		$res['version'] = $this->software['0']['version'];
		$res['notice'] = $this->software['0']['notice'];
		$res['update_data'] = $this->software['0']['update_data'];
		$res['update_type'] = $this->software['0']['update_type'];
		$res['static_data'] = $this->software['0']['static_data'];
		$res['trial_interval'] = $this->software['0']['trial_interval'];
		$res['software_state'] = $this->software['0']['software_state'];
		$res['bindingdel_type'] = $this->software['0']['bindingdel_type'];
		exit(api_json('1',$res));
	}
	public function remoteFun() {
		$data = $this->parseData();
		empty($data['name']) ? exit(api_json('1402')) : FALSE;
		do_action('api_software_remote_fun',[$data]);
		eval($this->software['0']['remote']);
		if(!function_exists($data['name'])) {
			exit(api_json('1401'));
		}
		$fun_param_num = count(get_fucntion_parameter_name($data['name']));
		if($fun_param_num != '0') {
			empty($data['param']) ? exit(api_json('1402')) : FALSE;
			$res_param_num = count($data['param']);
			if($fun_param_num != $res_param_num) {
				exit(api_json('1403'));
			}
		} else {
			$data['param'] = array();
		}
		exit(api_json('1408', array('result'=>@call_user_func_array($data['name'],$data['param'])) ));
	}
	public function addBlack() {
		$data = $this->parseData();
		empty($data['type']) ? exit(api_json('2502')) : FALSE;
		($data['type'] != '1' && $data['type'] != '2') ? exit(api_json('2502')) : FALSE;
		if($data['type'] == '2') {
			$data['feature'] = get_ip();
		} else {
			empty($data['feature']) ? exit(api_json('2502')) : FALSE;
		}
		$res = $this->con->select('black',"feature='{$data['feature']}' and type={$data['type']} and (software_id=0 or software_id={$this->software['0']['id']})");
		if($res) {
			exit(api_json('2501'));
		}
		$add['type'] = $data['type'];
		$add['feature'] = $data['feature'];
		$add['comment'] = isset($data['comment']) ? $data['comment'] : '';
		$add['time'] = time();
		$add['menber_id'] = 0;
		if(isset($data['global']) && $data['global'] == TRUE) {
			$add['software_id'] = 0;
		} else {
			$add['software_id'] = $this->software['0']['id'];
		}
		$this->con->insert('black',$add);
		exit(api_json('2503'));
	}
}
?>