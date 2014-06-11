<?php $this->load->view("partial/header"); ?>
<h1><?php echo $this->lang->line('common_welcome_message'); ?></h1>
<div class="panel panel-default">
	<div class="panel-body">
		<?php 
		$modules = $allowed_modules->result();
		$rows = array_chunk($modules, 3); ?>
		<? for($j=0; $j < count($rows); $j++) {  ?>
				<div class="row">
					<?php for($i=0; $i < count($rows[$j]); $i++) { 
						$module = $rows[$j][$i]; ?>
						<div class="col-xs-6 col-sm-4">
							<a href="<?php echo site_url("$module->module_id");?>">
							<img src="<?php echo base_url().'images/menubar/'.$module->module_id.'.png';?>" border="0" alt="Menubar Image" /></a><br />
							<a href="<?php echo site_url("$module->module_id");?>"><?php echo $this->lang->line("module_".$module->module_id) ?></a>
						</div>
					<?php } ?>
				</div>
		<?php } ?>
	</div>
</div>
<?php $this->load->view("partial/footer"); ?>