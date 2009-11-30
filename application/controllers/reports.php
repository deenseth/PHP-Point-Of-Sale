<?php
require_once ("secure_area.php");
class Reports extends Secure_area 
{
	function __construct()
	{
		parent::__construct('reports');
		$this->load->helper('report');		
	}
	
	//Initial report listing screen
	function index()
	{
		$this->load->view("reports/listing",array());	
	}
	
	//Input for all the summary reports. (see routes.php to see that all summary reports route here)
	function summary_input()
	{
		$data['report_date_range_simple'] = get_simple_date_ranges();
		$this->load->view("reports/summary_input",$data);	
	}
	
	//Summary sales report
	function summary_sales($start_date, $end_date)
	{
		$this->load->model('reports/Summary_sales');
		$model = $this->Summary_sales;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array($row['sale_date'], to_currency($row['subtotal']), to_currency($row['total']), to_currency($row['tax']));
		}

		$data = array(
			"title" => $this->lang->line('reports_sales_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)) ,
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->load->view("reports/tabular",$data);
	}
	
	//Summary brands report
	function summary_brands($start_date, $end_date)
	{
		$this->load->model('reports/Summary_brands');
		$model = $this->Summary_brands;
		$tabular_data = array();
		$report_data = $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date));
		
		foreach($report_data as $row)
		{
			$tabular_data[] = array();
		}

		$data = array(
			"title" => $this->lang->line('reports_brands_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)) ,
			"headers" => $model->getDataColumns(),
			"data" => $tabular_data,
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->load->view("reports/tabular",$data);
	}

}
?>