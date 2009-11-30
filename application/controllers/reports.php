<?php
require_once ("Secure_Area.php");
class Reports extends Secure_Area 
{
	function __construct()
	{
		parent::__construct('reports');
	}
	
	function index()
	{
		$this->load->helper('report');

		$data = array();
		$data['report_date_range_simple'] = get_simple_date_ranges();
		$data['report_date_range_simple_selected'] = date('Y-m-d') . '|' . date('Y-m-d');
		
		$data['report_date_range_custom'] = array();
		$this->load->view("reports/report",$data);	
	}
	
	function summary()
	{
	
		$this->load->view("reports/report",$data);
	}
}
?>