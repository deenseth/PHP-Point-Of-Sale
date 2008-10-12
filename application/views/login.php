<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/login.css" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>PHP Point Of Sale <?php echo $this->lang->line('login_login'); ?></title>
</head>
<body>
<?php echo form_open('login') ?>
<div id="container">
<?php echo $this->validation->error_string; ?>

	<div id="top">
	<?php echo $this->lang->line('login_login'); ?>
	</div>
	<div id="login_form">
		<div id="welcome_message">
		<?php echo $this->lang->line('login_welcome_message'); ?>
		</div>
		
		<div class="form_field_label"><?php echo $this->lang->line('login_username'); ?>: </div>
		<div class="form_field"><?php echo form_input('username', $this->validation->username); ?></div>

		<div class="form_field_label"><?php echo $this->lang->line('login_password'); ?>: </div>
		<div class="form_field"><?php echo form_password('password', $this->validation->password); ?></div>
		
		<div id="submit_button">
		<?php echo form_submit('loginButton','Go'); ?>
		</div>
	</div>
</div>
<?php echo form_close(); ?>
</body>
</html>