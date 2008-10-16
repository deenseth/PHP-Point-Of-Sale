<?php
/*
Gets the html table to manage customers based on an array of customer objects.
*/
function get_customer_manage_table($customers)
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
	$table.=get_customer_manage_table_data_rows($customers);
	$table.='</tbody></table>';
	return $table;
}

/*
Gets the html data rows for the customers based on an array of customer objects.
*/
function get_customer_manage_table_data_rows($customers)
{
	$CI =& get_instance();
	$table_data_rows='';
	
	foreach($customers as $customer)
	{
		$table_data_rows.='<tr>';
		$table_data_rows.="<td width='5'><input type='checkbox' id='customer_$customer->id' value='".$customer->id."'/></td>";
		$table_data_rows.='<td width="20%">'.character_limiter($customer->last_name,13).'</td>';
		$table_data_rows.='<td width="20%">'.character_limiter($customer->first_name,13).'</td>';
		$table_data_rows.='<td width="30%">'.mailto($customer->email,character_limiter($customer->email,22)).'</td>';
		$table_data_rows.='<td width="20%">'.character_limiter($customer->phone_number,13).'</td>';		
		$table_data_rows.='<td width="5%">'.anchor("customers/view/$customer->id/width:300/height:550", $CI->lang->line('common_edit'),array('class'=>'thickbox','title'=>$CI->lang->line('customer_update_customer'))).'</td>';		
		$table_data_rows.='</tr>';
	}
	
	if(count($customers)==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='padding:7px;'>".$CI->lang->line('customer_no_customers_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;
}
?>