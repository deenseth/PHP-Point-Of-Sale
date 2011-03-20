<?php $this->load->view("partial/header"); ?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/mailchimpdash/reports.css" />
<br/>
<h2><?=$campaign['title']?> | Campaign Report</h2>
<div id="report">
    <div id="report-stat-wrapper">
        <table id="report-stats">
            <tr>
                <th colspan="2">Campaign Totals</th>
            </tr>
            <tbody>    
                <? foreach ($campaignStats as $name=>$val) { ?>
                <? if (in_array($name, array('absplit', 'timewarp'))) { continue; } ?>
                <tr class="<?=++$counter % 2 == 0 ? 'odd' : 'even'?>">
                    <td class="title"><?=ucwords(str_replace('_', ' ', $name))?></td>
                    <td class="value"><?=$val?></td>
                </tr>
                <? } ?>
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
                
                <? foreach ($drilldownReportData as $title=>$data) { ?>
                <tr class="<?=$counter2++ % 2 == 0 ? 'odd' : ''?>">
                    <td class="title"><?=anchor(base_url().'index.php/mailchimpdash/lists/'.$listid.'/'.$campaign['id'].'/'.($title == 'None' ? 'Person' : $title ), $title, array('target'=>'_blank'))?></td>
                    <? foreach ($data as $kind=>$value) { ?>
                    <td><?=$value ? $value : 0?></td>
                    <? } ?>
                </tr>
                <? } ?>
            </tbody>
            
        </table>
    </div>
    <div class="clear"><!--  --></div>
    <div id="report-extras">
        <? if ($campaignAdvice) { ?>
        <h3>Advice</h3><br/>
        <div id="advice">
        <? foreach ($campaignAdvice as $advice) { ?>
            <p class="<?=$advice['type']?>"><?=$advice['msg']?></p>
        <? } ?>
        </div>
        <? } ?>
        <p><?=anchor(base_url().'index.php/mailchimpdash/lists/'.$listid.'/'.$campaign['cid'], 'View All Campaign Recipients', array('target'=>'_blank'))?></p>
        <p id="vip"><a href="<?=$vipReport['url']?>" target="_blank">View Your VIP Report</a>
        <? if ($vipReport['password']) { ?>
        (Your password is <span id="pass"><?=$vipReport['password']?></span>)
        <? } ?>
        </p>
    </div>
</div>
<br/>
<?php $this->load->view("partial/footer"); ?>