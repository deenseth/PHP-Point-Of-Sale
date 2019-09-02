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
		$this->send_receipt();
	}

	function print_totals($data)	
	{
		$today = date("F j, Y, g:i a"); 
		$message = init();
		$message .= $today;
		$message .= new_line();
		$message .= new_line();
		
		$finalTotal = 0;

		foreach($data['summary_data'] as $summary)
		{
			$message .= "Sale #" . " POS " .$summary['sale_id'] . " | " . to_currency($summary["subtotal"]) . " | " . to_currency($summary["tax"]) . " | " . to_currency($summary["total"]);
			$message .= new_line();
		}
		$message .= new_line();
		foreach($data['sales_totals'] as $sales_total) {
			$finalTotal += $sales_total['total'];
			$message .= $sales_total['payment_type']. ': '.to_currency($sales_total['total']);
			$message .= new_line();
		}
	    $message .= "Total: " . to_currency($finalTotal);
	    $message .= new_line();
	    $message .= new_line();
	    $message .= new_line();
	    $message .= new_line();
	    $message .= new_line();
	    $message .= open_drawer();
	    $message .= new_line();
	    $message .= new_line();

		$this->write_receipt($message);
		$this->send_receipt();
		redirect('home/close');
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

	function send_receipt()
	{
		shell_exec("cat ".$this->receipt_path." > /dev/usb/lp0");
	}
}
?>