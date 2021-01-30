<?php
namespace app\admin\model;
use app\admin\Auth;
class CardType extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$add['menber_id'] = Auth::get('id');
		$this->con->insert('card_type', $add);
		$this->log->menber('3',"添加卡类:{$add['name']}, 成功!");
		exit (bx_msg('添加成功','添加成功','success'));
	}
	public function edit($id,$edit) {
		$res = $this->con->update('card_type',$edit,"id={$id}");
		$this->log->menber('3',"修改卡类:{$edit['name']}, 成功!");
		exit (bx_msg('修改成功','修改成功','success'));
	}
	public function softwareLists($id) {
		$res = $this->con->select('card_type',"software_id={$id} and state=1",'','','','name,id');
		echo json_encode($res);
	}
	public function getInfo($id) {
		$res = $this->con->select('card_type',"id={$id}");
		echo json_encode($res);
	}
	public function delete($id) {
		$this->con->delete('card_type',"id in ({$id})");
		$this->log->menber('3','删除卡类(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit (bx_msg('删除成功','您选择的卡类已经删除成功！','success'));
	}
	public function lists($page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('card_type','','left join pre_software on pre_card_type.software_id=pre_software.id','pre_card_type.id',"{$pageset},{$limit}",'pre_card_type.*,pre_software.name as softwarename');
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('card_type','','','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>