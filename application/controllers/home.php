<?php
require_once ("secure_area.php");
class Home extends Secure_area 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->load->view("home");
	}
	
	function close()
	{
		$this->load->model('reports/Detailed_sales');

		$start_date = date('Y-m-d') . " 00:00:00";
		$end_date = date('Y-m-d H:i:s');

		$data['sales_totals'] = $this->Detailed_sales->getTypeSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date));

		$final_total = 0;
		foreach($data['sales_totals'] as $sales_total) {
			$final_total += $sales_total['total'];
		}

		$data['final_total'] = $final_total;

		$this->load->view("close", $data);
	}

	function print_totals()
	{
		$this->load->model('reports/Detailed_sales');

		//Start at the beginning of the dau
		$start_date = date('Y-m-d') . " 00:00:00";
		$end_date = date('Y-m-d H:i:s');
		$sale_type = 'all';

		$data['sales_totals'] = $this->Detailed_sales->getTypeSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));

		if(!$this->Employee->has_permission("reports", $this->Employee->get_logged_in_employee_info()->person_id))
		{
			unset($data['sales_totals']['profit']);
		}

		$report_data = $this->Detailed_sales->getData(array('start_date'=>$start_date, 'end_date'=>$end_date, 'sale_type'=>$sale_type));

		$data['summary_data'] = $report_data['summary'];

		$this->Receipt->print_totals($data);
	}

	function logout()
	{
		$this->Employee->logout();
	}
}
?>