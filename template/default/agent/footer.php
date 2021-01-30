<?php if(!defined('BX_ROOT')) {exit();} ?>
 </div>
</div>

     <script src="<?php echo __URL__; ?>public/static/js/popper.min.js" type="text/javascript" charset="utf-8"></script>
     <script src="<?php echo __URL__; ?>public/static/js/bootstrap.min.js"></script>
	 <script src="<?php echo __URL__; ?>public/static/js/function.js" type="text/javascript" charset="utf-8"></script>
	 <script src="<?php echo __URL__; ?>public/static/plugin/layer/layer.js" type="text/javascript" charset="utf-8"></script>
	 <!-- layer style -->
	 <link rel="stylesheet" type="text/css" href="<?php echo __URL__; ?>public/static/plugin/layer/style.css"/>
	 <script src="<?php echo __URL__; ?>public/static/plugin/FileSaver/FileSaver.min.js" type="text/javascript" charset="utf-8"></script>
	 <script src="<?php echo __URL__; ?>public/static/plugin/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>
	 <script type="text/javascript">
	 	lay('.laydate').each(function(){
			laydate.render({
	 			elem: this,
	 			trigger: 'click',
	 			type: 'datetime'
	 		});
	 	}); 
	 </script>
	 
	
	
	
     <!--loading-->
     <div class="colorful_loading_frame">
     <div class="colorful_loading"><i class="rect1"></i><i class="rect2"></i><i class="rect3"></i><i class="rect4"></i><i class="rect5"></i></div>
     </div>
     <?php do_action('agent_footer'); ?>
	</body>
	
	
</html>
