<?php
namespace app\admin\model;
use app\admin\Auth;
class Agent extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$res = $this->con->select('menber',"username='{$add['username']}'");
		if($res) {
			exit(bx_msg('用户名已经存在','请更换用户名','error','alert'));
		}
		$add['salt'] = create_rand_str(6);
		$add['password'] = md5($add['password'] . $add['salt']);
		$add['boss_id'] = Auth::get('id');
		$add['regtime'] = time();
		$add['regip'] = get_ip();
		$id=$this->con->insert('menber', $add,true);
		$this->con->insert('agent_authority', array('menber_id'=>$id));
		$this->log->menber('2', '添加' . ($add['power'] == '10' ? '超级' : '普通') . "代理:{$add['username']}, 密码:{$_POST['password']}, 余额:{$add['money']}");
		exit(bx_msg('添加成功','恭喜您成功添加了一位代理','success'));
	}
	public function edit($id,$edit) {
		if(!empty($_POST['password'])) {
			$edit['salt'] = create_rand_str(6);
			$edit['password'] = md5($_POST['password'] . $edit['salt']);
		}
		$this->con->update('menber',$edit,"id={$id}");
		$this->log->menber('2',"修改代理(ID):{$id}, 成功!");
		exit(bx_msg('修改成功','恭喜您成功修改了一位代理','success'));
	}
	public function getInfo($id) {
		$res = $this->con->select('menber',"id={$id}");
		echo json_encode($res);
	}
	public function delete($id) {
		$this->con->delete('menber',"id in ({$id})");
		$this->con->delete('agent_authority',"menber_id in ({$id})");
		$this->log->menber('2','删除代理(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit(bx_msg('删除成功','您选择的代理已经删除成功！','success'));
	}
	public function editAuthority($id,$edit) {
		$this->con->update('agent_authority',$edit,"menber_id={$id}");
		exit(bx_msg('修改成功','恭喜您成功修改了代理权限','success'));
	}
	public function getAuthorityInfo($id) {
		$res = $this->con->select('agent_authority',"menber_id={$id}");
		echo json_encode($res);
	}
	public function setBulletin($bulletin) {
		set_config($bulletin);
		$this->log->menber('2',"修改代理公告, 成功!");
		exit(bx_msg('修改成功','恭喜您成功修改了代理公告','success'));
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('menber',$where, 'LEFT JOIN pre_menber as a on pre_menber.boss_id = a.id', 'pre_menber.id',"{$pageset},{$limit}", 'pre_menber.id,pre_menber.username,pre_menber.power,pre_menber.money,pre_menber.consumed,pre_menber.congeal,
		pre_menber.comment,a.username as boss_name');
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('menber',$where,'','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>