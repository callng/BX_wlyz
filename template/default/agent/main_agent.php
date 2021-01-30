<?php if(!defined('BX_ROOT')) {exit();} ?>
<?php  if(\app\agent\Auth::get('power') != '10'){ exit('您没有权限'); } ?>
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
  	<?php do_action('agent_agent'); ?>
  	<div class="bd-callout bd-callout-info">
  	   	
<div class="form-inline">
	

    	
     <div class="form-group">
    	状态：
    <select class="form-control" id="search_agent_congeal">
      <option value="">全部</option>
      <option value="1">正常</option>
      <option value="2">停封</option>
    </select>&nbsp;
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
    <input type="text" class="form-control" id="agent_money" value="<?php echo \app\agent\Auth::get('default_money'); ?>"   disabled>\
    <div class="input-group-addon">开卡费率</div>\
    <input type="text" class="form-control" id="agent_rate" value="<?php echo \app\agent\Auth::get('default_rate'); ?>"  disabled>\
  </div>\
  </div>\
    <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理类型</div>\
    <input type="text" class="form-control" id="agent_rate" value="普通代理" disabled>\
    <div class="input-group-addon">代理状态</div>\
    <input type="text" class="form-control" id="agent_rate"  value="正常" disabled>\
  </div>\
  </div>\
   <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">代理备注</div>\
    <input type="text" class="form-control" id="agent_comment"  placeholder="不需要可留空">\
  </div>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_agent_add();" class="btn btn-primary">添加-<?php echo \app\agent\Auth::get('manager_price'); ?></a>\
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
    			  comment:$("#agent_comment").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'agent_getpage("",true)');
		       });
    		
    	}
    
    
    function agent_recharge(idval) {
        layer.prompt({
            title: '请输入充值余额 充值给 ID：' + idval,
            formType: 0,
            btn: ['充值','取消'],
            closeBtn: 2,
        }, function(vlaue, index){
            bx_load("充值中...");
            $.post("../Agent/recharge",{id:idval,money:vlaue},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'agent_getpage("",true)');
    			layer.close(index);
    		});
        });
    
    }
    
    
    
    $(document).ready(function(){
          agent_getpage(1);
    });
//语言转换
   var agent_lang = Array();
   agent_lang['agent_congeal'] = Array();
   agent_lang['agent_congeal']['1'] = '<span class="badge badge-primary my-badge">正常</span>';
   agent_lang['agent_congeal']['2'] = '<span class="badge badge-danger my-badge">停封</span>';  
    
           /**
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
		    congeal:$("#search_agent_congeal").val(),
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
    				<td>"+res.data[i]["power"]+"</td>\
    				<td>"+res.data[i]["boss_name"]+"</td>\
    				<td>"+res.data[i]["money"]+"</td>\
    				<td>"+res.data[i]["consumed"]+"</td>\
    				<td>"+agent_lang['agent_congeal'][res.data[i]["congeal"]]+"</td>\
    				<td>"+res.data[i]["comment"]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"agent_recharge("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">给TA充值</a>";
                }
    			$("#agent_table").html(body);
    			$("#agent_page").html(bx_page(res.count,a_page,agent_limit,'agent_getpage'));
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
