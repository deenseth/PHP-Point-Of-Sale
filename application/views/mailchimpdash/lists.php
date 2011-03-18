<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/lists.css" />
<script src="<?php echo base_url();?>js/mailchimpdash/lists.js" language="javascript" charset="UTF-8"></script>

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
<fieldset id='lists-options'>
    <legend>Filter by:</legend>
    <div id='lists-options-customers-wrapper'>
        <input type="checkbox" value="0" id="lists-options-customers"></input>
        <label for="lists-options-customers">Customers</label>
    </div>
    <div id='lists-options-suppliers-wrapper'>
        <input type="checkbox" value="0" id="lists-options-suppliers"></input>
        <label for="lists-options-suppliers">Suppliers</label>
    </div>
    <div id='lists-options-employees-wrapper'>
        <input type="checkbox" value="0" id="lists-options-employees"></input>
        <label for="lists-options-employees">Employees</label>
    </div>
</div>

<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>