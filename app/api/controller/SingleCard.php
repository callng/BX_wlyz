<?php
namespace app\api\controller;
class SingleCard extends Common {
	function __construct() {
		parent::init();
	}
	public function login() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('1702')) : FALSE;
		empty($data['machine_code']) ? exit(api_json('1702')) : FALSE;
		$this->isBlackMachineCode($data['machine_code']);
		do_action('api_single_card_login',[$data]);
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('1701'));
		}
		if($card_res['0']['congeal'] == "2") {
			exit(api_json('1703'));
		}
		if($this->software['0']['binding_type'] == "2") {
			if($card_res['0']['machine_code'] != $data['machine_code'] && $card_res['0']['machine_code'] != '') {
				exit(api_json('1704'));
			}
		}
		if($card_res['0']['endtime'] == '0') {
			$time = $this->getCardTime($card_res['0']['time'], $card_res['0']['time_type']);
		} elseif($this->getState() != '3') {
			if($card_res['0']['endtime'] <= time()) {
				exit(api_json('1705'));
			}
		}
		if($card_res['0']['state'] == '2') {
			if($card_res['0']['heart_beat'] >= time()) {
				if($this->software['0']['login_type'] == "2" && $card_res['0']['machine_code'] != $data['machine_code'] && $card_res['0']['machine_code'] != '') {
					exit(api_json('1706'));
				}
			}
		}
		do {
			$token = create_rand_str(20);
		}
		while ($token == $card_res['0']['token']);
		$login = array('machine_code'=>$data['machine_code'],'token'=>$token,'logtime'=>time(),'logip'=>get_ip(),'heart_beat'=>time() + $this->software['0']['heart_time'],'state'=>'2');
		if(isset($time)) {
			$login['endtime'] = time() + $time;
		}
		$this->con->update('single_card',$login,"cardnum='{$data['cardnum']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('1707', array('endtime'=>isset($login['endtime']) ? $login['endtime'] : $card_res['0']['endtime'],'point'=>$card_res['0']['point'],'token'=>$token) ));
	}
	public function logout() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('2402')) : FALSE;
		empty($data['token']) ? exit(api_json('2402')) : FALSE;
		do_action('api_single_card_logout',[$data]);
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('2401'));
		}
		if($data['token']!= $card_res['0']['token']) {
			exit(api_json('2403'));
		}
		if($card_res['0']['heart_beat'] < time()) {
			exit(api_json('2404'));
		}
		$this->con->update('single_card',array('state'=>'1','token'=>'','heart_beat'=>time()-10),"cardnum='{$data['cardnum']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('2405'));
	}
	public function heart() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('1802')) : FALSE;
		empty($data['token']) ? exit(api_json('1802')) : FALSE;
		do_action('api_single_card_heart',[$data]);
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('1801'));
		}
		if($data['token']!= $card_res['0']['token']) {
			exit(api_json('1803'));
		}
		if($card_res['0']['heart_beat'] < time()) {
			exit(api_json('1804'));
		}
		if($this->getState() != '3') {
			if($card_res['0']['endtime'] < time()) {
				exit(api_json('1805'));
			}
		}
		if($card_res['0']['state'] == '1') {
			exit(api_json('1806'));
		}
		$card['heart_beat'] = time() + $this->software['0']['heart_time'];
		$this->con->update('single_card',$card,"cardnum='{$data['cardnum']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('1807'));
	}
	public function bindingDel() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('1902')) : FALSE;
		empty($data['machine_code']) ? exit(api_json('1902')) : FALSE;
		$this->isBlackMachineCode($data['machine_code']);
		do_action('api_single_card_binding_del',[$data]);
		$data['point_min'] = isset($data['point_min']) && is_numeric($data['point_min']) ? $data['point_min'] : 0;
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('1901'));
		}
		if($this->software['0']['binding_type'] != '2') {
			exit(api_json('1903'));
		}
		if($data['machine_code'] == $card_res['0']['machine_code']) {
			exit(api_json('1904'));
		}
		if($this->software['0']['bindingdel_type'] == '2') {
			exit(api_json('1905'));
		}
		if($card_res['0']['machine_code'] == '') {
			exit(api_json('1906'));
		}
		$res_api = array();
		if($this->software['0']['bindingdel_time'] > '0') {
			if($card_res['0']['endtime']-($this->software['0']['bindingdel_time']*60) > time()) {
				$card['endtime'] = $card_res['0']['endtime']-($this->software['0']['bindingdel_time']*60);
				$res_api['bindingdel_time'] = $this->software['0']['bindingdel_time'];
			} else {
				exit(api_json('1907'));
			}
		}
		if($this->software['0']['bindingdel_point'] > '0') {
			$card['point'] = $card_res['0']['point'] - $this->software['0']['bindingdel_point'];
			if($card['point'] < $data['point_min'] ) {
				exit(api_json('1909'));
			}
			$res_api['bindingdel_point'] = $this->software['0']['bindingdel_point'];
		}
		$card['machine_code'] = '';
		$this->con->update('single_card',$card,"cardnum='{$data['cardnum']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('1908',$res_api));
	}
	public function getCardData() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('2002')) : FALSE;
		do_action('api_single_card_get_card_data',[$data]);
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('2001'));
		}
		exit(api_json('2003', array('card_data'=>$card_res['0']['card_data']) ));
	}
	public function setCardData() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('2102')) : FALSE;
		empty($data['card_data']) ? exit(api_json('2102')) : FALSE;
		do_action('api_single_card_set_card_data',[$data]);
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('2101'));
		}
		$card['card_data'] = $data['card_data'];
		$this->con->update('single_card',$card,"cardnum='{$data['cardnum']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('2103'));
	}
	public function deductPoint() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('2202')) : FALSE;
		empty($data['point']) || !is_numeric($data['point']) || $data['point'] <= 0 ? exit(api_json('2202')) : FALSE;
		do_action('api_single_card_deduct_point',[$data]);
		$data['point_min'] = isset($data['point_min']) && is_numeric($data['point_min']) ? $data['point_min'] : 0;
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('2201'));
		}
		$card['point'] = $card_res['0']['point'] - $data['point'];
		if($card['point'] < $data['point_min'] ) {
			exit(api_json('2203'));
		}
		$this->con->update('single_card',$card,"cardnum='{$data['cardnum']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('2204', array('point'=>$card['point']) ));
	}
	public function queryPoint() {
		$data = $this->parseData();
		empty($data['cardnum']) ? exit(api_json('2302')) : FALSE;
		do_action('api_single_card_query_point',[$data]);
		$card_res = $this->isSingleCard($data['cardnum']);
		if(!$card_res) {
			exit(api_json('2301'));
		}
		exit(api_json('2303', array('point'=>$card_res['0']['point']) ));
	}
	protected function isSingleCard($cardnum) {
		$res = $this->con->select('single_card',"cardnum='{$cardnum}' AND software_id={$this->software['0']['id']}");
		if(!$res) {
			return false;
		}
		return $res;
	}
}
?>