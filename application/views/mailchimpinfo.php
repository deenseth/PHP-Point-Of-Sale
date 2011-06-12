<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <base href="<?php echo base_url();?>" />
    <link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpinfo.css" />
    <title><?php echo $this->config->item('company').' -- '.$this->lang->line('common_powered_by').' PHP Point Of Sale' ?></title>
</head>
<body>
    <div id="wrapper">
		<h3 id='why'>Why MailChimp?</h3>
		<p><a href="http://mailchimp.com">MailChimp</a> is an email marketing tool that can be used to 
		improve your communications with customers, vendors, and employees.</p>
		
		<h3>Integration Perks</h3>
		<p>Integrate your point of sale solution with MailChimp to take advantage of the following:</p>
		<ul>
		    <li><b>Intelligent list management:</b> Build lists based on your customers, suppliers, and employees.</li>
		</ul>
		
		<h3>How To Use</h3>
		<p><i>If you are a MailChimp customer already</i>, simply <a href="http://admin.mailchimp.com/account/api-key-popup">click here</a> 
		and enter your MailChimp API key on the config page.</p><br/>
		<p><i>Don't have an API key?</i> <a href="http://mailchimp.com">Go to Mailchimp.com and learn more</a>.</p>
	</div>
</body>
</html>