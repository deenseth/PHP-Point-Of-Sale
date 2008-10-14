<?php
class Customer extends Model 
{
    function Customer()
    {
        parent::Model();
	}
	
	/*
	Returns all the customers
	*/
	function get_all_customers()
	{
		$this->db->from('customers');
		$this->db->order_by("last_name", "asc");
		$query = $this->db->get();
		
		$customers = array();
		foreach ($query->result() as $row)	
		{
			$customers[]=$row;
		}
		
		return $customers;
	}
	
	/*
	Get customers with specific ids
	*/
	function get_customers_with_ids($customer_ids)
	{
		if(!is_array($customer_ids))
		{
			return array();
		}
		
		$this->db->from('customers');
		$this->db->where_in('id',$customer_ids);
		$this->db->order_by("last_name", "asc");
		$query = $this->db->get();
		
		$customers = array();
		foreach ($query->result() as $row)	
		{
			$customers[]=$row;
		}
		
		return $customers;
	}
	
	/*
	Returns customers based on a search
	*/
	function get_customers($search)
	{
		$this->db->from('customers');
		$this->db->like('first_name', $search);
		$this->db->or_like('last_name', $search); 
		$this->db->or_like('email', $search); 
		$this->db->or_like('phone_number', $search);
		$this->db->or_like("CONCAT(`first_name`,' ',`last_name`)",$search);
		$this->db->order_by("last_name", "asc");
		$query = $this->db->get();
		
		$customers = array();
		foreach ($query->result() as $row)	
		{
			$customers[]=$row;
		}
		
		return $customers;
	}
	
	/*
	Gets information about a customer as an array.
	*/
	function get_customer_info($customer_id)
	{
		$query = $this->db->get_where('customers', array('id' => $customer_id), 1);
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//create object with empty properties.
			$fields = $this->db->list_fields('customers');
			$customer_obj = new stdClass;
			
			foreach ($fields as $field)
			{
				$customer_obj->$field='';
			}
			
			return $customer_obj;
		}
	}
	
	/*
	Inserts or updates a customer
	*/
	function save_customer($customer_id, $first_name, $last_name, $email, $phone_number, $comments)
	{
		$this->db->set(array(
		'first_name'=>$first_name,
		'last_name'=>$last_name,
		'email'=>$email,
		'phone_number'=>$phone_number,
		'comments'=>$comments
		));
		
		if ($customer_id=='-1')
		{
			$this->db->insert('customers');
		}
		else
		{
			$this->db->where('id', $customer_id);
			$this->db->update('customers');		
		}
	}
	
	/*
	Deletes a list of customers (if allowed)
	*/
	function delete_customers($customer_ids)
	{
		$all_successful = true;
		foreach($customer_ids as $customer_id)
		{
			$all_successful = $this->delete_customer($customer_id);
		}
		
		return $all_successful;
	}
	
	/*
	Deletes one customer
	*/
	function delete_customer($customer_id)
	{
		if($this->can_delete_customer($customer_id))
		{
			return $this->db->delete('customers', array('id' => $customer_id)); 
		}
		
		return false;
	}
	
	/*
	Check if a customer is allowed to be deleted
	*/
	function can_delete_customer($customer_id)
	{
		$query=$this->db->get_where('sales', array('customer_id' => $customer_id));
		return $query->num_rows() ==0;
	}
}
?>
