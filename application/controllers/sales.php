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
		$this->load->view("sales/register",array('cart'=>$this->cart->get_cart()));
	}
	
	function item_search()
	{
		$suggestions = $this->Item->get_item_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}	
	
	function add_item()
	{
		$item_id_or_number = $this->input->post("item");
		if(!$this->cart->add_item($item_id_or_number))
		{
			$data['error']=$this->lang->line('sales_unable_to_add_item');
		}
		$data['cart']=$this->cart->get_cart();
		$this->load->view("sales/register",$data);
	}
	
	function edit_item($item_id)
	{
		$this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
		$this->form_validation->set_rules('tax', 'lang:items_tax', 'required|numeric');
		$this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|integer');
	
		$price = $this->input->post("price");
		$tax = $this->input->post("tax");
		$quantity = $this->input->post("quantity");
		
		if ($this->form_validation->run() != FALSE)
		{
			$this->cart->edit_item($item_id,$quantity,$price,$tax);				
		}
		else
		{
			$data['error']=$this->lang->line('sales_error_editing_item');
		}
		$data['cart']=$this->cart->get_cart();
		$this->load->view("sales/register",$data);
		
	}
	
	function delete_item($item_number)
	{
		$this->cart->delete_item($item_number);
		$this->load->view("sales/register",array('cart'=>$this->cart->get_cart()));
	}

	
}
?>