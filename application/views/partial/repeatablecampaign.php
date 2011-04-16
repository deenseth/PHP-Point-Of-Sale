<div class="campaign" id="campaign-<?php echo $campaign->campaign_id?>">
	<div class="name">
	<h4><?php echo $campaign->title?></h4>
	</div>
	<div class="actions">
    <a href="<?php echo base_url()?>index.php/mailchimpdash/editrepeatablecampaign/<?php echo $campaign->campaign_id?>" onClick="thickit(this); return false;" class="button pill left">Edit Campaign</a><a href="javascript:void(0)" onClick="deleteCampaign(<?php echo $campaign->campaign_id?>); return false;" class="button pill right bad">Delete Campaign</a>
    </div>
    <div class="clear"><!--  --></div>
</div>