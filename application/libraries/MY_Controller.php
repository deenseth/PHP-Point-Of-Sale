<?php
class Secure_Area extends Controller 
{
	/*
	Controllers that are considered secure extend Secure_Area, optinally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function __construct($module_id=null)
	{
		parent::__construct();	
		
		if(!$this->Employee->is_logged_in())
		{
			redirect('login');
		}
		
		if(!$this->Employee->has_permission($module_id))
		{
			redirect('no_access/'.$module_id);
		}
		
		//load up global data
		$data['allowed_modules']=$this->Module->get_allowed_modules();
		$data['user_info']=$this->Employee->get_logged_in_employee_info();
		$this->load->vars($data);
	}
}

interface iPersonController
{
	public function index();
	public function search();
	public function view($person_id=-1);
	public function save($person_id=-1);
	public function delete();
	public function mailto();
	public function _get_form_width();
	public function _get_form_height();
}
?>