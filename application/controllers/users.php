<?php
class Users extends Secure_Area 
{
	function Users()
	{
		parent::Secure_Area('users');	
	}
	
	function index()
	{
	}
}
?>