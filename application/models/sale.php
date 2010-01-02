<?php
class Sale extends Model
{	
	
	function exists($sale_id)
	{
		$this->db->from('sales');	
		$this->db->where('sale_id',$sale_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	function save ($items,$customer_id,$employee_id,$comment,$sale_id=false)
	{
		if(count($items)==0)
			return -1;
		
		$sales_data = array(
		'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
		'employee_id'=>$employee_id,
		'comment'=>$comment
		);
		
		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->insert('sales',$sales_data);
		$sale_id = $this->db->insert_id();
		
		
		foreach($items as $item_id=>$item)
		{
			$sales_items_data = array
			(
				'sale_id'=>$sale_id,
				'item_id'=>$item_id,
				'quantity_purchased'=>$item['quantity'],
				'item_unit_price'=>$item['price']
			);
		
			$this->db->insert('sales_items',$sales_items_data);
			
			//Update stock quantity
			$item_data = array('quantity'=>$this->Item->get_info($item_id)->quantity-$item['quantity']);
			$this->Item->save($item_data,$item_id);
			
			
			
			foreach($this->Item_taxes->get_info($item_id) as $row)
			{
				$this->db->insert('sales_items_taxes', array(
					'sale_id' 	=>$sale_id, 
					'item_id' 	=>$item_id, 
					'name'		=>$row['name'],
					'percent' 	=>$row['percent']
				));
			}
		}
		$this->db->trans_complete();

		return $sale_id;
	}
	
	function get_sale_items($sale_id)
	{
		$this->db->from('sales_items');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();		
	}
	
	function get_customer($sale_id)
	{
		$this->db->from('sales');	
		$this->db->where('sale_id',$sale_id);
		return $this->Customer->get_info($this->db->get()->row()->customer_id);
	}
}
?>
