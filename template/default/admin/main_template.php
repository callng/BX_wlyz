<?php if(!defined('BX_ROOT')) {exit();} ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
		<div class="card">
  <h3 class="card-header">模板管理</h3>
  <div class="card-body ">
  <!--main-->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="template-tab" data-toggle="tab" href="#template" role="tab" aria-controls="template" aria-expanded="true">模版管理</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="template_install-tab"  data-toggle="tab" href="#template_install" role="tab" aria-controls="template_install">安装模版</a>
  </li>
</ul>

<!--modal-->
<div class="modal fade bd-example-modal-lg" id="a" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div id="my_add" class="modal-dialog modal-lg">
    
    <!--弹窗内容-->
    
  </div>
</div>

<style type="text/css">
	.template_list{
		list-style: none;
		margin: 0px;
		padding: 0px;
	}
	.template_list li{
		float: left;
		padding: 5px;
	}
</style>


<div class="tab-content" id="myTabContent">
<!--模版管理-->
  <div class="tab-pane fade  show active" id="template" role="tabpanel" aria-labelledby="template-tab">
<div class="py-2"></div>
<?php do_action('admin_template'); ?>
<div>
<?php $a = get_current_template(); ?>
<div class="alert alert-success mb-0" role="alert">
  <strong class="lead">当前模板</strong>
</div>
<ul class="template_list">
	<li>
		<div class="card" style="width: 19rem;">
			<img class="card-img-top" width="318" height="180" src="<?php echo __URL__; ?>template/<?php echo $a['admin']['directory'] ?>/preview.png">
			<div class="card-body">    				
				<h4 class="card-title"><?php echo $a['admin']['name'] ?></h4>    				
				<p class="card-text">作者：<a href="<?php echo $a['admin']['author_url'] ?>" target="_blank" ><?php echo $a['admin']['author'] ?></a></p>    				
				<p class="card-text">简介：<?php echo $a['admin']['description'] ?></p>    				
				<p class="card-text">版本：<?php echo $a['admin']['version'] ?></p>
				<p class="card-text">后台界面</p> 				    				
			</div>    				
		</div>
	</li>
	
	<li>
		<div class="card" style="width: 19rem;">
			<img class="card-img-top" width="318" height="180" src="<?php echo __URL__; ?>template/<?php echo $a['agent']['directory'] ?>/preview.png">
			<div class="card-body">    				
				<h4 class="card-title"><?php echo $a['agent']['name'] ?></h4>    				
				<p class="card-text">作者：<a href="<?php echo $a['agent']['author_url'] ?>" target="_blank" ><?php echo $a['agent']['author'] ?></a></p>    				
				<p class="card-text">简介：<?php echo $a['agent']['description'] ?></p>    				
				<p class="card-text">版本：<?php echo $a['agent']['version'] ?></p>
				<p class="card-text">代理界面</p>				    				
			</div>    				
		</div>
	</li>
	
</ul>
</div>


<div style="clear:both;">
<div class="alert alert-info mb-1" role="alert">
  <strong class="lead">模板列表</strong>
</div>
<div class="form-check form-check-inline">
  		<a href="javascript:;"  onclick="template_set();"  class="btn btn-success">应用模板</a>
</div>
<ul id="template_list" class="template_list">
</ul>
</div>

<nav style="clear:both;" aria-label="Page  navigation example" >
  <ul class="pagination justify-content-end" id="template_page">
    
  </ul>
</nav>


<script type="text/javascript">
	$(document).ready(function(){
          template_getpage(1);
          
    });
	//定义全局 储存页个数
   var template_limit = <?php echo $config['table_num'] ?>;
   var template_page = 1;
	function template_getpage (a_page,load) {
		if(load == null){
		loading_start();
		}
		if(a_page == ""){
    		a_page = template_page;
    	}else{
    		template_page = a_page;
    	}
		$.post("../Template/lists",{
			page:a_page,
			limit:template_limit,
			},
    		function(data){
    			//处理空数据
    			if(data == ""){
    				loading_close();
    				if(template_page == 1){
    				$("#template_list").html("");
    				$("#template_page").html("");
    				}else{
    					template_getpage(template_page-1);
    				}
    				return;
    			}
    			res=JSON.parse(data);
    			var body = "";
    			for (var i = 0; i < res.data.length; i++) {
    				body +='<li>\
    				<div class="card" style="width: 19rem;">\
    				<img class="card-img-top" width="318" height="180" src="<?php echo __URL__; ?>template/' + res.data[i]['directory'] + '/preview.png">\
    				<div class="card-body">\
    				<h4 class="card-title">' + res.data[i]['name'] + '</h4>\
    				<p class="card-text">作者：<a href="' + res.data[i]['author_url'] + '" target="_blank" >' + res.data[i]['author'] + '</a></p>\
    				<p class="card-text">简介：' + res.data[i]['description'] + '</p>\
    				<p class="card-text">版本：' + res.data[i]['version'] + '</p>\
    				<div class="form-check form-check-inline">\
    				<label class="form-check-label">\
    				<input class="form-check-input" type="radio" name="template_admin" id="template_admin_' + res.data[i]['id'] + '" value="' + res.data[i]['id'] + '"> 后台界面\
    				</label>\
    				</div>\
    				<div class="form-check form-check-inline">\
    				<label class="form-check-label">\
     				<input class="form-check-input" type="radio" name="template_agent" id="template_agent_' + res.data[i]['id'] + '" value="' + res.data[i]['id'] + '"> 代理界面\
    				</label>\
    				</div>\
    				<a href="javascript:;" onclick="template_uninstall(' + res.data[i]['id'] + ')" class="btn btn-danger btn-sm float-right">卸载</a>\
    				</div>\
    				</div>\
    				</li>';
                }
    			$("#template_list").html(body);
    			$("#template_page").html(bx_page(res.count,a_page,template_limit,'template_getpage'));
    			$("#template_admin_<?php echo $a['admin']['id'] ?>").attr("checked",true);
    	  	    $("#template_agent_<?php echo $a['agent']['id'] ?>").attr("checked",true);
    			
    			if(load == null){
    			loading_close();
    			}
    		});
	}
	function template_set () {
		bx_load("正在修改当前模板...");
		$.post("../Template/set", {
			admin:$('input[name="template_admin"]:checked').val(),
			agent:$('input[name="template_agent"]:checked').val()
		}, function(result) {
			bx_load_close();
			bx_msg(result);
		});
	}
	
	
	function template_uninstall (idval) {
		layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定卸载吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在卸载...");
			$.post("../Template/uninstall",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'template_getpage("",true)');
    		});
		});
	}
</script>

	
  </div>
  
<!--安装模版-->
  <div class="tab-pane fade pt-3" id="template_install" role="tabpanel" aria-labelledby="template_install-tab">
  	<?php do_action('admin_template_install'); ?>
  	<div class="form-group">
    <input id="file" type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
    <small id="fileHelp" class="form-text text-muted">请选择一个zip压缩格式的模板安装包 PHP上传限制：<span style="color: #ff0000;"><?php echo ini_get('upload_max_filesize'); ?></span></small>
  </div>
  	<a href="javascript:;" onclick="template_install();" class="btn btn-primary">上传安装</a> 	
  	
  	<script type="text/javascript">
  		function template_install () {
  			if($("#file").val() == ""){
  				layer.msg("请选择文件！",{icon: 5});
  				return;
  			}
  			bx_load("正在安装模板...");
  			var formData = new FormData();
  			formData.append('file', $('#file')[0].files[0]);
  			$.ajax({
      			url: '../Template/install',
  			type: 'POST',
  			cache: false,
  			data: formData,
  			processData: false,
  			contentType: false
  			}).done(function(res) {
  				bx_load_close();
  				bx_msg(res,'template_getpage("",true)');
  			}).fail(function(res) {
  				bx_load_close();
  				bx_msg(res,'template_getpage("",true)');
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
