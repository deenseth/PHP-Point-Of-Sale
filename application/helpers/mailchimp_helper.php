<?php

function display_email_data($person, $list, $filters)
{
    $CI =& get_instance();
    $persontype = $CI->Person->get_person_type($person->person_id);
    
    if ($filters && substr_count($filters, $persontype)) {
        return '';
    } 
    
    if ($persontype !== 'Person') {
        return display_email_data_for_person($person, $persontype);
    } else {
        $table_data_row='<tr>';
        $table_data_row.='<td width="12%">'.character_limiter($person->last_name,13).'</td>';
        $table_data_row.='<td width="12%">'.character_limiter($person->first_name,13).'</td>';
        $table_data_row.='<td width="24%" class="email">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
        $table_data_row.='<td width="50%" class="action">'
                       .anchor("customers/view/-1/width:350,email:".$person->email, $CI->lang->line('customers_new'),array('class'=>'thickbox left pill button','title'=>$CI->lang->line('customers_update'),'onClick'=>'thickit(this); return false;'))
                       .anchor("suppliers/view/-1/width:360,email:".$person->email, $CI->lang->line('suppliers_new'),array('class'=>'thickbox middle pill button','title'=>$CI->lang->line('suppliers_update'),'onClick'=>'thickit(this); return false;'))
                       .anchor("employees/view/-1/width:650,email:".$person->email, $CI->lang->line('employees_new'),array('class'=>'thickbox middle pill button','title'=>$CI->lang->line('employees_update'),'onClick'=>'thickit(this); return false;'))
                       .'<a class="negative button remove pill right"' 
                       .' onClick="listremove(this)">'
                       .'Remove</a>'
                       .'</td>';
        $table_data_row.='</tr>';
    }
    
    return $table_data_row;
    
}

function display_email_data_for_person($person, $persontype)
{
    $CI =& get_instance();
    
    $controller_name = strtolower($persontype).'s';
    
    switch($persontype) {
        case 'Customer':
            $width = 350;
            break;
        case 'Supplier':
            $width = 360;
            break;
        case 'Employee':
            $width = 650;
            break;
    }
    
    $table_data_row='<tr>';
    $table_data_row.='<td width="13%">'.character_limiter($person->last_name,13).'</td>';
    $table_data_row.='<td width="13%">'.character_limiter($person->first_name,13).'</td>';
    $table_data_row.='<td width="24%" class="email">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
    $table_data_row.='<td width="50%" class="action">'
                   .anchor($controller_name."/view/$person->person_id/width:{$width}", $CI->lang->line($controller_name.'_update'),
                        array('class'=>'thickbox button pill left','title'=>$CI->lang->line($controller_name.'_update'), 
                        'onClick'=>'thickit(this); return false;'))
                   .'<a class="negative button remove pill right"' 
                   .' onClick="listremove(this)">'
                   .'Remove</a>'
                   .'</td>';
    $table_data_row.='</tr>';
    return $table_data_row;
}


function display_campaign_data(array $campaign)
{
    $is_scheduled = $campaign['status'] == 'schedule';
    $was_sent = $campaign['status'] == 'sent';
    if ($campaign['send_time']) {
        $sent = "<span class='info'>Send Time:</span> {$campaign['send_time']}" ;
    } else {
        $sent = "<span class='sent'>Not Scheduled</span>" ;
    }
    $status = $campaign['status'] == 'schedule' ? "Scheduled" : ucfirst($campaign['status']);
    $listLink = $campaign['listname'] == "No" ? $campaign['listname']. ' List' 
                : anchor(base_url().'index.php/mailchimpdash/lists/'.$campaign['list_id'], 
                          $campaign['listname']. ' List', array('target'=>'_blank'));
    $fromName = $campaign['from_name'] == '' ? "(No Name Provided)" : $campaign['from_name'];
    $fromEmail = $campaign['from_email'] == '' ? "(None Email Provided)" : $campaign['from_email'];
    $subject = $campaign['subject'] == '' ? "(No Subject Provided)" : $campaign['subject'];
    
    $html = '<div class="campaign" id="campaign-'.$campaign['id'].'">';
    $html.= '   <div class="campaign-header">';
    $html.= '       <div class="campaign-header-left">' 
            . anchor('https://us2.admin.mailchimp.com/campaigns/wizard/setup?id='.$campaign['web_id'], 
                        $campaign['title'], 
                        array('target'=>'_blank', 'title'=>'Click to Manage')) 
            . ' ('.anchor($campaign['archive_url'], 
                        'View Archive', 
                        array('target'=>'_blank')).')';
    if ($campaign['status'] == 'sent') { 
            $html .= ' ('.anchor(base_url().'index.php/mailchimpdash/report/'.$campaign['id'], 
                        'View Report', 
                        array('target'=>'_blank')).')';
                        }
    $html.= '       </div>';
    $html.= '       <div class="campaign-header-right"><div class="resizer" style="background-image: url('.base_url().'images/plus.png);" onClick="expand(this)" ></div><p>'.$listLink.' | '. ucfirst($campaign['type']) . ' Report | </p></div>';
    $html.= '       <div class="clear"><!-- --></div>';
    $html.= '   </div>';
    $html.= '   <div class="campaign-body">';
    $html.= "       <p class='campaign-body-header'><span class='info'>Created:</span> {$campaign['create_time']} | <span class='info'>Status:</span> {$status} | {$sent} | <span class='info'>Emails Sent To:</span> <span class='sent'>{$campaign['emails_sent']}</span></p>";
    $html.= '       <div class="campaign-body-left">';
    $html.= "           <p class='campaign-body-email-from'>From: \"{$fromName}\" &lt;{$fromEmail}&gt;</p>";
    $html.= "           <p class='campaign-body-email-subject'>Subject: \"{$subject}\"</p>";
    $html.= "           <p class='campaign-body-segment-text'>{$campaign['segment_text']}</p>";
    $html.= '       </div>';
    $html.= '       <div class="campaign-body-right">';
    if (!$was_sent) {
        $html.= '           <div class="button-wrapper"><a class="button pill" onClick="campaignSend(\''.$campaign['id'].'\')">Send Campaign Now</a></div>';
        if ($campaign['status'] != "schedule") {
            $html.= '           <div class="button-wrapper"><a class="button pill" href="'.base_url().'index.php/mailchimpdash/campaignschedule/'.$campaign['id'].'/width:300" onClick="thickit(this); return false;">Schedule Campaign</a></div>';
        }
        $html.= '           <div class="button-wrapper"><a class="button pill" onClick="thickit(this); return false;" href="'.base_url().'/index.php/mailchimpdash/configuretest/'.$campaign['id'].'/width:420,height:300">Send Test Campaign</a></div>';
        if ($campaign['type'] == 'auto' || $campaign['type'] == 'rss') {
            if ($campaign['status'] != 'paused') {
                $html.= '           <div class="button-wrapper"><a class="button pill negative" onClick="campaignPause(\''.$campaign['id'].'\')">Pause Campaign</a></div>';
            } else {
                $html.= '           <div class="button-wrapper"><a class="button pill" onClick="campaignResume(\''.$campaign['id'].'\')">Unpause Campaign</a></div>';
            }
        }
    }
    $html .= '      <div class="button-wrapper"><a class="button pill negative" onClick="campaignDelete(\''.$campaign['id'].'\')">Delete Campaign</a></div>';
    $html.= '       </div>';
    $html.= '       <div class="clear"><!-- --></div>';
    $html.= '   </div>';
    $html.= '</div>';
    return $html; 
}

function campaign_export_script($isGraphical=false)
{
    $base_url = base_url();
    
    if ($isGraphical) {
    $js = <<<ENDJS
<script src="{$base_url}js/jquery.makecssinline.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript" src="{$base_url}js/chartgrabber.js"></script>
<script type="text/javascript">
function export_to_campaign(dom)
{
    var binary = $('#chart')[0].get_img_binary();
    
    $.post('{$base_url}index.php/reports/export',
            {chart: binary},
            function(data){
                $(dom).attr('href', $(dom).attr('href')+data);
                thickit(dom);
            }
            );
    
}
</script>    
ENDJS;
    } else {
    $js = <<<ENDJS
<script src="{$base_url}js/jquery.makecssinline.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
function export_to_campaign(dom)
{
    thickit(dom);    
}
</script>    
ENDJS;
    
    }
    return $js;
}

function campaign_export_button()
{
    $CI =& get_instance();
    if ($key = $CI->Appconfig->get('mc_api_key')) {
        return '<div class="export-button-wrapper"><a class="button pill" href="'.base_url().'index.php/mailchimpdash/charttocampaign/" onClick="export_to_campaign(this); return false;">Export To Campaign</a><div class="clear"><!-- --></div></div>';
    }
}

function add_to_group_button()
{
    $CI =& get_instance();
    if ($key = $CI->Appconfig->get('mc_api_key')) {
        return '<div class="group-add-wrapper"><a class="button pill" href="'.base_url().'index.php/mailchimpdash/groupoptions/1/" onClick="thickit(this); return false;">Add To Existing List Interest Group</a>&nbsp;&nbsp;<a class="button pill" href="'.base_url().'index.php/mailchimpdash/groupoptions/0/" onClick="thickit(this); return false;">Add to New List Interest Group</a><div class="clear"><!-- --></div></div>';
    }
}