<?php if(!defined('BX_ROOT')) {exit();} ?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="UTF-8">
		<title>用户登陆</title>
		<link rel="stylesheet" type="text/css" href="<?php echo __URL__; ?>public/static/css/bootstrap.min.css" />
		<script src="<?php echo __URL__; ?>public/static/plugin/iconfont/iconfont.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo __URL__; ?>public/static/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="<?php echo __URL__; ?>public/static/plugin/layer/layer.js" type="text/javascript" charset="utf-8"></script>
	 	<!-- layer style -->
	 	<link rel="stylesheet" type="text/css" href="<?php echo __URL__; ?>public/static/plugin/layer/style.css"/>
	</head>
	
    <style type="text/css">
    	.icon {
        	width: 1.5em; height: 1.5em;
       		vertical-align: -0.15em;
       		fill: currentColor;
        	overflow: hidden;
   		}
    	.sty{
    		width: 500px;
    		margin: 10% auto;
    	}
    	.but{
    		float: right;
    	}
    	body,button, input, select, textarea,h1 ,h2, h3, h4, h5, h6 { font-family: Microsoft YaHei,'宋体' , Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;}
    </style>
    
	<body style="background-image: url(<?php echo __URL__; ?>public/static/image/background.png);">
		<?php do_action('agent_login'); ?>
		<div class="card text-center sty">
			<div class="card-header">
				Agent Login
			</div>
			<div class="card-body">			
  <div class="input-group">
    <div class="input-group-addon"><svg class="icon" aria-hidden="true">
    <use xlink:href="#icon-iconfont"></use>
</svg></div>
    <input type="text" class="form-control"  id="username" placeholder="Username">
  </div>
			<br />	
  <div class="input-group">
    <div class="input-group-addon"><svg class="icon" aria-hidden="true">
    <use xlink:href="#icon-mima"></use>
</svg></div>
    <input type="password" class="form-control" id="password" placeholder="Password">
  </div>
  <br />	
  <div class="input-group">
    <div class="input-group-addon"><svg class="icon" aria-hidden="true">
    <use xlink:href="#icon-yanzhengma"></use>
</svg></div>
    <input type="text" class="form-control" id="verifycode" placeholder="Verification Code">
    	<img id="vc" src="../../verifycode" onclick="flushCode();"/>
  </div>
				
			</div>
			<div class="card-footer text-muted">
				<span id="ip">IP地址：<?php echo get_ip(); ?></span>
				<button  class="btn btn-primary but" onclick="login()" >登录</button>
			</div>
		</div>
	</body>
    <script type="text/javascript">  
        function flushCode(){
			$("#vc").attr("src",this.src='../../VerifyCode?'+Math.random());
		}
        function login(){
        	if(!$("#username").val()||!$("#password").val()||!$("#verifycode").val()){
        		layer.msg('请全部输入', {icon: 5});
				return;
			}
			layer.msg('登陆中', {icon: 16,time:0});
        	$.post("../Home/login",{
            username:$("#username").val(),
            password:$("#password").val(),
            verifycode:$("#verifycode").val()
            },
            function(data){
            	res = JSON.parse(data);
				if(res.text == "登录成功"){
					location.reload();
				}else{
					layer.msg(res.text, {icon: 5});
					flushCode();
				}

            });
        }
        
        $('#verifycode').keydown(function(e){
            if(e.keyCode==13){
                login();
            }
        });
       

    </script>
    
</html>