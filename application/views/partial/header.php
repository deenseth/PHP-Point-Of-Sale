<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $this->config->item('company').' -- '.$this->lang->line('common_powered_by').' PHP Point Of Sale' ?></title>
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos.css" />
	<script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript"></script>

</head>
<body>
<div id="menubar">
	<div id="menubarCompanyInfo">
	<span id="companyTitle"><?php echo $this->config->item('company'); ?></span><br />
	<span style='font-size:8pt;'><?php echo $this->lang->line('common_powered_by').' PHP Point Of Sale'; ?></span>
	</div>
	
	<div id="menubarNavigation">
		<?php
		foreach($allowed_modules as $module_id)
		{
		?>
		<div class="menuItem">
			<a href="<?php echo site_url("$module_id");?>">
			<img src="<?php echo base_url().'images/menubar/'.$module_id.'.gif';?>" border="0" alt="Home Image" /></a><br />
			<a href="<?php echo site_url("$module_id");?>"><?php echo $this->lang->line("module_$module_id") ?></a>
		</div>
		<?php
		}
		?>
		
	</div>
	
	<div id="menubarFooter">
	<?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name! |"; ?>
	<?php echo anchor("home/logout",$this->lang->line("common_logout")); ?>
	</div>

</div>