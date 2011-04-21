<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/index.css" />
<br />
<h3><?php echo $this->lang->line('common_mailchimp_dashboard'); ?></h3>
<h4><?php echo $this->lang->line('common_mailchimp_dashboard_desc'); ?></h4>
<div id="dashboard-links">
    <div class="dashboard-link">
        <?php echo anchor(current_url().'/lists', '<img src="'.base_url().'/images/chimpsmile.jpeg" alt=""/>')?>
        <p><?php echo anchor(current_url().'/lists', 'List Management')?></p>
        <div class="clear"><!--  --></div>
    </div>
</div>
<?php $this->load->view("partial/footer"); ?>