<?php
/*
Gets the html table to manage people.
*/
function get_people_manage_table($people,$controller)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table">';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thead><tr>';
	foreach($headers as $header)
	{
		$table.="<th>$header</th>";
	}
	$table.='</tr></thead><tbody>';
	$table.=get_people_manage_table_data_rows($people,$controller);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the people.
*/
function get_people_manage_table_data_rows($people,$controller)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($people->result() as $person)
	{
		$table_data_rows.=get_person_data_row($person,$controller);
	}
	
	if($people->num_rows()==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('common_no_persons_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}

function get_person_data_row($person,$controller)
{
	$CI =& get_instance();
	$controller_name=$CI->uri->segment(1);
	$width = $controller->_get_form_width();
	$height = $controller->_get_form_height();

	$table_data_row='<tr>';
	$table_data_row.="<td width='5'><input type='checkbox' id='person_$person->person_id' value='".$person->person_id."'/></td>";
	$table_data_row.='<td width="20%">'.character_limiter($person->last_name,13).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($person->first_name,13).'</td>';
	$table_data_row.='<td width="30%">'.mailto($person->email,character_limiter($person->email,22)).'</td>';
	$table_data_row.='<td width="20%">'.character_limiter($person->phone_number,13).'</td>';		
	$table_data_row.='<td width="5%">'.anchor($controller_name."/view/$person->person_id/width:$width/height:$height", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line($controller_name.'_update'))).'</td>';		
	$table_data_row.='</tr>';
	
	return $table_data_row;
	
	
}
?>