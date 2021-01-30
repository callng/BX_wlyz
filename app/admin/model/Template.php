<?php
namespace app\admin\model;
class Template extends Common {
	function __construct() {
		parent::init();
	}
	public function lists($page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('template','','','',"{$pageset},{$limit}");
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('template','','','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
	public function install($directory) {
		$info = include BX_ROOT . "template/{$directory}/info.php";
		$install['directory'] = $directory;
		$install['name'] = isset($info['name']) ? $info['name'] : '未获取到名称';
		$install['author'] = isset($info['author']) ? $info['author'] : '未获取到作者';
		$install['author_url'] = isset($info['author_url']) ? $info['author_url'] : 'http://wlyz.bingxs.com/';
		$install['version'] = isset($info['version']) ? $info['version'] : '未获取到版本';
		$install['description'] = isset($info['description']) ? $info['description'] : '未获取到简介';
		$res = $this->con->select('template',"directory='{$install['directory']}'");
		if($res) {
			$this->con->update('template',$install,"directory='{$install['directory']}'");
		} else {
			$this->con->insert('template',$install);
		}
		$this->log->menber('7',"安装【{$install['name']}】模板, 成功!");
		exit(bx_msg('安装成功',"安装【{$install['name']}】模板成功",'success'));
	}
	public function uninstall($id,$name) {
		$this->con->delete('template',"id={$id}");
		$this->log->menber('7',"卸载【{$name}】模板, 成功!");
		exit (bx_msg('卸载成功','您的模板已经卸载成功！','success'));
	}
	public function set($admin,$agent) {
		$set = array();
		if($admin != '') {
			$admin_res = $this->con->select('template',"id='{$admin}'");
			if(!$admin_res) {
				exit('参数错误');
			}
			$set['template_admin'] = $admin_res['0']['directory'];
		}
		if($agent != '') {
			$agent_res = $this->con->select('template',"id='{$agent}'");
			if(!$agent_res) {
				exit('参数错误');
			}
			$set['template_agent'] = $agent_res['0']['directory'];
		}
		set_config($set);
		$string = '';
		if(array_key_exists('template_admin', $set)) {
			$string .= "使用后台【{$admin_res['0']['name']}】模板, ";
		}
		if(array_key_exists('template_agent', $set)) {
			$string .= "使用代理【{$agent_res['0']['name']}】模板, ";
		}
		$string .= '成功!';
		$this->log->menber('7',$string);
		exit(bx_msg('修改成功','恭喜您成功更换了当前模板','success'));
	}
}
?>