<?php if(!defined('BX_ROOT')) {exit();} ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
		<div class="card">
  <h3 class="card-header">插件管理</h3>
  <div class="card-body ">
  <!--main-->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="plugin-tab" data-toggle="tab" href="#plugin" role="tab" aria-controls="plugin" aria-expanded="true">插件管理</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="plugin_install-tab"  data-toggle="tab" href="#plugin_install" role="tab" aria-controls="plugin_install">插件安装</a>
  </li>
</ul>

<!--modal-->
<div class="modal fade bd-example-modal-lg" id="a" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="my_add" class="modal-dialog modal-lg">
    
    <!--弹窗内容-->
    
  </div>
</div>



<div class="tab-content" id="myTabContent">
<!--插件管理-->
  <div class="tab-pane fade  show active" id="plugin" role="tabpanel" aria-labelledby="plugin-tab">
<div class="py-2"></div>
<?php do_action('admin_plugin'); ?>
<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
  <thead>
    <tr>
      <th>插件名称</th>
      <th>简介</th>
      <th>作者</th>
      <th>版本</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody id="plugin_table">
 
  </tbody>
</table>
  	
<nav aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="plugin_page">
    
  </ul>
</nav>

	<script type="text/javascript">
		$(document).ready(function(){
          plugin_getpage(1);
    });
	//定义全局 储存页个数
   var plugin_limit = <?php echo $config['table_num'] ?>;
   var plugin_page = 1;
	function plugin_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = plugin_page;
    	}else{
    		plugin_page = a_page;
    	}
		$.post("../Plugin/lists",{
			page:a_page,
			limit:plugin_limit,
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(plugin_page == 1){
    				$("#plugin_table").html("");
    				$("#plugin_page").html("");
    				}else{
    					plugin_getpage(plugin_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				//状态
    				var st = res.data[i]['state'] == '1' ? '<a href="javascript:;" onclick="plugin_close(' + res.data[i]['id'] + ')"  class="btn btn-success btn-sm">开启中</a>' : '<a href="javascript:;" onclick="plugin_open(' + res.data[i]['id'] + ')"  class="btn btn-danger btn-sm">已关闭</a>'
    				body +='<tr>\
    				<td scope="row"><img width="30" height="30" src="<?php echo __URL__; ?>app/common/plugin/' + res.data[i]['directory'] + '/preview.png"/>' + res.data[i]['name'] + '</td>\
    				<td>' + res.data[i]['description'] + '</td>\
    				<td><a href="' + res.data[i]['author_url'] + '" target="_blank">' + res.data[i]['author'] + '</a></td>\
    				<td>' + res.data[i]['version'] + '</td>\
    				<td>' + st +'</td>\
    				<td><a href="javascript:;" onclick="plugin_get_template(\'' + res.data[i]['directory'] + '\',\'' +res.data[i]['name'] + '\');"  class="btn btn-success btn-sm">设置</a> <a href="javascript:;" onclick="plugin_uninstall(' + res.data[i]['id'] + ')"  class="btn btn-danger btn-sm">卸载</a></td>\
    				</tr>';
                }
    			$("#plugin_table").html(body);
    			$("#plugin_page").html(bx_page(res.count,a_page,plugin_limit,'plugin_getpage'));
    			if(load == null){
    			loading_close();
    			}
    		});
	}
	
	
	function plugin_uninstall (idval) {
		layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定卸载吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在卸载...");
			$.post("../Plugin/uninstall",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'plugin_getpage("",true)');
    		});
		});
	}
	
	function plugin_close (idval) {
		bx_load("正在关闭插件...");
		$.post("../Plugin/close",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'plugin_getpage("",true)');
    		});
	}
	
	function plugin_open (idval) {
		bx_load("正在开启插件...");
		$.post("../Plugin/open",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'plugin_getpage("",true)');
    		});
	}
	
	function plugin_get_template (idval,name) {
		bx_load("正在获取插件模板...");
		$.get("../Plugin/getInc/" + idval,
    	function(result){
    		bx_load_close();
    		layer.open({
                type: 1,
                shade: 0,
                title: "<img width=\"30\" height=\"30\" src=\"<?php echo __URL__; ?>app/common/plugin/" + idval + "/preview.png\" />" + name,
                area: ['90%', '90%'],
                content: result,
                maxmin: true
            });
    	});
	}
	</script>
  </div>
  
<!--安装插件-->
  <div class="tab-pane fade pt-3" id="plugin_install" role="tabpanel" aria-labelledby="plugin_install-tab">
  	<?php do_action('admin_plugin_install'); ?>
  	<div class="form-group">
    <input id="file" type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
    <small id="fileHelp" class="form-text text-muted">请选择一个zip压缩格式的插件安装包 PHP上传限制：<span style="color: #ff0000;"><?php echo ini_get('upload_max_filesize'); ?></span></small>
  </div>
  	<a href="javascript:;" onclick="plugin_install();" class="btn btn-primary">上传安装</a>
 <script type="text/javascript">
  		function plugin_install () {
  			if($("#file").val() == ""){
  				layer.msg("请选择文件！",{icon: 5});
  				return;
  			}
  			bx_load("正在安装插件...");
  			var formData = new FormData();
  			formData.append('file', $('#file')[0].files[0]);
  			$.ajax({
      			url: '../Plugin/install',
  			type: 'POST',
  			cache: false,
  			data: formData,
  			processData: false,
  			contentType: false
  			}).done(function(res) {
  				bx_load_close();
  				bx_msg(res,'plugin_getpage("",true)');
  			}).fail(function(res) {
  				bx_load_close();
  				bx_msg(res,'plugin_getpage("",true)');
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