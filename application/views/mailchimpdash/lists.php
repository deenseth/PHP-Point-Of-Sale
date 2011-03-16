<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/lists.css" />
<br />
<h3><?php echo $this->lang->line('common_mailchimp_dashboard_lists'); ?></h3>
<p><?php echo $this->lang->line('common_mailchimp_dashboard_lists_helper'); ?></p>
<div id='lists'>
    <fieldset id='lists-buttons'>
        <legend><?php echo $this->lang->line('common_mailchimp_dashboard_listbuttons'); ?></legend>
        <? foreach ($lists as $list) { ?>
        <a href="<?=current_url()?>#" class="button" id="button_<?=$list['id']?>"><?=$list['name']?></a>
        <? } ?>
    </fieldset>
    <div id='lists-view'>
    
    </div>
</div>
<?php $this->load->view("partial/footer"); ?>