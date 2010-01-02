<?php
//Loads configuration from database into global CI config
function load_config()
{
	$CI =& get_instance();
	foreach($CI->Store->get_info($CI->config->item('store_id')) as $key=>$value)
	{
		$CI->config->set_item($key,$value);
	}
}
?>