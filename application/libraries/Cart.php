<?php
class Cart 
{
	var $CI;
  
  	function __construct()
	{
		$this->CI =& get_instance();
	}
	
	function get_cart()
	{
		if(!$this->CI->session->userdata('cart'))
			$this->set_cart(array());
		
		return $this->CI->session->userdata('cart');
	}
	
	function set_cart($cart_data)
	{
		$this->CI->session->set_userdata('cart',$cart_data);
	}
	
	function get_customer()
	{
		if(!$this->CI->session->userdata('customer'))
			$this->set_customer(-1);
		
		return $this->CI->session->userdata('customer');
	}
	
	function set_customer($customer_id)
	{
		$this->CI->session->set_userdata('customer',$customer_id);
	}
	
	function add_item($item_id,$quantity=1,$price=null,$tax=null)
	{
		//make sure item exists
		if(!$this->CI->Item->exists($item_id))
		{
			//try to get item id given an item_number
			$item_id = $this->CI->Item->get_item_id($item_id);
			
			if(!$item_id)
				return false;
		}
			
		$items = $this->get_cart();
		$item = array($item_id=>
		array(
			'name'=>$this->CI->Item->get_info($item_id)->name,			
			'quantity'=>$quantity,
			'price'=>$price!=null ? $price: $this->CI->Item->get_info($item_id)->unit_price,
			'tax'=>$tax!=null ? $price: $this->CI->Item->get_info($item_id)->tax_percent
			)
		);
			
		//Item already exists, add to quantity
		if(isset($items[$item_id]))
		{
			$items[$item_id]['quantity']+=$quantity;
		}
		else
		{
			//add to existing array
			$items+=$item;
		}
		
		$this->set_cart($items);
		return true;
		
	}
	
	function edit_item($item_id,$quantity,$price,$tax)
	{
		$items = $this->get_cart();
		if(isset($items[$item_id]))
		{
			$items[$item_id]['quantity'] = $quantity;
			$items[$item_id]['price'] = $price;
			$items[$item_id]['tax'] = $tax;
			$this->set_cart($items);	
		}
		
		return false;
	}
	
	function delete_item($item_id)
	{
		$items=$this->get_cart();
		unset($items[$item_id]);
		$this->set_cart($items);
	}
	
	function empty_cart()
	{
		$this->CI->session->unset_userdata('cart');
	}
	
	function delete_customer()
	{
		$this->CI->session->unset_userdata('customer');
	}
	
	function clear_all()
	{
		empty_cart();
		delete_customer();
	}
	
	function get_tax()
	{
		$tax = 0;
		foreach($this->get_cart() as $item)
		{
			$tax+=($item['price']*$item['quantity'])*($item['tax']/100);
		}
		
		return to_currency($tax);
	}
	
	function get_subtotal()
	{
		$subtotal = 0;
		foreach($this->get_cart() as $item)
		{
			$subtotal+=($item['price']*$item['quantity']);
		}
		return to_currency($subtotal);		
	}
	
	function get_total()
	{
		$total = 0;
		foreach($this->get_cart() as $item)
		{
			$total+=($item['price']*$item['quantity'])*(1+($item['tax']/100));
		}
		return to_currency($total);		
	}
}
?>