<?php
abstract class Report extends Model 
{
	//Returns the column names used for the report
	abstract public function getDataColumns();
	
	//Returns all the data to be populated into the report
	abstract public function getData(array $inputs);
	
	//Returns key=>value pairing of summary data for the report
	abstract public function getSummaryData(array $inputs);
	
	final public function createSalesItemsIncTaxTempTable()
	{
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('sales_items_tax_percent_temp')." 
		(SELECT sale_id, item_id, quantity_purchased, item_unit_price, SUM(percent) as item_tax_percent 
		FROM phppos_sales_items INNER JOIN phppos_sales USING (sale_id) 
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_items_taxes')." USING (sale_id, item_id)
		GROUP BY sale_id, item_id)");
	}
}
?>