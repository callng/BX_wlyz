<?php if(!defined('BX_ROOT')) {exit();} ?>
<?php
$software = get_software_lists(); $software_card = get_software_card_lists(); ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
		<div class="card">
  <h3 class="card-header">卡密管理</h3>
  
  <div class="card-body ">
  <!--main-->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="card-tab" data-toggle="tab" href="#card" role="tab" aria-controls="card" aria-expanded="true">卡密管理</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="single_card-tab" data-toggle="tab" href="#single_card" role="tab" aria-controls="single_card">单卡管理</a>
  </li>
</ul>

<!--modal-->
<div class="modal fade bd-example-modal-lg" id="a" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="my_add" class="modal-dialog modal-lg">
    
    <!--弹窗内容-->
    
  </div>
</div>



<!--卡密管理-->
<div class="tab-content" id="myTabContent">

  <div class="tab-pane fade  show active" id="card" role="tabpanel" aria-labelledby="card-tab">
  	<?php do_action('agent_card'); ?>
  	<div class="bd-callout bd-callout-info">
  	   	
<div class="form-inline">
	
    <div class="form-group">
       程序名：
    <select class="form-control" id="search_card_software_id" style="width: 150px">
      <option value="">全部</option>
      <?php foreach($software as $k => $v):; ?>
	  <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
      <?php endforeach; ?>
    </select>&nbsp;
    </div>
 

    <div class="form-group">
    	状态：
    <select class="form-control" id="search_card_state">
      <option value="">全部</option>
      <option value="1">正常使用</option>
      <option value="2">停止使用</option>
    </select>&nbsp;
    </div>
    
    <div class="form-group">
    	使用状态：
    <select class="form-control" id="search_card_used">
      <option value="">全部</option>
      <option value="1">未被使用</option>
      <option value="2">已被使用</option>
    </select>&nbsp;
    </div>
    
    <div class="form-group">   
       卡名：
    <input type="text" class="form-control" id="search_card_name" style="width: 150px;" >&nbsp;
    </div>

       
    <div class="form-group">
       卡密：
    <input type="text" class="form-control" id="search_card_cardnum" style="width: 150px;" >&nbsp;
    </div>
    <a href="javascript:;" onclick="card_getpage(1);"   class="btn btn-info">搜索</a>

</div>
</div>

  	<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="card_add();"  class="btn btn-success">添加卡密</a>
  		<a href="javascript:;"  onclick="card_checkeddel();"  class="btn btn-danger">删除选中</a>
  		<a href="javascript:;"  onclick="export_card('#card_table td:nth-child(9)','text');"  class="btn btn-primary">导出</a>
  	</div>
  	
  	
  	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=card_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th>编号</th>
      <th>程序名称</th>
      <th>卡密名称</th>
      <th>时间</th>
      <th>点数</th>
      <th>造卡日期</th>
      <th>造卡者</th>
      <th>卡密</th>
      <th>备注</th>
      <th>状态</th>
      <th>使用状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="card_table">
 
  </tbody>
</table>
  	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="card_page">
    
  </ul>
</nav>  	
  	
<script type="text/javascript">
	function card_add() {
	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">添加卡密</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序名称</div>\
    <select onchange="card_softlt(this.value);" class="form-control" id="software_id" ">\
    		<?php foreach($software_card as $k => $v):; ?>
      <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>\
       <?php endforeach; ?>
    </select>\
    <div class="input-group-addon">卡类名称</div>\
    <select class="form-control" id="card_type_id">\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">生成数量</div>\
    <input id="card_count" type="text" class="form-control" value=""  placeholder="单位：数字">\
    <div class="input-group-addon">生成备注</div>\
    <input id="card_comment" type="text" class="form-control" value=""  placeholder="单位：备注">\
  </div>\
  </div>\
<div  style="text-align: center;">\
<a   href="javascript:;"  onclick="ajax_card_add();"  class="btn btn-primary">生成</a>\
</div>\
<div class="form-group">\
    <label for="exampleTextarea">生成列表</label>\
    <textarea class="form-control" id="card_body" rows="18"></textarea>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        $("#my_add").html(body);
        //通过程序名获取该卡类的列表
    	<?php echo isset($software_card['0']['id']) ? "card_softlt({$software_card['0']['id']});" : ''; ?>
        $('.bd-example-modal-lg').modal('show');
    }
    
    function card_softlt (idval) {
    	    bx_load("正在加载卡类...");
    		$.post("../CardType/softwareLists",{
    			  id:idval
    			  },function(result){
    			  	bx_load_close();
			         res=JSON.parse(result);
    			     var body = "";
    			     for (var i = 0; i < res.length; i++) {
    			     	  body += "<option value=\""+res[i]['id']+"\">"+res[i]['name']+"---"+res[i]['money']+"元</option>";
    			     }
			         $("#card_type_id").html(body);
		        });
    	}
    
    
    function ajax_card_add(){
    		bx_load("正在生成...<br/>生成数量过多会大量耗时...");
    			  $.post("../Card/add",{
    			  card_type_id:$("#card_type_id").val(),
    			  count:$("#card_count").val(),
    			  comment:$("#card_comment").val()
    			  },function(result){
    			  	 bx_load_close();
			         a = JSON.parse(result)
			         bx_msg(JSON.stringify(a.msg ? a.msg : a),'card_add_body(' + result + ')');
		       });
    		
    	}
    	function card_add_body (data) {
    		res = data;
			  var body = "";
			  for (var i = 0; i < res.data.length; i++) {
			      body += res.data[i] + "\n";
			  }
			  card_getpage("",true);
			  $("#card_body").html(body);
    	}
    
    
    
    
    
    
    
    function card_del(idval){   
        layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../Card/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'card_getpage("",true)');
    		});
		});
		
		

	}
	
	
	function card_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=card_checkbox]:checked').each(function(){  
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
			$.post("../Card/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'card_getpage("",true)');
    		});
		});
        
    
        
    }
    
    
    
    $(document).ready(function(){
          card_getpage(1);
    });
  //语言转换
   var card_lang = Array();
   card_lang['card_state'] = Array();
   card_lang['card_state']['1'] = '<span class="badge badge-primary my-badge">正常使用</span>';
   card_lang['card_state']['2'] = '<span class="badge badge-danger my-badge">停止使用</span>';
   card_lang['card_used'] = Array();
   card_lang['card_used']['1'] = '<span class="badge badge-info my-badge">未被使用</span>';
   card_lang['card_used']['2'] = '<span class="badge badge-success my-badge">已被使用</span>';
   
   var time_lang = Array();
    time_lang['1'] = '秒';
    time_lang['2'] = '分';
    time_lang['3'] = '时';
    time_lang['4'] = '天';
    time_lang['5'] = '周';
    time_lang['6'] = '月';
    time_lang['7'] = '年';
 /*
 * @param  page  分页号
 * @param  limit 多少个
 */
   //定义全局 储存页个数
   var card_limit = <?php echo $config['table_num'] ?>;
   var card_page = 1;
	function card_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = card_page;
    	}else{
    		card_page = a_page;
    	}
		$.post("../Card/lists",{
			page:a_page,
			limit:card_limit,
			//搜索
		    software_id:$("#search_card_software_id").val(),
		    state:$("#search_card_state").val(),
		    used:$("#search_card_used").val(),
		    name:$("#search_card_name").val(),
		    cardnum:$("#search_card_cardnum").val()
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(card_page == 1){
    				$("#card_table").html("");
    				$("#card_page").html("");
    				}else{
    					card_getpage(card_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"card_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["software_name"] +  "</td>\
    				<td>"+res.data[i]["name"]+"</td>\
    				<td>"+res.data[i]["time"]+time_lang[res.data[i]["time_type"]]+"</td>\
    				<td>"+res.data[i]["point"]+"</td>\
    				<td>"+bx_time(res.data[i]["create_time"])+"</td>\
    				<td>"+res.data[i]["menber_name"]+"</td>\
    				<td>"+res.data[i]["cardnum"]+"</td>\
    				<td>"+res.data[i]["comment"]+"</td>\
    				<td>"+card_lang['card_state'][res.data[i]["state"]]+"</td>\
    				<td>"+card_lang['card_used'][res.data[i]["used"]]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"card_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a>"+"</td>";
                }
    			$("#card_table").html(body);
    			$("#card_page").html(bx_page(res.count,a_page,card_limit,'card_getpage'));
    			if(load == null){
    			loading_close();
    			}
    		});
	}
</script>
  	
  	
	
  </div>
 

<div class="tab-pane fade" id="single_card" role="tabpanel" aria-labelledby="single_card-tab">
  	<?php do_action('agent_single_card'); ?>
  	   <div class="bd-callout bd-callout-info">
  	   	
<div class="form-inline">
	
    <div class="form-group">
       程序名：
    <select class="form-control" id="search_single_card_software_id" style="width: 150px">
      <option value="">全部</option>
	  <?php foreach($software as $k => $v):; ?>
	  <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
      <?php endforeach; ?>
    </select>&nbsp;
    </div>
 

    <div class="form-group">
    	状态：
    <select class="form-control" id="search_single_card_congeal">
      <option value="">全部</option>
      <option value="1">正常</option>
      <option value="2">停封</option>
    </select>&nbsp;
    </div>
    
    <div class="form-group">
    	在线状态：
    <select class="form-control" id="search_single_card_state">
      <option value="">全部</option>
      <option value="2">在线</option>
      <option value="1">离线</option>
    </select>&nbsp;
    </div>
    
    
    <div class="form-group">   
       卡名：
    <input type="text" class="form-control" id="search_single_card_name" style="width: 150px;" >&nbsp;
    </div>

       
    <div class="form-group">
       单卡：
    <input type="text" class="form-control" id="search_single_card_cardnum" style="width: 150px;" >&nbsp;
    </div>
    <a href="javascript:;" onclick="single_card_getpage(1);"   class="btn btn-info">搜索</a>

</div>
</div>

  	<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="single_card_add();"  class="btn btn-success">添加单卡</a>
  		<a href="javascript:;"  onclick="single_card_checkeddel();"  class="btn btn-danger">删除选中</a>
  		<a href="javascript:;"  onclick="export_card('#single_card_table input[name=ex_single_card]','val');"  class="btn btn-primary">导出</a>
  	</div>
  	
  	
  	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=single_card_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th>编号</th>
      <th>单卡名称</th>
      <th>单卡</th>
      <th>归属程序</th>
      <th>造卡者</th>
      <th>造卡时间</th>
      <th>到期时间</th>
      <th>时间</th>
      <th>点数</th>
      <th>机器码</th>
      <th>自定义数据</th>
      <th>备注</th>
      <th>状态</th>
      <th>在线状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="single_card_table">
 
  </tbody>
</table>	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="single_card_page">
    
  </ul>
</nav>
<script type="text/javascript">
	function single_card_add() {
		var body ='<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">添加单卡</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序名称</div>\
    <select onchange="card_softlt(this.value);" class="form-control" id="software_id">\
    		<?php foreach($software_card as $k => $v):; ?>
      <option value="<?php echo $v['id'] ?>"><?php echo $v['name'] ?></option>\
       <?php endforeach; ?>
    </select>\
    <div class="input-group-addon">卡类名称</div>\
    <select class="form-control" id="card_type_id">\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">生成数量</div>\
    <input id="single_card_count" type="text" class="form-control" value=""  placeholder="单位：数字">\
    <div class="input-group-addon">生成备注</div>\
    <input id="single_card_comment" type="text" class="form-control" value=""  placeholder="单位：备注">\
  </div>\
  </div>\
<div  style="text-align: center;">\
<a   href="javascript:;"  onclick="ajax_single_card_add();"  class="btn btn-primary">生成</a>\
</div>\
<div class="form-group">\
    <label for="exampleTextarea">生成列表</label>\
    <textarea class="form-control" id="single_card_body" rows="18"></textarea>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        $("#my_add").html(body);
        <?php echo isset($software_card['0']['id']) ? "card_softlt({$software_card['0']['id']});" : ''; ?>
        $('.bd-example-modal-lg').modal('show');
   }
    
    
    function ajax_single_card_add(){
    		bx_load("正在生成...<br/>生成数量过多会大量耗时...");
    			  $.post("../SingleCard/add",{
    			  card_type_id:$("#card_type_id").val(),
    			  count:$("#single_card_count").val(),
    			  comment:$("#single_card_comment").val()
    			  },function(result){
			         bx_load_close();
			         a = JSON.parse(result)
			         bx_msg(JSON.stringify(a.msg ? a.msg : a),'single_card_add_body(' + result + ')');
		       });
    		
    	}
    	function single_card_add_body (data) {
    		res = data;
			  var body = "";
			  for (var i = 0; i < res.data.length; i++) {
			      body += res.data[i] + "\n";
			  }
			  single_card_getpage("",true);
			  $("#single_card_body").html(body);
    	}
    
    
    
    
    function single_card_del(idval){
		layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../SingleCard/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'single_card_getpage("",true)');
    		});
		});
	}
    
    function single_card_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=single_card_checkbox]:checked').each(function(){  
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
			$.post("../SingleCard/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'single_card_getpage("",true)');
    		});
		});
        
        

        
    }

    
    
    
    //语言转换
   var single_card_lang = Array();
   single_card_lang['congeal'] = Array();
   single_card_lang['congeal']['1'] = '<span class="badge badge-primary my-badge">正常</span>';
   single_card_lang['congeal']['2'] = '<span class="badge badge-danger my-badge">停封</span>';
   single_card_lang['state'] = Array();
   single_card_lang['state']['1'] = '<span class="badge badge-secondary my-badge">离线</span>';
   single_card_lang['state']['2'] = '<span class="badge badge-success my-badge">在线</span>';
    
    $("#single_card-tab").one("click",function(){single_card_getpage(1);});
          /**
 * @param  page  分页号
 * @param  limit 多少个
 */
   //定义全局 储存页个数
   var single_card_limit = <?php echo $config['table_num'] ?>;
   var single_card_page = 1;
	function single_card_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = single_card_page;
    	}else{
    		single_card_page = a_page;
    	}
		$.post("../SingleCard/lists",{
			page:a_page,
			limit:single_card_limit,
			//搜索
		    software_id:$("#search_single_card_software_id").val(),
		    state:$("#search_single_card_state").val(),
		    congeal:$("#search_single_card_congeal").val(),
		    name:$("#search_single_card_name").val(),
		    menber_name:$("#search_single_card_menber_name").val(),
		    cardnum:$("#search_single_card_cardnum").val()
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(single_card_page == 1){
    				$("#single_card_table").html("");
    				$("#single_card_page").html("");
    				}else{
    					single_card_getpage(single_card_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"single_card_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["name"] +  "</td>\
    				<td><input name=\"ex_single_card\" type=\"text\" value=\""+res.data[i]["cardnum"]+"\" /></td>\
    				<td>"+res.data[i]["software_name"]+"</td>\
    				<td>"+res.data[i]["menber_name"]+"</td>\
    				<td>"+bx_time(res.data[i]["create_time"])+"</td>\
    				<td>"+(res.data[i]["endtime"] == '0' ? '未激活' : bx_time(res.data[i]["endtime"]))+"</td>\
    				<td>"+res.data[i]["time"]+time_lang[res.data[i]["time_type"]]+"</td>\
    				<td>"+res.data[i]["point"]+"</td>\
    				<td>"+res.data[i]["machine_code"]+"</td>\
    				<td>"+res.data[i]["card_data"]+"</td>\
    				<td>"+res.data[i]["comment"]+"</td>\
    				<td>"+single_card_lang['congeal'][res.data[i]["congeal"]]+"</td>\
    				<td>"+single_card_lang['state'][res.data[i]["state"]]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"single_card_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a>"+"</td>";
                }
    			$("#single_card_table").html(body);
    			$("#single_card_page").html(bx_page(res.count,a_page,single_card_limit,'single_card_getpage'));
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