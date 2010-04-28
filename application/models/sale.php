<?php
class Sale extends Model
{
	public function get_info($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		return $this->db->get();
	}
	
	function exists($sale_id)
	{
		$this->db->from('sales');
		$this->db->where('sale_id',$sale_id);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}

	function save ($items,$customer_id,$employee_id,$comment,$payment_type,$sale_id=false)
	{
		if(count($items)==0)
			return -1;

		$sales_data = array(
		'customer_id'=> $this->Customer->exists($customer_id) ? $customer_id : null,
		'employee_id'=>$employee_id,
		'payment_type'=>$payment_type,
		'comment'=>$comment
		);

		//Run these queries as a transaction, we want to make sure we do all or nothing
		$this->db->trans_start();

		$this->db->insert('sales',$sales_data);
		$sale_id = $this->db->insert_id();


		foreach($items as $item_id=>$item)
		{
			$cur_item_info = $this->Item->get_info($item_id);

			$sales_items_data = array
			(
				'sale_id'=>$sale_id,
				'item_id'=>$item_id,
				'quantity_purchased'=>$item['quantity'],
				'discount_percent'=>$item['discount'],
				'item_cost_price' => $cur_item_info->cost_price,
				'item_unit_price'=>$item['price']
			);

			$this->db->insert('sales_items',$sales_items_data);

			//Update stock quantity
			$item_data = array('quantity'=>$cur_item_info->quantity - $item['quantity']);
			$this->Item->save($item_data,$item_id);

			$customer = $this->Customer->get_info($customer_id);
			
			if ($customer_id == -1 or $customer->taxable)
			{
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
	
	//We create a temp table that allows us to do easy report/sales queries
	public function create_sales_items_temp_table()
	{
		$this->db->query("CREATE TEMPORARY TABLE ".$this->db->dbprefix('sales_items_temp')." 
		(SELECT date(sale_time) as sale_date, sale_id, comment,payment_type, customer_id, employee_id, item_id, supplier_id, quantity_purchased, item_cost_price, item_unit_price, SUM(percent) as item_tax_percent, 
		discount_percent, (item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) as subtotal,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(1+(SUM(percent)/100)) as total,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100)*(SUM(percent)/100) as tax,
		(item_unit_price*quantity_purchased-item_unit_price*quantity_purchased*discount_percent/100) - (item_cost_price*quantity_purchased) as profit

		FROM ".$this->db->dbprefix('sales_items')."
		INNER JOIN ".$this->db->dbprefix('sales')." USING (sale_id) 
		INNER JOIN ".$this->db->dbprefix('items')." USING (item_id) 
		LEFT OUTER JOIN ".$this->db->dbprefix('suppliers')." ON  ".$this->db->dbprefix('items').'.supplier_id='.$this->db->dbprefix('suppliers').'.person_id'."
		LEFT OUTER JOIN ".$this->db->dbprefix('sales_items_taxes')." USING (sale_id, item_id)
		GROUP BY sale_id, item_id)");
		
		//Update null item_tax_percents to be 0 instead of null
		$this->db->where('item_tax_percent IS NULL');
		$this->db->update('sales_items_temp', array('item_tax_percent' => 0));
		
		//Update null tax to be 0 instead of null
		$this->db->where('tax IS NULL');
		$this->db->update('sales_items_temp', array('tax' => 0));

		//Update null subtotals to be equal to the total as these don't have tax
		$this->db->query('UPDATE '.$this->db->dbprefix('sales_items_temp'). ' SET total=subtotal WHERE total IS NULL');
		
	}
}
?>
