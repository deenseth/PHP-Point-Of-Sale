<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/repeatablecampaigns.css" />
<script type="text/javascript">

function deleteCampaign(campaign_id)
{
	if (confirm('Are you sure you want to delete this repeatable campaign?')) {
		$.post('<?=base_url()?>index.php/mailchimpdash/deleterepeatable/'+campaign_id,
				{},
				function(data){
					if (typeof(data) != 'object') {
						var response = JSON.parse(data);
					} else {
						var response = data;
					}
					if (response.success) {
					  set_feedback(response.message, 'success_message', false);
					  $(obj).parent('td').parent('tr').fadeOut(250);
				  } else {
					  set_feedback(response.message, 'error_message', true);
				  }
				},
				'json');

		$('#campaign-'+campaign_id).remove();
		return false;
	}
}

</script>
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