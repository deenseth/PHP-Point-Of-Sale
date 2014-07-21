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
	
	function logout()
	{
		$this->load->model('reports/Detailed_sales');

		$start_date = date('Y-m-d') . " 00:00:00";
		$end_date = date('Y-m-d H:i:s');

		$data['sales_totals'] = $this->Detailed_sales->getTypeSummaryData(array('start_date'=>$start_date, 'end_date'=>$end_date));

		$this->load->view("close", $data);
		//$this->Employee->logout();
	}
}
?>