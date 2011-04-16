<?php
require_once("report.php");
class Specific_item extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
	    return array('summary' => array($this->lang->line('reports_customer_id'), $this->lang->line('reports_customer'), $this->lang->line('reports_date'), $this->lang->line('reports_quantity_purchased'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_tax'), $this->lang->line('reports_profit'),$this->lang->line('reports_discount')));
	}
	
	public function getData(array $inputs)
	{
	    $this->db->select('person_id, CONCAT(first_name," ",last_name) as customer_name, sale_date, quantity_purchased, subtotal,total, tax, profit, discount_percent', false);
		$this->db->from('sales_items_temp');
		$this->db->join('people', 'sales_items_temp.customer_id = people.person_id');
		$this->db->where('sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'" and item_id='.$inputs['item_id']);
		$this->db->group_by('sale_id');
		$this->db->order_by('sale_id');

		$data = array();
		$data['summary'] = $this->db->get()->result_array();
		return $data;
	}
	
	public function getSummaryData(array $inputs)
	{
		$this->db->select('sum(subtotal) as subtotal, sum(total) as total, sum(tax) as tax, sum(profit) as profit');
		$this->db->from('sales_items_temp');
		$this->db->where('sale_date BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'" and item_id='.$inputs['item_id']);
		
		return $this->db->get()->row_array();
	}
}
?>