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
	Logs out a user by destorying all session data
	*/
	function logout_user()
	{
		$this->session->sess_destroy();
	}
	
	/*
	Determins if a user is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('user_id')!=false;
	}
}
?>
