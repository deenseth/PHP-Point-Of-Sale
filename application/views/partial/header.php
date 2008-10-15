<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title><?php echo $this->config->item('company').' -- '.$this->lang->line('common_powered_by').' PHP Point Of Sale' ?></title>
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos.css" />
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/thickbox.css" />
	<script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/jquery.tablesorter.min.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/manage_functions.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
	<script src="<?php echo base_url();?>js/lang.js.php" type="text/javascript" language="javascript" charset="UTF-8"></script>

</head>
<body>
<div id="menubar">
	<div id="menubar_container">
		<div id="menubar_company_info">
		<span id="company_title"><?php echo $this->config->item('company'); ?></span><br />
		<span style='font-size:8pt;'><?php echo $this->lang->line('common_powered_by').' PHP Point Of Sale'; ?></span>
		</div>
		
		<div id="menubar_navigation">
			<?php
			foreach($allowed_modules as $module_id)
			{
			?>
			<div class="menu_item">
				<a href="<?php echo site_url("$module_id");?>">
				<img src="<?php echo base_url().'images/menubar/'.$module_id.'.gif';?>" border="0" alt="Home Image" /></a><br />
				<a href="<?php echo site_url("$module_id");?>"><?php echo $this->lang->line("module_$module_id") ?></a>
			</div>
			<?php
			}
			?>
		</div>
		
		<div id="menubar_footer">
		<?php echo $this->lang->line('common_welcome')." $user_info->first_name $user_info->last_name! | "; ?>
		<?php echo anchor("home/logout",$this->lang->line("common_logout")); ?>
		</div>
		
		<div id="menubar_date">
		<?php echo date('F d, Y') ?>
		</div>

	</div>
</div>
<div id="content_area_wrapper">
<div id="content_area">