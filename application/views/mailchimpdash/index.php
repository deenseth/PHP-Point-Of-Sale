<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/index.css" />
<br />
<h3><?php echo $this->lang->line('common_mailchimp_dashboard'); ?></h3>
<h4><?php echo $this->lang->line('common_mailchimp_dashboard_desc'); ?></h4>
<div id="dashboard-links">
    <div class="dashboard-link">
        <?=anchor(current_url().'/lists', '<img src="'.base_url().'/images/chimpsmile.jpeg" alt=""/>')?>
        <p><?=anchor(current_url().'/lists', 'List Management')?></p>
        <div class="clear"><!--  --></div>
    </div>
    <div class="dashboard-link">
        <?=anchor(current_url().'/campaigns', '<img src="'.base_url().'/images/campaign.png" alt=""/>')?>
        <p><?=anchor(current_url().'/campaigns', 'Campaign Management')?></p>
        <div class="clear"><!--  --></div>
    </div>
    <div class="dashboard-link">
        <?=anchor(current_url().'/repeatablecampaigns', '<img src="'.base_url().'/images/chimp_clock.gif" alt=""/>')?>
        <p><?=anchor(current_url().'/repeatablecampaigns', 'Repeatable Campaign Management')?></p>
        <div class="clear"><!--  --></div>
    </div>
</div>
<?php $this->load->view("partial/footer"); ?>