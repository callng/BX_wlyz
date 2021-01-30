<?php
namespace app\admin\controller;
use app\admin\Auth;
use core\lib\Db;
use app\admin\model\Agent as model;
class Agent extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function add() {
		$add['username'] = isset($_POST['username'])?$_POST['username']:'';
		$add['password'] = isset($_POST['password'])?$_POST['password']:'';
		$add['money'] = isset($_POST['money'])?$_POST['money']:'';
		$add['rate'] = isset($_POST['rate'])?$_POST['rate']:'';
		$add['power'] = isset($_POST['power'])?$_POST['power']:'';
		$add['congeal'] = isset($_POST['congeal'])?$_POST['congeal']:'';
		$add['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		$add['software_id'] = isset($_POST['software_id'])?$_POST['software_id']:'';
		if($add['power'] != '10' && $add['power'] != '11') {
			exit(bx_msg('参数错误','参数错误','error'));
		}
		if($add['username'] != '' && $add['password'] != '' && $add['money'] != '' && $add['rate'] != '' && $add['power'] != '' && $add['congeal'] != '') {
			if($add['power'] == '10') {
				$add['recharge_agent'] = isset($_POST['recharge_agent'])?$_POST['recharge_agent']:'';
				$add['default_rate'] = isset($_POST['default_rate'])?$_POST['default_rate']:'';
				$add['manager_price'] = isset($_POST['manager_price'])?$_POST['manager_price']:'';
				$add['default_money'] = isset($_POST['default_money'])?$_POST['default_money']:'';
				if($add['recharge_agent'] == '' || $add['default_rate'] == '' || $add['manager_price'] == '' || $add['default_money'] == '') {
					exit(bx_msg('参数错误','请全部填写','error'));
				}
			}
			$this->model->add($add);
		}
		exit(bx_msg('参数错误','请全部填写','error'));
	}
	public function lists() {
		$lists = post_lists();
		$where[] = isset($_POST['power']) && $_POST['power'] != '' ? "pre_menber.power = {$_POST['power']}" : '(pre_menber.power = 10 or pre_menber.power = 11)';
		$where[] = isset($_POST['congeal']) && $_POST['congeal'] != '' ? "pre_menber.congeal = {$_POST['congeal']}" : '';
		if(isset($_POST['menber_name']) && $_POST['menber_name'] != '') {
			$con = Db::getInstance();
			$menber = $con->select('menber',"username='{$_POST['menber_name']}'",'','','','id');
			$where[] = 'pre_menber.boss_id = ' . (isset($menber['0']['id']) ? $menber['0']['id'] : '0');
		}
		$where[] = isset($_POST['username']) && $_POST['username'] != '' ? "pre_menber.username = '{$_POST['username']}'" : '';
		$search = sql_and($where);
		$this->model->lists($search,$lists['page'], $lists['limit']);
	}
	public function setBulletin() {
		$theme['agent_bulletin'] = isset($_POST['bulletin']) ? $_POST['bulletin'] : exit(bx_msg('参数错误','错误','error'));
		$theme['agent_bulletin'] = stripslashes($theme['agent_bulletin']);
		$this->model->setBulletin($theme);
	}
	public function getInfo() {
		$agent_id = post_id();
		$this->model->getInfo($agent_id);
	}
	public function edit() {
		$agent_id = post_id();
		$edit['money'] = isset($_POST['money'])?$_POST['money']:'';
		$edit['rate'] = isset($_POST['rate'])?$_POST['rate']:'';
		$edit['power'] = isset($_POST['power'])?$_POST['power']:'';
		$edit['congeal'] = isset($_POST['congeal'])?$_POST['congeal']:'';
		$edit['comment'] = isset($_POST['comment'])?$_POST['comment']:'';
		$edit['software_id'] = isset($_POST['software_id'])?$_POST['software_id']:'';
		if($edit['power'] != '10' && $edit['power'] != '11') {
			exit('error');
		}
		if($edit['money'] != '' && $edit['rate'] != '' && $edit['power'] != '' && $edit['congeal'] != '') {
			if($edit['power'] == '10') {
				$edit['recharge_agent'] = isset($_POST['recharge_agent'])?$_POST['recharge_agent']:'';
				$edit['default_rate'] = isset($_POST['default_rate'])?$_POST['default_rate']:'';
				$edit['manager_price'] = isset($_POST['manager_price'])?$_POST['manager_price']:'';
				$edit['default_money'] = isset($_POST['default_money'])?$_POST['default_money']:'';
				if($edit['recharge_agent'] == '' || $edit['default_rate'] == '' || $edit['manager_price'] == '' || $edit['default_money'] == '') {
					exit(bx_msg('参数错误','请全部填写','error'));
				}
				$edit['boss_id'] = Auth::get('id');
			}
			$this->model->edit($agent_id,$edit);
		}
		exit(bx_msg('参数错误','请全部填写','error'));
	}
	public function delete() {
		$agent_id = post_id();
		$this->model->delete($agent_id);
	}
	public function checkeDdelete() {
		$agent_id = post_id();
		$this->model->checkedDelete($agent_id);
	}
	public function getAuthorityInfo() {
		$agent_id = post_id();
		$this->model->getAuthorityInfo($agent_id);
	}
	public function editAuthority() {
		$agent_id = post_id();
		$edit['binding_state'] = isset($_POST['binding_state'])?'2':'1';
		$edit['offline_state'] = isset($_POST['offline_state'])?'2':'1';
		$edit['deluser_state'] = isset($_POST['deluser_state'])?'2':'1';
		$edit['changepw_state'] = isset($_POST['changepw_state'])?'2':'1';
		$edit['congeal_state'] = isset($_POST['congeal_state'])?'2':'1';
		$edit['endtime_state'] = isset($_POST['endtime_state'])?'2':'1';
		$edit['point_state'] = isset($_POST['point_state'])?'2':'1';
		$edit['delcard_state'] = isset($_POST['delcard_state'])?'2':'1';
		$this->model->editAuthority($agent_id, $edit);
	}
}
?>