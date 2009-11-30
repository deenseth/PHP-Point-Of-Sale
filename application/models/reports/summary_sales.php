<?php
require_once("report.php");
class Summary_sales extends Report
{
	//TODO USE LANGUAGE FILE
	public function getDataColumns()
	{
		return array('Date', 'Subtotal', 'Total', 'Tax');
	}
	
	//TODO CONVERT TO USE ACTIVE RECORD PATTERN SO TABLE PREFIX CAN CHANGE
	public function getData(array $inputs)
	{
		return $this->db->query('SELECT date(phppos_sales.sale_time) as sale_date, 
		SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax
		FROM phppos_sales INNER JOIN phppos_sales_items USING (sale_id)
		GROUP BY sale_date
		HAVING sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date']. '"
		ORDER BY sale_date ASC')->result_array();
	}
	
	//TODO CONVERT TO USE ACTIVE RECORD PATTERN SO TABLE PREFIX CAN CHANGE	
	public function getSummaryData(array $inputs)
	{
		return $this->db->query('SELECT SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax
		FROM phppos_sales INNER JOIN phppos_sales_items USING (sale_id)
		WHERE date(phppos_sales.sale_time) BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date']. '"')->row_array();
	}

}
?>