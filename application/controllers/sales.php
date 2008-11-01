<?php
require_once ("Secure_Area.php");
class Sales extends Secure_Area 
{
	function __construct()
	{
		parent::__construct('sales');	
	}
	
	function index()
	{
		$this->_reload();		
	}
	
	function item_search()
	{
		$suggestions = $this->Item->get_item_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}	
	
	function customer_search()
	{
		$suggestions = $this->Customer->get_customer_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	function select_customer()
	{
		$customer_id = $this->input->post("customer");
		$this->sale_lib->set_customer($customer_id);
		$this->_reload();		
	}
	
	function add_item()
	{
		$data=array();
		
		$item_id_or_number = $this->input->post("item");
		if(!$this->sale_lib->add_item($item_id_or_number))
		{
			$data['error']=$this->lang->line('sales_unable_to_add_item');
		}
		$this->_reload($data);		
	}
	
	function edit_item($item_id)
	{
		$data= array();
		
		$this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
		$this->form_validation->set_rules('tax', 'lang:items_tax', 'required|numeric');
		$this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|integer');
	
		$price = $this->input->post("price");
		$tax = $this->input->post("tax");
		$quantity = $this->input->post("quantity");
		
		if ($this->form_validation->run() != FALSE)
		{
			$this->sale_lib->edit_item($item_id,$quantity,$price,$tax);				
		}
		else
		{
			$data['error']=$this->lang->line('sales_error_editing_item');
		}
		
		$this->_reload($data);		
	}
	
	function delete_item($item_number)
	{
		$this->sale_lib->delete_item($item_number);
		$this->_reload();		
	}

	function delete_customer()
	{
		$this->sale_lib->delete_customer();
		$this->_reload();		
	}
	
	function _reload($data=array())
	{
		$data['cart']=$this->sale_lib->get_cart();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['tax']=$this->sale_lib->get_tax();
		$data['total']=$this->sale_lib->get_total();
		$customer_id=$this->sale_lib->get_customer();
		if($customer_id!=-1)
		{
			$info=$this->Customer->get_info($customer_id);
			$data['customer']=$info->first_name.' '.$info->last_name;
		}
		$this->load->view("sales/register",$data);		
	}

	
}
?>