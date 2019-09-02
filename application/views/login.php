<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/bootstrap.css" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/bootstrap-select.css" />
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/bootstrap-theme.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PHP Point Of Sale <?php echo $this->lang->line('login_login'); ?></title>
<script src="<?php echo base_url();?>js/jquery-1.10.2.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>js/bootstrap.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function()
{
	$("#login_form input:first").focus();
});
</script>
</head>
<body>
<h1><?php echo $this->config->item('company'); ?></h1>
<?php echo form_open('login') ?>
<div id="container">
<?php echo validation_errors(); ?>

	<div class="panel panel-default">
		<div class="panel-heading">Login</div>
		<div class="panel-body">
			<div class="form-group">
				<?php echo form_input(array(
				'class'=>'form-control',
				'name'=>'username', 
				'value'=>set_value('username'),
				'size'=>'20')); ?>
			</div>
			<div class="form-group">
				<?php echo form_password(array(
				'class'=>'form-control',
				'name'=>'password', 
				'value'=>set_value('password'),
				'size'=>'20')); ?>
			</div>
			<?php echo form_submit(array(
				'id'=>'loginButton',
				'value'=>'GO',
				'class'=>'form-control btn btn-primary')); ?>
		</div>
	</div>
<?php echo form_close(); ?>
</body>
</html>
