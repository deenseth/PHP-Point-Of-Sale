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
	
	function view($customer_id=-1)
	{
		$data['customer_info']=$this->Customer->get_customer_info($customer_id);
		$this->load->view("customers/form",$data);
	}
	
	
	function save($customer_id=-1)
	{
		$first_name=$this->input->post('first_name');
		$last_name=$this->input->post('last_name');
		$email=$this->input->post('email');
		$phone_number=$this->input->post('phone_number');
		$comments=$this->input->post('comments');
		
		$this->Customer->save_customer($customer_id,$first_name,$last_name,$email,$phone_number,$comments);
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