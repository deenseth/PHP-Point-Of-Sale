<?php
class Secure_Area extends Controller 
{
	/*
	Controllers that are considered secure extend Secure_Area, optinally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function Secure_Area($module_id=null)
	{
		parent::Controller();	
		$this->load->model('User');
		$this->load->model('Module');
		if(!$this->User->is_logged_in())
		{
			redirect('login');
		}
		
		if(!$this->User->has_permission($module_id))
		{
			redirect('no_access/'.$module_id);
		}
		
		//load up global data
		$data['allowed_modules']=$this->Module->get_allowed_modules();
		$data['user_info']=$this->User->get_logged_in_user_info();
		$this->load->vars($data);
	}
	
}
?>