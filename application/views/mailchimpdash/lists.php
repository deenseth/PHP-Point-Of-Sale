<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/lists.css" />
<script src="<?php echo base_url();?>js/mailchimpdash/lists.js" language="javascript" charset="UTF-8"></script>
<?php if ($list_id) { ?>
<script type='text/javascript'>
$(document).ready(function(){
	$('#lists-view').slideDown(1000, function() {
	    listPage('<?php echo $list_id?>', 0);
	});
});
</script>
<?php } ?>
<br />
<h3><?php echo $this->lang->line('common_mailchimp_dashboard_lists'); ?></h3>
<p><?php echo $this->lang->line('common_mailchimp_dashboard_lists_helper'); ?></p>
<div id='lists'>
    <fieldset id='lists-buttons'>
        <legend><?php echo $this->lang->line('common_mailchimp_dashboard_listbuttons'); ?></legend>
        <?php foreach ($lists as $list) { ?>
        <a href="<?php echo current_url()?>" class="button" id="button_<?php echo $list['id']?>"><?php echo $list['name']?></a>
        <?php } ?>
    </fieldset>
    <div id='lists-view'>
        <div id="lists-loading"><img id="lists-loading" src="<?php echo base_url()?>images/spinner_small.gif" /></div>
    </div>
</div>
<fieldset id='lists-options'>
    <legend>Filter by:</legend>
    <div id='lists-options-customers-wrapper'>
        <input type="checkbox" <?php echo $filter == 'Customer' ? 'checked' : '' ?> id="lists-options-customers"></input>
        <label for="lists-options-customers">Customers</label>
    </div>
    <div id='lists-options-suppliers-wrapper'>
        <input type="checkbox" <?php echo $filter == 'Supplier' ? 'checked' : '' ?> id="lists-options-suppliers"></input>
        <label for="lists-options-suppliers">Suppliers</label>
    </div>
    <div id='lists-options-employees-wrapper'>
        <input type="checkbox" <?php echo $filter == 'Employer' ? 'checked' : '' ?> id="lists-options-employees"></input>
        <label for="lists-options-employees">Employees</label>
    </div>
    <div id='lists-options-persons-wrapper'>
        <input type="checkbox" <?php echo $filter == 'Person' ? 'checked' : '' ?> id="lists-options-persons"></input>
        <label for="lists-options-persons" title="List subscribers not currently in this system">Subscriber Only</label>
    </div>
</div>

<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>