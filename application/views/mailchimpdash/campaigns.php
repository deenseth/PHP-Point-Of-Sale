<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/campaigns.css" />
<script src="<?php echo base_url();?>js/mailchimpdash/campaigns.js" language="javascript" charset="UTF-8"></script>
<br />
<h2>Campaigns</h2>
<? foreach ($campaigns as $campaign) { ?>
<?=display_campaign_data($campaign)?>
<? } ?>
<?php $this->load->view("partial/footer"); ?>