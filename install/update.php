<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
<?php
if(is_file('update.lock')){ exit('您已经升级过了 如果要重新升级请删除update.lock文件'); } $do= isset($_GET['do'])? $_GET['do']:''; if($do=='yes'){ $_config = require '../config/config.php'; try { $con = new PDO("mysql:host={$_config['db']['host']};port={$_config['db']['port']};dbname={$_config['db']['name']}",$_config['db']['user'], $_config['db']['pw']); $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); $con->exec("set names utf8"); $sql = file_get_contents("update.sql"); $sql=str_replace('{ABC}', $_config['db']['tablepre'], $sql); $sql=explode(';</explode>',$sql); for($i=0;$i<count($sql)-1;$i++) { $con -> exec($sql[$i]); } echo '共执行' . (count($sql)-1) . '条sql语句<br />'; if(file_put_contents('update.lock','lock')){ echo '写入升级锁文件成功'.'<br />'; }else{ exit('写入升级锁文件失败'); } exit('恭喜！升级成功'); } catch(PDOException $e){ exit('<h3>升级出错:' . $e->getMessage() . '</h3>'); } } ?>
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
					<h4 style="text-align: center;" >欢迎使用冰心网络验证     3.0 > 3.1升级向导</h4>
					<p style="text-align: center;" class="h5">
						PHP >= 5.4.0<br />
						PATH_INFO
					</p>
				</div>
			</div>

			<form method="post" action="update.php?do=yes">
				<div class="row">
					<div class="col-5"></div>
					<div class="offset-sm-5 col-sm-5">
					<button  type="submit" class="btn btn-primary">
					点此升级
					</button>
				</div>
				</div>
				

			</form>
		</div>
	</body>
</html>
