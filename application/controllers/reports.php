<?php
require_once ("secure_area.php");
class Reports extends Secure_area 
{
	function __construct()
	{
		parent::__construct('reports');
		$this->load->language('reports');
		$this->load->helper('report');		
	}
	
	function index()
	{
		$this->load->view("reports/listing",array());	
	}
	
	function summary_sales($start_date, $end_date)
	{
		
	}
	
	function summary_input()
	{
		$data['report_date_range_simple'] = get_simple_date_ranges();
		$this->load->view("reports/summary_input",$data);	
	}
}
?>