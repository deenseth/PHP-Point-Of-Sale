<?php
require_once ("Secure_Area.php");
class Config extends Secure_Area 
{
	function __construct()
	{
		parent::__construct('config');
		$this->load->language('config');
	}
	
	function index()
	{
		$this->load->view("config");
	}
		
	function save()
	{
		$batch_save_data=array(
		'company'=>$this->input->post('company'),
		'address'=>$this->input->post('address'),
		'phone'=>$this->input->post('phone'),
		'email'=>$this->input->post('email'),
		'fax'=>$this->input->post('fax'),
		'website'=>$this->input->post('website'),
		'default_tax_rate'=>$this->input->post('default_tax_rate'),		
		'return_policy'=>$this->input->post('return_policy')	
		);
		
		if($this->AppConfig->batch_save($batch_save_data))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('config_saved_successfully')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('config_saved_unsuccessfully')));
	
		}
	}
}
?>