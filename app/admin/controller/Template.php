<?php
namespace app\admin\controller;
use core\lib\Db;
use app\admin\model\Template as model;
class Template extends Common {
	function __construct() {
		parent::isLogin();
		$this->model = new model;
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
			exit(bx_msg('模板出错','损坏的模板！','error','alert'));
		}
		if($zip->extractTo(BX_ROOT . 'template/') === FALSE) {
			exit(bx_msg('解压失败','解压zip文件失败！','error','alert'));
		}
		$zip->close();
		$this->model->install($directory);
	}
	public function set() {
		$admin = isset($_POST['admin']) ? $_POST['admin'] : '';
		$agent = isset($_POST['agent']) ? $_POST['agent'] : '';
		if($admin == '' && $agent == '') {
			exit(bx_msg('请选择模板','请至少选择一个模板','error'));
		}
		$this->model->set($admin,$agent);
	}
	public function restoreDefault() {
		$a = isset($_GET['a']) ? $_GET['a'] : '';
		$restore = array();
		if($a == '1') {
			$restore['template_admin'] = 'default';
		}
		if($a == '2') {
			$restore['template_admin'] = 'default';
			$restore['template_agent'] = 'default';
		}
		if(empty($restore)) {
			echo '<h3>不管您出于什么原因来到这里！我们给你列出了两个选项<br />';
			echo '仅仅恢复后台地址为默认：域名/idnex.php/admin/template/restoreDefault?a=1<br />';
			echo '恢复后台和代理地址为默认：域名/index.php/admin/template/restoreDefault?a=2<br /></h3>';
			exit;
		}
		set_config($restore);
		echo '<h3>恢复成功</h3>';
		exit;
	}
	public function uninstall() {
		$template_id = post_id();
		if($template_id == '1') {
			exit(bx_msg('卸载失败','默认模板不能卸载！','error'));
		}
		$con = Db::getInstance();
		$res = $con->select('template',"id={$template_id}");
		if(!$res) {
			exit (bx_msg('错误','未找到该模板！','error'));
		}
		$a = get_config(array('template_admin','template_agent'));
		if($a['template_admin'] == $res['0']['directory'] || $a['template_agent'] == $res['0']['directory']) {
			exit(bx_msg('卸载失败','该模板正在使用!无法卸载','error'));
		}
		if(!delete_file(BX_ROOT . 'template/' . $res['0']['directory'])) {
			exit(bx_msg('卸载失败','删除文件夹失败！','error'));
		}
		$this->model->uninstall($template_id,$res['0']['name']);
	}
}
?>