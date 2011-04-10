<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/repeatablecampaigns.css" />
<br/><br/>
<h1>Repeatable Campaigns</h1>

<? if ($daily) { ?>
<div id="daily" class="campaigns">
<h3>Daily Campaigns</h3>

<? foreach ($daily as $campaign) { ?>
	<?$this->load->view('partial/repeatablecampaign', array('campaign'=>$campaign))?>
<? } ?>

</div>
<? } ?>

<? if ($weekly) { ?>
<div id="weekly" class="campaigns">
<h3>Weekly Campaigns</h3>

<? foreach ($weekly as $campaign) { ?>
	<?$this->load->view('partial/repeatablecampaign', array('campaign'=>$campaign))?>
<? } ?>

</div>
<? } ?>

<? if ($monthly) { ?>
<div id="weekly" class="campaigns">
<h3>Monthly Campaigns</h3>

<? foreach ($monthly as $campaign) { ?>
	<?$this->load->view('partial/repeatablecampaign', array('campaign'=>$campaign))?>
<? } ?>

</div>
<? } ?>
<div id="feedback_bar"></div>
<br/><br/>
<?php $this->load->view("partial/footer"); ?>