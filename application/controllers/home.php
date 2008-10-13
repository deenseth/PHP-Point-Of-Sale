<?php
class Home extends Secure_Area 
{
	function Home()
	{
		parent::Secure_Area();	
	}
	
	function index()
	{
		$this->load->view("home");
	}
	
	function logout()
	{
		$this->User->logout_user();
	}
}
?>