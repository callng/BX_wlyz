<?php
namespace app\admin\model;
class Plugin extends Common {
	function __construct() {
		parent::init();
	}
	public function lists($page,$limit) {
		$pageset = ($page-1)*$limit;
		$res = $this->con->select('plugin','','','id',"{$pageset},{$limit}");
		empty($res) ? exit : FALSE;
		$conut = $this->con->select('plugin','','','','','COUNT(id)');
		echo bx_lists($res, $conut['0']['COUNT(id)']);
		exit;
	}
	public function install($directory) {
		$info = include BX_ROOT . "app/common/plugin/{$directory}/info.php";
		$install['directory'] = $directory;
		$install['name'] = isset($info['name']) ? $info['name'] : '未获取到名称';
		$install['author'] = isset($info['author']) ? $info['author'] : '未获取到作者';
		$install['author_url'] = isset($info['author_url']) ? $info['author_url'] : 'http://wlyz.bingxs.com/';
		$install['version'] = isset($info['version']) ? $info['version'] : '未获取到版本';
		$install['description'] = isset($info['description']) ? $info['description'] : '未获取到简介';
		$res = $this->con->select('plugin',"directory='{$install['directory']}'");
		if($res) {
			$this->con->update('plugin',$install,"directory='{$install['directory']}'");
		} else {
			$install['state'] = '2';
			$this->con->insert('plugin',$install);
		}
		$this->log->menber('8',"安装【{$install['name']}】插件, 成功!");
		exit(bx_msg('安装成功',"安装【{$install['name']}】插件成功",'success'));
	}
	public function uninstall($id,$name) {
		$this->con->delete('plugin',"id={$id}");
		$this->log->menber('8',"卸载【{$name}】插件, 成功!");
		exit (bx_msg('卸载成功','您的插件已经卸载成功！','success'));
	}
	public function close($id) {
		$this->con->update('plugin',array('state'=>'2'),"id={$id}");
		$this->log->menber('8',"关闭插件(ID):{$id}, 成功!");
		exit (bx_msg('关闭成功','您的插件已经关闭成功！','success'));
	}
	public function open($id) {
		$this->con->update('plugin',array('state'=>'1'),"id={$id}");
		$this->log->menber('8',"开启插件(ID):{$id}, 成功!");
		exit (bx_msg('开启成功','您的插件已经开启成功！','success'));
	}
}
?>