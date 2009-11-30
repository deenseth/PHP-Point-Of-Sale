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
		$this->load->model('reports/Summary_sales');
		$tabular_data = array();
		$report_data = $this->Summary_sales->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['sale_date'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']));
		}

		$data = array(
			"title" => $this->lang->line('reports_summary'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)) ,
			"headers" => $this->Summary_sales->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $this->Summary_sales->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->load->view("reports/tabular",$data);

	}
	
	function summary_input()
	{
		$data['report_date_range_simple'] = get_simple_date_ranges();
		$this->load->view("reports/summary_input",$data);	
	}
}
?>