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

		$data = array(
			"title" => $this->lang->line('reports_sales_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);
		$this->load->view("reports/tabular",$data);
	}
	
	//Summary categories report
	function summary_categories($start_date, $end_date)
	{
		$this->load->model('reports/Summary_categories');
		$model = $this->Summary_categories;
		$data = array(
			"title" => $this->lang->line('reports_categories_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);
		
		$this->load->view("reports/tabular",$data);
	}
	
	//Summary customers report
	function summary_customers($start_date, $end_date)
	{
		$this->load->model('reports/Summary_customers');
		$model = $this->Summary_customers;
		$data = array(
			"title" => $this->lang->line('reports_customers_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->load->view("reports/tabular",$data);
	}
	
	//Summary items report
	function summary_items($start_date, $end_date)
	{
		$this->load->model('reports/Summary_items');
		$model = $this->Summary_items;
		$data = array(
			"title" => $this->lang->line('reports_items_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->load->view("reports/tabular",$data);
	}
	
	//Summary employees report
	function summary_employees($start_date, $end_date)
	{
		$this->load->model('reports/Summary_employees');
		$model = $this->Summary_employees;
		$data = array(
			"title" => $this->lang->line('reports_employees_summary_report'),
			"subtitle" => date('m/d/Y', strtotime($start_date)) .'-'.date('m/d/Y', strtotime($end_date)),
			"headers" => $model->getDataColumns(),
			"data" => $model->getData(array('start_date'=>$start_date, 'end_date'=>$end_date)),
			"summary_data" => $model->getSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date))
		);

		$this->load->view("reports/tabular",$data);
	}

}
?>