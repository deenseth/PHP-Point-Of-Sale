<?php
//Loads configuration from database into global CI config
function load_config()
{
	$CI =& get_instance();
	
	//get the store_id based on $_SERVER['HTTP_HOST']
	$store_info = $CI->Store_lookup->get_info(isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https' : 'http' . '://'. $_SERVER['HTTP_HOST']);
	
	if (isset($store_info->store_id))
	{
		$CI->config->set_item('store_id', $store_info->store_id);
	}
	
	foreach($CI->Store->get_info($CI->config->item('store_id')) as $key=>$value)
	{
		$CI->config->set_item($key,$value);
	}
}
?>