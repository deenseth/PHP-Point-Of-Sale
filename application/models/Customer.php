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
	Returns customers based on a search
	*/

	function get_customers($search)
	{
		$this->db->from('customers');
		$this->db->like('first_name', $search);
		$this->db->or_like('last_name', $search); 
		$this->db->or_like('email', $search); 
		$this->db->or_like('phone_number', $search); 
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
	Gets the table html table to manage customers.
	*/
	function get_manage_table($customers)
	{
		$this->table->set_template(get_sortable_table_template());
		$this->table->set_heading('<input type="checkbox" id="select_all" />', 
		$this->lang->line('common_last_name'),
		$this->lang->line('common_first_name'),
		$this->lang->line('common_email'),
		$this->lang->line('common_phone_number'),
		'&nbsp');
		
		foreach($customers as $customer)
		{
			$checkbox = "<input type='checkbox' onclick='doIt();' id='customer_$customer->id' value='$customer->id'/>";
			$this->table->add_row($checkbox,$customer->first_name,$customer->last_name,
			$customer->email,$customer->phone_number,
			anchor("customers/edit/$customer->id", $this->lang->line('common_edit'),array('class'=>'thickbox')));
		}
		
		$output = $this->table->generate();
		$this->table->clear();
		
		return $output;
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
