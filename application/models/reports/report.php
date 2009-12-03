<?php
class Report extends Model 
{
	function __construct()
	{
		parent::Model();
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");
		$this->createSalesItemsTempTable();
	}
	
	//Returns the column names used for the report
	public function getDataColumns(){/*override*/}
	
	//Returns all the data to be populated into the report
	public function getData(array $inputs){/*override*/}
	
	//Returns key=>value pairing of summary data for the report
	public function getSummaryData(array $inputs){/*override*/}
	
	public function createSalesItemsTempTable()
	{
		//TODO THIS SEEMS VERY BUGGY. I AM NOT SURE IF THE BROWSER IS CACHING OR SOMETHING IS CACHING
		//IN THE DATABASE.
		/*
		$this->db->query("DROP TABLE IF EXISTS ".$this->db->dbprefix('sales_items_temp'));
		$this->db->query("CREATE TABLE ".$this->db->dbprefix('sales_items_temp')." 
		(SELECT sale_id, item_id, quantity_purchased, item_unit_price, SUM(percent) as item_tax_percent 
		FROM phppos_sales_items INNER JOIN phppos_sales USING (sale_id) 
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_items_taxes')." USING (sale_id, item_id)
		GROUP BY sale_id, item_id)");
		*/
		//THIS IS ALSO BUGGY!
		
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('sales_items_temp')." 
		(SELECT sale_id, item_id, quantity_purchased, item_unit_price, SUM(percent) as item_tax_percent 
		FROM phppos_sales_items INNER JOIN phppos_sales USING (sale_id) 
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_items_taxes')." USING (sale_id, item_id)
		GROUP BY sale_id, item_id)");
		

	}
}
?>