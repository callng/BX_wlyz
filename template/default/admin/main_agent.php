<?php if(!defined('BX_ROOT')) {exit();} ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
		<div class="card">
  <h3 class="card-header">代理管理</h3>
  <div class="card-body ">
  <!--main-->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="agent-tab" data-toggle="tab" href="#agent" role="tab" aria-controls="agent" aria-expanded="true">代理管理</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="agent_log-tab"  data-toggle="tab" href="#agent_log" role="tab" aria-controls="agent_log">代理日志</a>
  </li>
   <li class="nav-item">
    <a class="nav-link" id="agent_bulletin-tab"  data-toggle="tab" href="#agent_bulletin" role="tab" aria-controls="agent_bulletin">代理公告</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="agent_card-tab"  data-toggle="tab" href="#agent_card" role="tab" aria-controls="agent_card">代理卡密</a>
  </li>
</ul>

<!--modal-->
<div class="modal fade bd-example-modal-lg" id="a" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="my_add" class="modal-dialog modal-lg">
    
    <!--弹窗内容-->
    
  </div>
</div>




<div class="tab-content" id="myTabContent">
<!--代理管理-->
  <div class="tab-pane fade  show active" id="agent" role="tabpanel" aria-labelledby="agent-tab">
 <?php do_action('admin_agent'); ?>
  	<div class="bd-callout bd-callout-info">
  	  	
<div class="form-inline">
	

      

    <div class="form-group">
    	类型：
    <select class="form-control" id="search_agent_power">
      <option value="">全部</option>
      <option value="10">超级代理</option>
      <option value="11">普通代理</option>
    </select>&nbsp;
    </div>
    	
     <div class="form-group">
    	状态：
    <select class="form-control" id="search_agent_congeal">
      <option value="">全部</option>
      <option value="1">正常</option>
      <option value="2">停封</option>
    </select>&nbsp;
    </div>
    	
    <div class="form-group">   
       归属上级：
    <input type="text" class="form-control" id="search_agent_menber_name" style="width: 150px;" >&nbsp;
    </div>
  
    <div class="form-group">
       用户名：
    <input type="text" class="form-control" id="search_agent_username" style="width: 150px;" >&nbsp;
    </div>
    <a href="javascript:;" onclick="agent_getpage(1);"   class="btn btn-info">搜索</a>

</div>
</div>
  	
  	
  	
<div class="form-check form-check-inline">
        <a href="javascript:;"  onclick="agent_add();"  class="btn btn-success">添加代理</a>
  		<a href="javascript:;"  onclick="agent_checkeddel();"  class="btn btn-danger">删除选中</a>
</div>




	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=agent_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th>编号</th>
      <th>用户名</th>
      <th>类型</th>
      <th>归属上级</th>
      <th>余额</th>
      <th>已消费</th>
      <th>状态</th>
      <th>备注</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="agent_table">
 
  </tbody>
</table>
  	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="agent_page">
    
  </ul>
</nav>  	





<script type="text/javascript">
	function agent_add() {
		var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">添加代理</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理账号</div>\
    <input type="text" class="form-control" id="agent_username"  placeholder="给你的代理起个名字吧">\
    <div class="input-group-addon">代理密码</div>\
    <input type="text" class="form-control" id="agent_password"  placeholder="代理密码">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理余额</div>\
    <input type="text" class="form-control" id="agent_money"  placeholder="代理余额">\
    <div class="input-group-addon">开卡费率</div>\
    <input type="text" class="form-control" id="agent_rate"  placeholder="卡类价格×开卡费率%=价格 1~100">\
  </div>\
  </div>\
    <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理类型</div>\
    <select id="agent_power" onchange="Super();"  class="form-control">\
      <option value="10">超级代理</option>\
      <option value="11">普通代理</option>\
    </select>\
    <div class="input-group-addon">代理状态</div>\
   <select id="agent_congeal" class="form-control">\
      <option value="1">正常</option>\
      <option value="2">停封</option>\
   </select>\
  </div>\
  </div>\
   <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理备注</div>\
    <input type="text" class="form-control" id="agent_comment"  placeholder="不需要可留空">\
  </div>\
  </div>\
  <div id="Super_agent">\
 <div class="card border-info mb-3 text-center">\
  <div class="card-body">\
  	<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">充值下级余额费率</div>\
    <input type="text" class="form-control" id="agent_recharge_agent"  placeholder="1~100 单位：百分比%">\
    <div class="input-group-addon">默认下级开卡费率</div>\
    <input type="text" class="form-control" id="agent_default_rate"  placeholder="1~100 单位：百分比%">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">添加下级扣除余额</div>\
   <input type="text" class="form-control" id="agent_manager_price"  placeholder="扣除本身余额">\
    <div class="input-group-addon">添加下级默认余额</div>\
    <input type="text" id="agent_default_money" class="form-control"  placeholder="添加下级自带余额">\
  </div>\
  </div>\
  </div>\
</div>\
  </div>\
  <div class="form-group">\
    <label for="exampleTextarea">所属软件  <span style="color:#FF0000;float: right;">说明：以上 百分比% 单位无需填写</span><br />\
    	1.留空表示授权全部软件可以开卡所有卡类<br />\
    	2.如需授权某个程序或者多个程序请在下方添加程序编号  请以英文 “,” 符号分割<br />\
    	3.例如： 1 代表只授权编号“1”程序下的卡类 1,2,3 代表只授权编号“1”“2”“3”三款程序下的卡类\
    </label>\
    <textarea class="form-control" id="agent_software_id" rows="8"></textarea>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_agent_add();" class="btn btn-primary">添加</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
   </div>';
     $("#my_add").html(body);
        $('.bd-example-modal-lg').modal('show');
    }
	
	function ajax_agent_add(){
    		    bx_load("正在添加...");
    			  $.post("../Agent/add",{
    			  username:$("#agent_username").val(),
    			  password:$("#agent_password").val(),
    			  money:$("#agent_money").val(),
    			  rate:$("#agent_rate").val(),
    			  power:$("#agent_power").val(),
    			  congeal:$("#agent_congeal").val(),
    			  comment:$("#agent_comment").val(),
    			  recharge_agent:$("#agent_recharge_agent").val(),
    			  default_rate:$("#agent_default_rate").val(),
    			  manager_price:$("#agent_manager_price").val(),
    			  default_money:$("#agent_default_money").val(),
    			  software_id:$("#agent_software_id").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'agent_getpage("",true)');
		       });
    			  	   
    		
    	}
	
	
	function Super () {
  		if($("#agent_power").val() == "10"){
  			$("#Super_agent").css("display","block")
  		}
  		if($("#agent_power").val() == "11"){
  			$("#Super_agent").css("display","none");
  		}
  	}
	function agent_edit(idval) {
     $("#my_add").html(' ');
     loading_start();
     $.post("../Agent/getInfo",{id:idval},function(data){
     	var res = JSON.parse(data);
     	var body= '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">修改代理 编号:' + res[0].id + '</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理账号</div>\
    <input type="text" class="form-control" id="agent_username" value="' + res[0].username + '"  placeholder="给你的代理起个名字吧" disabled>\
    <div class="input-group-addon">代理密码</div>\
    <input type="text" class="form-control" id="agent_password"  placeholder="不修改请留空">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理余额</div>\
    <input type="text" class="form-control" id="agent_money" value="' + res[0].money + '"  placeholder="代理余额">\
    <div class="input-group-addon">开卡费率</div>\
    <input type="text" class="form-control" id="agent_rate" value="' + res[0].rate + '"  placeholder="卡类价格×开卡费率%=价格 1~100">\
  </div>\
  </div>\
    <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理类型</div>\
    <select id="agent_power" onchange="Super();"  class="form-control">\
      <option value="10">超级代理</option>\
      <option value="11">普通代理</option>\
    </select>\
    <div class="input-group-addon">代理状态</div>\
   <select id="agent_congeal" class="form-control">\
      <option value="1">正常</option>\
      <option value="2">停封</option>\
    </select>\
  </div>\
  </div>\
   <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理备注</div>\
    <input type="text" class="form-control" value="' + res[0].comment + '" id="agent_comment"  placeholder="不需要可留空">\
  </div>\
  </div>\
  <div id="Super_agent" >\
 <div class="card border-info mb-3 text-center">\
  <div class="card-body">\
  	<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">充值下级余额费率</div>\
    <input type="text" class="form-control" id="agent_recharge_agent"  value="' + res[0].recharge_agent + '" placeholder="1~100 单位：百分比%">\
    <div class="input-group-addon">默认下级开卡费率</div>\
    <input type="text" class="form-control" id="agent_default_rate"  value="' + res[0].default_rate + '" placeholder="1~100 单位：百分比%">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">添加下级扣除余额</div>\
   <input type="text" class="form-control" id="agent_manager_price" value="' + res[0].manager_price + '" placeholder="扣除本身余额">\
    <div class="input-group-addon">添加下级默认余额</div>\
    <input type="text" id="agent_default_money" class="form-control" value="' + res[0].default_money + '" placeholder="添加下级自带余额">\
  </div>\
  </div>\
  </div>\
</div>\
  </div>\
  <div class="form-group">\
    <label for="exampleTextarea">所属软件  <span style="color:#FF0000;float: right;">说明：以上 百分比% 单位无需填写</span><br />\
    	1.留空表示授权全部软件可以开卡所有卡类<br />\
    	2.如需授权某个程序或者多个程序请在下方添加程序编号  请以英文 “,” 符号分割<br />\
    	3.例如： 1 代表只授权编号“1”程序下的卡类 1,2,3 代表只授权编号“1”“2”“3”三款程序下的卡类\
    	</label>\
    <textarea class="form-control" id="agent_software_id" rows="8">' + res[0].software_id + '</textarea>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_agent_edit(' + res[0].id + ');" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        loading_close();
        $("#my_add").html(body);
        $('#agent_power').val(res[0].power);
    $('#agent_congeal').val(res[0].congeal);
    Super();
        $('.bd-example-modal-lg').modal('show');
     });
    }
	
	function ajax_agent_edit(id){
    		    bx_load("正在修改...");
    			  $.post("../Agent/edit",{
    			  id:id,
    			  password:$("#agent_password").val(),
    			  money:$("#agent_money").val(),
    			  rate:$("#agent_rate").val(),
    			  power:$("#agent_power").val(),
    			  congeal:$("#agent_congeal").val(),
    			  comment:$("#agent_comment").val(),
    			  recharge_agent:$("#agent_recharge_agent").val(),
    			  default_rate:$("#agent_default_rate").val(),
    			  manager_price:$("#agent_manager_price").val(),
    			  default_money:$("#agent_default_money").val(),
    			  software_id:$("#agent_software_id").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'agent_getpage("",true)');
		       });	
    	}
	
	
	function agent_del(idval){
		layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../Agent/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'agent_getpage("",true)');
    		});
		});     
	}
	
	
	
	
	function agent_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=agent_checkbox]:checked').each(function(){  
        id_array.push($(this).val());//向数组中添加元素  
        });
        var ids=id_array.join(',');//将数组元素连接起来以构建一个字符串  
        //遍历结束
        layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../Agent/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'agent_getpage("",true)');
    		});
		});
        

	}
	$(document).ready(function(){
          agent_getpage(1);
    });
//语言转换
   var agent_lang = Array();
   agent_lang['agent_power'] = Array();
   agent_lang['agent_power']['10'] = '<span class="badge badge-success my-badge">超级代理</span>';
   agent_lang['agent_power']['11'] = '<span class="badge badge-primary my-badge">普通代理</span>';
   agent_lang['agent_congeal'] = Array();
   agent_lang['agent_congeal']['1'] = '<span class="badge badge-primary my-badge">正常</span>';
   agent_lang['agent_congeal']['2'] = '<span class="badge badge-danger my-badge">停封</span>';
 /*
 * @param  page  分页号
 * @param  limit 多少个
 */
   //定义全局 储存页个数
   var agent_limit = <?php echo $config['table_num'] ?>;
   var agent_page = 1;
	function agent_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = agent_page;
    	}else{
    		agent_page = a_page;
    	}
		$.post("../Agent/lists",{
			page:a_page,
			limit:agent_limit,
			//搜索
		    power:$("#search_agent_power").val(),
		    congeal:$("#search_agent_congeal").val(),
		    menber_name:$("#search_agent_menber_name").val(),
		    username:$("#search_agent_username").val()
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(agent_page == 1){
    				$("#agent_table").html("");
    				$("#agent_page").html("");
    				}else{
    					agent_getpage(agent_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"agent_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["username"] +  "</td>\
    				<td>"+agent_lang['agent_power'][res.data[i]["power"]]+"</td>\
    				<td>"+res.data[i]["boss_name"]+"</td>\
    				<td>"+res.data[i]["money"]+"</td>\
    				<td>"+res.data[i]["consumed"]+"</td>\
    				<td>"+agent_lang['agent_congeal'][res.data[i]["congeal"]]+"</td>\
    				<td>"+res.data[i]["comment"]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"agent_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"agent__edit_authority("+res.data[i]["id"]+");\"  class=\"btn btn-info btn-sm\">权限</a> <a href=\"javascript:;\" onclick=\"agent_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
                }
    			$("#agent_table").html(body);
    			$("#agent_page").html(bx_page(res.count,a_page,agent_limit,'agent_getpage'));
    			if(load == null){
    			loading_close();
    			}
    		});
	}
	
	function agent__edit_authority(idval) {
     loading_start();
     $.post("../Agent/getAuthorityInfo",{id:idval},function(data){
     	res = JSON.parse(data);
     	var body = '<div class="container-fluid p-3">\
		<div class="row pb-3">\
  <div class="col-4">\
	<label class="form-check-label">\
      <input id="agent_binding_state"  type="checkbox" class="form-check-input">\
      允许解绑用户\
    </label>\
</div>\
    <div class="col-4">\
    	<label class="form-check-label">\
      <input id="agent_offline_state"  type="checkbox" class="form-check-input">\
      允许踢用户下线\
    </label>\
    </div>\
    <div class="col-4">\
    	<label class="form-check-label">\
      <input id="agent_deluser_state"  type="checkbox" class="form-check-input">\
      允许删除用户\
    </label>\
    </div>\
  </div>\
  <div class="row pb-3">\
  <div class="col-4">\
	<label class="form-check-label">\
      <input id="agent_changepw_state"  type="checkbox" class="form-check-input">\
         允许修改用户密码\
    </label>\
</div>\
    <div class="col-4">\
    	<label class="form-check-label">\
      <input id="agent_congeal_state"  type="checkbox" class="form-check-input">\
      允许修改用户状态\
    </label>\
    </div>\
    <div class="col-4">\
    	<label class="form-check-label">\
      <input id="agent_endtime_state"  type="checkbox" class="form-check-input">\
      允许修改用户到期时间\
    </label>\
    </div>\
  </div>\
  <div class="row pb-3">\
  <div class="col-4">\
	<label class="form-check-label">\
      <input id="agent_point_state"  type="checkbox" class="form-check-input">\
         允许修改用户点数\
    </label>\
</div>\
<div class="col-4">\
	<label class="form-check-label">\
      <input id="agent_delcard_state"  type="checkbox" class="form-check-input">\
         允许删除卡密\
    </label>\
</div>\
  </div>\
  <div class="text-center">\
  	<a href="javascript:;"  onclick="ajax_agent_edit_authority(' + res[0].menber_id + ');" class="btn btn-primary">修改</a>\
  </div>\
	</div>';
        loading_close();
        layer.open({
            type: 1,
            closeBtn: 2,
            title: "代理权限 编号：" + idval,
            area: '650px',
            content: body
        });
        $("#agent_binding_state").prop("checked", res[0].binding_state == 2 ? true : false);
	    $("#agent_offline_state").prop("checked", res[0].offline_state == 2 ? true : false);
	    $("#agent_deluser_state").prop("checked", res[0].deluser_state == 2 ? true : false);
	    $("#agent_changepw_state").prop("checked", res[0].changepw_state == 2 ? true : false);
	    $("#agent_congeal_state").prop("checked", res[0].congeal_state == 2 ? true : false);
	    $("#agent_endtime_state").prop("checked", res[0].endtime_state == 2 ? true : false);
	    $("#agent_point_state").prop("checked", res[0].point_state == 2 ? true : false);
	    $("#agent_delcard_state").prop("checked", res[0].delcard_state == 2 ? true : false);
        
     });
    }
	
	
	function ajax_agent_edit_authority (id) {
		bx_load("正在修改...");
    			  $.post("../Agent/editAuthority",{
    			  id:id,
    			  binding_state:$("#agent_binding_state:checked").val(),
    			  offline_state:$("#agent_offline_state:checked").val(),
    			  deluser_state:$("#agent_deluser_state:checked").val(),
    			  changepw_state:$("#agent_changepw_state:checked").val(),
    			  congeal_state:$("#agent_congeal_state:checked").val(),
    			  endtime_state:$("#agent_endtime_state:checked").val(),
    			  point_state:$("#agent_point_state:checked").val(),
    			  delcard_state:$("#agent_delcard_state:checked").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result);
		        });
	}
	
	
	
</script>





       


  	
  </div>
  
<!--代理日志-->
  <div class="tab-pane fade" id="agent_log" role="tabpanel" aria-labelledby="agent_log-tab">
  	  	<div class="py-2"></div>
  	  	<?php do_action('admin_agent_log'); ?>
  	<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="agent_log_checkeddel();"  class="btn btn-danger">删除选中</a>
</div>




	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=agent_log_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th>编号</th>
      <th>操作者</th>
      <th>操作类型</th>
      <th>详情</th>
      <th>IP</th>
      <th>操作时间</th>
    </tr>
  </thead>
  <tbody id="agent_log_table">
 
  </tbody>
</table>
  	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="agent_log_page">
    
  </ul>
</nav>  	
  	
<script type="text/javascript">
	function agent_log_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=agent_log_checkbox]:checked').each(function(){  
        id_array.push($(this).val());//向数组中添加元素  
        });
        var ids=id_array.join(',');//将数组元素连接起来以构建一个字符串  
        //遍历结束
        layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../MenberLog/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'agent_log_getpage("",true)');
    		});
		});
        
        
        
        
    }

//语言转换
   var agent_log_lang = Array();
   agent_log_lang['menber_log_type'] = Array();
   agent_log_lang['menber_log_type']['1'] = '登陆';
   agent_log_lang['menber_log_type']['2'] = '代理管理';
   agent_log_lang['menber_log_type']['3'] = '卡密管理';
   agent_log_lang['menber_log_type']['4'] = '安全管理';
   agent_log_lang['menber_log_type']['5'] = '软件管理';
   agent_log_lang['menber_log_type']['6'] = '用户管理';

	      /**
 * @param  page  分页号
 * @param  limit 多少个
 */
    $("#agent_log-tab").one("click",function(){agent_log_getpage(1);});
   //定义全局 储存页个数
   var agent_log_limit = <?php echo $config['table_num'] ?>;
   var agent_log_page = 1;
	function agent_log_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = agent_log_page;
    	}else{
    		agent_log_page = a_page;
    	}
		$.post("../MenberLog/lists?agent=yes",{
			page:a_page,
			limit:agent_log_limit,
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(agent_log_page == 1){
    				$("#agent_log_table").html("");
    				$("#agent_log_page").html("");
    				}else{
    					agent_log_getpage(agent_log_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"agent_log_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["menber_name"] +  "</td>\
    				<td>" + agent_log_lang['menber_log_type'][res.data[i]["type"]] +  "</td>\
    				<td>"+res.data[i]["details"]+"</td>\
    				<td>"+res.data[i]["ip"]+"</td>\
    				<td>"+bx_time(res.data[i]["time"])+"</td>";
                }
    			$("#agent_log_table").html(body);
    			$("#agent_log_page").html(bx_page(res.count,a_page,agent_log_limit,'agent_log_getpage'));
    			if(load == null){
    			loading_close();
    			}
    		});
	}
</script>






  	
</div>




<!--代理公告-->
  <div class="tab-pane fade" id="agent_bulletin" role="tabpanel" aria-labelledby="agent_bulletin-tab">
  	<div class="py-2"></div>
  	<?php do_action('admin_agent_bulletin'); ?>
  	<div class="alert alert-success" role="alert">
  <strong>代理公告：   </strong> 用于展示在代理登陆后的界面 格式:html代码
</div>

<textarea class="form-control" id="thenm_agent_bulletin" rows="20"><?php echo $config['agent_bulletin']; ?></textarea>

<br />
        <button type="button" onclick="agent_edit_bulletin();" class="btn btn-success">确认修改</button>
        <button type="button" onclick="$('#yulan').html($('#thenm_agent_bulletin').val());" class="btn btn-info">预览</button>
<div class="py-2" ></div>
<div id="yulan"></div>

<script type="text/javascript">
	function agent_edit_bulletin () {
    	bx_load("正在修改...");
    	$.post("../Agent/setBulletin",{
    		bulletin:$("#thenm_agent_bulletin").val()
    	},function(result){
			bx_load_close();
			bx_msg(result);
		});
    	
	}
</script>

 	
</div>

 
 
 
<div class="tab-pane fade" id="agent_card" role="tabpanel" aria-labelledby="agent_card-tab">
<?php do_action('admin_agent_card'); ?>
<div class="bd-callout bd-callout-info">
  	   	
<div class="form-inline">
	


    <div class="form-group">
    	状态：
    <select class="form-control" id="search_agent_card_state">
      <option value="">全部</option>
      <option value="1">正常使用</option>
      <option value="2">停止使用</option>
    </select>&nbsp;
    </div>
    
    <div class="form-group">
    	使用状态：
    <select class="form-control" id="search_agent_card_used">
      <option value="">全部</option>
      <option value="1">未被使用</option>
      <option value="2">已经使用</option>
    </select>&nbsp;
    </div>
    
    
    <div class="form-group">   
       卡名：
    <input type="text" class="form-control" id="search_agent_card_name" style="width: 150px;" >&nbsp;
    </div>

       
    <div class="form-group">
       卡密：
    <input type="text" class="form-control" id="search_agent_card_cardnum" style="width: 150px;" >&nbsp;
    </div>
    <a href="javascript:;" onclick="agent_card_getpage(1);"   class="btn btn-info">搜索</a>

</div>
</div>
	
	
	
<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="agent_card_add();"  class="btn btn-success">添加卡密</a>
  		<a href="javascript:;"  onclick="agent_card_checkeddel();"  class="btn btn-danger">删除选中</a>
  		<a href="javascript:;"  onclick="export_card('#agent_card_table td:nth-child(6)','text');"  class="btn btn-primary">导出</a>
  	</div>
  	
  	
  	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=agent_card_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th>编号</th>
      <th>卡密名称</th>
      <th>余额</th>
      <th>造卡日期</th>
      <th>卡密</th>
      <th>备注</th>
      <th>状态</th>
      <th>使用状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="agent_card_table">
 
  </tbody>
</table>
  	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="agent_card_page">
    
  </ul>
</nav> 

<script type="text/javascript">
	function agent_card_add() {
		var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">添加代理卡密</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密名称</div>\
    <input id="agent_card_name" type="text" class="form-control" value=""  placeholder="起个名字吧！">\
    <div class="input-group-addon">卡密余额</div>\
    <input id="agent_card_money" type="text" class="form-control" value=""  placeholder="余额">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">生成数量</div>\
    <input id="agent_card_count" type="text" class="form-control" value=""  placeholder="单位：数字">\
    <div class="input-group-addon">卡密卡头</div>\
    <input id="agent_card_head" type="text" class="form-control" value=""  placeholder="不需要可留空">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">生成备注</div>\
    <input id="agent_card_comment" type="text" class="form-control" value=""  placeholder="单位：备注">\
  </div>\
  </div>\
<div  style="text-align: center;">\
<a   href="javascript:;"  onclick="ajax_agent_card_add();"  class="btn btn-primary">生成</a>\
</div>\
<div class="form-group">\
    <label for="exampleTextarea">生成列表</label>\
    <textarea class="form-control" id="agent_card_body" rows="18"></textarea>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button></div></div>';
     $("#my_add").html(body);

      $('.bd-example-modal-lg').modal('show');
     
    }
    
    function ajax_agent_card_add(){
    		bx_load("正在生成...<br/>生成数量过多会大量耗时...");
    			  $.post("../AgentCard/add",{
    			  name:$("#agent_card_name").val(),
    			  money:$("#agent_card_money").val(),
    			  head:$("#agent_card_head").val(),
    			  count:$("#agent_card_count").val(),
    			  comment:$("#agent_card_comment").val()
    			  },function(result){
			         bx_load_close();
			         a = JSON.parse(result);
			         bx_msg(JSON.stringify(a.msg ? a.msg : a),'agent_card_add_body(' + result + ')');
		       });
    		
    	}
    	function agent_card_add_body (data) {
    		res = data;
			  var body = "";
			  for (var i = 0; i < res.data.length; i++) {
			      body += res.data[i] + "\n";
			  }
			  agent_card_getpage("",true);
			  $("#agent_card_body").html(body);
    	}
    
    
    
    
    function agent_card_edit(idval) {
     $("#my_add").html(' ');
     loading_start();
     $.post("../AgentCard/getInfo",{id:idval},function(data){
     	var res = JSON.parse(data);
     	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">修改代理卡密 编号:' + res[0].id + '</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密名称</div>\
    <input id="agent_card_name" type="text" class="form-control" value="' + res[0].name + '"  placeholder="卡密名称">\
    <div class="input-group-addon">卡密状态</div>\
    <select class="form-control" id="agent_card_state" >\
      <option value="1">正常使用</option>\
      <option value="2">停止使用</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密余额</div>\
    <input id="agent_card_money" type="text" class="form-control" value="' + res[0].money + '"  placeholder="单位：小时">\
    <div class="input-group-addon">卡密备注</div>\
    <input id="agent_card_comment" type="text" class="form-control" value="' + res[0].comment + '"  placeholder="不需要可留空">\
  </div>\
  </div>\
  <h4>卡密信息：</h4>\
  <p>卡密：' + res[0].cardnum + '</p>\
  <p>使用状态：<span id="xyzt"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;使用者：' + res[0].username + '</p>\
  <p>造卡日期：<span id="zksj"></span></p>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_card_edit(' + res[0].id + ');" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        loading_close();
        $("#my_add").html(body);
        $('#agent_card_state').val(res[0].state);
    	$("#xyzt").html(card_lang['card_used'][res[0].used]);
    	$("#zksj").html(bx_time(res[0].create_time));
        $('.bd-example-modal-lg').modal('show');
     });
    }
    function ajax_card_edit(id){
    		bx_load("正在修改...");
    			  $.post("../AgentCard/edit",{
    			  id:id,
    			  name:$("#agent_card_name").val(),
    			  money:$("#agent_card_money").val(),
    			  state:$("#agent_card_state").val(),
    			  comment:$("#agent_card_comment").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'agent_card_getpage("",true)');
		        });

    		
    	}
    function agent_card_del(idval){
		layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../AgentCard/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'agent_card_getpage("",true)');
    		});
		});     
	}
	
	
	
	
	function agent_card_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=agent_card_checkbox]:checked').each(function(){  
        id_array.push($(this).val());//向数组中添加元素  
        });
        var ids=id_array.join(',');//将数组元素连接起来以构建一个字符串  
        //遍历结束
        layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../AgentCard/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'agent_card_getpage("",true)');
    		});
		});
        

	}
    
    
    $("#agent_card-tab").one("click",function(){agent_card_getpage(1);});
    
    
    
    //语言转换
   var card_lang = Array();
   card_lang['card_state'] = Array();
   card_lang['card_state']['1'] = '<span class="badge badge-primary my-badge">正常使用</span>';
   card_lang['card_state']['2'] = '<span class="badge badge-danger my-badge">停止使用</span>';
   card_lang['card_used'] = Array();
   card_lang['card_used']['1'] = '<span class="badge badge-info my-badge">未被使用</span>';
   card_lang['card_used']['2'] = '<span class="badge badge-success my-badge">已被使用</span>';
    //定义全局 储存页个数
   var agent_card_limit = <?php echo $config['table_num'] ?>;
   var agent_card_page = 1;
	function agent_card_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = agent_card_page;
    	}else{
    		agent_card_page = a_page;
    	}
		$.post("../AgentCard/lists",{
			page:a_page,
			limit:agent_card_limit,
			//搜索
		    state:$("#search_agent_card_state").val(),
		    used:$("#search_agent_card_used").val(),
		    name:$("#search_agent_card_name").val(),
		    cardnum:$("#search_agent_card_cardnum").val()
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(agent_card_page == 1){
    				$("#agent_card_table").html("");
    				$("#agent_card_page").html("");
    				}else{
    					agent_card_getpage(agent_card_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"agent_card_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["name"] +  "</td>\
    				<td>"+res.data[i]["money"]+"</td>\
    				<td>"+bx_time(res.data[i]["create_time"])+"</td>\
    				<td>"+res.data[i]["cardnum"]+"</td>\
    				<td>"+res.data[i]["comment"]+"</td>\
    				<td>"+card_lang['card_state'][res.data[i]["state"]]+"</td>\
    				<td>"+card_lang['card_used'][res.data[i]["used"]]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"agent_card_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"agent_card_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
                }
    			$("#agent_card_table").html(body);
    			$("#agent_card_page").html(bx_page(res.count,a_page,agent_card_limit,'agent_card_getpage'));
    			if(load == null){
    			loading_close();
    			}
    		});
	}
</script>


 	
</div>
 
 
  	

  
  
</div>

<!--main-->
  </div>
</div>
</div>
	</div>
</div>
