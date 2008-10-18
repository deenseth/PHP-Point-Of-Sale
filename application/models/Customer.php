<?php
require_once('Person.php');

class Customer extends Person 
{
    function __construct()
    {
        parent::__construct();
	}
	
	/*
	Currently not overriding get_info & get_multiple_info as customers do not 
	contain any more information than a Person. (But they can in the future)
	*/
	
	/*
	Returns all the customers
	*/
	function get_all()
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');			
		$this->db->order_by("last_name", "asc");
		return $this->db->get();		
	}
	
	/*
	Determines if a given person_id is a customer
	*/
	function exists($person_id)
	{
		$this->db->from('customers');	
		$this->db->join('people', 'people.person_id = customers.person_id');
		$this->db->where('customers.person_id',$employee_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	/*
	Inserts or updates a customer
	*/
	function save(&$person_data, &$customer_data,$person_id=false)
	{
		$success=false;
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		if(parent::save($person_data,$person_id))
		{
		
			if (!$person_id or $person_id < 0)
			{
				$customer_data['person_id']=$this->db->insert_id();
				$this->db->set($customer_data);
				$success = $this->db->insert('customers');
			}
			else
			{
				//Currently there is no extra data for a customer, so their is nothing to update
				$success = true;
				
				/*
				$this->db->set($customer_data);
				$this->db->where('person_id', $person_id);
				$success = $this->db->update('customers');
				*/
			}
			
		}
		
		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Deletes one customer
	*/
	function delete($customer_id)
	{
		$success=false;
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();
		
		//delete from customers table
		if($this->db->delete('customers', array('person_id' => $customer_id)))
		{
			//delete from Person table
			$success = parent::delete($customer_id);
		}
		
		$this->db->trans_complete();		
		return $success;
	}
	
	/*
	Deletes a list of customers
	*/
	function delete_list($customer_ids)
	{
		$success=false;

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->where_in('person_id',$customer_ids);
		if ($this->db->delete('customers'))
		{
			$success = parent::delete_list($customer_ids);
		}
		
		$this->db->trans_complete();		
		return $success;
 	}
 	
 	/*
	Get search suggestions to find customers
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->like('first_name', $search); 
		$this->db->or_like('last_name', $search);
		$this->db->or_like("CONCAT(`first_name`,' ',`last_name`)",$search);		
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->first_name.' '.$row->last_name;		
		}
		
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->like("email",$search);
		$this->db->order_by("email", "asc");		
		$by_email = $this->db->get();
		foreach($by_email->result() as $row)
		{
			$suggestions[]=$row->email;		
		}

		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');	
		$this->db->like("phone_number",$search);
		$this->db->order_by("phone_number", "asc");		
		$by_phone = $this->db->get();
		foreach($by_phone->result() as $row)
		{
			$suggestions[]=$row->phone_number;		
		}
		
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	
	}
	
	/*
	Preform a search on customers
	*/
	function search($search)
	{
		$this->db->from('customers');
		$this->db->join('people','customers.person_id=people.person_id');		
		$this->db->like('first_name', $search);
		$this->db->or_like('last_name', $search); 
		$this->db->or_like('email', $search); 
		$this->db->or_like('phone_number', $search);
		$this->db->or_like("CONCAT(`first_name`,' ',`last_name`)",$search);
		$this->db->order_by("last_name", "asc");
		
		return $this->db->get();	
	}

}
?>
