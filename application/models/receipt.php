<?php
class Receipt extends CI_Model
{

	function __construct()
	{
		$this->load->helper('printer_helper');
		$this->load->helper('file');
	}

	function print_receipt($id, $products, $totals, $tenders)
	{
		$today = date("F j, Y, g:i a");  

		$message = init();
		$message .= center();
		$message .= header_style();
		$message .= "Fairytale";
		$message .= new_line();
		$message .= reset_styles();
		$message .= "Fashion Boutique";
		$message .= new_line();
		$message .= new_line();
		$message .= "www.fairytale-boutique.com";
		$message .= new_line();
		$message .= "319 East 2nd st. Suite #114";
		$message .= new_line();
		$message .="Los Angeles, CA 90012";
		$message .= new_line();
		$message .= "(213) 680-1032";
		$message .= new_line();
		$message .= new_line();
		$message .= $today;
		$message .= new_line();
		$message .= new_line();
		$message .= "Sale #".$id;
		$message .= new_line();
		$message .= new_line();
		$message .= left();

		foreach($products as $product)
		{
			$message .= $product["name"] . " ";
			$message .= "$".$product["price"] . " x" . $product["qty"];
			$message .= new_line();
		}
		$message .= new_line();
		$message .= "Sub Total: $". $totals['subtotal'];
		if($totals['discount'] > 0)
		{
			$message .= new_line();
			$message .= "Discount: ". $totals['discount'];
		}
		$message .= new_line();
		$message .= "Tax: $". $totals['tax'];
		$message .= new_line();
		$message .= "=======================";
		$message .= new_line();
		$message .= total_style();
		$message .= "Total: $". $totals['total'];
		$message .= reset_styles();
		$message .= new_line();
		$message .= new_line();
		foreach($tenders as $tender)
		{
			$message .= ucfirst($tender['type']) . ": "; 
			$message .= "$".$tender['amount'];
			$message .= new_line();
		}
		$message .= new_line();
		$message .= "Change: $". $totals['change'];
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= new_line();
		$message .= open_drawer();
		$message .= new_line();
		$message .= new_line();

		writereceipt($message);
		//sendreceipt();
	}


	function writereceipt($message)
	{
		if (!write_file('./tmp/receipt.txt', $message))
		{
		     log_message('error', 'Unable to write the file');
		}else{
		     log_message('info', 'File written!');
		}
	}

	function sendreceipt()
	{
		shell_exec("cat /var/www/pos/temp/receipt.txt > /dev/usb/lp0");
	}
}
?>