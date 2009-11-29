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
		$this->load->view("reports/report",array());	
	}
}
?>