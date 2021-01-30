<?php
namespace app\agent\model;
use app\agent\Auth;
class User extends Common {
	function __construct() {
		parent::init();
	}
	public function getInfo($id) {
		$res = $this->con->select('user',"pre_user.id={$id} and pre_user.menber_id=" . Auth::get('id'),'LEFT JOIN pre_software ON pre_user.software_id = pre_software.id LEFT JOIN pre_menber ON pre_user.menber_id = pre_menber.id','','','pre_user.*, pre_software.name AS software_name,pre_menber.username AS menber_username');
		new_html_special_chars($res);
		if($res['0']['state'] != "1") {
			if($res['0']['heart_beat'] < time()) {
				$res['0']['state'] = "1";
			}
		}
		echo json_encode($res);
	}
	public function edit($id,$edit) {
		$auth = $this->getAuthority(array('binding_state','offline_state','changepw_state','congeal_state','endtime_state','point_state'));
		$user_res = $this->con->select('user',"id={$id}",'','','','congeal,endtime,salt,point');
		if($edit['congeal'] != $user_res['0']['congeal']) {
			if($auth['0']['congeal_state'] != '2') {
				exit(bx_msg('权限不足','您没有权限修改用户状态','error'));
			}
		}
		if($edit['endtime'] != $user_res['0']['endtime']) {
			if($auth['0']['endtime_state'] != '2') {
				exit(bx_msg('权限不足','您没有权限修改用户到期时间','error'));
			}
		}
		if($edit['point'] != $user_res['0']['point']) {
			if($auth['0']['point_state'] != '2') {
				exit(bx_msg('权限不足','您没有权限修改用户点数','error'));
			}
		}
		if(!empty($_POST['password']) || !empty($_POST['super_password'])) {
			if($auth['0']['changepw_state'] != '2') {
				exit(bx_msg('权限不足','您没有权限修改用户密码','error'));
			}
			if(!empty($_POST['password']) && !empty($_POST['super_password'])) {
				$edit['salt'] = create_rand_str(6);
			} else {
				$edit['salt'] = $user_res['0']['salt'];
			}
			if(!empty($_POST['password'])) {
				$edit['password'] = md5($_POST['password'] . $edit['salt']);
			}
			if(!empty($_POST['super_password'])) {
				$edit['super_password'] = md5($_POST['super_password'] . $edit['salt']);
			}
		}
		if(isset($edit['machine_code']) && $edit['machine_code'] == '') {
			if($auth['0']['binding_state'] != '2') {
				exit(bx_msg('权限不足','您没有权限解绑用户','error'));
			}
		}
		if(isset($edit['state']) && $edit['state'] == '1') {
			if($auth['0']['offline_state'] != '2') {
				exit(bx_msg('权限不足','您没有权限强制用户下线','error'));
			}
		}
		$res = $this->con->update('user',$edit,"id={$id} and menber_id=" . Auth::get('id'));
		$this->log->menber('6', "修改用户(ID):{$id}, 成功!",'2');
		exit(bx_msg('修改成功','修改成功','success'));
	}
	public function delete($id) {
		$auth = $this->getAuthority(array('deluser_state'));
		if($auth['0']['deluser_state'] != '2') {
			exit(bx_msg('权限不足','您没有权限删除用户','error'));
		}
		$this->con->delete('user',"id in ({$id}) and menber_id=" . Auth::get('id'));
		$this->log->menber('6', '删除用户(个数):' . (substr_count($id,',') + 1) .', 成功!','2');
		exit (bx_msg('删除成功','您选择的用户已经删除成功！','success'));
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('user',$where,'LEFT JOIN pre_software ON pre_user.software_id = pre_software.id
		 LEFT JOIN pre_menber ON pre_user.menber_id = pre_menber.id', 'pre_user.id',"{$pageset},{$limit}", "pre_user.id,pre_user.username,pre_user.regtime,pre_user.endtime,pre_user.machine_code,pre_user.user_data,pre_user.comment,pre_user.congeal,pre_user.state,
		 pre_user.heart_beat,pre_user.point,pre_software.name AS software_name,pre_menber.username AS menber_name");
		empty($res) ? exit : FALSE;
		new_html_special_chars($res);
		$conut = $this->con->select('user',$where,'','','','COUNT(id)');
		foreach ($res as $key => $value) {
			if($res[$key]['state'] != "1") {
				if($res[$key]['heart_beat'] < time()) {
					$res[$key]['state'] = "1";
				}
			}
		}
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>