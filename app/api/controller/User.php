<?php
namespace app\api\controller;
class User extends Common {
	function __construct() {
		parent::init();
	}
	public function register() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('202')) : FALSE;
		empty($data['password']) ? exit(api_json('202')) : FALSE;
		empty($data['super_password']) ? exit(api_json('202')) : FALSE;
		empty($data['machine_code']) ? exit(api_json('202')) : FALSE;
		$this->isBlackMachineCode($data['machine_code']);
		do_action('api_user_register',[$data]);
		$user['comment'] = isset($data['comment']) ? $data['comment'] : '';
		$user['user_data'] = isset($data['user_data']) ? $data['user_data'] : '';
		$restrict_time = time()-($this->software['0']['restrict_regtime'] * 60 * 60);
		$restrict = $this->con->select('user',"machine_code='{$data['machine_code']}' AND regtime>'{$restrict_time}' AND software_id={$this->software['0']['id']}",'','','','COUNT(id)');
		if($restrict['0']['COUNT(id)'] >= $this->software['0']['restrict_regnum']) {
			exit(api_json('205'));
		}
		$row = $this->isUser($data['username']);
		if($row) {
			$this->log->user('0','1',"用户名:{$data['username']}, 用户名已经存在!");
			exit(api_json('201'));
		}
		$user['username'] = $data['username'];
		$user['machine_code'] = $data['machine_code'];
		$user['regtime'] = time();
		$user['regip'] = get_ip();
		$user['software_id'] = $this->software['0']['id'];
		$user['menber_id'] = $this->software['0']['menber_id'];
		$user['salt'] = create_rand_str(6);
		$user['password'] = md5($data['password'] . $user['salt']);
		$user['super_password'] = md5($data['super_password'] . $user['salt']);
		$res_log = '';
		$res_api = array();
		$user['endtime'] = 0;
		$user['point'] = 0;
		if($this->software['0']['give_time'] > '0') {
			$user['endtime'] += ($this->software['0']['give_time']*60)+time();
			$res_log .= " 赠送时间:{$this->software['0']['give_time']}分钟!";
			$res_api['give_time']=$this->software['0']['give_time'];
		}
		if($this->software['0']['give_point'] > '0') {
			$user['point'] += $this->software['0']['give_point'];
			$res_log .= " 赠送点数:{$this->software['0']['give_point']}!";
			$res_api['give_point']=$this->software['0']['give_point'];
		}
		$id = $this->con->insert('user',$user,true);
		$this->log->user($id,'1',"注册成功!{$res_log}");
		exit(api_json('203',$res_api));
	}
	public function recharge() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('302')) : FALSE;
		empty($data['recharge_card']) ? exit(api_json('302')) : FALSE;
		do_action('api_user_recharge',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('301'));
		}
		$card_res = $this->con->select('card',"cardnum='{$data['recharge_card']}' AND software_id={$this->software['0']['id']}");
		if(!$card_res) {
			exit(api_json('303'));
		}
		if($card_res['0']['state'] == '2') {
			$this->log->user($user_res['0']['id'],'2',"充值卡:{$data['recharge_card']}, 充值卡停止使用!");
			exit(api_json('304'));
		}
		if($card_res['0']['used'] == '2') {
			$this->log->user($user_res['0']['id'],'2',"充值卡:{$data['recharge_card']}, 充值卡已被使用!");
			exit(api_json('305'));
		}
		$time = $this->getCardTime($card_res['0']['time'], $card_res['0']['time_type']);
		if($user_res['0']['endtime'] >= time()) {
			$user['endtime'] = $user_res['0']['endtime'] + $time;
		} else {
			$user['endtime'] = time() + $time;
		}
		$user['point'] = $user_res['0']['point'] + $card_res['0']['point'];
		$user['menber_id'] = $card_res['0']['menber_id'];
		$this->con->update('user',$user,"id='{$user_res['0']['id']}' AND software_id={$this->software['0']['id']}");
		$this->con->update('card',array('used'=>'2','used_id'=>$user_res['0']['id']),"cardnum='{$data['recharge_card']}' AND software_id={$this->software['0']['id']}");
		$this->log->recharge($user_res['0']['id'], $card_res['0']['menber_id'], $card_res['0']['time'],$card_res['0']['time_type'],$card_res['0']['point'],time(), $user['endtime'], $card_res['0']['cardnum']);
		exit(api_json('306',array('endtime'=>$user['endtime'],'point'=>$user['point'],'time'=>$card_res['0']['time'],'time_type'=>$card_res['0']['time_type'],'card_point'=>$card_res['0']['point'])));
	}
	public function passwordChange() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('502')) : FALSE;
		empty($data['password']) ? exit(api_json('502')) : FALSE;
		empty($data['super_password']) ? exit(api_json('502')) : FALSE;
		do_action('api_user_password_change',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('501'));
		}
		if(md5($data['super_password'] . $user_res['0']['salt']) != $user_res['0']['super_password']) {
			$this->log->user($user_res['0']['id'],'3',"新密码:{$data['password']}, 超级密码:{$data['super_password']}, 超级密码错误!");
			exit(api_json('503'));
		}
		$user['salt'] = create_rand_str(6);
		$user['password'] = md5($data['password'] . $user['salt']);
		$user['super_password'] = md5($data['super_password'] . $user['salt']);
		$this->con->update('user',$user,"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		$this->log->user($user_res['0']['id'],'3',"新密码:{$data['password']}, 超级密码:{$data['super_password']}, 修改成功!");
		exit(api_json('504'));
	}
	public function login() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('602','',true)) : FALSE;
		empty($data['password']) ? exit(api_json('602','',true)) : FALSE;
		empty($data['machine_code']) ? exit(api_json('602','',true)) : FALSE;
		$this->isBlackMachineCode($data['machine_code']);
		$this->isBlackMachineCode($data['machine_code']);
		do_action('api_user_login',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('601','',true));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			$this->log->user($user_res['0']['id'],'4',"密码:{$data['password']}, 密码错误!");
			exit(api_json('603','',true));
		}
		if($user_res['0']['congeal'] == "2") {
			$this->log->user($user_res['0']['id'],'4',"账号已被停封!");
			exit(api_json('604','',true));
		}
		if($this->software['0']['binding_type'] == "2") {
			if($user_res['0']['machine_code'] != $data['machine_code'] && $user_res['0']['machine_code'] != '') {
				$this->log->user($user_res['0']['id'],'4',"机器码:{$data['machine_code']}, 机器码不对应!");
				exit(api_json('605','',true));
			}
		}
		if($this->getState() != '3') {
			if($user_res['0']['endtime'] <= time()) {
				$this->log->user($user_res['0']['id'],'4',"账号已到期!");
				exit(api_json('606','',true));
			}
		}
		if($user_res['0']['state'] == '2') {
			if($user_res['0']['heart_beat'] >= time()) {
				if($this->software['0']['login_type'] == "2" && $user_res['0']['machine_code'] != $data['machine_code'] && $user_res['0']['machine_code'] != '') {
					$this->log->user($user_res['0']['id'],'4',"用户在线中 不可登陆!");
					exit(api_json('607','',true));
				}
			}
		}
		do {
			$token = create_rand_str(20);
		}
		while ($token == $user_res['0']['token']);
		$this->con->update('user',array('machine_code'=>$data['machine_code'],'token'=>$token,'logtime'=>time(),'logip'=>get_ip(),'heart_beat'=>time() + $this->software['0']['heart_time'],'state'=>'2'),"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		$this->log->user($user_res['0']['id'],'4',"登陆成功!");
		exit(api_json('608', array('endtime'=>$user_res['0']['endtime'],'point'=>$user_res['0']['point'],'token'=>$token) ));
	}
	public function logout() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('702')) : FALSE;
		empty($data['password']) ? exit(api_json('702')) : FALSE;
		empty($data['token']) ? exit(api_json('702')) : FALSE;
		do_action('api_user_logout',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('701'));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			$this->log->user($user_res['0']['id'],'5',"密码:{$data['password']}, 密码错误!");
			exit(api_json('703'));
		}
		if($data['token']!= $user_res['0']['token']) {
			$this->log->user($user_res['0']['id'],'5',"Token不一致!");
			exit(api_json('704'));
		}
		if($user_res['0']['heart_beat'] < time()) {
			$this->log->user($user_res['0']['id'],'5',"Token已过期!");
			exit(api_json('705'));
		}
		$this->con->update('user',array('state'=>'1','token'=>'','heart_beat'=>time()-10),"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		$this->log->user($user_res['0']['id'],'5',"退出成功!");
		exit(api_json('700'));
	}
	public function bindingDel() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('802')) : FALSE;
		empty($data['password']) ? exit(api_json('802')) : FALSE;
		empty($data['machine_code']) ? exit(api_json('802')) : FALSE;
		$this->isBlackMachineCode($data['machine_code']);
		$data['point_min'] = isset($data['point_min']) && is_numeric($data['point_min']) ? $data['point_min'] : 0;
		do_action('api_user_binding_del',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('801'));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			$this->log->user($user_res['0']['id'],'6',"密码:{$data['password']}, 密码错误!");
			exit(api_json('803'));
		}
		if($this->software['0']['binding_type'] != '2') {
			exit(api_json('806'));
		}
		if($data['machine_code'] == $user_res['0']['machine_code']) {
			exit(api_json('805'));
		}
		if($this->software['0']['bindingdel_type'] == '2') {
			exit(api_json('804'));
		}
		if($user_res['0']['machine_code'] == '') {
			exit(api_json('810'));
		}
		$res_api = array();
		$res_log = '';
		if($this->software['0']['bindingdel_time'] > '0') {
			if($user_res['0']['endtime']-($this->software['0']['bindingdel_time']*60) > time()) {
				$user['endtime'] = $user_res['0']['endtime']-($this->software['0']['bindingdel_time']*60);
				$res_api['bindingdel_time'] = $this->software['0']['bindingdel_time'];
				$res_log .= " 扣除{$this->software['0']['bindingdel_time']}分钟!";
			} else {
				$this->log->user($user_res['0']['id'],'6',"用户所剩时间不够扣除!");
				exit(api_json('807'));
			}
		}
		if($this->software['0']['bindingdel_point'] > '0') {
			$user['point'] = $user_res['0']['point'] - $this->software['0']['bindingdel_point'];
			if($user['point'] < $data['point_min'] ) {
				$this->log->user($user_res['0']['id'],'6',"用户所剩点数不够扣除!");
				exit(api_json('809'));
			}
			$res_api['unBindPoint'] = $this->software['0']['bindingdel_point'];
			$res_log .= " 扣除{$this->software['0']['bindingdel_point']}点数!";
		}
		$user['machine_code'] = '';
		$this->con->update('user',$user,"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		$this->log->user($user_res['0']['id'],'6',"解绑成功!{$res_log}");
		exit(api_json('808',$res_api));
	}
	public function trial() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('902','',true)) : FALSE;
		empty($data['password']) ? exit(api_json('902','',true)) : FALSE;
		do_action('api_user_trial',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('901','',true));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			$this->log->user($user_res['0']['id'],'7',"密码:{$data['password']}, 密码错误!");
			exit(api_json('903','',true));
		}
		if($this->software['0']['trial_interval'] <= '0' || $this->software['0']['trial_data'] <= '0') {
			exit(api_json('904','',true));
		}
		if(time() - $user_res['0']['trial'] < $this->software['0']['trial_interval']*3600) {
			$this->log->user($user_res['0']['id'],'7',"用户距离上次试用还不到{$this->software['0']['trial_interval']}小时!");
			exit(api_json('905','',true));
		}
		if($user_res['0']['endtime'] > time()) {
			$this->log->user($user_res['0']['id'],'7',"用户未到期!");
			exit(api_json('906','',true));
		}
		$user['trial'] = time();
		$user['endtime'] = time() + ($this->software['0']['trial_data'] * 60);
		$this->con->update('user',$user,"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		$this->log->user($user_res['0']['id'],'7',"试用成功! 时间:{$this->software['0']['trial_data']}分钟!");
		exit(api_json('907', array('time'=>$this->software['0']['trial_data']) ));
	}
	public function heart() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('1002','',true)) : FALSE;
		empty($data['password']) ? exit(api_json('1002','',true)) : FALSE;
		empty($data['token']) ? exit(api_json('1002','',true)) : FALSE;
		do_action('api_user_heart',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('1001','',true));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			$this->log->user($user_res['0']['id'],'8',"密码:{$data['password']}, 密码错误!");
			exit(api_json('1003','',true));
		}
		if($data['token']!= $user_res['0']['token']) {
			$this->log->user($user_res['0']['id'],'8',"Token不一致!");
			exit(api_json('1004','',true));
		}
		if($user_res['0']['heart_beat'] < time()) {
			$this->log->user($user_res['0']['id'],'8',"Token已过期!");
			exit(api_json('1008','',true));
		}
		if($this->getState() != '3') {
			if($user_res['0']['endtime'] < time()) {
				$this->log->user($user_res['0']['id'],'8',"用户到期!");
				exit(api_json('1005','',true));
			}
		}
		if($user_res['0']['state'] == '1') {
			$this->log->user($user_res['0']['id'],'8',"用户被强制下线!");
			exit(api_json('1007','',true));
		}
		$user['heart_beat'] = time() + $this->software['0']['heart_time'];
		$this->con->update('user',$user,"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('1006','',true));
	}
	public function getUserData() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('1102','',true)) : FALSE;
		empty($data['password']) ? exit(api_json('1102','',true)) : FALSE;
		do_action('api_user_get_user_data',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('1101','',true));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			exit(api_json('1103','',true));
		}
		exit(api_json('1104', array('user_data'=>$user_res['0']['user_data']) ));
	}
	public function setUserData() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('1202')) : FALSE;
		empty($data['password']) ? exit(api_json('1202')) : FALSE;
		empty($data['user_data']) ? exit(api_json('1202')) : FALSE;
		do_action('api_user_set_user_data',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('1201'));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			exit(api_json('1203'));
		}
		$user['user_data'] = $data['user_data'];
		$this->con->update('user',$user,"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('1204'));
	}
	public function queryCard() {
		$data = $this->parseData();
		empty($data['card']) ? exit(api_json('1302','',true)) : FALSE;
		do_action('api_user_query_card');
		$card = $this->con->select('card',"cardnum='{$data['card']}'");
		if(!$card) {
			exit(api_json('1301','',true));
		}
		exit(api_json('1303', array('name'=>$card['0']['name'],'time'=>$card['0']['time'],'time_type'=>$card['0']['time_type'],'point'=>$card['0']['point'],'create_time'=>$card['0']['create_time'],'comment'=>$card['0']['comment'],'state'=>$card['0']['state'],'used'=>$card['0']['used']) ));
	}
	public function deductPoint() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('1502','',true)) : FALSE;
		empty($data['password']) ? exit(api_json('1502','',true)) : FALSE;
		empty($data['point']) || !is_numeric($data['point']) || $data['point'] <= 0 ? exit(api_json('1502','',true)) : FALSE;
		$data['point_min'] = isset($data['point_min']) && is_numeric($data['point_min']) ? $data['point_min'] : 0;
		do_action('api_user_deduct_point',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('1501','',true));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			exit(api_json('1503','',true));
		}
		$user['point'] = $user_res['0']['point'] - $data['point'];
		if($user['point'] < $data['point_min'] ) {
			exit(api_json('1505','',true));
		}
		$this->con->update('user',$user,"username='{$data['username']}' AND software_id={$this->software['0']['id']}");
		exit(api_json('1504', array('point'=>$user['point']) ));
	}
	public function queryPoint() {
		$data = $this->parseData();
		empty($data['username']) ? exit(api_json('1602','',true)) : FALSE;
		empty($data['password']) ? exit(api_json('1602','',true)) : FALSE;
		do_action('api_user_query_point',[$data]);
		$user_res = $this->isUser($data['username']);
		if(!$user_res) {
			exit(api_json('1601','',true));
		}
		if(md5($data['password'] . $user_res['0']['salt']) != $user_res['0']['password']) {
			exit(api_json('1603','',true));
		}
		exit(api_json('1604', array('point'=>$user_res['0']['point']) ));
	}
	protected function isUser($username) {
		$res = $this->con->select('user',"username='{$username}' AND software_id={$this->software['0']['id']}");
		if(!$res) {
			return false;
		}
		return $res;
	}
}
?>