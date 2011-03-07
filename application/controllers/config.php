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
	
	function mailchimpinfo()
	{
		$this->load->view('mailchimpinfo');
	}
		
	function save()
	{
		if ($key = $this->input->post('mc_api_key')) {
			$this->load->library('MailChimp',  array('api_key'=>$key), 'MailChimp');
			$success = ($this->MailChimp->ping() === "Everything's Chimpy!");
			$mc_message =  $success ? 'Connected to MailChimp! ' 
			                        : "Unable to connect to MailChimp. Please check your connection and your API key. ";
            $validated_api_key = $success ? $this->input->post('mc_api_key') : '';
		} else {
			$validated_api_key = $this->config->item('mc_api_key');
		}

		$batch_save_data=array(
		'company'=>$this->input->post('company'),
		'address'=>$this->input->post('address'),
		'phone'=>$this->input->post('phone'),
		'email'=>$this->input->post('email'),
		'fax'=>$this->input->post('fax'),
		'website'=>$this->input->post('website'),
		'default_tax_1_rate'=>$this->input->post('default_tax_1_rate'),		
		'default_tax_1_name'=>$this->input->post('default_tax_1_name'),		
		'default_tax_2_rate'=>$this->input->post('default_tax_2_rate'),	
		'default_tax_2_name'=>$this->input->post('default_tax_2_name'),		
		'return_policy'=>$this->input->post('return_policy'),
		'language'=>$this->input->post('language'),
		'timezone'=>$this->input->post('timezone'),
		'print_after_sale'=>$this->input->post('print_after_sale'),
		'mc_api_key'=>$validated_api_key
		);
		
		if($this->Appconfig->batch_save($batch_save_data))
		{
			echo json_encode(array('success'=>true,'message'=>$mc_message . $this->lang->line('config_saved_successfully')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$mc_message . $this->lang->line('config_saved_unsuccessfully')));
	
		}
	}
}
?>