<?php
class Customers extends Secure_Area implements iPersonController
{
	function __construct()
	{
		parent::__construct('customers');	
	}
	
	function index()
	{
		$data['controller']=strtolower(get_class());
		$data['manage_table']=get_people_manage_table($this->Customer->get_all(),$this);
		$this->load->view('people/manage',$data);
	}
	
	/*
	Returns customer table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_people_manage_table_data_rows($this->Customer->search($search),$this);
		echo $data_rows;
	}
	
	function suggest()
	{
		$suggestions = $this->Customer->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	function view($customer_id=-1)
	{
		$data['customer_info']=$this->Customer->get_info($customer_id);
		$this->load->view("customers/form",$data);
	}
	
	
	function save($customer_id=-1)
	{
		$person_data = array(
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'email'=>$this->input->post('email'),
		'phone_number'=>$this->input->post('phone_number'),
		'address_1'=>$this->input->post('address_1'),
		'address_2'=>$this->input->post('address_2'),
		'city'=>$this->input->post('city'),
		'state'=>$this->input->post('state'),
		'zip'=>$this->input->post('zip'),
		'country'=>$this->input->post('country'),
		'comments'=>$this->input->post('comments')
		);
		
		$success = $this->Customer->save($person_data,array(),$customer_id);
		
		if($success)
		{
			//New customer
			if($customer_id==-1)
			{
				echo json_encode(array('text'=>$this->lang->line('customers_successful_adding').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'class_name'=>'success_message','keep_displayed'=>false));
			}
			else //previous customer
			{
				echo json_encode(array('text'=>$this->lang->line('customers_successful_updating').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'class_name'=>'success_message','keep_displayed'=>false));
			}
		}
		else//failure
		{
			echo json_encode(array('text'=>$this->lang->line('customers_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'class_name'=>'error_message','keep_displayed'=>true));
		}
	}
	
	/*
	This deletes customers from the customers table
	*/
	function delete()
	{
		$customers_to_delete=$this->input->post('ids');
		$success = $this->Customer->delete_list($customers_to_delete);
		
		if($success)
		{
			echo json_encode(array('text'=>$this->lang->line('customers_successful_deleted').' '.
			count($customers_to_delete).' '.$this->lang->line('customers_one_or_multiple'),'class_name'=>'success_message','keep_displayed'=>false));
		}
		else
		{
			echo json_encode(array('text'=>$this->lang->line('customers_cannot_be_deleted'),
			'class_name'=>'error_message','keep_displayed'=>true));
		}
	}
	
	/*
	This returns a mailto link for customers with a certain id. This is called with AJAX.
	*/
	function mailto()
	{
		$customers_to_email=$this->input->post('ids');
		
		if($customers_to_email!=false)
		{
			$mailto_url='mailto:';
			foreach($this->Customer->get_multiple_info($customers_to_email)->result() as $customer)
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
	
	/*
	get the width for the add/edit form
	*/
	function _get_form_width()
	{
		return 300;
	}
	
	/*
	get the width for the add/edit form
	*/
	function _get_form_height()
	{
		return 600;
	}
}
?>