<?php
if (!defined('BX_ROOT')) {exit();} $software = get_software_lists(); ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
			<div class="card">
				<h3 class="card-header">安全管理</h3>

				<div class="card-body ">
					<!--main-->
					<ul class="nav nav-tabs" id="myTab" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="safe-tab" data-toggle="tab" href="#safe" role="tab" aria-controls="safe" aria-expanded="true">
								安全管理
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="theme-tab"  data-toggle="tab" href="#theme" role="tab" aria-controls="theme">
								配置设置
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="menber_log-tab" data-toggle="tab" href="#menber_log" role="tab" aria-controls="menber_log">
								管理日志
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="black-tab" data-toggle="tab" href="#black" role="tab" aria-controls="black">
								黑名单
							</a>
						</li>
					</ul>

					<!--modal-->
					<div class="modal fade bd-example-modal-lg" id="a" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div id="my_add" class="modal-dialog modal-lg">

							<!--弹窗内容-->

						</div>
					</div>

					<div class="tab-content" id="myTabContent">
						<!--安全管理-->
						<div class="tab-pane fade  show active" id="safe" role="tabpanel" aria-labelledby="safe-tab">
							<div class="py-2"></div>
							<?php do_action('admin_safe'); ?>
							<div class="alert alert-danger" role="alert">
								<strong>修改密码： </strong> 修改后请牢记密码。暂不支持自助找回密码！！！
							</div>
							<!--修改密码-->
							<div class="card border-primary">
								<div class="card-body">
									

										<div class="form-group row">
											<label for="example-text-input" class="col-1 col-form-label">原密码：</label>
											<div class="col-11">
												<input class="form-control" type="text" value="" id="opwd" placeholder="请输入原密码">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-search-input" class="col-1 col-form-label">修改密码：</label>
											<div class="col-11">
												<input class="form-control" type="password" value="" id="npwd" placeholder="请输入修改密码">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-email-input" class="col-1 col-form-label">再次确认：</label>
											<div class="col-11">
												<input class="form-control" type="password" value="" id="nnpwd" placeholder="请再次输入修改密码">
											</div>
										</div>

										<div class="row">
											<div class="col-1"></div>
											<div class="col-11">
												<button type="button" onclick="ajax_modify_password();" class="btn btn-primary">
												确认修改
												</button>
											</div>
										</div>

									
								</div>
							</div>
<script type="text/javascript">
function ajax_modify_password() {
	if($("#opwd").val() == "" || $("#npwd").val() == "" || $("#nnpwd").val() == "") {
		layer.msg('请进行全部输入！', {icon: 2});
		return;
	}
	if($("#npwd").val() !== $("#nnpwd").val()) {
		layer.msg('确认密码有误！请更正！', {icon: 2});
		return;
	}
	bx_load("正在修改密码...");
	$.post("../Safe/passwordChange", {
		opwd: $("#opwd").val(),
		npwd: $("#npwd").val()
	}, function(result) {
		bx_load_close();
		bx_msg(result);
	});

}
</script>

						</div>

						<!--网站设置-->
						<div class="tab-pane fade" id="theme" role="tabpanel" aria-labelledby="theme-tab">

							<div class="py-2"></div>
                             <?php do_action('admin_config'); ?>
							<!--配置设置-->
							<div class="alert alert-success" role="alert">
								<strong>配置设置</strong>
							</div>

							<div class="card border-info">
								<div class="card-body">
									

										<div class="form-group row">
											<label for="example-text-input" class="col-1 col-form-label">网站名称：</label>
											<div class="col-11">
												<input class="form-control" id="theme_name" type="text" value="<?php echo $config['sitename'] ?>"  placeholder="用于头部显示">
											</div>
										</div>
										<div class="form-group row">
											<label for="example-email-input" class="col-1 col-form-label">表格数量：</label>
											<div class="col-11">
												<input class="form-control" id="theme_table_num" type="text" value="<?php echo $config['table_num'] ?>"  placeholder="请输入表格每页显示的数量   请进行合理的设置  不能为负数， 0 ， 小数">
											</div>
										</div>
										<div class="row">
											<div class="col-1"></div>
											<div class="col-11">
												<button type="button" onclick="ajax_theme_editto();" class="btn btn-info">
												确认修改
												</button>
											</div>
										</div>

									
								</div>
							</div>

<script type="text/javascript">
$(function() {$("[data-toggle='popover']").popover();});

function ajax_theme_editto() {
	bx_load("正在修改...");
	$.post("../Safe/configEdit",{
		sitename:$("#theme_name").val(),
		table_num: $("#theme_table_num").val()
	}, function(result) {
		bx_load_close();
		bx_msg(result);
	});

}
</script>

						</div>
						<!--管理日志-->
						<div class="tab-pane fade" id="menber_log" role="tabpanel" aria-labelledby="menber_log-tab">
							<div class="py-2"></div>
							<?php do_action('admin_menber_log'); ?>
							<div class="form-check form-check-inline">
								<a href="javascript:;"  onclick="menber_log_checkeddel();"  class="btn btn-danger">
									删除选中
								</a>
							</div>

							<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
								<thead>
									<tr>
										<th>
											<input onclick="$('input[name=menber_log_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox">
										</th>
										<th>编号</th>
										<th>操作者</th>
										<th>操作类型</th>
										<th>详情</th>
										<th>IP</th>
										<th>操作时间</th>
									</tr>
								</thead>
								<tbody id="menber_log_table">

								</tbody>
							</table>

							<nav aria-label="Page  navigation example" >
								<ul class="pagination justify-content-end" id="menber_log_page">

								</ul>
							</nav>

<script type="text/javascript">
function menber_log_checkeddel() {
	//遍历多选
	var id_array = new Array();
	$('input[name=menber_log_checkbox]:checked').each(function() {
		id_array.push($(this).val()); //向数组中添加元素
	});
	var ids = id_array.join(','); //将数组元素连接起来以构建一个字符串
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
    			bx_msg(result,'menber_log_getpage("",true)');
    		});
	});

}


//语言转换
   var menber_log_lang = Array();
   menber_log_lang['menber_log_type'] = Array();
   menber_log_lang['menber_log_type']['1'] = '登录';
   menber_log_lang['menber_log_type']['2'] = '代理管理';
   menber_log_lang['menber_log_type']['3'] = '卡密管理';
   menber_log_lang['menber_log_type']['4'] = '安全管理';
   menber_log_lang['menber_log_type']['5'] = '软件管理';
   menber_log_lang['menber_log_type']['6'] = '用户管理';
   menber_log_lang['menber_log_type']['7'] = '模板管理';
   menber_log_lang['menber_log_type']['8'] = '插件管理';

/**
 * @param  page  分页号
 * @param  limit 多少个
 */
$("#menber_log-tab").one("click", function() {
	menber_log_getpage(1);
});
//定义全局 储存页个数
var menber_log_limit =<?php echo $config['table_num'] ?>;
var menber_log_page = 1;

function menber_log_getpage(a_page, load) {
	if(load == null) {
		loading_start();
	}
	if(a_page == "") {
		a_page = menber_log_page;
	} else {
		menber_log_page = a_page;
	}
	$.post("../MenberLog/lists", {
			page: a_page,
			limit: menber_log_limit,
		},
		function(data) {
			//处理空数据
			if(data == "") {
				loading_close();
				if(menber_log_page == 1) {
					$("#menber_log_table").html("");
					$("#menber_log_page").html("");
				} else {
					menber_log_getpage(menber_log_page - 1);
				}
				return;
			}
			res = JSON.parse(data);
			var body = "";
			for(var i = 0; i < res.data.length; i++) {
				body += "<tr>\
<th scope=\"row\"><input name=\"menber_log_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
<th>" + res.data[i]["id"] + "</th>\
<td>" + res.data[i]["menber_name"] + "</td>\
<td>" + menber_log_lang['menber_log_type'][res.data[i]["type"]] + "</td>\
<td>" + res.data[i]["details"] + "</td>\
<td>" + res.data[i]["ip"] + "</td>\
<td>" + bx_time(res.data[i]["time"]) + "</td>";
			}
			$("#menber_log_table").html(body);
			$("#menber_log_page").html(bx_page(res.count,a_page,menber_log_limit,'menber_log_getpage'));
			if(load == null) {
				loading_close();
			}
		});
}
</script>

						</div>

<div class="tab-pane fade" id="black" role="tabpanel" aria-labelledby="black-tab">
	<div class="py-2"></div>
	<?php do_action('admin_black'); ?>
	
	<div class="bd-callout bd-callout-info">
  	   	
<div class="form-inline">
	
    <div class="form-group">
       程序名：
    <select class="form-control" id="search_black_software_id" style="width: 150px">
      <option value="">全部</option>
      <option value="0">全局</option>
	  <?php foreach($software as $k => $v):; ?>
	  <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>
      <?php endforeach; ?>
    </select>&nbsp;
    </div>
 
    <div class="form-group">
    	类型：
    <select class="form-control" id="search_black_type">
      <option value="">全部</option>
      <option value="1">机器码</option>
      <option value="2">IP</option>
    </select>&nbsp;
    </div>
    
    <div class="form-group">   
                特征：
    <input type="text" class="form-control" id="search_black_feature" style="width: 150px;" >&nbsp;
    </div>
    
    <div class="form-group">
                操作者：
    <input type="text" class="form-control" id="search_black_menber_name" style="width: 150px;" >&nbsp;
    </div>
    
    <div class="form-group">
                备注：
    <input type="text" class="form-control" id="search_black_comment" style="width: 150px;" >&nbsp;
    </div>
    <a href="javascript:;" onclick="black_getpage(1);"   class="btn btn-info">搜索</a>

</div>
</div>
	
	
	<div class="form-check form-check-inline">
		<a href="javascript:;"  onclick="black_add();"  class="btn btn-success">
			添加
		</a>
		<a href="javascript:;"  onclick="black_checkeddel();"  class="btn btn-danger">
			删除选中
		</a>
	</div>

	<table class="table table-striped table-responsive table-hover table-auto my-table-auto table-sm"  >
		<thead>
			<tr>
				     <th>
					<input onclick="$('input[name=black_checkbox]').prop('checked',$(this).prop('checked'));" type="checkbox">
					</th>
					<th>编号</th>
					<th>特征</th>
					<th>类型</th>
					<th>操作者</th>
					<th>归属程序</th>
					<th>备注</th>
					<th>添加时间</th>
					<th>操作</th>
			</tr>
		</thead>
	<tbody id="black_table">

	</tbody>
	</table>

	<nav aria-label="Page  navigation example" >
		<ul class="pagination justify-content-end" id="black_page">

		</ul>
	</nav>
	<script type="text/javascript">
		function black_add () {
			var body = '<div class="container-fluid p-3">\
			<div class="input-group">\
			<div class="input-group-addon">类型</div>\
    		<select id="black_type" class="form-control">\
            <option value="1">机器码</option>\
            <option value="2">IP</option>\
            </select>\
            </div>\
            <div class="input-group  pt-3">\
            <div class="input-group-addon">程序</div>\
    		<select id="black_software_id" class="form-control">\
            <option value="0">全局</option>\
	        <?php foreach($software as $k => $v):; ?>
	        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>\
            <?php endforeach; ?>
            </select>\
            </div>\
            <div class="input-group  pt-3">\
            <div class="input-group-addon">特征</div>\
            <input type="text" id="black_feature" class="form-control"  placeholder="机器码 或 IP">\
            </div>\
            <div class="input-group  pt-3">\
            <div class="input-group-addon">备注</div>\
            <input type="text" id="black_comment" class="form-control"  placeholder="不需要可留空">\
            </div>\
            <div class="float-right pt-3">\
            <a href="javascript:;" onclick="ajax_black_add();" class="btn btn-primary">添加</a>\
            <button type="button" class="btn btn-secondary" onclick="layer.close(blockShow);" >关闭</button>\
            </div>\
			</div>';
			blockShow = layer.open({
      				type: 1,
      				title: '添加',
      				closeBtn: 2,
      				area: ['500px', '325px'],
      				content: body
    			});
		}
		
		function ajax_black_add(){
			bx_load("正在添加...");
			$.post("../Black/add",{
    			  type:$("#black_type").val(),
    			  software_id:$("#black_software_id").val(),
    			  feature:$("#black_feature").val(),
    			  comment:$("#black_comment").val()
    		},function(result){
			      bx_load_close();
			      bx_msg(result,'black_getpage("",true)');
		    });
		}
		
		/**
 * @param  page  分页号
 * @param  limit 多少个
 */
$("#black-tab").one("click", function() {
	black_getpage(1);
});
//定义全局 储存页个数
var black_limit =<?php echo $config['table_num'] ?>;
var black_page = 1;


//语言转换
   var black_lang = Array();
   black_lang['1'] = '机器码';
   black_lang['2'] = 'IP';
function black_getpage(a_page, load) {
	if(load == null) {
		loading_start();
	}
	if(a_page == "") {
		a_page = menber_log_page;
	} else {
		menber_log_page = a_page;
	}
	$.post("../Black/lists", {
			page: a_page,
			limit: menber_log_limit,
			//搜索
		    software_id:$("#search_black_software_id").val(),
		    type:$("#search_black_type").val(),
		    feature:$("#search_black_feature").val(),
		    menber_name:$("#search_black_menber_name").val(),
		    comment:$("#search_black_comment").val()
		},
		function(data) {
			//处理空数据
			if(data == "") {
				loading_close();
				if(menber_log_page == 1) {
					$("#black_table").html("");
					$("#black_page").html("");
				} else {
					black_getpage(black_page - 1);
				}
				return;
			}
			res = JSON.parse(data);
			var body = "";
			for(var i = 0; i < res.data.length; i++) {
				body += "<tr>\
<th scope=\"row\"><input name=\"black_checkbox\" type=\"checkbox\" value=\"" + res.data[i]["id"] + "\" ></th>\
<th>" + res.data[i]["id"] + "</th>\
<td>" + res.data[i]["feature"] + "</td>\
<td>" + black_lang[res.data[i]["type"]] + "</td>\
<td>" + res.data[i]["menber_name"] + "</td>\
<td>" + (res.data[i]["software_id"] == 0 ? '全局' : res.data[i]["software_name"]) + "</td>\
<td>" + res.data[i]["comment"] + "</td>\
<td>" + bx_time(res.data[i]["time"]) + "</td>\
<td><a href=\"javascript:;\" onclick=\"black_edit("+res.data[i]["id"]+");\"  class=\"btn btn-success btn-sm\">设置</a> <a href=\"javascript:;\" onclick=\"black_del("+res.data[i]["id"]+");\"  class=\"btn btn-danger btn-sm\">删除</a></td>";
			}
			$("#black_table").html(body);
			$("#black_page").html(bx_page(res.count,a_page,menber_log_limit,'menber_log_getpage'));
			if(load == null) {
				loading_close();
			}
		});
}
	
	

function black_checkeddel() {
	//遍历多选
	var id_array = new Array();
	$('input[name=black_checkbox]:checked').each(function() {
		id_array.push($(this).val()); //向数组中添加元素
	});
	var ids = id_array.join(','); //将数组元素连接起来以构建一个字符串
	//遍历结束
	layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../Black/delete",{id:ids},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'black_getpage("",true)');
    		});
	});

}

function black_del(idval){   
        layer.confirm('你将无法恢复！', {
			btn: ['确定','取消'], //按钮
			title:"确定删除吗？",
			closeBtn:2,
			icon:7
		}, function(){
			bx_load("正在删除...");
			$.post("../Black/delete",{id:idval},
    			function(result){
    			bx_load_close();
    			bx_msg(result,'black_getpage("",true)');
    		});
		});
		
		

	}	

function black_edit(idval){
	loading_start();
	$.post("../Black/getInfo",{
    	id:idval,
   },function(data){
   	    loading_close();
		res = JSON.parse(data);
		var body = '<div class="container-fluid p-3">\
			<div class="input-group">\
			<div class="input-group-addon">类型</div>\
    		<select id="black_type" class="form-control">\
            <option value="1">机器码</option>\
            <option value="2">IP</option>\
            </select>\
            </div>\
            <div class="input-group  pt-3">\
            <div class="input-group-addon">程序</div>\
    		<select id="black_software_id" class="form-control">\
            <option value="0">全局</option>\
	        <?php foreach($software as $k => $v):; ?>
	        <option value="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></option>\
            <?php endforeach; ?>
            </select>\
            </div>\
            <div class="input-group  pt-3">\
            <div class="input-group-addon">特征</div>\
            <input type="text" id="black_feature" class="form-control" value="' + res[0].feature +'"  placeholder="机器码 或 IP">\
            </div>\
            <div class="input-group  pt-3">\
            <div class="input-group-addon">备注</div>\
            <input type="text" id="black_comment" class="form-control" value="' + res[0].comment +'"  placeholder="不需要可留空">\
            </div>\
            <div class="float-right pt-3">\
            <a href="javascript:;" onclick="ajax_black_edit(' + res[0].id +');" class="btn btn-primary">修改</a>\
            <button type="button" class="btn btn-secondary" onclick="layer.close(blockShow);" >关闭</button>\
            </div>\
			</div>';
			blockShow = layer.open({
      				type: 1,
      				title: '修改黑名单 编号：' + idval,
      				closeBtn: 2,
      				area: ['500px', '325px'],
      				content: body
    			});
    		$('#black_software_id').val(res[0].software_id);
    		$('#black_type').val(res[0].type);
	});
}
	function ajax_black_edit(id){
    		    bx_load("正在修改...");
    			  $.post("../Black/edit",{
    			  id:id,
    			  type:$("#black_type").val(),
    			  software_id:$("#black_software_id").val(),
    			  feature:$("#black_feature").val(),
    			  comment:$("#black_comment").val()
    			  },function(result){
			          bx_load_close();
			          bx_msg(result,'black_getpage("",true)');
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