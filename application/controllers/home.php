<?php
require_once ("Secure_Area.php");
class Home extends Secure_Area 
{
	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		$this->load->view("home");
	}
	
	function logout()
	{
		$this->Employee->logout();
	}
}
?>