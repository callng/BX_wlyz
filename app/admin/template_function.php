<?php
use core\lib\Db;
function get_software_lists() {
	$con = Db::getInstance();
	return $con->select('software','','','','','id,name');
}
function get_software_card_lists() {
	$con = Db::getInstance();
	return $con->select('card_type','state=1','pre_card_type LEFT JOIN pre_software ON pre_card_type.software_id = pre_software.id', 'pre_card_type.software_id','','DISTINCT pre_card_type.software_id as id,pre_software.name');
}
function get_bulletin() {
	$contents = @curl_get_contents('http://wlyz.bingxs.com/api/bulletin.php',false,$context);
	$a = json_decode($contents,TRUE);
	if($a) {
		return array('header'=>'','msg'=>''); //return $a;
	}
	return array('header'=>'','msg'=>'');
}
function get_current_template() {
	$a = get_config(array('template_admin','template_agent'));
	$con = db::getInstance();
	$admin = $con->select('template',"directory='{$a['template_admin']}'");
	$agent = $con->select('template',"directory='{$a['template_agent']}'");
	return array('admin'=>$admin['0'],'agent'=>$agent['0']);
}
?>