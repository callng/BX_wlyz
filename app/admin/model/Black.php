<?php
namespace app\admin\model;
use app\admin\Auth;
class Black extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$res = $this->con->select('black',"feature='{$add['feature']}' and type={$add['type']} and (software_id=0 or software_id={$add['software_id']})");
		if($res) {
			exit(bx_msg('请更换特征','此特征已经存在','error','alert'));
		}
		$add['menber_id'] = Auth::get('id');
		$add['time'] = time();
		$this->con->insert('black',$add);
		$v = ['','机器码','IP'];
		$this->log->menber('4', "添加黑名单:{$add['feature']}, 类型:" . $v[$add['type']]);
		exit(bx_msg('添加成功','添加成功','success'));
	}
	public function getInfo($id) {
		$res = $this->con->select('black',"id={$id}");
		echo json_encode($res);
	}
	public function edit($id,$edit) {
		$res = $this->con->select('black',"feature='{$edit['feature']}' and type={$edit['type']} and id!={$id} and (software_id=0 or software_id={$edit['software_id']})");
		if($res) {
			exit(bx_msg('请更换特征','此特征已经存在','error','alert'));
		}
		$edit['menber_id'] = Auth::get('id');
		$res = $this->con->update('black',$edit,"id={$id}");
		$this->log->menber('4',"修改黑名单(ID):{$id}, 成功!");
		exit (bx_msg('修改成功','修改成功','success'));
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('black ',$where,'LEFT JOIN pre_software ON pre_black.software_id = pre_software.id 
		LEFT JOIN pre_menber ON pre_black.menber_id = pre_menber.id', 'pre_black.id',"{$pageset},{$limit}", 'pre_black.*, pre_software.name AS software_name,pre_menber.username AS menber_name');
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('black',$where,'','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
	public function delete($id) {
		$this->con->delete('black',"id in ({$id})");
		$this->log->menber('4','删除黑名单(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit (bx_msg('删除成功','您选择的黑名单已经删除成功！','success'));
	}
}
?>