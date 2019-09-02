<?php
require_once ("person_controller.php");
class Employees extends Person_controller
{
	function __construct()
	{
		parent::__construct('employees');
	}
	
	function index()
	{
	    $data['mailchimp']=($this->config->item('mc_api_key') != null);
	    $data['controller_name'] = strtolower(get_class());
		$config['base_url'] = site_url('/employees/index/');
		$config['total_rows'] = $this->Employee->count_all();
		$config['per_page'] = '20';
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$data['search'] = '';
		$data['form_width']=$this->get_form_width();
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['manage_table']=get_people_manage_table($this->Employee->get_all($config['per_page'], $page),$this);
		$this->load->view('people/manage',$data);
	}
	
	/*
	Returns employee table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data['search'] = $search;
		$data['controller_name'] = strtolower(get_class());
		$data['manage_table']=get_people_manage_table($this->Employee->search($search),$this);
		$this->load->view('people/manage',$data);
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Employee->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	/*
	Loads the employee edit form
	*/
	function view($employee_id=-1)
	{
	    $email=preg_replace('/.*email:([^\/]*)\/.*/', '$1', uri_string());
	    
		if ($email != uri_string()) {
		    $data['person_info']=$employee_id == -1 ? $this->Employee->get_by_email($email) : $this->Employee->get_info($employee_id);
    		if (!$data['person_info'] && $email) {
    		    if ($key = $this->config->item('mc_api_key')) {
                    $this->load->library('MailChimp', array($key) , 'MailChimp');
                    $data['person_info'] = $this->MailChimp->getPersonDataByEmail($email);
    		    }
    		}
    		
		} else {
            $data['person_info']= $this->Employee->get_info($employee_id);		    
		}
		
		
		$data['all_modules']=$this->Module->get_all_modules();
		$this->load->view("employees/form",$data);
	}
	
	/*
	Inserts/updates an employee
	*/
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
		$permission_data = $this->input->post("permissions")!=false ? $this->input->post("permissions"):array();
		
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
		
		if ($_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' && $employee_id == 1)
		{
			//failure
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('employees_error_updating_demo_admin').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		}
		elseif($this->Employee->save($person_data,$employee_data,$permission_data,$employee_id))
		{
			//New employee
			if($employee_id==-1)
			{
			    $subscriptionInfo = '';
                if ($key = $this->config->item('mc_api_key')) {
                    $this->load->library('MailChimp', array($key) , 'MailChimp');
                    
                    if ($this->MailChimp->handleSubscriptionForPerson($employee_data['person_id'])) {
                        $subscriptionInfo = $this->lang->line('common_successful_subscription');
                    } else {
                        $subscriptionInfo = $this->lang->line('common_unsuccessful_subscription');
                    }
                }
			    
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('employees_successful_adding').' '.
				$person_data['first_name'].' '.$person_data['last_name'].'. '.$subscriptionInfo,'person_id'=>$employee_data['person_id']));
			}
			else //previous employee
			{
			    $subscriptionInfo = '';
                if ($key = $this->config->item('mc_api_key')) {
                    $this->load->library('MailChimp', array($key) , 'MailChimp');
                    
                    if ($this->MailChimp->handleSubscriptionForPerson($employee_id, true)) {
                        $subscriptionInfo = $this->lang->line('common_successful_subscription');
                    } else {
                        $subscriptionInfo = $this->lang->line('common_unsuccessful_subscription');
                    }
                }
			    
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('employees_successful_updating').' '.
				$person_data['first_name'].' '.$person_data['last_name'].'. '.$subscriptionInfo,'person_id'=>$employee_id));
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
		
		if ($_SERVER['HTTP_HOST'] == 'demo.phppointofsale.com' && in_array(1,$employees_to_delete))
		{
			//failure
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('employees_error_deleting_demo_admin')));
		}
		elseif($this->Employee->delete_list($employees_to_delete))
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
	get the width for the add/edit form
	*/
	function get_form_width()
	{
		return 650;
	}
}
?>