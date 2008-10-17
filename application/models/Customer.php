<?php
class Customer extends Person 
{
    function Customer()
    {
        parent::Person();
	}
	
	/*
	Currently not overriding get_info & get_multiple_info as customers do not 
	contain any more information than a Person. (But they can in the future)
	*/
	
	
	
	/*
	Inserts or updates a customer
	*/
	function save($person_data, $customer_data,$person_id=false)
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
}
?>
