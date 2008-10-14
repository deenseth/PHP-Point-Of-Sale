<?php
class Customers extends Secure_Area 
{
	function Customers()
	{
		parent::Secure_Area('customers');	
	}
	
	function index()
	{
		$data['manage_table']=$this->Customer->get_manage_table(
		$this->Customer->get_all_customers());
		$this->load->view('customers',$data);
	}
	
	/*
	Returns a manage table based on a search. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$selected_customer_ids=$this->input->post('selected_customer_ids');

		$manage_table=$this->Customer->get_manage_table(
		$this->Customer->get_customers($search),$selected_customer_ids);
		
		echo $manage_table;
	}
	
	function add()
	{
		$this->edit(-1);
	}
	
	function edit($customer_id)
	{
		echo $customer_id;
	}
	
	function delete()
	{
		$customers_to_delete=$this->input->post('customers_to_delete');
		$this->Customers->delete_customers($customers_to_delete);
	}
}
?>