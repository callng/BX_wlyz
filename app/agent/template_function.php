<?php
use core\lib\Db;
use app\agent\Auth;
function get_software_lists() {
	$con = Db::getInstance();
	$agent = $con->select('menber',"id=" . Auth::get('id'),'','','','software_id');
	$res_sql = $agent['0']['software_id'] != '' ? "id in ({$agent['0']['software_id']})" : '';
	return $con->select('software',$res_sql,'','','','id,name');
}
function get_software_card_lists() {
	$con = Db::getInstance();
	$agent = $con->select('menber',"id=" . Auth::get('id'),'','','','software_id');
	$res_sql = $agent['0']['software_id'] != '' ? "and pre_card_type.software_id in ({$agent['0']['software_id']})" : '';
	return $con->select('card_type','state=1 ' . $res_sql,'pre_card_type LEFT JOIN pre_software ON pre_card_type.software_id = pre_software.id', 'pre_card_type.software_id','','DISTINCT pre_card_type.software_id as id,pre_software.name');
}
?>