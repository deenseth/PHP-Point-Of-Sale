<?php
class Receipt extends CI_Model
{

	private $receipt_path;

	function __construct()
	{
		$this->receipt_path = APPPATH.'/tmp/receipt.txt';
		$this->load->helper('printer_helper');
		$this->load->helper('file');
	}

	function print_receipt($data)
	{
		$today = date("F j, Y, g:i a");  

		$message = init();
		$message .= center();
		$message .= header_style();
		$message .= $this->Appconfig->get('company');
		$message .= reset_styles();
		$message .= new_line();
		$message .= new_line();
		$message .= $this->Appconfig->get('website');
		$message .= new_line();
		$message .= $this->Appconfig->get('address');
		$message .= new_line();
		$message .= $this->Appconfig->get('phone');
		$message .= new_line();
		$message .= new_line();
		$message .= $today;
		$message .= new_line();
		$message .= new_line();
		$message .= "Sale #".$data['sale_id'];
		$message .= new_line();
		$message .= new_line();
		$message .= left();

		foreach($data['cart'] as $product)
		{
			$message .= $product["name"] . " ";
			$message .= to_currency($product["price"]) . " x" . $product["quantity"];
			$message .= new_line();
			if($product['discount'] > 0)
			{
				$message .= "Discount: ". $product['discount'] . "%";
			}
		}
		$message .= new_line();
		$message .= "Sub Total: ". to_currency($data['subtotal']);
		$message .= new_line();
		foreach($data['taxes'] as $tax)
		{
			$message .= "Tax: ". to_currency($tax);
		}
		$message .= new_line();
		$message .= "=======================";
		$message .= new_line();
		$message .= total_style();
		$message .= "Total: ". to_currency($data['total']);
		$message .= reset_styles();
		$message .= new_line();
		$message .= new_line();
		foreach($data['payments'] as $payment)
		{
			$message .= ucfirst($payment['payment_type']) . ": "; 
			$message .= to_currency($payment['payment_amount']);
			$message .= new_line();
		}
		$message .= new_line();
		$message .= "Change: ". $data['amount_change'];
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= open_drawer();
		$message .= new_line();
		$message .= new_line();

		$this->write_receipt($message);
		//$this->send_receipt($receipt_path);
	}


	function write_receipt($message)
	{
		if (!write_file($this->receipt_path, $message))
		{
		     log_message('error', 'Unable to write the file');
		}else{
		     log_message('info', 'File written!');
		}
	}

	function send_receipt($path)
	{
		shell_exec("cat ".$this->receipt_path." > /dev/usb/lp0");
	}
}
?>