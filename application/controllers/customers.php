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
	Returns customer table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_customer_manage_table_data_rows($this->Customer->get_customers($search));
		echo $data_rows;
	}
	
	function suggest()
	{
		$suggestions = $this->Customer->get_customer_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
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
		
		$customer_data = array(
		'first_name'=>$first_name,
		'last_name'=>$last_name,
		'email'=>$email,
		'phone_number'=>$phone_number,
		'comments'=>$comments
		);
		
		$success = $this->Customer->save_customer($customer_id,$customer_data);
		
		if($success)
		{
			//New customer
			if($customer_id==-1)
			{
				echo json_encode(array('text'=>$this->lang->line('customer_successful_adding_customer').' '.
				$first_name.' '.$last_name,'class_name'=>'success_message','keep_displayed'=>false));
			}
			else //previous customer
			{
				echo json_encode(array('text'=>$this->lang->line('customer_successful_updating_customer').' '.
				$first_name.' '.$last_name,'class_name'=>'success_message','keep_displayed'=>false));
			}
		}
		else//failure
		{
			echo json_encode(array('text'=>$this->lang->line('customer_error_adding_updating_customer').' '.
			$first_name.' '.$last_name,'class_name'=>'error_message','keep_displayed'=>true));
		}
	}
	
	/*
	This deletes customers from the customers table
	*/
	function delete()
	{
		$customers_to_delete=$this->input->post('ids');
		$success = $this->Customer->delete_customers($customers_to_delete);
		
		if($success)
		{
			echo json_encode(array('text'=>$this->lang->line('customer_successful_deleted').' '.
			count($customers_to_delete).' '.$this->lang->line('customer_customer(s)'),'class_name'=>'success_message','keep_displayed'=>false));
		}
		else
		{
			echo json_encode(array('text'=>$this->lang->line('customer_cannot_be_deleted'),
			'class_name'=>'error_message','keep_displayed'=>true));
		}
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