<?php $this->load->view("partial/header"); ?>
<br />
<h3><?php echo $this->lang->line('common_mailchimp_dashboard'); ?></h3>
<h4><?php echo $this->lang->line('common_mailchimp_dashboard_desc'); ?></h4>
<div id="dashboard-links">
    <ul>
        <li><?=anchor(current_url().'/lists', 'Lists')?></li>
    
    
    </ul>
</div>
<?php $this->load->view("partial/footer"); ?>