<?php

function display_email_data(array $listMember, $list)
{
    $CI =& get_instance();
    
    $person = $CI->Person->get_by_email($listMember['email']);
    
    $persontype = $CI->Person->get_person_type($person->person_id);
    
    if ($persontype !== 'Person') {
        $controller_name = strtolower($persontype).'s';
        
        $table_data_row='<tr>';
        $table_data_row.='<td width="13%">'.character_limiter($person->last_name,13).'</td>';
        $table_data_row.='<td width="13%">'.character_limiter($person->first_name,13).'</td>';
        $table_data_row.='<td width="24%" class="email">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
        $table_data_row.='<td width="50%" class="action">'
                       .anchor($controller_name."/view/$person->person_id/width:500", $CI->lang->line($controller_name.'_update'),
                            array('class'=>'thickbox button pill left','title'=>$CI->lang->line($controller_name.'_update'), 
                            'onClick'=>'thickit(this); return false;'))
                       .'<a class="negative button remove pill right"' 
                       .' onClick="listremove(this)">'
                       .'Remove</a>'
                       .'</td>';
        $table_data_row.='</tr>';
    } else {
        $table_data_row='<tr>';
        $table_data_row.='<td width="12%">'.character_limiter($person->last_name,13).'</td>';
        $table_data_row.='<td width="12%">'.character_limiter($person->first_name,13).'</td>';
        $table_data_row.='<td width="24%" class="email">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
        $table_data_row.='<td width="50%" class="action">'
                       .anchor("customers/view/-1/width:500,email:".$person->email, $CI->lang->line('customers_new'),array('class'=>'thickbox left pill button','title'=>$CI->lang->line('customers_update'),'onClick'=>'thickit(this); return false;'))
                       .anchor("suppliers/view/-1/width:500email:".$person->email, $CI->lang->line('suppliers_new'),array('class'=>'thickbox middle pill button','title'=>$CI->lang->line('suppliers_update'),'onClick'=>'thickit(this); return false;'))
                       .anchor("employees/view/-1/width:500,email:".$person->email, $CI->lang->line('employees_new'),array('class'=>'thickbox middle pill button','title'=>$CI->lang->line('employees_update'),'onClick'=>'thickit(this); return false;'))
                       .'<a class="negative button remove pill right"' 
                       .' onClick="listremove(this)">'
                       .'Remove</a>'
                       .'</td>';
        $table_data_row.='</tr>';
    }
    
    return $table_data_row;
    
}