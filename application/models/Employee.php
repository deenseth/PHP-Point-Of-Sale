<?php
class Employee extends Person 
{
    function Employee()
    {
        parent::Person();
	}
	
	/*
	Gets information about a particular employee
	*/
	function get_info($employee_id)
	{
		$this->db->from('employees');	
		$this->db->join('people', 'people.person_id = employees.person_id');
		$this->db->where('employees.person_id',$employee_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $employee_id is NOT an employee
			$person_obj=parent::get_info(-1);
			
			//Get all the fields from employee table
			$fields = $this->db->list_fields('employees');
			
			//append those fields to base parent object, we we have a complete empty object
			foreach ($fields as $field)
			{
				$person_obj->$field='';
			}
			
			return $person_obj;
		}
	}
	/*
	Gets information about multiple employees
	*/
	function get_multiple_info($employee_ids)
	{
		$this->db->from('employees');
		$this->db->join('people', 'people.person_id = employees.person_id');		
		$this->db->where_in('employees.person_id',$employee_ids);
		$this->db->order_by("last_name", "asc");
		return $this->db->get();		
	}
	
	/*
	Inserts or updates an employee
	*/
	function save($person_data, $employee_data,$person_id=false)
	{
		$success=false;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
			
		if(parent::save($person_data,$person_id))
		{
		
			if (!$person_id or $person_id < 0)
			{
				$employee_data['person_id']=$this->db->insert_id();
				$this->db->set($employee_data);
				$success = $this->db->insert('employees');
			}
			else
			{
				$this->db->set($employee_data);
				$this->db->where('person_id', $person_id);
				$success = $this->db->update('employees');		
			}
			
		}
		
		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Deletes one employee
	*/
	function delete($employee_id)
	{
		$success=false;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		//Delete permissions
		if($this->db->delete('permissions', array('person_id' => $employee_id)))
		{
			//delete from employee table
			if($this->db->delete('employees', array('person_id' => $employee_id)))
			{
				//delete from Person table
				$success = parent::delete($employee_id);
			}
		}
		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Deletes a list of employees
	*/
	function delete_list($employee_ids)
	{
		$success=false;

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->where_in('person_id',$employee_ids);
		if ($this->db->delete('employees'))
		{
			$success = parent::delete_list($employee_ids);
		}
		
		$this->db->trans_complete();		
		return $success;
 	}
	
	/*
	Attempts to login employee and set session. Returns boolean based on outcome.
	*/
	function login($username, $password)
	{
		$query = $this->db->get_where('employees', array('username' => $username,'password'=>md5($password)), 1);
		if ($query->num_rows() ==1)
		{
			$row=$query->row();
			$this->session->set_userdata('person_id', $row->person_id);
			return true;
		}
		return false;
	}
	
	/*
	Logs out a user by destorying all session data and redirect to login
	*/
	function logout()
	{
		$this->session->sess_destroy();
		redirect('login');
	}
	
	/*
	Determins if a employee is logged in
	*/
	function is_logged_in()
	{
		return $this->session->userdata('person_id')!=false;
	}
	
	/*
	Gets information about the currently logged in employee.
	*/
	function get_logged_in_employee_info()
	{
		if($this->is_logged_in())
		{
			return $this->get_info($this->session->userdata('person_id'));
		}
		
		return false;
	}
	
	/*
	Determins whether the employee logged in has permission for a particular module
	*/
	function has_permission($module_id)
	{
		//if no module_id is specified or of the module_id is home, allow access
		if($module_id==null or $module_id=='home')
		{
			return true;
		}
		
		$employee_info=$this->get_logged_in_employee_info();
		if($user_info!=false)
		{
			$query = $this->db->get_where('permissions', array('employee_id' => $employee_info->employee_id,'module_id'=>$module_id), 1);
			return $query->num_rows() == 1;
		}
		
		return false;
	}
}
?>
