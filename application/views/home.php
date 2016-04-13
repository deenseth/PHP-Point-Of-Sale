<?php $this->load->view("partial/header"); ?>
<?php 

	$icons = array('customers'=>'group', 
		'items'=>'cube', 
		'item_kits'=>'cubes', 
		'suppliers'=>'truck', 
		'reports'=>'bar-chart-o', 
		'receivings'=>'inbox', 
		'sales'=>'shopping-cart', 
		'employees'=>'user',
		'giftcards'=>'credit-card',
		'config'=>'cogs');

?>
<div class="panel panel-default">
	<ul class="list-group">
		<?php foreach($allowed_modules->result() as $module) {  ?>

			<a class="list-group-item" href="<?php echo site_url("$module->module_id");?>">
				<i class="launch-icon fa fa-<?php echo isset($icons[$module->module_id]) ? $icons[$module->module_id] : ''; ?> fa-3x"></i>
				<h4><?php echo $this->lang->line("module_".$module->module_id) ?></h4>
				<?php echo $this->lang->line('module_'.$module->module_id.'_desc');?>	
			</a>
		<?php } ?>
	</ul>
</div>
<?php $this->load->view("partial/footer"); ?>