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
    $html = '<div class="campaign" id="campaign-'.$campaign['id'].'">';
    $html.= '   <div class="campaign-header">';
    $html.= '       <div class="campaign-header-left">' . $campaign['title'] . '</div>';
    $html.= '       <div class="campaign-header-right"><div class="resizer" style="background-image: url('.base_url().'images/plus.png);" onClick="expand(this)" ></div><p>'.$campaign['listname'].' List | '. ucfirst($campaign['type']) . ' Report | </p></div>';
    $html.= '       <div class="clear"><!-- --></div>';
    $html.= '   </div>';
    $html.= '   <div class="campaign-body">';
    
    $html.= '   </div>';
    $html.= '</div>';
    return $html; 
    
    
}