<?php
namespace app\admin\model;
use app\admin\Auth;
class SingleCard extends Common {
	function __construct() {
		parent::init();
	}
	public function add($add) {
		$res = $this->con->select('card_type',"id={$add['card_type_id']}",'','','','software_id,name,head,time,time_type,point');
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
			$this->con->insert('single_card', $card_add);
		}
		$this->log->menber('3',"生成单卡:{$card_add['name']}, 数量:{$add['count']}, 成功!");
		echo '{"msg":',bx_msg('生成成功',"一共生成了{$add['count']}张",'success','alert'),",";
		echo '"data":',json_encode($body),'}';
		exit;
	}
	public function getInfo($id) {
		$res = $this->con->select('single_card',"pre_single_card.id={$id}","LEFT JOIN pre_software ON pre_single_card.software_id = pre_software.id
		LEFT JOIN pre_menber ON pre_single_card.menber_id = pre_menber.id",'','','pre_single_card.*,pre_software.name as software_name,pre_menber.username as menber_name');
		if($res['0']['state'] != "1") {
			if($res['0']['heart_beat'] < time()) {
				$res['0']['state'] = "1";
			}
		}
		echo json_encode($res);
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('single_card',$where,'LEFT JOIN pre_software ON pre_single_card.software_id = pre_software.id 
		LEFT JOIN pre_menber ON pre_single_card.menber_id = pre_menber.id', 'pre_single_card.id',"{$pageset},{$limit}", 'pre_single_card.*, pre_software.name AS software_name,pre_menber.username as menber_name');
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('single_card',$where,'','','','COUNT(id)');
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
	public function edit($id,$edit) {
		$res = $this->con->update('single_card',$edit,"id={$id}");
		$this->log->menber('3',"修改单卡:{$edit['name']}, 成功!");
		exit (bx_msg('修改成功','修改成功','success'));
	}
	public function delete($id) {
		$this->con->delete('single_card',"id in ({$id})");
		$this->log->menber('3','删除单卡(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit (bx_msg('删除成功','您选择的单卡已经删除成功！','success'));
	}
}
?>