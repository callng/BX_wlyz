<?php
namespace app\admin\model;
class UserLog extends Common {
	function __construct() {
		parent::init();
	}
	public function delete($id) {
		$this->con->delete('user_log',"id in ({$id})");
		$this->log->menber('4','删除用户日志(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit(bx_msg('删除成功','您选择的用户日志已经删除成功！','success'));
	}
	public function lists($page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('user_log','', 'LEFT JOIN pre_user ON pre_user_log.user_id = pre_user.id 
		 LEFT JOIN pre_software ON pre_user_log.software_id = pre_software.id', 'pre_user_log.id', "{$pageset},{$limit}", "pre_user_log.*,pre_user.username AS username,pre_software.name AS software_name");
		empty($res) ? exit : FALSE;
		new_html_special_chars($res);
		$conut = $this->con->select('user_log','','','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>