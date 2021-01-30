<?php
namespace app\admin\model;
use app\admin\Auth;
class Software extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$add['s_key'] = create_rand_str(40);
		$add['menber_id'] = Auth::get('id');
		$add['remote'] = '';
		$add['encrypt'] = 'authcode';
		$add['defined_encrypt'] = '';
		$this->con->insert('software', $add);
		$this->log->menber('5',"添加软件:{$add['name']}, 成功!");
		exit (bx_msg('添加成功','添加成功','success'));
	}
	public function getInfo($id) {
		$res = $this->con->select('software',"id={$id}");
		echo json_encode($res);
	}
	public function edit($id,$edit) {
		$this->con->update('software', $edit,"id={$id}");
		$this->log->menber('5',"修改软件:{$edit['name']}, 成功!");
		exit (bx_msg('修改成功','修改成功','success'));
	}
	public function delete($id) {
		$this->con->delete('software',"id={$id}");
		$this->con->delete('user',"software_id={$id}");
		$this->con->delete('card',"software_id={$id}");
		$this->con->delete('card_type',"software_id={$id}");
		$this->con->delete('single_card',"software_id={$id}");
		$this->con->delete('black',"software_id={$id}");
		$this->log->menber('5',"删除软件(ID):{$id}, 成功!");
		exit (bx_msg('删除成功','您选择的软件已经删除成功！','success'));
	}
	public function againKey($id) {
		$s_key['s_key'] = create_rand_str(40);
		$this->con->update('software', $s_key,"id={$id}");
		exit (bx_msg('修改程序key成功',$s_key['s_key'],'success','alert'));
	}
	public function getRemoteInfo($id) {
		$res = $this->con->select('software',"id={$id}",'','','','id,remote');
		echo json_encode($res);
	}
	public function editRemote($id,$edit) {
		$this->con->update('software', $edit,"id={$id}");
		$this->log->menber('5',"修改远程函数, 软件(ID):{$id}, 成功!");
		exit(bx_msg('修改成功','恭喜您成功修改了远程函数','success'));
	}
	public function getEncryptInfo($id) {
		$res = $this->con->select('software',"id={$id}",'','','','id,encrypt,defined_encrypt');
		echo json_encode($res);
	}
	public function editEncrypt($id,$edit) {
		$this->con->update('software', $edit,"id={$id}");
		$this->log->menber('5',"修改加密方式, 软件(ID):{$id}, 成功!");
		exit(bx_msg('修改成功','恭喜您成功修改了加密方式','success'));
	}
	public function lists($page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('software','','','id',"{$pageset},{$limit}",'id,name,s_key,version,software_state');
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('software','','','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>