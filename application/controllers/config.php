<?php
require_once ("secure_area.php");
class Config extends Secure_area 
{
	function __construct()
	{
		parent::__construct('config');
	}
	
	function index()
	{
		$this->load->view("config");
	}
		
	function save()
	{
		$store_data=array(
		'name'=>$this->input->post('store'),
		'address'=>$this->input->post('address'),
		'phone'=>$this->input->post('phone'),
		'email'=>$this->input->post('email'),
		'fax'=>$this->input->post('fax'),
		'website'=>$this->input->post('website'),
		'default_tax_rate'=>$this->input->post('default_tax_rate'),		
		'return_policy'=>$this->input->post('return_policy')	
		);
		
		if($this->Store->save($store_data, $this->config->item('store_id')))
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