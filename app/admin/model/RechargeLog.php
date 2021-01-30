<?php
namespace app\admin\model;
class RechargeLog extends Common {
	function __construct() {
		parent::init();
	}
	public function delete($id) {
		$this->con->delete('recharge_log',"id in ({$id})");
		$this->log->menber('4','删除充值日志(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit(bx_msg('删除成功','您选择的充值日志已经删除成功！','success'));
	}
	public function lists($page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('recharge_log','', 'LEFT JOIN pre_user ON pre_recharge_log.user_id = pre_user.id 
		 LEFT JOIN pre_software ON pre_recharge_log.software_id = pre_software.id
		 LEFT JOIN pre_menber ON pre_recharge_log.menber_id = pre_menber.id', 'pre_recharge_log.id', "{$pageset},{$limit}", "pre_recharge_log.*,pre_user.username AS username,pre_software.name AS software_name,pre_menber.username AS menber_name");
		empty($res) ? exit : FALSE;
		new_html_special_chars($res);
		$conut = $this->con->select('recharge_log','','','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>