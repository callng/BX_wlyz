<?php
namespace app\admin\controller;
use core\lib\Db;
use app\admin\model\Plugin as model;
class Plugin extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
	}
	public function getInc($id,$name='') {
		$con = Db::getInstance();
		$res = $con->select('plugin',"directory='{$id}'");
		if($res) {
			if($name == '') {
				$name = $res['0']['directory'];
			}
			include BX_ROOT . "app/common/plugin/{$res['0']['directory']}/{$name}.inc.php";
		}
		exit;
	}
	public function lists() {
		$lists = post_lists();
		$this->model->lists($lists['page'], $lists['limit']);
	}
	public function install() {
		$zipfile = isset($_FILES['file']) ? $_FILES['file'] : '';
		if (!$zipfile || $zipfile['error'] >= 1 || empty($zipfile['tmp_name'])) {
			exit(bx_msg('上传失败','文件上传失败','error'));
		}
		if (get_file_suffix($zipfile['name']) != 'zip') {
			exit(bx_msg('错误','请上传zip文件','error'));
		}
		if (!class_exists('ZipArchive', FALSE)) {
			exit(bx_msg('解压失败','未找到ZipArchive扩展','error','alert'));
		}
		$zip = new \ZipArchive();
		if (@$zip->open($zipfile['tmp_name']) !== TRUE) {
			exit(bx_msg('解压失败','打开zip文件失败！','error','alert'));
		}
		$directory = substr($zip->getNameIndex(0),0,-1);
		if($zip->getFromName("{$directory}/info.php") === FALSE) {
			exit(bx_msg('插件出错','损坏的插件！','error','alert'));
		}
		if($zip->getFromName("{$directory}/{$directory}.inc.php") === FALSE) {
			exit(bx_msg('插件出错','损坏的插件！','error','alert'));
		}
		if($zip->getFromName("{$directory}/{$directory}.php") === FALSE) {
			exit(bx_msg('插件出错','损坏的插件！','error','alert'));
		}
		if($zip->getFromName("{$directory}/install.php") === FALSE) {
			exit(bx_msg('插件出错','损坏的插件！','error','alert'));
		}
		if($zip->getFromName("{$directory}/uninstall.php") === FALSE) {
			exit(bx_msg('插件出错','损坏的插件！','error','alert'));
		}
		if($zip->extractTo(BX_ROOT . 'app/common/plugin/') === FALSE) {
			exit(bx_msg('解压失败','解压zip文件失败！','error','alert'));
		}
		$zip->close();
		include BX_ROOT . "app/common/plugin/{$directory}/install.php";
		$this->model->install($directory);
	}
	public function uninstall() {
		$plugin_id = post_id();
		$con = Db::getInstance();
		$res = $con->select('plugin',"id={$plugin_id}");
		if(!$res) {
			exit (bx_msg('错误','未找到该插件！','error'));
		}
		include BX_ROOT . "app/common/plugin/{$res['0']['directory']}/uninstall.php";
		if(!delete_file(BX_ROOT . 'app/common/plugin/' . $res['0']['directory'])) {
			exit(bx_msg('卸载失败','删除文件夹失败！','error'));
		}
		$this->model->uninstall($plugin_id,$res['0']['name']);
	}
	public function close() {
		$plugin_id = post_id();
		$this->model->close($plugin_id);
	}
	public function open() {
		$plugin_id = post_id();
		$this->model->open($plugin_id);
	}
}
?>