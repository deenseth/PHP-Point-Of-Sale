<?php
require_once("report.php");
class Summary_sales extends Report
{
	public function getDataColumns()
	{
		return array('Date', 'Subtotal', 'Total', 'Tax');
	}
	
	//TODO THIS IS BUGGY AS I CANNOT FIGURE OUT HOW TO LIMIT TO A DATE RANGE	
	public function getData(array $inputs)
	{
		return $this->db->query('SELECT DATE_FORMAT(phppos_sales.sale_time, "%m-%d-%Y") as sale_date, 
		SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax
		FROM phppos_sales INNER JOIN phppos_sales_items USING (sale_id)
		GROUP BY sale_date
		ORDER BY sale_date ASC')->result_array();
	}
	
	//TODO THIS IS BUGGY AS I CANNOT FIGURE OUT HOW TO LIMIT TO A DATE RANGE
	public function getSummaryData(array $inputs)
	{
		return $this->db->query("SELECT SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax
		FROM phppos_sales INNER JOIN phppos_sales_items USING (sale_id)")->row_array();
	}

}
?>