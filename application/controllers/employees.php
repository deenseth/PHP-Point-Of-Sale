<?php
class Employees extends Secure_Area implements iPersonController
{
	function __construct()
	{
		parent::__construct('employees');	
	}
	
	function index()
	{
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->_get_form_width();
		$data['form_height']=$this->_get_form_height();
		$data['manage_table']=get_people_manage_table($this->Employee->get_all(),$this);
		$this->load->view('people/manage',$data);
	}
	
	/*
	Returns employee table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_people_manage_table_data_rows($this->Employee->search($search),$this);
		echo $data_rows;
	}
	
	/*
	Gets one row of the manage table. This is called using AJAX to update one row.
	*/
	function get_row()
	{
		$person_id = $this->input->post('person_id');
		$data_row=get_person_data_row($this->Employee->get_info($person_id),$this);
		echo $data_row;
	}
	
	function suggest()
	{
		$suggestions = $this->Employee->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	function view($employee_id=-1)
	{
		$data['employee_info']=$this->Employee->get_info($employee_id);
		$this->load->view("employees/form",$data);
	}
	
	
	function save($employee_id=-1)
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
		
		//Password has been changed OR first time password set
		if($this->input->post('password')!='')
		{
			$employee_data=array(
			'username'=>$this->input->post('username'),
			'password'=>md5($this->input->post('password'))
			);
		}
		else //Password not changed
		{
			$employee_data=array('username'=>$this->input->post('username'));
		}
		
		$success = $this->Employee->save($person_data,$employee_data,$employee_id);
		if($success)
		{
			//New employee
			if($employee_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('employees_successful_adding').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$employee_data['person_id']));
			}
			else //previous employee
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('employees_successful_updating').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$employee_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('employees_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		}
	}
	
	/*
	This deletes employees from the employees table
	*/
	function delete()
	{
		$employees_to_delete=$this->input->post('ids');
		$success = $this->Employee->delete_list($employees_to_delete);
		
		if($success)
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('employees_successful_deleted').' '.
			count($employees_to_delete).' '.$this->lang->line('employees_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('employees_cannot_be_deleted')));
		}
	}
	
	/*
	This returns a mailto link for employees with a certain id. This is called with AJAX.
	*/
	function mailto()
	{
		$employees_to_email=$this->input->post('ids');
		
		if($employees_to_email!=false)
		{
			$mailto_url='mailto:';
			foreach($this->Employee->get_multiple_info($employees_to_email)->result() as $employee)
			{
				$mailto_url.=$employee->email.',';	
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
		return 650;
	}
}
?>