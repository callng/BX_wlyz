<?php if(!defined('BX_ROOT')) {exit();} ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
		<div class="card">
  <h3 class="card-header">程序管理</h3>
  
  <div class="card-body ">
  	<?php do_action('admin_software'); ?>
  <div class="form-check form-check-inline">
  <a href="javascript:;"  onclick="software_add()"  class="btn btn-success">添加程序</a>
  
</div>

<!--modal-->
<div class="modal fade bd-example-modal-lg" id="a" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="my_add" class="modal-dialog modal-lg">
    
    <!--弹窗内容-->
    
  </div>
</div>

<script type="text/javascript">
	
	function software_add() {
	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">添加程序</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序名称</div>\
    <input type="text" class="form-control" id="name"  placeholder="给你的程序起个名字吧">\
    <div class="input-group-addon">版本号码</div>\
    <input type="text" class="form-control" id="version"  placeholder="程序版本号码用于更新程序">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序公告</div>\
    <input type="text" class="form-control" id="notice"  placeholder="程序的公告">\
    <div class="input-group-addon">静态数据</div>\
    <input type="text" class="form-control" id="static_data"  placeholder="静态数据">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">试用间隔</div>\
    <input type="text" id="trial_interval" class="form-control"  placeholder="0为不允许 单位：小时">\
    <div class="input-group-addon">试用时间</div>\
    <input type="text" id="trial_data" class="form-control"  placeholder="单位：分钟">\
  </div>\
  </div>\
    <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">更新地址</div>\
    <input type="text" class="form-control" id="update_data"  placeholder="更新地址">\
    <div class="input-group-addon">程序状态</div>\
    <select id="software_state" class="form-control">\
      <option value="1">正常运营</option>\
      <option value="2">停止运营</option>\
      <option value="3">免费运营</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">绑定模式</div>\
    <select id="binding_type" class="form-control">\
      <option value="1">不绑定</option>\
      <option value="2">机器码绑定</option>\
    </select>\
    <div class="input-group-addon">解绑模式</div>\
   <select id="bindingdel_type" class="form-control">\
      <option value="1">可以解绑</option>\
      <option value="2">不能解绑</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">登陆模式</div>\
    <select id="login_type" class="form-control">\
      <option value="1">已经在线，则挤下线</option>\
      <option value="2">已经在线，不可登陆</option>\
    </select>\
    <div class="input-group-addon">更新方式</div>\
   <select id="update_type" class="form-control">\
      <option value="1">自行更新</option>\
      <option value="2">强制更新</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">注册赠送时间</div>\
    <input id="give_time" type="text" class="form-control"  placeholder="单位：分钟">\
    <div class="input-group-addon">注册赠送点数</div>\
    <input type="text" class="form-control" id="give_point"  placeholder="单位：数字">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">解绑扣除时间</div>\
    <input id="bindingdel_time" type="text" class="form-control"  placeholder="单位：分钟">\
    <div class="input-group-addon">解绑扣除点数</div>\
    <input type="text" class="form-control" id="bindingdel_point"  placeholder="单位：数字">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">&nbsp;&nbsp;&nbsp;每个机器码&nbsp;&nbsp;&ensp;&ensp;</div>\
    <input id="restrict_regtime" type="text" class="form-control" value="24"  placeholder="单位：小时">\
    <div class="input-group-addon">小时内可以注册</div>\
    <input id="restrict_regnum" type="text" class="form-control" value="3"  placeholder="单位：个数">\
    <div class="input-group-addon">个账号</div>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">心跳检测时间</div>\
    <input id="heart_time" type="text" class="form-control" value="180"  placeholder="单位：秒">\
  </div>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_software_add();" class="btn btn-primary">添加</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        $("#my_add").html(body);
        $('.bd-example-modal-lg').modal('show');
}
          
          
        function ajax_software_add(){
        	if(software_check() == false){
       	        return;
       	    }
    		bx_load("正在添加...");
    		$.post("../Software/add",{
    			  name:$("#name").val(),
    			  heart_time:$("#heart_time").val(),
    			  version:$("#version").val(),
    			  notice:$("#notice").val(),
    			  static_data:$("#static_data").val(),
    			  give_time:$("#give_time").val(),
    			  give_point:$("#give_point").val(),
    			  login_type:$("#login_type").val(),
    			  update_data:$("#update_data").val(),
    			  update_type:$("#update_type").val(),
    			  trial_interval:$("#trial_interval").val(),
    			  trial_data:$("#trial_data").val(),
    			  software_state:$("#software_state").val(),
    			  binding_type:$("#binding_type").val(),
    			  bindingdel_type:$("#bindingdel_type").val(),
    			  bindingdel_time:$("#bindingdel_time").val(),
    			  bindingdel_point:$("#bindingdel_point").val(),
    			  restrict_regtime:$("#restrict_regtime").val(),
    			  restrict_regnum:$("#restrict_regnum").val()
    		},function(result){
			      bx_load_close();
			      bx_msg(result,'getpage("",true)');
		    });
		}
		    
		    
		    
		 
		function software_edit(idval) {
            $("#my_add").html(' ');
            loading_start();
            $.post("../Software/getInfo",{id:idval},
    		       function(result){
    		       	var res = JSON.parse(result);
    		       	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">修改程序 编号:' + res[0].id + '</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序名称</div>\
    <input type="text" class="form-control" id="name" value="' + res[0].name + '"  placeholder="给你的程序起个名字吧">\
    <div class="input-group-addon">版本号码</div>\
    <input type="text" class="form-control" id="version" value="' + res[0].version + '"  placeholder="程序版本号码用于更新程序">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序公告</div>\
    <input type="text" class="form-control" id="notice" value="' + res[0].notice + '"  placeholder="程序的公告">\
    <div class="input-group-addon">静态数据</div>\
    <input type="text" class="form-control" id="static_data" value="' + res[0].static_data + '"  placeholder="静态数据">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">试用间隔</div>\
    <input type="text" id="trial_interval" value="' + res[0].trial_interval + '" class="form-control"  placeholder="0为不允许 单位：小时">\
    <div class="input-group-addon">试用时间</div>\
    <input type="text" id="trial_data" value="' + res[0].trial_data + '" class="form-control"  placeholder="单位：分钟">\
  </div>\
  </div>\
    <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">更新地址</div>\
    <input type="text" class="form-control" id="update_data" value="' + res[0].update_data + '"   placeholder="更新地址">\
    <div class="input-group-addon">程序状态</div>\
    <select id="software_state" class="form-control">\
      <option value="1">正常运营</option>\
      <option value="2">停止运营</option>\
      <option value="3">免费运营</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">绑定模式</div>\
    <select id="binding_type" class="form-control">\
      <option value="1">不绑定</option>\
      <option value="2">机器码绑定</option>\
    </select>\
    <div class="input-group-addon">解绑模式</div>\
   <select id="bindingdel_type" class="form-control">\
      <option value="1">可以解绑</option>\
      <option value="2">不能解绑</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">登陆模式</div>\
    <select id="login_type" class="form-control">\
      <option value="1">已经在线，则挤下线</option>\
      <option value="2">已经在线，不可登陆</option>\
    </select>\
    <div class="input-group-addon">更新方式</div>\
   <select id="update_type" class="form-control">\
      <option value="1">自行更新</option>\
      <option value="2">强制更新</option>\
    </select>\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">注册赠送时间</div>\
    <input id="give_time" type="text" class="form-control" value="' + res[0].give_time + '"  placeholder="单位：分钟">\
    <div class="input-group-addon">注册赠送点数</div>\
    <input id="give_point" type="text" class="form-control" value="' + res[0].give_point + '"  placeholder="单位：数字">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">解绑扣除时间</div>\
    <input id="bindingdel_time" type="text" class="form-control" value="' + res[0].bindingdel_time + '"  placeholder="单位：分钟">\
    <div class="input-group-addon">解绑扣除点数</div>\
    <input id="bindingdel_point" type="text" class="form-control" value="' + res[0].bindingdel_point + '"  placeholder="单位：数字">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">&nbsp;&nbsp;&nbsp;每个机器码&nbsp;&nbsp;&ensp;&ensp;</div>\
    <input id="restrict_regtime" type="text" class="form-control" value="' + res[0].restrict_regtime + '"  placeholder="单位：小时">\
    <div class="input-group-addon">小时内可以注册</div>\
    <input id="restrict_regnum" type="text" class="form-control" value="' + res[0].restrict_regnum + '"  placeholder="单位：个数">\
    <div class="input-group-addon">个账号</div>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">心跳检测时间</div>\
    <input type="text" class="form-control" id="heart_time" value="' + res[0].heart_time + '"  placeholder="单位：秒">\
  </div>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_software_again_s_key('+ res[0].id +');" class="btn btn-danger mr-auto">重新生成程序KEY</a>\
        <a href="javascript:;" onclick="ajax_software_edit('+ res[0].id +');" class="btn btn-primary">确定修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
    			       loading_close();
    			       $("#my_add").html(body);
    			       $('#software_state').val(res[0].software_state);
    			       $('#binding_type').val(res[0].binding_type);
    			       $('#bindingdel_type').val(res[0].bindingdel_type);
    			       $('#login_type').val(res[0].login_type);
    			       $('#update_type').val(res[0].update_type);
    			       $('.bd-example-modal-lg').modal('show');
    		});

       }
       
       function ajax_software_edit(id){
       	        if(software_check() == false){
       	        	return;
       	        }
    		    bx_load("正在修改...");
    			  $.post("../Software/edit",{
    			  id:id,
    			  name:$("#name").val(),
    			  heart_time:$("#heart_time").val(),
    			  version:$("#version").val(),
    			  notice:$("#notice").val(),
    			  static_data:$("#static_data").val(),
    			  give_time:$("#give_time").val(),
    			  give_point:$("#give_point").val(),
    			  login_type:$("#login_type").val(),
    			  update_data:$("#update_data").val(),
    			  update_type:$("#update_type").val(),
    			  trial_interval:$("#trial_interval").val(),
    			  trial_data:$("#trial_data").val(),
    			  software_state:$("#software_state").val(),
    			  binding_type:$("#binding_type").val(),
    			  bindingdel_type:$("#bindingdel_type").val(),
    			  bindingdel_time:$("#bindingdel_time").val(),
    			  bindingdel_point:$("#bindingdel_point").val(),
    			  restrict_regtime:$("#restrict_regtime").val(),
    			  restrict_regnum:$("#restrict_regnum").val()
    			  },function(result){
			          bx_load_close();
			          bx_msg(result,'getpage("",true)')
		        });
    			
    			  	   
    		
    		
    	}
       
       //重新生成key
    	function ajax_software_again_s_key(id){
    		bx_load("正在重新生成程序key...");
    		$.post("../Software/againKey",{
    			  id:id
    		},function(result){
			      bx_load_close();
			      bx_msg(result,'getpage("",true)')
		    });
    		

    	}
       
       
       
       function software_remote_edit(idval) {
            $("#my_add").html(' ');
            loading_start();
            $.post("../Software/getRemoteInfo",{id:idval},
    		       function(result){
    		       	   res = JSON.parse(result);
    		       	   var body = '	<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">远程函数 编号:'+ res[0].id +'</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
        <div class="alert alert-info" role="alert" >\
  <strong>远程函数</strong> 采用PHP语法\
  <a class="btn btn-primary btn-sm float-right" data-toggle="collapse" href="#collapse_remote" aria-expanded="false" aria-controls="collapse_remote">\
    系统函数\
  </a>\
</div>\
<div class="collapse" id="collapse_remote" >\
<div class="card">\
  <div class="card-body">\
  	函数调用以及说明 请查看官方文档\
  	<br />\
  <code>bx_verify_user</code>&nbsp;&nbsp;<code>bx_verify_single_card</code>\
  </div>\
</div>\
  <br />\
</div>\
<textarea class="form-control" id="software_remote" rows="20">'+ res[0].remote +'</textarea>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_software_remote_edit('+ res[0].id +')" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
    			       loading_close();
    			       $("#my_add").html(body);
    			       $('.bd-example-modal-lg').modal('show');
    		});

       }
       
       function ajax_software_remote_edit(id){
    		    bx_load("正在修改...");
    			  $.post("../Software/editRemote",{
    			  id:id,
    			  remote:$("#software_remote").val()
    			  },function(result){
			          bx_load_close();
			          bx_msg(result);
		        });
    			
    			  	   
    		
    		
    	}
       
       
       function software_encrypt_edit(idval) {
            $("#my_add").html(' ');
            loading_start();
            $.post("../Software/getEncryptInfo",{id:idval},
    		       function(result){
    		       	   var res = JSON.parse(result);
    		       	   var body = '	<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">安全传输 编号:'+ res[0].id +'</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
      	<div class="alert alert-info" role="alert" >\
  <strong>安全传输</strong> 程序与服务器通信的加密方式\
</div>\
      <div class="form-group row m-0">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">加密选择</div>\
    <select class="form-control" onchange="encrypt();" id="software_encrypt">\
      <option value="no" >无(不推荐)</option>\
      <option value="authcode" >Authcode(推荐)</option>\
      <option value="rc4" >RC4</option>\
      <option value="defined_encrypt" >自定义</option>\
    </select>\
  </div>\
  </div>\
<br />\
<textarea class="form-control"  id="software_defined_encrypt" rows="20">'+ res[0].defined_encrypt +'</textarea>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_software_encrypt_edit('+ res[0].id +')" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
    			       loading_close();
    			       $("#my_add").html(body);
    			       $('#software_encrypt').val(res[0].encrypt);
    			       encrypt();
    			       $('.bd-example-modal-lg').modal('show');
    		});

       }
       
       function ajax_software_encrypt_edit(id){
    		    bx_load("正在修改...");
    			  $.post("../Software/editEncrypt",{
    			  id:id,
    			  encrypt:$("#software_encrypt").val(),
    			  defined_encrypt:$("#software_defined_encrypt").val()
    			  },function(result){
			          bx_load_close();
			          bx_msg(result);
		        });
    			
    			  	   
    		
    		
    	}
       
       function software_check () {
       	    if($("#name").val() == ''){
       	    	layer.msg('请填写程序名称', {icon: 5});
       	    	return false;
       	    }
       	    if($("#version").val() == ''){
       	    	layer.msg('请填写版本号码', {icon: 5});
       	    	return false;
       	    }
       	    if($("#notice").val() == ''){
       	    	layer.msg('请填写公告', {icon: 5});
       	    	return false;
       	    }
       	    if($("#static_data").val() == ''){
       	    	layer.msg('请填写静态数据', {icon: 5});
       	    	return false;
       	    }
       	    if($("#trial_interval").val() == ''){
       	    	layer.msg('请填写试用间隔', {icon: 5});
       	    	return false;
       	    }
       	    if($("#trial_data").val() == ''){
       	    	layer.msg('请填写试用时间', {icon: 5});
       	    	return false;
       	    }
       	    if($("#update_data").val() == ''){
       	    	layer.msg('请填写更新地址', {icon: 5});
       	    	return false;
       	    }
       	    if($("#give_time").val() == ''){
       	    	layer.msg('请填写注册赠送时间', {icon: 5});
       	    	return false;
       	    }
       	    if($("#give_point").val() == ''){
       	    	layer.msg('请填写注册赠送点数', {icon: 5});
       	    	return false;
       	    }
       	    if($("#bindingdel_time").val() == ''){
       	    	layer.msg('请填写解绑扣除时间', {icon: 5});
       	    	return false;
       	    }
       	    if($("#bindingdel_point").val() == ''){
       	    	layer.msg('请填写解绑扣除点数', {icon: 5});
       	    	return false;
       	    }
       	    if($("#restrict_regtime").val() == ''){
       	    	layer.msg('请填写机器码限制时间', {icon: 5});
       	    	return false;
       	    }
       	    if($("#restrict_regnum").val() == ''){
       	    	layer.msg('请填写机器码限制账号', {icon: 5});
       	    	return false;
       	    }
       	    if($("#heart_time").val() == ''){
       	    	layer.msg('请填写心跳检测时间', {icon: 5});
       	    	return false;
       	    }
       }
       
       
       function encrypt () {
  		if($("#software_encrypt").val() == 'defined_encrypt'){
  			$('#software_defined_encrypt').css('display','block')
  		}else{
  			$('#software_defined_encrypt').css('display','none');
  		}
  			
  	}
</script>


  <table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  style="margin-top: 15px;">
  <thead>
    <tr>
      <th>编号</th>
      <th>程序名称</th>
      <th>程序KEY</th>
      <th>版本号</th>
      <th>软件状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="software">
  	
  </tbody>
</table>

<nav aria-label="Page  navigation example">
  <ul class="pagination justify-content-end" id="pagebody">
    
  </ul>
</nav>



<script type="text/javascript">
	function software_del(idval){
        
        layer.confirm('你将无法恢复！该程序下的 卡类，用户，卡密，单卡，黑名单 都将被删除', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../Software/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'getpage("",true)');
    		});
		});
        
        
        
        
	}
	//语言转换
   var software_lang = Array();
   software_lang['software_state'] = Array();
   software_lang['software_state']['1'] = '正常运营';
   software_lang['software_state']['2'] = '停止运营';
   software_lang['software_state']['3'] = '免费运营';
	
/**
 * @param  page  分页号
 * @param  limit 多少个
 */
    $(document).ready(function(){
          getpage(1);
    });
    //定义全局 储存页个数
    var software_limit = <?php echo $config['table_num'] ?>;
    var software_page = 1;
    //load为 任意值时 则不加载动画
    //a_page为空则表示刷新当前页
	function getpage (a_page,load) {
        if(load == null){
        	loading_start();
        }
		//储存当前页
    	if(a_page == ""){
    		a_page = software_page;
    	}else{
    		software_page = a_page;
    	}
		$.post("../Software/lists",{page:a_page,limit:software_limit},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				//判断是否为最后一页 最后一页空数据 自动往前一页
    				if(software_page == 1){
    				$("#software").html("");
    			    $("#pagebody").html("");
    			    }else{
    					getpage(software_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\">" + res.data[i]["id"] +"</th>\
    				<td>"+res.data[i]["name"]+"</td>\
    				<td><span class=\"badge badge-info my-badge\">"+res.data[i]["s_key"]+"</span></td>\
    				<td>"+res.data[i]["version"]+"</td>\
    				<td>"+software_lang['software_state'][res.data[i]["software_state"]]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"software_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"software_encrypt_edit("+res.data[i]["id"]+");\"  class=\"btn btn-primary btn-sm\">安全</a> <a href=\"javascript:;\" onclick=\"software_remote_edit("+res.data[i]["id"]+");\"  class=\"btn btn-info btn-sm\">高级</a> <a href=\"javascript:;\" onclick=\"software_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
                }
    			$("#software").html(body);
    			$("#pagebody").html(bx_page(res.count,a_page,software_limit,'getpage'));
    			if(load == null){
    			loading_close();
    			}
    		});
	}
</script>

  </div>
</div>
</div>
	</div>
</div>