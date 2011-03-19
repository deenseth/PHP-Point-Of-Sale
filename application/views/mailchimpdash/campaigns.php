<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/campaigns.css" />
<script src="<?php echo base_url();?>js/mailchimpdash/campaigns.js" language="javascript" charset="UTF-8"></script>
<br />
<h2>Campaigns</h2>
<div id="nav-bar">
    <div id="button-back">
    <? if ($page > 1) { ?>
    <a class="button pill" href="<?=base_url()?>index.php/mailchimpdash/campaigns/<?=$page-1?>">Back</a>
    <? } else { ?>
    &nbsp;
    <? } ?>
    </div>
    <div id="countinfo">
        <p>Viewing <?=$slice+1?> through <?=$slice + 25 >= $total ? $total : $slice + 25?> of <?=$total?> campaigns.</p>
    </div>
    <div id="button-next">
    <? if ($slice + 25 < $total) { ?>
    <a class="button pill" href="<?=base_url()?>index.php/mailchimpdash/campaigns/<?=$page+1?>">Next</a>
    <?  }else { ?>
    &nbsp;
    <? } ?>
    </div>
    <div class="clear"><!--  --></div>
</div>
<? foreach ($campaigns as $campaign) { ?>
<?=display_campaign_data($campaign)?>
<? } ?>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>