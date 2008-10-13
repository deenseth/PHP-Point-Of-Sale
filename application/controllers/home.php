<?php
class Home extends Secure_Area 
{
	function Home()
	{
		parent::Secure_Area();	
		$this->load->model("Module");
	}
	
	function index()
	{
		$data["allowed_modules"]=$this->Module->get_allowed_modules();
		$this->load->view("home",$data);
	}
}
?>