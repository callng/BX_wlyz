<?php
namespace app\agent\model;
use app\agent\Auth;
class Card extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$res = $this->con->select('card_type',"id={$add['card_type_id']}",'','','','software_id,name,head,time,time_type,point,money');
		$agent_res = $this->con->select('menber','id=' . Auth::get('id'),'','','','money,rate,consumed');
		$del = ($res['0']['money'] * $add['count']) * ($agent_res['0']['rate']/100);
		$self['money'] = $agent_res['0']['money'] - $del;
		if( $self['money'] < '0.00' ) {
			exit(bx_msg('余额不足','请充值','error'));
		}
		$self['consumed'] = $agent_res['0']['consumed'] + $del;
		$this->con->update('menber',$self,'id=' . Auth::get('id'));
		$card_add['time'] = $res['0']['time'];
		$card_add['time_type'] = $res['0']['time_type'];
		$card_add['point'] = $res['0']['point'];
		$card_add['software_id'] = $res['0']['software_id'];
		$card_add['name'] = $res['0']['name'];
		$card_add['comment'] = $add['comment'];
		$card_add['create_time'] = time();
		$card_add['menber_id'] = Auth::get('id');
		$cardhead = $res['0']['head'];
		$body = array();
		for ($i=0; $i < $add['count']; $i++) {
			$body[$i] = $cardhead . create_card();
			$card_add['cardnum'] = $body[$i];
			$this->con->insert('card', $card_add);
		}
		$this->log->menber('3',"生成卡密:{$card_add['name']}, 数量:{$add['count']}, 个人余额:{$agent_res['0']['money']} → {$self['money']}, 成功!",'2');
		echo '{"msg":',bx_msg('生成成功',"一共生成了{$add['count']}张,扣除余额{$del}元",'success','alert'),",";
		echo '"data":',json_encode($body),'}';
		exit;
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('card',$where,'LEFT JOIN pre_software ON pre_card.software_id = pre_software.id 
		LEFT JOIN pre_menber ON pre_card.menber_id = pre_menber.id', 'pre_card.id',"{$pageset},{$limit}", 'pre_card.*, pre_software.name AS software_name,pre_menber.username as menber_name');
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('card',$where,'','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
	public function delete($id) {
		$auth = $this->getAuthority(array('delcard_state'));
		if($auth['0']['delcard_state'] != '2') {
			exit(bx_msg('权限不足','您没有权限删除卡密','error'));
		}
		$this->con->delete('card',"id in ({$id}) and menber_id=" . Auth::get('id'));
		$this->log->menber('3','删除卡密(个数):' . (substr_count($id,',') + 1) .', 成功!','2');
		exit (bx_msg('删除成功','您选择的卡密已经删除成功！','success'));
	}
}
?>