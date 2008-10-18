<?php
class Login extends Controller 
{
	function __construct()
	{
		parent::__construct();	
	}
	
	function index()
	{
		if($this->Employee->is_logged_in())
		{
			redirect ('home');
		}
		else
		{
			$rules['username']  = "callback_login_check";
        	$this->validation->set_rules($rules);
        	$fields['username'] = $this->lang->line('login_username');
        	$fields['password'] = $this->lang->line('login_password');
    	
    	    $this->validation->set_fields($fields);
    	    $this->validation->set_error_delimiters('<div class="error">', '</div>');
			
			if($this->validation->run() == FALSE)
			{
				$this->load->view('login');
			}
			else
			{
				redirect ('home');
			}
		}
	}
	
	function login_check($username)
	{
		$password = $this->validation->password;	
		
		if(!$this->Employee->login($username,$password))
		{
			$this->validation->set_message('login_check', $this->lang->line('login_invalid_username_and_password'));
			return false;
		}
		return true;		
	}
}
?>