<?php
require_once("report.php");
class Summary_brands extends Report
{
	//TODO USE LANGUAGE FILE
	public function getDataColumns()
	{
		return array('Brand', 'Subtotal', 'Total', 'Tax');
	}
	
	//TODO
	public function getData(array $inputs)
	{
		return array();
	}
	
	//TODO
	public function getSummaryData(array $inputs)
	{
		return array();
	}
}
?>