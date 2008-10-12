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
		if(!$this->User->is_logged_in())
		{
			redirect('login');
		}
		
		if(!$this->User->has_permission($module_id))
		{
			redirect('no_access/'.$module_id);
		}	
	}
	
}
?>