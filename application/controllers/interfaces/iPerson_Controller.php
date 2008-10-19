<?php
/*
This interface is implemented by any controller that keeps track of people, such
as customers and employees.
*/
require_once("iData_Controller.php");
interface iPerson_Controller extends iData_Controller
{
	public function mailto();
}
?>