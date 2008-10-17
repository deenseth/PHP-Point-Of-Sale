<?php
class Employees extends Controller 
{
	function Employees()
	{
		parent::Controller();	
	}
	
	function index()
	{
		/*
		$customers = $this->Customer->get_multiple_info(array(1,2));
		
		echo '<pre>';
		foreach($customers->result() as $row)
		{	
			var_dump($row);
		}		
		echo '</pre>';
		*/
		
		$this->Employee->save(
		array(
		'first_name'=>'Chris',
		'last_name'=>'Muench',
		'phone_number'=>'585-880-6599',
		'email'=>'me@chrismuench.com',
		'address_1'=>'Address 1',
		),
		array(
		'username'=>'admin',
		'password'=>md5('pointofsale')
		));
		
		
		
		
	}
}
?>