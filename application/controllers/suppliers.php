<?php
require_once ("person_controller.php");
class Suppliers extends Person_controller
{
	function __construct()
	{
		parent::__construct('suppliers');
	}
	
	function index()
	{
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_people_manage_table($this->Supplier->get_all(),$this);
		$this->load->view('people/manage',$data);
	}
	
	/*
	Returns supplier table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_people_manage_table_data_rows($this->Supplier->search($search),$this);
		echo $data_rows;
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Supplier->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	/*
	Loads the supplier edit form
	*/
	function view($supplier_id=-1)
	{
		$data['person_info']=$this->Supplier->get_info($supplier_id);
		$this->load->view("suppliers/form",$data);
	}
	
	/*
	Inserts/updates a supplier
	*/
	function save($supplier_id=-1)
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
		$supplier_data=array(
		'account_number'=>$this->input->post('account_number')=='' ? null:$this->input->post('account_number'),
		);
		if($this->Supplier->save($person_data,$supplier_data,$supplier_id))
		{
			//New supplier
			if($supplier_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('suppliers_successful_adding').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$supplier_data['person_id']));
			}
			else //previous supplier
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('suppliers_successful_updating').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$supplier_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('suppliers_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		}
	}
	
	/*
	This deletes suppliers from the suppliers table
	*/
	function delete()
	{
		$suppliers_to_delete=$this->input->post('ids');
		
		if($this->Supplier->delete_list($suppliers_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('suppliers_successful_deleted').' '.
			count($suppliers_to_delete).' '.$this->lang->line('suppliers_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('suppliers_cannot_be_deleted')));
		}
	}
	
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{			
		return 360;
	}
}
?>