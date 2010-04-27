<?php
require_once ("secure_area.php");
class Sales extends Secure_area
{
	function __construct()
	{
		parent::__construct('sales');
		$this->load->library('sale_lib');
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

	function change_mode()
	{
		$mode = $this->input->post("mode");
		$this->sale_lib->set_mode($mode);
		$this->_reload();
	}

	function add()
	{
		$data=array();
		$mode = $this->sale_lib->get_mode();
		$item_id_or_number_or_receipt = $this->input->post("item");
		$quantity = $mode=="sale" ? 1:-1;

		if($this->sale_lib->is_valid_receipt($item_id_or_number_or_receipt) && $mode=='return')
		{
			$this->sale_lib->return_entire_sale($item_id_or_number_or_receipt);
		}
		elseif(!$this->sale_lib->add_item($item_id_or_number_or_receipt,$quantity))
		{
			$data['error']=$this->lang->line('sales_unable_to_add_item');
		}
		$this->_reload($data);
	}

	function edit_item($item_id)
	{
		$data= array();

		$this->form_validation->set_rules('price', 'lang:items_price', 'required|numeric');
		$this->form_validation->set_rules('quantity', 'lang:items_quantity', 'required|integer');
		$this->form_validation->set_rules('discount', 'lang:items_discount', 'required|integer');

		$price = $this->input->post("price");
		$quantity = $this->input->post("quantity");
		$discount = $this->input->post("discount");


		if ($this->form_validation->run() != FALSE)
		{
			$this->sale_lib->edit_item($item_id,$quantity,$discount,$price);
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

	function complete()
	{
		$data['cart']=$this->sale_lib->get_cart();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title']=$this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a');
		$customer_id=$this->sale_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$comment = $this->input->post('comment');
		$emp_info=$this->Employee->get_info($employee_id);
		$payment_type = $this->input->post('payment_type');
		$data['payment_type']=$this->input->post('payment_type');
		
		if ($this->input->post('amount_tendered'))
		{
			$data['amount_tendered'] = $this->input->post('amount_tendered');
			$data['amount_change'] = to_currency($data['amount_tendered'] - round($data['total'], 2));
		}
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}

		//SAVE sale to database
		$data['sale_id']='POS '.$this->Sale->save($data['cart'], $customer_id,$employee_id,$comment,$payment_type);

		$this->load->view("sales/receipt",$data);
		$this->sale_lib->clear_all();
	}
	
	function receipt($sale_id)
	{
		$sale_info = $this->Sale->get_info($sale_id)->row_array();
		$this->sale_lib->copy_entire_sale($sale_id);
		$data['cart']=$this->sale_lib->get_cart();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['receipt_title']=$this->lang->line('sales_receipt');
		$data['transaction_time']= date('m/d/Y h:i:s a', strtotime($sale_info['sale_time']));
		$customer_id=$this->sale_lib->get_customer();
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$emp_info=$this->Employee->get_info($employee_id);
		$data['payment_type']=$sale_info['payment_type'];
		
		$data['employee']=$emp_info->first_name.' '.$emp_info->last_name;

		if($customer_id!=-1)
		{
			$cust_info=$this->Customer->get_info($customer_id);
			$data['customer']=$cust_info->first_name.' '.$cust_info->last_name;
		}
		$data['sale_id']='POS '.$sale_id;
		$this->load->view("sales/receipt",$data);
		$this->sale_lib->clear_all();

	}

	function _reload($data=array())
	{
		$person_info = $this->Employee->get_logged_in_employee_info();
		$data['cart']=$this->sale_lib->get_cart();
		$data['modes']=array('sale'=>$this->lang->line('sales_sale'),'return'=>$this->lang->line('sales_return'));
		$data['mode']=$this->sale_lib->get_mode();
		$data['subtotal']=$this->sale_lib->get_subtotal();
		$data['taxes']=$this->sale_lib->get_taxes();
		$data['total']=$this->sale_lib->get_total();
		$data['items_module_allowed'] = $this->Employee->has_permission('items', $person_info->person_id);
		$data['payment_options']=array(
			$this->lang->line('sales_cash') => $this->lang->line('sales_cash'),
			$this->lang->line('sales_check') => $this->lang->line('sales_check'),
			$this->lang->line('sales_debit') => $this->lang->line('sales_debit'),
			$this->lang->line('sales_credit') => $this->lang->line('sales_credit')
		);

		$customer_id=$this->sale_lib->get_customer();
		if($customer_id!=-1)
		{
			$info=$this->Customer->get_info($customer_id);
			$data['customer']=$info->first_name.' '.$info->last_name;
		}
		$this->load->view("sales/register",$data);
	}

    function cancel_sale()
    {
        //$this->load->view("sales/receipt",$data);
    	$this->sale_lib->clear_all();
    	$this->_reload();

    }

}
?>