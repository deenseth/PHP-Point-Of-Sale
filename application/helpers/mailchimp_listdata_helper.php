<?php

function display_email_data(array $listMember, $list)
{
    $CI =& get_instance();
    
    if ($person = $CI->Person->get_by_email($listMember['email'])) {
        return get_person_data_row($person, null, $list);
    } else {
        
    }
    
}