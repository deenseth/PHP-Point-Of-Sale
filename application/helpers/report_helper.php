<?php
function get_simple_date_ranges()
{
		$CI =& get_instance();
		$today =  date('Y-m-d');
		$yesterday = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-1,date("Y")));
		$seven_days_ago = date('Y-m-d', mktime(0,0,0,date("m"),date("d")-7,date("Y")));
		$start_of_this_month = date('Y-m-d', mktime(0,0,0,date("m"),1,date("Y")));
		$end_of_this_month = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
		$start_of_last_month = date('Y-m-d', mktime(0,0,0,date("m")-1,1,date("Y")));
		$end_of_last_month = date('Y-m-d',strtotime('-1 second',strtotime('+1 month',strtotime((date('m') - 1).'/01/'.date('Y').' 00:00:00'))));
		$start_of_this_year =  date('Y-m-d', mktime(0,0,0,1,1,date("Y")));
		$end_of_this_year =  date('Y-m-d', mktime(0,0,0,12,31,date("Y")));
		$start_of_last_year =  date('Y-m-d', mktime(0,0,0,1,1,date("Y")-1));
		$end_of_last_year =  date('Y-m-d', mktime(0,0,0,12,31,date("Y")-1));
		$start_of_time =  date('Y-m-d', 0);

		return array(
			$today. '|' . $today 								=> $CI->lang->line('reports_today'),
			$yesterday. '|' . $yesterday						=> $CI->lang->line('reports_yesterday'),
			$seven_days_ago. '|' . $today 						=> $CI->lang->line('reports_last_7'),
			$start_of_this_month . '|' . $end_of_this_month		=> $CI->lang->line('reports_this_month'),
			$start_of_last_month . '|' . $end_of_last_month		=> $CI->lang->line('reports_last_month'),
			$start_of_this_year . '|' . $end_of_this_year	 	=> $CI->lang->line('reports_this_year'),
			$start_of_last_year . '|' . $end_of_last_year		=> $CI->lang->line('reports_last_year'),
			$start_of_time . '|' . 	$today						=> $CI->lang->line('reports_all_time'),
		);
}