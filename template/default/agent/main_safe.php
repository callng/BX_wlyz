<?php if(!defined('BX_ROOT')) {exit();} ?>
<div  class="main container-fluid py-3">
	<div class="row">
		<div class="col-12">
		<div class="card">
  <h3 class="card-header">安全管理</h3>
  
  <div class="card-body ">
  <!--main-->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="safe-tab" data-toggle="tab" href="#safe" role="tab" aria-controls="safe" aria-expanded="true">安全管理</a>
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
  <?php do_action('agent_safe'); ?>
  	<div class="alert alert-danger" role="alert">
  <strong>修改密码：   </strong>   修改后请牢记密码。
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
        <button type="button" onclick="ajax_modify_password();" class="btn btn-primary">确认修改</button>
      </div>
</div>

    
  </div>
</div>
<script type="text/javascript">
	function ajax_modify_password(){
    		if($("#opwd").val() == "" ||$("#npwd").val() == "" || $("#nnpwd").val() == ""){
    			layer.msg('请进行全部输入！', {icon: 2});
    			return;
    		}
    		if($("#npwd").val() !== $("#nnpwd").val()){
    			layer.msg('确认密码有误！请更正！', {icon: 2});
    			return;
    		}
    		bx_load("正在修改密码...");
    			  $.post("../Safe/passwordChange",{
    			  opwd:$("#opwd").val(),
    			  npwd:$("#npwd").val()
    			  },function(result){
			        bx_load_close();
			        bx_msg(result);
		        });
    		
    	}
</script>

<div class="py-2"></div>
<div class="alert alert-info" role="alert">
  <strong>充值：   </strong>   通过卡密自助充值余额！
</div>
       
<!--充值-->
<div class="card border-info">
  <div class="card-body">
    
                                        
      <div class="form-group row">
  <label for="example-text-input" class="col-1 col-form-label">卡密：</label>
  <div class="col-11">
    <input class="form-control" type="text" value="" id="money_card" placeholder="请输入卡密">
  </div>
</div>

<div class="row">
	  <div class="col-1"></div>
      <div class="col-11">
        <button type="button" onclick="ajax_money_recharge();" class="btn btn-primary">确认充值</button>
      </div>
</div>

    
  </div>
</div>

<script type="text/javascript">
	function ajax_money_recharge () {
		if($("#money_card").val() == ""){
			layer.msg('请输入充值卡', {icon: 2});
    		return;
		}
		bx_load("充值中...");
		$.post("../Safe/moneyRecharge",{
    		card:$("#money_card").val()
    	},function(result){
			bx_load_close();
			bx_msg(result);
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