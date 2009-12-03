<?php
require_once("report.php");
class Summary_employees extends Report
{
	function __construct()
	{
		parent::__construct();
	}
	
	public function getDataColumns()
	{
		return array($this->lang->line('reports_employee'), $this->lang->line('reports_subtotal'), $this->lang->line('reports_total'), $this->lang->line('reports_tax'));
	}
	
	public function getData(array $inputs)
	{
		$this->db->select('CONCAT(first_name, " ",last_name) as employee, SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax', false);
		$this->db->from('employees');
		$this->db->join('people', 'employees.person_id = people.person_id');
		$this->db->join('sales', 'employees.person_id = sales.employee_id');		
		$this->db->join('sales_items_temp', 'sales.sale_id = sales_items_temp.sale_id');		
		$this->db->where('date(sale_time) BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');
		$this->db->group_by('employee_id');
		$this->db->order_by('last_name');

		return $this->db->get()->result_array();		
	}
	
	public function getSummaryData(array $inputs)
	{
		$this->db->select('SUM(item_unit_price*quantity_purchased) as subtotal, 
		ROUND(SUM(item_unit_price*quantity_purchased)*(1+(item_tax_percent/100)), 2) as total,
		ROUND(SUM(item_unit_price*quantity_purchased)*(item_tax_percent/100), 2) as tax', false);
		$this->db->from('employees');
		$this->db->join('people', 'employees.person_id = people.person_id');
		$this->db->join('sales', 'employees.person_id = sales.employee_id');		
		$this->db->join('sales_items_temp', 'sales.sale_id = sales_items_temp.sale_id');		
		$this->db->where('date(sale_time) BETWEEN "'. $inputs['start_date']. '" and "'. $inputs['end_date'].'"');

		return $this->db->get()->row_array();
	}
}
?>