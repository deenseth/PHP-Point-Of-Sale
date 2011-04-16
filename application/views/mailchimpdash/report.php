<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/reports.css" />
<br/>
<h2><?php echo $campaign['title']?> | Campaign Report</h2>
<div id="report">
    <div id="report-stat-wrapper">
        <table id="report-stats">
            <tr>
                <th colspan="2">Campaign Totals</th>
            </tr>
            <tbody>    
                <?php foreach ($campaignStats as $name=>$val) { ?>
                <?php if (in_array($name, array('absplit', 'timewarp'))) { continue; } ?>
                <tr class="<?php echo ++$counter % 2 == 0 ? 'odd' : 'even'?>">
                    <td class="title"><?php echo ucwords(str_replace('_', ' ', $name))?></td>
                    <td class="value"><?php echo $val?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div id="report-drilldown-wrapper"> 
        <table id="report-drilldown">
            <tr>
                <th id="report-drilldown-title" colspan="5">Campaign Drilldown</th>
            </tr>
            <tr id="report-drilldown-labels">
                <th></th>
                <th>Sent</th>
                <th>Soft Bounces</th>
                <th>Hard Bounces</th>
                <th>Unsubscribes</th>
            </tr>
            <tbody>
                
                <?php foreach ($drilldownReportData as $title=>$data) { ?>
                <tr class="<?php echo $counter2++ % 2 == 0 ? 'odd' : ''?>">
                    <td class="title"><?php echo anchor(base_url().'index.php/mailchimpdash/lists/'.$listid.'/'.$campaign['id'].'/'.($title == 'None' ? 'Person' : $title ), $title, array('target'=>'_blank'))?></td>
                    <?php foreach ($data as $kind=>$value) { ?>
                    <td><?php echo $value ? $value : 0?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
            
        </table>
    </div>
    <div class="clear"><!--  --></div>
    <div id="report-extras">
        <?php if ($campaignAdvice) { ?>
        <h3>Advice</h3><br/>
        <div id="advice">
        <?php foreach ($campaignAdvice as $advice) { ?>
            <p class="<?php echo $advice['type']?>"><?php echo $advice['msg']?></p>
        <?php } ?>
        </div>
        <?php } ?>
        <p><?php echo anchor(base_url().'index.php/mailchimpdash/lists/'.$listid.'/'.$campaign['cid'], 'View All Campaign Recipients', array('target'=>'_blank'))?></p>
        <p id="vip"><a href="<?php echo $vipReport['url']?>" target="_blank">View Your VIP Report</a>
        <?php if ($vipReport['password']) { ?>
        (Your password is <span id="pass"><?php echo $vipReport['password']?></span>)
        <?php } ?>
        </p>
    </div>
</div>
<br/>
<?php $this->load->view("partial/footer"); ?>