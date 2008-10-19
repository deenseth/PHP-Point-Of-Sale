<?php
require_once ("Secure_Area.php");
class Sales extends Secure_Area 
{
	function __construct()
	{
		parent::__construct('sales');	
	}
	
	function index()
	{
	}
}
?>