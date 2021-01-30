<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
<?php
if(is_file('install.lock')){ exit('您已经安装了 如果要重新安装请删除install.lock文件'); } $do= isset($_GET['do'])? $_GET['do']:''; if($do=='yes'){ $host=isset($_POST['host'])?$_POST['host']:NULL; $port=isset($_POST['port'])?$_POST['port']:NULL; $user=isset($_POST['user'])?$_POST['user']:NULL; $pw=isset($_POST['pw'])?$_POST['pw']:NULL; $name=isset($_POST['name'])?$_POST['name']:NULL; $pre=isset($_POST['pre'])?$_POST['pre']:NULL; $key=isset($_POST['key'])?$_POST['key']:NULL; if($host==null || $port==null || $user==null || $name==null || $pre==null || $key==null){ exit('除了数据库密码其他请进行全部填写'); } else { $config="<?php
return [

    // +----------------------------------------------------------------------
    // | 数据库设置
    // +----------------------------------------------------------------------

	'db'                   => [
	    // 服务器地址
		'host'      => '{$host}',
		// 服务器端口
		'port'      => '{$port}',
		// 用户
		'user'      => '{$user}',
		// 密码
		'pw'        => '{$pw}',
		// 数据库
		'name'      => '{$name}',
		// 表名前缀
		'tablepre'  => '{$pre}',
	],
	
	// +----------------------------------------------------------------------
    // | 程序设置
    // +----------------------------------------------------------------------
    
    // 调试模式
    'debug'                  => false,
    // 默认时区
    'default_timezone'       => 'PRC',
    // 程序key
    'key'                    => '{$key}',
    
	// +----------------------------------------------------------------------
    // | 模块设置
    // +----------------------------------------------------------------------
    
    // 默认模块名
    'default_module'         => 'index',
    // 默认控制器名
    'default_controller'     => 'Index',
    // 默认操作名
    'default_action'         => 'index',
    
	
	// +----------------------------------------------------------------------
    // | URL设置
    // +----------------------------------------------------------------------
    
    // 路由配置文件（支持配置多个）
    'route_config_file'      => ['route'],
    
];
?>"; } try { $con = new PDO("mysql:host={$host};port={$port};dbname={$name}",$user, $pw); $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $con -> exec("set names utf8"); $sql = file_get_contents("install.sql"); $sql=str_replace('{ABC}', $pre, $sql); $sql=explode(';</explode>',$sql); for($i=0;$i<count($sql)-1;$i++) { $con -> exec($sql[$i]); } echo '共执行' . (count($sql)-1) . '条sql语句<br />'; if(file_put_contents('install.lock','lock')){ echo '写入安装锁文件成功'.'<br />'; }else{ exit('写入安装锁文件失败'); } if(file_put_contents('update.lock','lock')){ echo '写入升级锁文件成功'.'<br />'; }else{ exit('写入升级锁文件失败'); } if(file_put_contents('../config/config.php',$config)){ echo '写入数据库配置成功'.'<br />'; }else{ exit('写入数据库配置失败'); } exit('恭喜！安装成功 默认账号 admin 默认密码 admin'); } catch(PDOException $e){ exit('<h3>安装出错:' . $e->getMessage() . '</h3>'); } } ?>
		<link rel="stylesheet" type="text/css" href="../public/static/css/bootstrap.min.css"/>
		<style type="text/css">body,
button,
input,
select,
textarea,
h1,
h2,
h3,
h4,
h5,
h6,
p,
* {
	font-family: Microsoft YaHei, '宋体', Tahoma, Helvetica, Arial, "\5b8b\4f53", sans-serif;
}</style>
	</head>
	<body>
		<div class="container">
			<div class="jumbotron jumbotron-fluid">
				<div class="container">
					<h4 style="text-align: center;" >欢迎使用冰心网络验证     3.02安装向导</h4>
					<p style="text-align: center;" class="h5">
						PHP >= 5.4.0<br />
						PATH_INFO
					</p>
				</div>
			</div>

			<form method="post" action="index.php?do=yes">
				<div class="form-group">
					<label class="form-control-label" for="formGroupExampleInput">数据库地址:</label>
					<input type="text" class="form-control"  value="localhost" name="host" >
				</div>
				<div class="form-group">
					<label class="form-control-label" for="formGroupExampleInput2">数据库端口:</label>
					<input type="text" class="form-control" value="3306" name="port" >
				</div>
				<div class="form-group">
					<label class="form-control-label" for="formGroupExampleInput2">数据库用户名:</label>
					<input type="text" class="form-control"  name="user" >
				</div>
				<div class="form-group">
					<label class="form-control-label" for="formGroupExampleInput2">数据库密码:</label>
					<input type="text" class="form-control"  name="pw" >
				</div>
				<div class="form-group">
					<label class="form-control-label" for="formGroupExampleInput2">数据库名:</label>
					<input type="text" class="form-control" name="name" >
				</div>
				<div class="form-group">
					<label class="form-control-label" for="formGroupExampleInput2">数据表前缀:</label>
					<input type="text" class="form-control" value="BX_" name="pre" >
				</div>
				<div class="form-group">
					<label class="form-control-label" for="formGroupExampleInput2">KEY:</label>
					<input type="text" class="form-control" value="" name="key" >
				</div>
				
				<div class="row">
					<div class="col-5"></div>
					<div class="col-5">
					<button  type="submit" class="btn btn-primary">
						安装
					</button>
				</div>
				</div>
				

			</form>
		</div>
	</body>
</html>
