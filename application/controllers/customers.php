<?php
class Customers extends Secure_Area 
{
	function Customers()
	{
		parent::Secure_Area('customers');	
	}
	
	function index()
	{
		$this->load->view('customers/manage');
	}
	
	/*
	Returns a manage table based on a search. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$manage_table=get_customer_manage_table($this->Customer->get_customers($search));
		echo $manage_table;
	}
	
	function add()
	{
		$this->edit('');
	}
	
	function edit($customer_id)
	{
		$data['customer_info']=$this->Customer->get_customer_info($customer_id);
		$this->load->view("customers/form",$data);
	}
	
	/*
	This deletes customers (that can be deleted) from the customers table
	*/
	function delete()
	{
		$customers_to_delete=$this->input->post('ids');
		$this->Customer->delete_customers($customers_to_delete);
	}
	
	/*
	This returns a mailto link for customers with a certain id. This is called with AJAX.
	*/
	function email()
	{
		$customers_to_email=$this->input->post('ids');
		
		if($customers_to_email!=false)
		{
			$mailto_url='mailto:';
			foreach($this->Customer->get_customers_with_ids($customers_to_email) as $customer)
			{
				$mailto_url.=$customer->email.',';	
			}
			//remove last comma
			$mailto_url=substr($mailto_url,0,strlen($mailto_url)-1);
			
			echo $mailto_url;
			exit;
		}
		echo '#';
	}
}
?>