<?php
class Sale extends Model
{	
	function save ($items,$customer_id,$employee_id,$comment,$sale_id=false)
	{
		if(count($items)==0)
			return -1;
		
		$sales_data = array(
		'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
		'employee_id'=>$employee_id,
		'comment'=>$comment
		);
		
		$this->db->insert('sales',$sales_data);
		$sale_id = $this->db->insert_id();
		
		
		foreach($items as $item_id=>$item)
		{
			$sales_items_data = array
			(
				'sale_id'=>$sale_id,
				'item_id'=>$item_id,
				'quantity_purchased'=>$item['quantity'],
				'item_unit_price'=>$item['price'],
				'item_tax_percent'=>$item['tax']				
			);
		
			$this->db->insert('sales_items',$sales_items_data);
			
		}
		
		return $sale_id;
	}
}
?>
