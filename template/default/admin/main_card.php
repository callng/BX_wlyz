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
    <a class="nav-link" id="card_type-tab"  data-toggle="tab" href="#card_type" role="tab" aria-controls="card_type">卡类管理</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="recharge_log-tab" data-toggle="tab" href="#recharge_log" role="tab" aria-controls="recharge_log">充值记录</a>
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
  	<?php do_action('admin_card'); ?>
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
       造卡者：
    <input type="text" class="form-control" id="search_card_menber_name" style="width: 150px;" >&nbsp;
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
    			     	  body += "<option value=\""+res[i]["id"]+"\">"+res[i]["name"]+"</option>";
    			     }
			         $("#card_type_id").html(body);
		        });
    	}
    	
    	function ajax_card_add(){
    		if($("#card_type_id").val() == null){
    			layer.msg("请选择卡类!<br />没有卡类请先进行添加",{icon: 5});
    			return;
    		}
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
    
    
    
    
    
    
    function card_edit(idval) {
     $("#my_add").html(' ');
     loading_start();
     $.post("../Card/getInfo",{id:idval},function(data){
     	res = JSON.parse(data);
     	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">修改卡密 编号:'+ res[0].id +'</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密名称</div>\
    <input id="card_name" type="text" class="form-control" value="'+ res[0].name +'"  placeholder="卡密名称">\
    <div class="input-group-addon">卡密状态</div>\
    <select class="form-control" id="card_state" >\
      <option value="1">正常使用</option>\
      <option value="2">停止使用</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密时间</div>\
    <input id="card_time" type="text" class="form-control" value="'+ res[0].time +'"  placeholder="">\
    <div class="input-group-addon">时间单位</div>\
    <select class="form-control" id="card_time_type">\
      <option value="1">秒</option>\
      <option value="2">分</option>\
      <option value="3">时</option>\
      <option value="4">天</option>\
      <option value="5">周</option>\
      <option value="6">月</option>\
      <option value="7">年</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
  	<div class="input-group-addon">卡密点数</div>\
    <input id="card_point" type="text" class="form-control" value="'+ res[0].point +'"  placeholder="不需要可留空">\
  	<div class="input-group-addon">卡密备注</div>\
    <input id="card_comment" type="text" class="form-control" value="'+ res[0].comment +'"  placeholder="不需要可留空">\
  </div>\
  </div>\
  <h4>卡密信息：</h4>\
  <p>卡密：'+ res[0].cardnum +'</p>\
  <p>使用状态：<span id="xyzt"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;使用者：'+ res[0].username +'</p>\
  <p>造卡者：'+ res[0].menber_name +'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;造卡日期：<span id="zksj"></span></p>\
  <p>所属程序：'+ res[0].software_name +'</p>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_card_edit('+ res[0].id +');" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        loading_close();
        $("#my_add").html(body);
        $('#card_state').val(res[0].state);
    	$('#card_time_type').val(res[0].time_type);
    	$("#xyzt").html(card_lang['card_used'][res[0].used]);
    	$("#zksj").html(bx_time(res[0].create_time));
        $('.bd-example-modal-lg').modal('show');
     });
    }
    
    function ajax_card_edit(id){
    		bx_load("正在修改...");
    			  $.post("../Card/edit",{
    			  id:id,
    			  name:$("#card_name").val(),
    			  time:$("#card_time").val(),
    			  time_type:$("#card_time_type").val(),
    			  point:$("#card_point").val(),
    			  state:$("#card_state").val(),
    			  comment:$("#card_comment").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'card_getpage("",true)');
		        });

    		
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
       /**
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
		    menber_name:$("#search_card_menber_name").val(),
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
    				<td><a href=\"javascript:;\" onclick=\"card_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"card_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
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
  
<!--卡类管理-->
  <div class="tab-pane fade" id="card_type" role="tabpanel" aria-labelledby="card_type-tab">
  	<div class="py-2"></div>
  	<?php do_action('admin_card_type'); ?>
  	<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="card_type_add();"  class="btn btn-success">添加卡类</a>
  		<a href="javascript:;"  onclick="card_type_checkeddel();"  class="btn btn-danger">删除选中</a>
  	</div>
  	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=card_type_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th>编号</th>
      <th>程序名称</th>
      <th>卡类名称</th>
      <th>时间</th>
      <th>点数</th>
      <th>面值(元)</th>
      <th>自定义卡头</th>
      <th>备注</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="card_type_table">

  </tbody>
</table>
  	
<nav aria-label="Page  navigation example">
  <ul class="pagination justify-content-end" id="card_type_page">
    
  </ul>
</nav>

<script type="text/javascript">
	function card_type_add() {
		var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">添加卡类</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序名称</div>\
    <select class="form-control" id="software_id">\
    <?php foreach($software as $k => $v): ?>
      <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>\
      <?php endforeach; ?>
    </select>\
    <div class="input-group-addon">卡类状态</div>\
    <select class="form-control" id="state">\
      <option value="1">正常使用</option>\
      <option value="2">停止使用</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡类名称</div>\
    <input id="name" type="text" class="form-control" value=""  placeholder="给卡类起个名字吧">\
    <div class="input-group-addon">卡密卡头</div>\
    <input id="head" type="text" class="form-control" value=""  placeholder="不需要可留空">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密时间</div>\
    <input id="time" type="text" class="form-control" value="" placeholder="单位：数字">\
    <div class="input-group-addon">时间单位</div>\
    <select class="form-control" id="time_type">\
      <option value="1">秒</option>\
      <option value="2">分</option>\
      <option value="3" selected="selected">时</option>\
      <option value="4">天</option>\
      <option value="5">周</option>\
      <option value="6">月</option>\
      <option value="7">年</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
  	<div class="input-group-addon">卡密点数</div>\
    <input id="point" type="text" class="form-control" value=""  placeholder="单位：数字">\
  	<div class="input-group-addon">卡密价格</div>\
    <input id="money" type="text" class="form-control" value=""  placeholder="单位：元">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡类备注</div>\
    <input id="comment" type="text" class="form-control" value=""  placeholder="不需要可留空">\
  </div>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_card_type_add();" class="btn btn-primary">添加</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        $("#my_add").html(body);
        $('.bd-example-modal-lg').modal('show');
    }
    
    function ajax_card_type_add(){
    		bx_load("正在添加...");
    			  $.post("../CardType/add",{
    			  software_id:$("#software_id").val(),
    			  name:$("#name").val(),
    			  state:$("#state").val(),
    			  head:$("#head").val(),
    			  time:$("#time").val(),
    			  time_type:$("#time_type").val(),
    			  point:$("#point").val(),
    			  money:$("#money").val(),
    			  comment:$("#comment").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'card_type_getpage("",true)');
		        });
    		
    	}
    
    
    
    function card_type_edit(idval) {
     $("#my_add").html(' ');
     loading_start();
     $.post("../CardType/getInfo",{id:idval},function(data){
     	res = JSON.parse(data);
     	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">修改卡类 编号:' + res[0].id + '</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">程序名称</div>\
    <select class="form-control" id="software_id">\
    <?php foreach($software as $k => $v): ?>
      <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>\
      <?php endforeach; ?>
    </select>\
    <div class="input-group-addon">卡类状态</div>\
    <select class="form-control" id="state" ">\
      <option value="1">正常使用</option>\
      <option value="2">停止使用</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡类名称</div>\
    <input id="name" type="text" class="form-control" value="' + res[0].name + '"  placeholder="给卡类起个名字吧">\
    <div class="input-group-addon">卡密卡头</div>\
    <input id="head" type="text" class="form-control" value="' + res[0].head + '"  placeholder="不需要可留空">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密时间</div>\
    <input id="time" type="text" class="form-control" value="' + res[0].time + '"  placeholder="单位：小时">\
    <div class="input-group-addon">时间单位</div>\
    <select class="form-control" id="time_type">\
      <option value="1">秒</option>\
      <option value="2">分</option>\
      <option value="3">时</option>\
      <option value="4">天</option>\
      <option value="5">周</option>\
      <option value="6">月</option>\
      <option value="7">年</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
  	<div class="input-group-addon">卡密点数</div>\
    <input id="point" type="text" class="form-control" value="' + res[0].point + '"  placeholder="单位：数字">\
    <div class="input-group-addon">卡密价格</div>\
    <input id="money" type="text" class="form-control" value="' + res[0].money + '"  placeholder="单位：元">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡类备注</div>\
    <input id="comment" type="text" class="form-control" value="' + res[0].comment + '"  placeholder="不需要可留空">\
  </div>\
  </div>\
 </div>\
      <div class="modal-footer">\
        <a href="javascript:;" onclick="ajax_card_type_edit(' + res[0].id + ');" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        loading_close();
        $("#my_add").html(body);
        $('#software_id').val(res[0].software_id);
    	$('#state').val(res[0].state);
    	$('#time_type').val(res[0].time_type);
        $('.bd-example-modal-lg').modal('show');
     });
    }
    
    function ajax_card_type_edit(id){
    		bx_load("正在修改...");
    			  $.post("../CardType/edit",{
    			  id:id,
    			  software_id:$("#software_id").val(),
    			  name:$("#name").val(),
    			  state:$("#state").val(),
    			  head:$("#head").val(),
    			  time:$("#time").val(),
    			  time_type:$("#time_type").val(),
    			  point:$("#point").val(),
    			  money:$("#money").val(),
    			  comment:$("#comment").val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'card_type_getpage("",true)');
		        });
    		
    	}
    
    
    
    function card_type_del(idval){
		layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../CardType/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'card_type_getpage("",true)');
    		});
		});
	}
    
    function card_type_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=card_type_checkbox]:checked').each(function(){  
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
			$.post("../CardType/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'card_type_getpage("",true)');
    		});
		});
        
        

        
    }
    
    
    
    //语言转换
   var card_type_lang = Array();
   card_type_lang['state'] = Array();
   card_type_lang['state']['1'] = '<span class="badge badge-primary my-badge">正常使用</span>';
   card_type_lang['state']['2'] = '<span class="badge badge-danger my-badge">停止使用</span>';
    
    /**
 * @param  page  分页号
 * @param  limit 多少个
 */
   $("#card_type-tab").one("click",function(){card_type_getpage(1);});
   //定义全局 储存页个数
   var card_type_limit = <?php echo $config['table_num'] ?>;
   var card_type_page = 1;
	function card_type_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = card_type_page;
    	}else{
    		card_type_page = a_page;
    	}
		$.post("../CardType/lists",{page:a_page,limit:card_type_limit},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(card_type_page == 1){
    				$("#card_type_table").html("");
    				$("#card_type_page").html("");
    				}else{
    					card_type_getpage(card_type_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"card_type_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["softwarename"] +  "</td>\
    				<td>"+res.data[i]["name"]+"</td>\
    				<td>"+res.data[i]["time"]+time_lang[res.data[i]["time_type"]]+"</td>\
    				<td>"+res.data[i]["point"] + "</td>\
    				<td>"+res.data[i]["money"]+"</td>\
    				<td>"+res.data[i]["head"]+"</td>\
    				<td>"+res.data[i]["comment"]+"</td>\
    				<td>"+card_type_lang['state'][res.data[i]["state"]]+"</td>\
    				<td><a href=\"javascript:;\" onclick=\"card_type_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"card_type_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
                }
    			$("#card_type_table").html(body);
    			$("#card_type_page").html(bx_page(res.count,a_page,card_type_limit,'card_type_getpage'));
    			if(load == null){
    			loading_close();
    			}
    		});
	}
</script>
  	
  	
  	
  	
  </div>
  
  <div class="tab-pane fade" id="recharge_log" role="tabpanel" aria-labelledby="recharge_log-tab">
  	<div class="py-2"></div>
  	<?php do_action('admin_recharge_log'); ?>
  	<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="recharge_log_checkeddel();"  class="btn btn-danger">删除选中</a>
</div>




	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th><input onclick="$('input[name=recharge_log_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox"></th>
      <th>编号</th>
      <th>用户名</th>
      <th>归属程序</th>
      <th>造卡者</th>
      <th>时间</th>
      <th>点数</th>
      <th>充值时间</th>
      <th>到期时间</th>
      <th>卡密</th>
    </tr>
  </thead>
  <tbody id="recharge_log_table">
 
  </tbody>
</table>
  	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="recharge_log_page">
    
  </ul>
</nav>  	
  	
  	
  	
  	
  	
  <script type="text/javascript">
 function recharge_log_checkeddel () {
    	//遍历多选
    	var id_array=new Array();  
    	$('input[name=recharge_log_checkbox]:checked').each(function(){  
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
			$.post("../RechargeLog/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'recharge_log_getpage("",true)');
    		});
		});

        
    }
 
 
 
 
 
 
  	    /**
 * @param  page  分页号
 * @param  limit 多少个
 */
   $("#recharge_log-tab").one("click",function(){recharge_log_getpage(1);});
   //定义全局 储存页个数
   var recharge_log_limit = <?php echo $config['table_num'] ?>;
   var recharge_log_page = 1;
	function recharge_log_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = recharge_log_page;
    	}else{
    		recharge_log_page = a_page;
    	}
		$.post("../RechargeLog/lists",{page:a_page,limit:recharge_log_limit},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(recharge_log_page == 1){
    				$("#recharge_log_table").html("");
    				$("#recharge_log_page").html("");
    				}else{
    					recharge_log_getpage(recharge_log_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +="<tr>\
    				<th scope=\"row\"><input name=\"recharge_log_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
    				<th>" + res.data[i]["id"] + "</th>\
    				<td>" + res.data[i]["username"] +  "</td>\
    				<td>"+res.data[i]["software_name"]+"</td>\
    				<td>"+res.data[i]["menber_name"]+"</td>\
    				<td>"+res.data[i]["time"]+time_lang[res.data[i]["time_type"]]+"</td>\
    				<td>"+res.data[i]["point"]+"</td>\
    				<td>"+bx_time(res.data[i]["recharge_time"])+"</td>\
    				<td>"+bx_time(res.data[i]["endtime"])+"</td>\
    				<td>"+res.data[i]["cardnum"]+"</td>";
                }
    			$("#recharge_log_table").html(body);
    			$("#recharge_log_page").html(bx_page(res.count,a_page,recharge_log_limit,'recharge_log_getpage'))
    			if(load == null){
    			loading_close();
    			}
    		});
	}
  </script>	
  	
  	
  	
</div>
<div class="tab-pane fade" id="single_card" role="tabpanel" aria-labelledby="single_card-tab">
  	<?php do_action('admin_single_card'); ?>
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
       造卡者：
    <input type="text" class="form-control" id="search_single_card_menber_name" style="width: 150px;" >&nbsp;
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
		var body = '<div class="modal-content">\
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
    		if($("#card_type_id").val() == null){
    			layer.msg("请选择卡类!<br />没有卡类请先进行添加",{icon: 5});
    			return;
    		}
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
    
    
    
    
    function single_card_edit(idval) {
     $("#my_add").html(' ');
     loading_start();
     $.post("../SingleCard/getInfo",{id:idval},function(data){
     	res = JSON.parse(data);
     	var body = '<div class="modal-content">\
      <div class="modal-header">\
        <h5 class="modal-title">修改单卡 编号:' + res[0].id + '</h5>\
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">\
          <span aria-hidden="true">&times;</span>\
        </button>\
      </div>\
      <div  class="modal-body">\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
  	<div class="input-group-addon">卡密名称</div>\
    <input id="single_card_name" type="text" class="form-control" value="' + res[0].name + '"  placeholder="卡密名称">\
    <div class="input-group-addon">单卡状态</div>\
     <select class="form-control" id="single_card_congeal" >\
      <option value="1">正常</option>\
      <option value="2">停封</option>\
    </select>\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">单卡数据</div>\
   <input id="single_card_card_data" type="text" class="form-control" value="' + res[0].card_data + '"  placeholder="自定义数据">\
    <div class="input-group-addon">单卡点数</div>\
    <input id="single_card_point" type="text" class="form-control" value="' + res[0].point + '"  placeholder="单位：数字">\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">卡密时间</div>\
    <input id="single_card_time" type="text" class="form-control" value="' + res[0].time + '"  placeholder="">\
    <div class="input-group-addon">时间单位</div>\
    <select class="form-control" id="single_card_time_type">\
      <option value="1">秒</option>\
      <option value="2">分</option>\
      <option value="3">时</option>\
      <option value="4">天</option>\
      <option value="5">周</option>\
      <option value="6">月</option>\
      <option value="7">年</option>\
    </select>\
  </div>\
  </div>\
  <div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
    <div class="input-group-addon">到期时间</div>\
    <input id="single_card_endtime" type="text" class="form-control" value=""  placeholder="">\
    <div class="input-group-addon">单卡备注</div>\
    <input id="single_card_comment" type="text" class="form-control" value="' + res[0].comment + '"  placeholder="不需要可留空">\
  </div>\
  </div>\
<div class="form-group row">\
  <div class="input-group mb-2 mr-sm-2 mb-sm-0">\
  </div>\
  </div>\
  <h4>单卡信息：</h4>\
  <p>单卡：' + res[0].cardnum + '</p>\
  <p>在线状态：<span id="zxzt"></span> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;机器码：' + res[0].machine_code + '</p>\
  <p>归属程序：' + res[0].software_name + '</p>\
  <p>造卡者：' + res[0].menber_name + '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;造卡日期：<span id="zksj"></span></p>\
  <p>最后一次登陆时间：<span id="zhdl"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;最后一次登陆IP：' + res[0].logip + '</p>\
 </div>\
      <div class="modal-footer">\
      	<label class="form-check-label">\
    <input class="form-check-input" type="checkbox" id="single_card_machine_code" value="on">清除机器码\
  </label>\
    <label class="form-check-label mr-auto">\
    <input class="form-check-input" type="checkbox"  id="single_card_state" value="on">强制下线\
  </label>\
        <a href="javascript:;" onclick="ajax_single_card_edit(' + res[0].id + ');" class="btn btn-primary">修改</a>\
        <button type="button" class="btn btn-secondary" data-dismiss="modal">关闭</button>\
      </div>\
    </div>';
        loading_close();
        $("#my_add").html(body);
        
        $("#single_card_congeal").val(res[0].congeal);
    	$("#single_card_endtime").val(bx_time(res[0].endtime));
    	$('#single_card_time_type').val(res[0].time_type);
    	$("#zhdl").html(res[0].logtime ? bx_time(res[0].logtime) : '从未登陆');
    	$("#zksj").html(bx_time(res[0].create_time));
    	$("#zxzt").html(single_card_lang['state'][res[0].state]);
        laydate.render({elem: '#single_card_endtime',type: 'datetime'});
        
        $('.bd-example-modal-lg').modal('show');
     });
    }
    
    function ajax_single_card_edit(id){
    		bx_load("正在修改...");
    			  $.post("../SingleCard/edit",{
    			  id:id,
    			  name:$("#single_card_name").val(),
    			  congeal:$("#single_card_congeal").val(),
    			  endtime:$("#single_card_endtime").val(),
    			  point:$("#single_card_point").val(),
    			  time:$("#single_card_time").val(),
    			  time_type:$("#single_card_time_type").val(),
    			  card_data:$("#single_card_card_data").val(),
    			  comment:$("#single_card_comment").val(),
    			  machine_code:$('#single_card_machine_code:checked').val(),
    			  state:$('#single_card_state:checked').val()
    			  },function(result){
			         bx_load_close();
			         bx_msg(result,'single_card_getpage("",true)');
		        });

    			  	   

    		
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
    				<td><a href=\"javascript:;\" onclick=\"single_card_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"single_card_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
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