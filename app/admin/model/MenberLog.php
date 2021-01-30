<?php
namespace app\admin\model;
class MenberLog extends Common {
	function __construct() {
		parent::init();
	}
	public function delete($id) {
		$this->con->delete('menber_log',"id in ({$id})");
		$this->log->menber('4','删除管理日志(个数):' . (substr_count($id,',') + 1) .', 成功!');
		exit(bx_msg('删除成功','您选择的管理日志已经删除成功！','success'));
	}
	public function lists($where,$page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('menber_log',$where,'LEFT JOIN pre_menber ON pre_menber_log.menber_id = pre_menber.id', 'pre_menber_log.id',"{$pageset},{$limit}","pre_menber_log.*, pre_menber.username as menber_name");
		empty($res) ? exit : FALSE;
		new_html_special_chars($res);
		$conut = $this->con->select('menber_log',$where,'','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
}
?>