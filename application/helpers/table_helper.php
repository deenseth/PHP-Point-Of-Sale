<?php
/*
Gets the html table to manage customers based on an array of customer objects.
*/
function get_customer_manage_table($customers)
{
	$CI =& get_instance();
	$table='<table class="tablesorter" id="sortable_table"><thead>';
	
	$headers = array('<input type="checkbox" id="select_all" />', 
	$CI->lang->line('common_last_name'),
	$CI->lang->line('common_first_name'),
	$CI->lang->line('common_email'),
	$CI->lang->line('common_phone_number'),
	'&nbsp');
	
	$table.='<thread><tr>';
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
		$table_data_rows.="<td><input type='checkbox' id='customer_$customer->id' value='".$customer->id."'/></td>";
		$table_data_rows.="<td>$customer->last_name</td>";
		$table_data_rows.="<td>$customer->first_name</td>";
		$table_data_rows.='<td>'.mailto($customer->email).'</td>';
		$table_data_rows.='<td>'.$customer->phone_number.'</td>';		
		$table_data_rows.='<td>'.anchor("customers/view/$customer->id", $CI->lang->line('common_edit'),array('class'=>'thickbox')).'</td>';		
		$table_data_rows.='</tr>';
	}
	
	if(count($customers)==0)
	{
		$table_data_rows.="<tr><td colspan='6'><div class='warning_message' style='text-align:center;'>".$CI->lang->line('customer_no_customers_to_display')."</div></tr></tr>";
	}
	
	return $table_data_rows;


}
?>