<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<style type="text/css">
<!--
#container
{
	position:relative;
	margin-left:auto;margin-right:auto;
	margin-top:20px;
	width:360px;
}

#top
{
	position:relative;
	width:100%;
	height:20px;
	padding:2px;
	background-color:#005B7F;
	text-align:center;
	font-family:Verdana;
	color:white;
	font-size:12pt;
}

#login_form
{
	position:relative;
	width:100%;
	height:230px;
	padding:2px;	
	font-family:Verdana;
	color:white;
	font-size:10pt;
	background-color:#A7A7A7;
}

#welcome_message
{
	text-align:center;
	margin-top:10px;
	margin-bottom:20px;
}

.error
{
	margin:0 auto;
	border:3px solid #d3153b;
	background-color:#fbe6f2;
	padding:5px;
	width:80%;
	text-align:center;
	font-size:18px;
	margin-bottom:20px;
	
}

.form_field_label
{
	float:left;
	margin-left:20px;
	width:30%;
}

.form_field
{
	float:left;
	width:30%;
}

#submit_button
{
	position:absolute;
	bottom:60px;
	right:60px;
}

-->
</style>
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