<?php
class User extends Model 
{
    function User()
    {
        parent::Model();
	}

	/*
	Attempts to login user and set session. Returns boolean based on outcome.
	*/
	function login_user($username, $password)
	{
		$query = $this->db->get_where('users', array('username' => $username,'password'=>$password), 1);
		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('user_id', $row->id);
			return true;
		}
		return false;
	}
	
	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout_user()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
	
	/*
	Determins if a user is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('user_id')!=false;
	}
	
	/*
	Gets information about the currently logged in user.
	*/
	function get_logged_in_user_info()
	{
		if($this->is_logged_in())
		{
			$query = $this->db->get_where('users', array('id' => $this->session->userdata('user_id')), 1);
			return $query->row();
		}
		
		return false;
	}
	
	/*
	Determins whether the user logged in permission for a particular module
	*/
	function has_permission($module_id)
	{
		//if no module_id is specified or of the module_id is home, allow access
		if($module_id==null or $module_id=='home')
		{
			return true;
		}
		
		$user_info=$this->get_logged_in_user_info();
		if($user_info!=false)
		{
			$query = $this->db->get_where('permissions', array('user_id' => $user_info->id,'module_id'=>$module_id), 1);
			return $query->num_rows() == 1;
		}
		
		return false;
	}
}
?>
