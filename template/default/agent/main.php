<?php if(!defined('BX_ROOT')) {exit();} ?>
<div  class="main container-fluid py-3">
	<?php do_action('agent_index'); ?>
	<?php echo $config['agent_bulletin']; ?>
</div>