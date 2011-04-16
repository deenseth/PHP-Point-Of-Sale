<?php
class Secure_area extends Controller 
{
	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function __construct($module_id=null)
	{
		parent::__construct();	
		$this->load->model('Employee');
		if(!$this->Employee->is_logged_in())
		{
			redirect('login');
		}
		
		if(!$this->Employee->has_permission($module_id,$this->Employee->get_logged_in_employee_info()->person_id))
		{
			redirect('no_access/'.$module_id);
		}
		
		//load mailchimpdash integration
		if($key = $this->Appconfig->get('mc_api_key')) {
			$this->load->library('MCAPI',  array($key), 'MCAPI');
			if ($this->MCAPI->ping() !== 'Everything\'s Chimpy!') {
				log_message('debug', 'There was a problem contacting MailChimp. Please make sure you are connected to the Internet.');
			}
		}
		
		
		
		//load up global data
		$logged_in_employee_info=$this->Employee->get_logged_in_employee_info();
		$data['allowed_modules']=$this->Module->get_allowed_modules($logged_in_employee_info->person_id, ($key != null));
		$data['user_info']=$logged_in_employee_info;
		$this->load->vars($data);
	}
}
?>