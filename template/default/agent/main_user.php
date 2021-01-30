<?php if(!defined('BX_ROOT')) {exit();} ?>
<?php
$software = get_software_lists(); ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
		<div class="card">
  <h3 class="card-header">用户管理</h3>
  <div class="card-body ">
  <!--main-->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="user-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user" aria-expanded="true">用户管理</a>
  </li>
</ul>

<!--modal-->
<div class="modal fade bd-example-modal-lg" id="a" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="my_add" class="modal-dialog modal-lg">
    
    <!--弹窗内容-->
    
  </div>
</div>




<div class="tab-content" id="myTabContent">
<!--用户管理-->
  <div class="tab-pane fade  show active" id="user" role="tabpanel" aria-labelledby="user-tab">
<?php do_action('agent_user'); ?>
<div class="bd-callout bd-callout-info">
  	   	
<div class="form-inline">
	
    <div class="form-group">
       程序名：
    <select class="form-control" id="search_user_software_id" style="width: 150px">
      <option value="">全部</option>
      <?php foreach($software as $k => $v):;?>
	  ?>
	  <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
      <?php endforeach; ?>
    </select>&nbsp;
    </div>
 

    <div class="form-group">
    	状态：
    <select class="form-control" id="search_user_congeal">
      <option value="">全部</option>
      <option value="1">正常</option>
      <option value="2">停封</option>
    </select>&nbsp;
    </div>
    	
     <div class="form-group">
    	在线状态：
    <select class="form-control" id="search_user_state">
      <option value="">全部</option>
      <option value="2">在线</option>
      <option value="1">离线</option>
    </select>&nbsp;
    </div>
    	
  
    <div class="form-group">
       用户名：
    <input type="text" class="form-control" id="search_user_username" style="width: 150px;" >&nbsp;
    </div>
    <a href="javascript:;" onclick="user_getpage(1);"   class="btn btn-info">搜索</a>
    &nbsp;&nbsp;&nbsp;&nbsp;
    <a data-toggle="collapse" href="#more" aria-expanded="false" aria-controls="more"  >更多</a>

</div>

<!--更多搜索-->
<div class="collapse" id="more">
<div class="form-inline pt-3">
	<div class="form-group">   
       注册时间：
    <input type="text" class="form-control laydate" id="search_user_regtime_start" style="width: 200px;">&nbsp;~&nbsp;
    <input type="text" class="form-control laydate" id="search_user_regtime_end" style="width: 200px;">&nbsp;
    </div>
    <div class="form-group">   
       到期时间：
    <input type="text" class="form-control laydate" id="search_user_endtime_start" style="width: 200px;">&nbsp;~&nbsp;
    <input type="text" class="form-control laydate" id="search_user_endtime_end" style="width: 200px;">&nbsp;
    </div>
    <div class="form-group">   
       点数：
    <input type="text" class="form-control" id="search_user_point_start" style="width: 150px;">&nbsp;~&nbsp;
    <input type="text" class="form-control" id="search_user_point_end" style="width: 150px;">&nbsp;
    </div>
</div>
</div>



</div>


<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="user_checkeddel();"  class="btn btn-danger">删除选中</a>
</div>




	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=user_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th >编号</th>
      <th>用户名</th>
      <th>归属程序</th>
      <th>归属管理</th>
      <th>注册时间</th>
      <th>到期时间</th>
      <th>点数</th>
      <th>机器码</th>
      <th>自定义数据</th>
      <th>备注</th>
      <th>状态</th>
      <th>在线状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="user_table">
 
  </tbody>
</table>
  	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="user_page">
    
  </ul>
</nav>  	





<script type="text/javascript">
	function user_edit(idval) {
     $("#my_add").html(' ');
     loading_start();
     $.post("../User/getInfo",{id:idval},function(data){
     	var res = JSON.parse(data);
     	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">修改用户 编号:'+ res[0].id +'</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">用户状态</div>\
     <select class="form-control" id="user_congeal">\
      <option value="1">正常</option>\
      <option value="2">停封</option>\
    </select>\
    	<div class="input-group-addon">到期时间</div>\
    <input id="user_endtime" type="text" class="form-control" value="'+ res[0].endtime +'"  placeholder="单位：小时">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">用户数据</div>\
   <input id="user_user_data" type="text" class="form-control" value="'+ res[0].user_data +'"  placeholder="自定义数据" disabled>\
    <div class="input-group-addon">用户点数</div>\
    <input id="user_point" type="text" class="form-control" value="'+ res[0].point +'"  placeholder="单位：数字">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">普通密码</div>\
   <input id="user_password" type="text" class="form-control" value=""  placeholder="不修改请留空">\
    <div class="input-group-addon">超级密码</div>\
    <input id="user_super_password" type="text" class="form-control" value=""  placeholder="不修改请留空">\
  </div>\
  </div>\
    <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">用户备注</div>\
    <input id="user_comment" type="text" class="form-control" value="'+ res[0].comment +'"  placeholder="不需要可留空">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
  </div>\
  </div>\
  <h4>用户信息：</h4>\
  <p>用户账号：'+ res[0].username +'</p>\
  <p>在线状态：<span id="zxzt"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机器码：'+ res[0].machine_code +'</p>\
  <p>归属程序：'+ res[0].software_name +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;归属管理：'+ res[0].menber_username +'</p>\
  <p>注册时间：<span id="zcsj"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注册IP：'+ res[0].regip +'</p>\
  <p>最后一次登陆时间：<span id="zhdl"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最后一次登陆IP：'+ res[0].logip +'</p>\
 </div>\
      <div class="modal-footer">\
      	<label class="form-check-label">\
    <input class="form-check-input" type="checkbox" id="user_machine_code" value="on">清除机器码\
  </label>\
    <label class="form-check-label">\
    <input class="form-check-input" type="checkbox"  id="user_state" value="on">强制下线\
  </label>\
  <div class="mr-auto"></div>\
        <a href="javascript:;" onclick="ajax_user_edit('+ res[0].id +');" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        loading_close();
        $("#my_add").html(body);
        $("#user_congeal").val(res[0].congeal);
    	$("#user_endtime").val(bx_time(res[0].endtime));
    	$("#zxzt").html(user_lang['user_state'][res[0].state]);
    	$("#zcsj").html(bx_time(res[0].regtime));
    	$("#zhdl").html(res[0].logtime ? bx_time(res[0].logtime) : "从未登陆" );
    	laydate.render({elem: '#user_endtime',type: 'datetime'});
        $('.bd-example-modal-lg').modal('show');
     });
    }
	
	function ajax_user_edit(id){
    		bx_load("正在修改...");
    			  $.post("../User/edit",{
    			  id:id,
    			  congeal:$("#user_congeal").val(),
    			  endtime:$("#user_endtime").val(),
    			  point:$("#user_point").val(),
    			  password:$("#user_password").val(),
    			  super_password:$("#user_super_password").val(),
    			  machine_code:$('#user_machine_code:checked').val(),
    			  state:$('#user_state:checked').val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'user_getpage("",true)');
		        });

    			  	   

    		
    	}
	
	
	
	
	function user_del(idval){
		layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../User/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'user_getpage("",true)');
    		});
		});
		
	}
	function user_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=user_checkbox]:checked').each(function(){  
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
			$.post("../User/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'user_getpage("",true)');
    		});
		});
        
        
        
	}
	$(document).ready(function(){
          user_getpage(1);
    });
    
    //语言转换
   var user_lang = Array();
   user_lang['user_congeal'] = Array();
   user_lang['user_congeal']['1'] = '<span class="badge badge-primary my-badge">正常</span>';
   user_lang['user_congeal']['2'] = '<span class="badge badge-danger my-badge">停封</span>';
   user_lang['user_state'] = Array();
   user_lang['user_state']['1'] = '<span class="badge badge-secondary my-badge">离线</span>';
   user_lang['user_state']['2'] = '<span class="badge badge-success my-badge">在线</span>';
    
       /**
 * @param  page  分页号
 * @param  limit 多少个
 */
   //定义全局 储存页个数
   var user_limit = <?php echo $config['table_num'] ?>;
   var user_page = 1;
	function user_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = user_page;
    	}else{
    		user_page = a_page;
    	}
		$.post("../User/lists",{
			page:a_page,
			limit:user_limit,
			//搜索
		    software_id:$("#search_user_software_id").val(),
		    congeal:$("#search_user_congeal").val(),
		    state:$("#search_user_state").val(),
		    username:$("#search_user_username").val(),
		    regtime_start:$("#search_user_regtime_start").val(),
		    regtime_end:$("#search_user_regtime_end").val(),
		    endtime_start:$("#search_user_endtime_start").val(),
		    endtime_end:$("#search_user_endtime_end").val(),
		    point_start:$("#search_user_point_start").val(),
		    point_end:$("#search_user_point_end").val()
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(user_page == 1){
    				$("#user_table").html("");
    				$("#user_page").html("");
    				}else{
    					user_getpage(user_page-1);
    				}
    				return;
    			}
    			//时间格式错误 服务器会返回 信息
    			res=JSON.parse(data);
    			if(res.state == 'error'){
    				loading_close();
    				layer.alert(res.text, {
            			icon: window.msg_icon['error'],
            			title: res.title,
            			closeBtn: 2,
        		    });
    				return;
    			}
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"user_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["username"] +  "</td>\
    				<td>"+res.data[i]["software_name"]+"</td>\
    				<td>"+res.data[i]["menber_name"]+"</td>\
    				<td>"+bx_time(res.data[i]["regtime"])+"</td>\
    				<td>"+bx_time(res.data[i]["endtime"])+"</td>\
    				<td>"+res.data[i]["point"]+"</td>\
    				<td>"+res.data[i]["machine_code"]+"</td>\
    				<td>"+res.data[i]["user_data"]+"</td>\
    				<td>"+res.data[i]["comment"]+"</td>\
    				<td>"+user_lang['user_congeal'][res.data[i]["congeal"]]+"</td>\
    				<td>"+user_lang['user_state'][res.data[i]["state"]]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"user_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"user_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
                }
    			$("#user_table").html(body);
    			$("#user_page").html(bx_page(res.count,a_page,user_limit,'user_getpage'));
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
