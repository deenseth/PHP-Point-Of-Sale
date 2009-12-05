<?php
abstract class Report extends Model 
{
	function __construct()
	{
		parent::Model();

		//Make sure the report is not cached by the browser
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		
		//Create our temp table to work with the data in our report
		$this->createSalesItemsTempTable();
	}
	
	//Returns the column names used for the report
	public abstract function getDataColumns();
	
	//Returns all the data to be populated into the report
	public abstract function getData(array $inputs);
	
	//Returns key=>value pairing of summary data for the report
	public abstract function getSummaryData(array $inputs);
	
	//We create a temp table that allows us to do easy report queries
	public function createSalesItemsTempTable()
	{
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('sales_items_temp')." 
		(SELECT date(sale_time) as sale_date, sale_id, customer_id, employee_id, item_id, quantity_purchased, item_unit_price, SUM(percent) as item_tax_percent, 
		(item_unit_price*quantity_purchased) as subtotal,
		ROUND((item_unit_price*quantity_purchased)*(1+(SUM(percent)/100)),2) as total,
		ROUND((item_unit_price*quantity_purchased)*(SUM(percent)/100),2) as tax
		FROM ".$this->db->dbprefix('sales_items')."
		INNER JOIN ".$this->db->dbprefix('sales')." USING (sale_id) 
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_items_taxes')." USING (sale_id, item_id)
		GROUP BY sale_id, item_id)");
		
		//Update null item_tax_percents to be 0 instead of null
		$this->db->where('item_tax_percent IS NULL');
		$this->db->update('sales_items_temp', array('item_tax_percent' => 0));
		
		//Update null tax to be 0 instead of null
		$this->db->where('tax IS NULL');
		$this->db->update('sales_items_temp', array('tax' => 0));

		//Update null subtotals to be equal to the total as these don't have tax
		$this->db->query('UPDATE '.$this->db->dbprefix('sales_items_temp'). ' SET total=subtotal WHERE total IS NULL');
		
	}
}
?>