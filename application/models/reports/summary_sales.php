<?php
require_once("report.php");
class Summary_sales extends Report
{
	//TODO USE LANGUAGE FILE
	public function getDataColumns()
	{
		return array('Date', 'Subtotal', 'Total', 'Tax');
	}
	
	public function getData(array $inputs)
	{
		$this->db->select('date(phppos_sales.sale_time) as sale_date, 
		SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax', false);
		$this->db->from('sales');
		$this->db->join('sales_items', 'sales.sale_id = sales_items.sale_id');		
		$this->db->group_by('sale_date');
		$this->db->having('sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->order_by('sale_date');
		
		return $this->db->get()->result_array();		
	}
	
	public function getSummaryData(array $inputs)
	{
		$this->db->select('SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax', false);
		$this->db->from('sales');
		$this->db->join('sales_items', 'sales.sale_id = sales_items.sale_id');		
		$this->db->where('date(sale_time) BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');

		return $this->db->get()->row_array();		
	}

}
?>