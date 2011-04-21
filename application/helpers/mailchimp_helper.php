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
        $table_data_row='<tr id="person-'.$person->person_id.'">';
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
    
    $table_data_row='<tr id="person-'.$person->person_id.'">';
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