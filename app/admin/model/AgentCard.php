<?php
namespace app\admin\model;
class AgentCard extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$card_add['money'] = $add['money'];
		$card_add['name'] = $add['name'];
		$card_add['comment'] = $add['comment'];
		$card_add['create_time'] = time();
		$cardhead = $add['head'];
		$body = array();
		for ($i=0; $i < $add['count']; $i++) {
			$body[$i] = $cardhead . create_card();
			$card_add['cardnum'] = $body[$i];
			$this->con->insert('agent_card', $card_add);
		}
		$this->log->menber('2',"生成代理卡密:{$card_add['name']}, 数量:{$add['count']}, 成功!");
		echo '{"msg":',bx_msg('生成成功',"一共生成了{$add['count']}张",'success','alert'),",";
		echo '"data":',json_encode($body),'}';
		exit;
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('agent_card ',$where,'','id',"{$pageset},{$limit}");
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('agent_card',$where,'','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
	public function getInfo($id) {
		$res = $this->con->select('agent_card',"pre_agent_card.id={$id}",'LEFT JOIN pre_menber ON pre_agent_card.used_id = pre_menber.id', '','','pre_agent_card.*,pre_menber.username as username');
		echo json_encode($res);
	}
	public function edit($id,$edit) {
		$res = $this->con->update('agent_card',$edit,"id={$id}");
		$this->log->menber('2',"修改代理卡密:{$edit['name']}, 成功!");
		exit (bx_msg('修改成功','修改成功','success'));
	}
	public function delete($id) {
		$this->con->delete('agent_card',"id in ({$id})");
		$this->log->menber('2','删除代理卡密(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit (bx_msg('删除成功','您选择的代理卡密已经删除成功！','success'));
	}
}
?>