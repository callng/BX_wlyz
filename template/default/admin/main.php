<?php if(!defined('BX_ROOT')) {exit();} ?>
<?php  $a = get_bulletin(); ?>
<div  class="main container-fluid py-3">
<?php  echo($a['header']); ?>
<?php do_action('admin_index'); ?>
<script src="<?php echo __URL__; ?>public/static/js/echarts.common.min.js" type="text/javascript" charset="utf-8"></script>

	<div id="echarts" style="width: 100%;height: 800px;"></div>
	<script type="text/javascript">
		var myChart = echarts.init(document.getElementById('echarts'));
		option = {
    title: {
        text: '数据总览',
        left: 'center'
    },
    color: ['#3398DB'],
    tooltip : {
        trigger: 'axis',
        axisPointer : {            // 坐标轴指示器，坐标轴触发有效
            type : 'shadow'        // 默认为直线，可选为：'line' | 'shadow'
        }
    },
    grid: {
        left: '3%',
        right: '4%',
        bottom: '3%',
        containLabel: true
    },
    xAxis : [
        {
            type : 'category',
            axisLabel:{
                textStyle:{
                    fontSize: 16
                }
            },
            data : ['用户总数', '在线用户', '离线用户', '卡密总数', '已被使用', '未被使用', '代理总数','超级代理','普通代理','程序总数'],
            axisTick: {
                alignWithLabel: true
            }
        }
    ],
    yAxis : [
        {
            type : 'value',
            axisLabel:{
                textStyle:{
                    fontSize: 16
                }
            },
        }
    ],
    series : [
        {
            name:'',
            type:'bar',
            barWidth: '60%',
            itemStyle: {
                normal: {
                    color: function(params) { // build a color map as your need. 
                        var colorList = ['#3398DB', '#3CB371', '#343a40', '#3398DB', '#3CB371', '#343a40', '#6699FF', '#0099CC', '#009999', '#666666'];
                        return colorList[params.dataIndex]
                    },
                    label: { show: true, position: 'top', formatter: '{b}\n{c}',textStyle: {fontSize: 16} }
                }
            },
            data:[
                <?php $con = \core\lib\Db::getInstance();$user_count = $con->select('user','','','','','count(id)'); echo $user_count['0']['count(id)']; ?>, 
                <?php $count = $con->select('user','heart_beat>' . time() . ' and state=2','','','','count(id)'); echo $count['0']['count(id)']; ?>, 
                <?php echo $user_count['0']['count(id)'] - $count['0']['count(id)']; ?>, 
                <?php $card_count = $con->select('card','','','','','count(id)'); echo $card_count['0']['count(id)']; ?>, 
                <?php $count = $con->select('card','used=2','','','','count(id)'); echo $count['0']['count(id)']; ?>, 
                <?php echo $card_count['0']['count(id)'] - $count['0']['count(id)']; ?>, 
                <?php $agent_count = $con->select('menber','power = 10 or power = 11','','','','count(id)'); echo $agent_count['0']['count(id)']; ?>,
                <?php $count = $con->select('menber','power = 10','','','','count(id)'); echo $count['0']['count(id)']; ?>,
                <?php echo $agent_count['0']['count(id)'] - $count['0']['count(id)']; ?>,
                <?php $count = $con->select('software','','','','','count(id)'); echo $count['0']['count(id)']; ?>
            ]
        }
    ]
};
		myChart.setOption(option);
	</script>


<div class="row py-3">
	<div class="col-lg-6">
		<div class="card" >
  <h3 class="card-header"><svg class="icon"  aria-hidden="true"><use xlink:href="#icon-database__eas"></use></svg>&nbsp;服务器信息</h3>
  <div class="card-body">
   <ul class="list-group list-group-flush">
   	<li class="list-group-item">程序版本：<?php  echo APP_VERSION; ?></li>
    <li class="list-group-item">系统信息：<?php echo php_uname(); ?></li>
    <li class="list-group-item">Web服务器：<?php echo $_SERVER['SERVER_SOFTWARE']; ?></li>
    <li class="list-group-item">服务器时间：<?php echo date("Y-m-d H:i:s",time()); ?></li>
    <li class="list-group-item">服务器域名：<?php echo $_SERVER['HTTP_HOST']; ?></li>
    <li class="list-group-item">服务器 IP地址：<?php echo $_SERVER['SERVER_ADDR']; ?></li>
    <li class="list-group-item">服务器 PHP版本：<?php echo PHP_VERSION; ?></li>
    <?php $res = $con->sql('select version()'); ?>
    <li class="list-group-item">服务器 MySQL 版本：<?php echo $res['0']['version()']; ?></li>
    <?php $res = $con->sql("SELECT sum(DATA_LENGTH)+sum(INDEX_LENGTH) FROM information_schema.TABLES where TABLE_SCHEMA='" . \core\lib\Config::get('db.name') . "'"); $res['0']['sum(DATA_LENGTH)+sum(INDEX_LENGTH)'] = $res['0']['sum(DATA_LENGTH)+sum(INDEX_LENGTH)']/1048576;?>
    
    <li class="list-group-item">服务器 MySQL 尺寸：<?php echo $res['0']['sum(DATA_LENGTH)+sum(INDEX_LENGTH)'] . ' M'; ?></li>
  </ul>
  </div>
</div>
	</div>
	
	<div class="col-lg-6">
		<div class="card" >
  <h3 class="card-header"><svg class="icon"  aria-hidden="true"><use xlink:href="#icon-zixun-copy"></use></svg>&nbsp;官方资讯</h3>
  <div class="card-body">
  	<?php
 echo($a['msg']); ?>
  </div>
</div>
	</div>
</div>
</div>
