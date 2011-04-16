<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/campaigns.css" />
<script src="<?php echo base_url();?>js/mailchimpdash/campaigns.js" language="javascript" charset="UTF-8"></script>
<br />
<h2>Campaigns</h2>
<div id="nav-bar">
    <div id="button-back">
    <?php if ($page > 1) { ?>
    <a class="button pill" href="<?php echo base_url()?>index.php/mailchimpdash/campaigns/<?php echo $page-1?>">Back</a>
    <?php } else { ?>
    &nbsp;
    <?php } ?>
    </div>
    <div id="countinfo">
        <p>Viewing <?php echo $slice+1?> through <?php echo $slice + 25 >= $total ? $total : $slice + 25?> of <?php echo $total?> campaigns.</p>
    </div>
    <div id="button-next">
    <?php if ($slice + 25 < $total) { ?>
    <a class="button pill" href="<?php echo base_url()?>index.php/mailchimpdash/campaigns/<?php echo $page+1?>">Next</a>
    <?php  }else { ?>
    &nbsp;
    <?php } ?>
    </div>
    <div class="clear"><!--  --></div>
</div>
<?php foreach ($campaigns as $campaign) { ?>
<div class="campaign-wrapper" id="campaign-<?php echo $campaign['id']?>"></div>
<?php } ?>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>