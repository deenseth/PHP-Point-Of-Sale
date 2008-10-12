<?php

class No_Access extends Controller 
{
	function No_Access()
	{
		parent::Controller();
		$this->load->model("Module");
	}
	
	function index($module_id='')
	{
		$data['module_name']=$this->Module->get_module_name($module_id);
		$this->load->view('no_access',$data);
	}
}
?>