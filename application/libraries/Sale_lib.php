<?php
class Sale_lib 
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
	
	function get_mode()
	{
		if(!$this->CI->session->userdata('sale_mode'))
			$this->set_mode('sale');
		
		return $this->CI->session->userdata('sale_mode');
	}
	
	function set_mode($mode)
	{
		$this->CI->session->set_userdata('sale_mode',$mode);
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
			'price'=>$price!=null ? $price: $this->CI->Item->get_info($item_id)->unit_price
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
	
	function edit_item($item_id,$quantity,$price)
	{
		$items = $this->get_cart();
		if(isset($items[$item_id]))
		{
			$items[$item_id]['quantity'] = $quantity;
			$items[$item_id]['price'] = $price;
			$this->set_cart($items);	
		}
		
		return false;
	}
	
	function is_valid_receipt($receipt_sale_id)
	{
		//POS #
		$pieces = explode(' ',$receipt_sale_id);
		
		if(count($pieces)==2)
		{
			return $this->CI->Sale->exists($pieces[1]);
		}
		
		return false;
	}
	
	function return_entire_sale($receipt_sale_id)
	{
		//POS #
		$pieces = explode(' ',$receipt_sale_id);
		$sale_id = $pieces[1];
		
		$this->empty_cart();
		$this->delete_customer();
		
		foreach($this->CI->Sale->get_sale_items($sale_id)->result() as $row)
		{
			$this->add_item($row->item_id,-$row->quantity_purchased,$row->item_unit_price);
		}
		$this->set_customer($this->CI->Sale->get_customer($sale_id)->person_id);
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
	
	function clear_mode()
	{
		$this->CI->session->unset_userdata('sale_mode');
	}
	
	function clear_all()
	{
		$this->clear_mode();
		$this->empty_cart();
		$this->delete_customer();
	}
	
	function get_taxes()
	{
		$taxes = array();
		foreach($this->get_cart() as $item_id=>$item)
		{
			$tax_info = $this->CI->Item_taxes->get_info($item_id);
			
			foreach($tax_info as $tax)
			{
				$name = $tax['percent'].'% ' . $tax['name'];
				$tax_amount=($item['price']*$item['quantity'])*(($tax['percent'])/100);
				
				
				if (!isset($taxes[$name]))
				{
					$taxes[$name] = 0;
				}
				$taxes[$name] += $tax_amount;
			}
		}
		
		return $taxes;
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
			$total+=($item['price']*$item['quantity']);
		}
		
		foreach($this->get_taxes() as $tax)
		{
			$total+=$tax;
		}
		
		return to_currency($total);		
	}
}
?>