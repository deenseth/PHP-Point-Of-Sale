<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/lists.css" />
<script src="<?php echo base_url();?>js/mailchimpdash/lists.js" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
function listremove(obj)
{
	var emailval = $(obj).parent('td').parent('tr').find('td.email a').attr('href').replace(/mailto:/, '');
	var listidval = $('#listid').val();
	$.post('<?=base_url()?>index.php/mailchimpdash/listremoveajax',
			{email: emailval, 
			 listid: listidval 
			},
			function(response){
				if (response.success) {
				  set_feedback(response.message, 'success_message', false);
				  $(obj).parent('td').parent('tr').fadeOut(250);
			  } else {
				  set_feedback(response.message, 'error_message', true);
			  }
			},
		  "json"
	  );
	
}

</script>
<br />
<h3><?php echo $this->lang->line('common_mailchimp_dashboard_lists'); ?></h3>
<p><?php echo $this->lang->line('common_mailchimp_dashboard_lists_helper'); ?></p>
<div id='lists'>
    <fieldset id='lists-buttons'>
        <legend><?php echo $this->lang->line('common_mailchimp_dashboard_listbuttons'); ?></legend>
        <? foreach ($lists as $list) { ?>
        <a href="<?=current_url()?>" class="button" id="button_<?=$list['id']?>"><?=$list['name']?></a>
        <? } ?>
    </fieldset>
    <div id='lists-view'>
        <div id="lists-loading"><img id="lists-loading" src="<?=base_url()?>images/spinner_small.gif" /></div>
    </div>
</div>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>