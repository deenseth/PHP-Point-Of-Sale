<?php
require_once("report.php");
class Summary_categories extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array($this->lang->line('reports_category'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_tax'));
	}
	
	public function getData(array $inputs)
	{
		$this->db->select('category, SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax', false);
		$this->db->from('items');
		$this->db->join('sales_items_temp', 'items.item_id = sales_items_temp.item_id');		
		$this->db->join('sales', 'sales_items_temp.sale_id = sales.sale_id');		
		$this->db->where('date(sale_time) BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->group_by('category');
		$this->db->order_by('category');
		
		return $this->db->get()->result_array();		
	}
	
	public function getSummaryData(array $inputs)
	{
		$this->db->select('SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax', false);
		$this->db->from('items');
		$this->db->join('sales_items_temp', 'items.item_id = sales_items_temp.item_id');		
		$this->db->join('sales', 'sales_items_temp.sale_id = sales.sale_id');		
		$this->db->where('date(sale_time) BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		
		return $this->db->get()->row_array();
	}
}
?>