<?php if(!defined('BX_ROOT')) {exit();} ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>代理端 - <?php echo $config['sitename']; ?></title>
		
		<link rel="stylesheet" type="text/css" href="<?php echo __URL__; ?>public/static/css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo __URL__; ?>public/static/css/loading.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo __URL__; ?>public/static/plugin/bootstrap_dosc/docs.min.css"/>
		<link rel="stylesheet" type="text/css" href="<?php echo __URL__; ?>public/static/css/style.css"/>
		<script src="<?php echo __URL__; ?>public/static/plugin/iconfont/iconfont.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo __URL__; ?>public/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		
		
		
	</head>
	<body style="background-image: url(<?php echo __URL__; ?>public/static/image/background.png);background-attachment: fixed;">
	<?php do_action('agent_header'); ?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand mr-auto" href="./show"><?php echo $config['sitename'] ?></a>
  
      <a href="javascript:logout();"  class="btn btn-outline-success">安全退出</a>
<script type="text/javascript">
	function logout () {
		layer.confirm('您真的要退出吗？',function(){
			layer.msg('退出中', {icon: 16,time:0});
			$.get("../Home/logout",
    			function(result){
    				res = JSON.parse(result);
					if(res.text == "退出成功"){
						location.reload();
					}else{
						layer.msg(res.text, {icon: 5});
					}
    					
    		});
		});
	}
</script>
  
</nav>
<div class="bx-warp">
<div class="container-fluid">

      		
      
	<div id="menu" class="card sidebar">
  <div class="card-header" style="text-align: center;border-bottom: 0px;" >
  		 <img   src="<?php echo __URL__; ?>public/static/image/avatar.png"  class="img-thumbnail rounded-circle">
  		 <div>用户名: <span class="badge badge-success"><?php echo \app\agent\Auth::get('username'); ?></span><br />
  		 UID: <span class="badge badge-primary"><?php echo \app\agent\Auth::get('id'); ?></span>
  		 权限: <span class="badge badge-info"><?php echo \app\agent\Auth::get('power')=='10'?'超级代理':'普通代理'; ?></span><br />
  		 余额: <span class="badge badge-danger"><?php echo \app\agent\Auth::get('money'); ?></span><br />
  		 消费: <span class="badge badge-secondary"><?php echo \app\agent\Auth::get('consumed'); ?></span>
  		 </div>
  
  </div>

 <div class="list-group"  >
  <a href="?mod=inedx" id="bx_menu_index"  class="list-group-item  list-group-item-action"><svg class="icon" aria-hidden="true"><use xlink:href="#icon-house__easyic"></use></svg>&nbsp;首页</a>
  <?php if(\app\agent\Auth::get('power')=='10'):; ?>
  <a href="?mod=agent" id="bx_menu_agent" class="list-group-item list-group-item-action"><svg class="icon"  aria-hidden="true"><use xlink:href="#icon-proxy2-copy"></use></svg>&nbsp;代理管理</a>
  <?php endif; ?>
  <a href="?mod=user" id="bx_menu_user" class="list-group-item list-group-item-action"><svg class="icon"  aria-hidden="true"><use xlink:href="#icon-yonghu1"></use></svg>&nbsp;用户管理</a>
  <a href="?mod=card" id="bx_menu_card" class="list-group-item list-group-item-action"><svg class="icon"   aria-hidden="true"><use xlink:href="#icon-yinhangqia"></use></svg>&nbsp;卡密管理</a>
  <a href="?mod=safe" id="bx_menu_safe" class="list-group-item list-group-item-action"><svg class="icon"  aria-hidden="true"><use xlink:href="#icon-anquan"></use></svg>&nbsp;安全管理</a>
  <script type="text/javascript">
  	//菜单类
  	(function ($) {
                $.getUrlParam = function (name) {
                    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
                    var r = window.location.search.substr(1).match(reg);
                    if (r != null) return unescape(r[2]); return null;
                }
            })(jQuery);
            var mod = $.getUrlParam("mod");
  	switch (mod) {
	case 'agent':
		$("#bx_menu_agent").addClass("active");
		break;
	case 'user':
		$("#bx_menu_user").addClass("active");
		break;
	case 'card':
		$("#bx_menu_card").addClass("active");
		break;
	case 'cardtype':
		$("#bx_menu_cardtype").addClass("active");
		break;
	case 'safe':
		$("#bx_menu_safe").addClass("active");
		break;
	default:
		$("#bx_menu_index").addClass("active");
		break;
}
  </script>
  
 
</div>
<div style="position:fixed;bottom:0;height: 40px;width:240px;background-color: #C0C0C0;line-height:40px;text-align: center;">
  	 Copyright BingXin &copy;2017
</div>
</div>