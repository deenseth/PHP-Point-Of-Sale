<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>TITLE</title>
	<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/phppos.css" />
	<script src="<?php echo base_url();?>js/jquery-1.2.6.min.js" type="text/javascript" language="javascript"></script>

</head>
<body>
<div id="menubar">
	<div id="menubarCompanyInfo">
	<span id="companyTitle"><?php echo "cfg_company"; ?></span><br />
	<span style='font-size:8pt;'><?php echo "lang->poweredBy".' PHP Point Of Sale'; ?></span>
	</div>
	
	<div id="menubarNavigation">
		<div class="menuItem">
		<a href="home.php" target="mainframe"><img src="<?php echo base_url();?>/images/menubar/home.gif" alt="Home Image" /></a><br />
		<a href="home.php" target="mainframe"><?php echo "lang->home"; ?></a>
		</div>
		
	</div>
	
	<div id="menubarFooter">
	<?php echo "lang->welcome userLoginName! |"; ?>
	<a target="_parent" href="logout.php"><?php 'LOGOUT'?></a>
	</div>

</div>