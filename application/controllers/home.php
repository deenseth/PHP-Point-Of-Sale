<?php
class Home extends Secure_Area 
{
	function Home()
	{
		//parent::Secure_Area('customers');	
		parent::Controller();
	}
	
	function index()
	{
		get_database_configuration($this->config);
	}
}
?>