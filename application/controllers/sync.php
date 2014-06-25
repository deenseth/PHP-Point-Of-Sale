<?php
class Sync extends CI_Controller
{

	function index()
	{
		$client = new SoapClient('https://local.fairytale-boutique.com/api/v2_soap?wsdl=1');

		// If somestuff requires api authentification,
		// then get a session token
		$session = $client->login('raspberrypos', '99kXNM3zrNPr');

		//Get the last sync time
		$last_sync = $this->Sync_items->get_last_sync();
		//Get items sold since last sync
		$items_sold = $this->Sale->get_sale_items_after($last_sync);
		//Update inventory on remote server
		foreach ($items_sold as $sold_item) {
			$stock_item = $client->catalogInventoryStockItemList($session, array($sold_item->item_number));
			$qty = $stock_item[0]->qty;
			$new_qty = $qty - $sold_item->quantity_purchased;
			$result = $client->catalogInventoryStockItemUpdate($session, $sold_item->item_number, array(
				'qty' => $new_qty
			));
		}

		//Get all products on remote server
		$list = $client->catalogProductList($session);
		for($i = 0; $i < count($list); $i++){
			$current = $list[$i];
			$attributes = new stdClass();
			$attributes->additional_attributes = array('cost', 'manufacturer', 'price');
		  	$product = $client->catalogProductInfo($session, $current->product_id, null, $attributes);
		  	$productInventory = $client->catalogInventoryStockItemList($session, array($current->product_id));
		  	$price = null;
		  	$cost = null;
		  	foreach($product->additional_attributes as $attribute) {
		  	    if ($attribute->key == "price") {
		  	        $price = $attribute->value;
		  	    }
		  	     if ($attribute->key == "cost") {
		  	        $cost = $attribute->value;
		  	    }
		  	}
		  	$item_data = array();

		  	if(isset($product->name)){
		  		$item_data['name'] = $product->name;
		  	}else{
		  		$this->logError('Name cannot be empty');
		  		continue;
		  	}
		  	if(isset($product->sku)){
		  		$item_data['item_number'] = $product->sku;
		  	}else{
		  		$this->logError('sku cannot be empty');
		  		continue;
		  	}
		  	if(isset($cost)){
		  		$item_data['cost_price'] = $cost;
		  	}else{
		  		$item_data['cost_price'] = 0;
		  	}
		  	if(isset($price)){
		  		$item_data['unit_price'] = $price;
		  	}else{
		  		$this->logError('price cannot be empty');
		  		continue;
		  	}
		  	if(isset($productInventory[0]->qty)){
		  		$item_data['quantity'] = $productInventory[0]->qty;
		  	}else{
		  		$this->logError('Quantity cannot be empty');
		  		continue;
		  	}
		  	$item_data['description'] = isset($product->description)? $product->description : '';
		  	$item_data['category'] = 'Remote Inventory';
		  	$item_data['supplier_id'] = null;
		  	$item_data['reorder_level'] = 0;
		  	$item_data['location'] = 'in store';
		  	$item_data['allow_alt_description'] = 0;
		  	$item_data['is_serialized'] = 0;
	  		$item_data['item_id'] = $this->Item->get_item_id($product->sku);
	  		
	  		//If we have a item_id the item already exists so update otherwise we need to add it
	  		if($item_data['item_id'])
	  		{
	  			$update_data[] = $item_data;
	  		}else{
	  			$add_data[] = $item_data;
	  		}
		}

		//If we have items that need to be updated
		if(isset($update_data))
		{
			$this->Item->update_multiple_by_index($update_data, 'item_id');
		}
		//If we have items that need to be added.
		if(isset($add_data))
		{
			$this->Item->save_multiple($add_data);

			foreach ($add_data as $item) {
				$tax_ids[] = $this->Item->get_item_id($item['item_number']);
			}

			$items_taxes_data[] = array('name'=>'DEFAULT TAX', 'percent'=>10);
			$this->Item_taxes->save_multiple($items_taxes_data, $tax_ids);
		}
		//Save the timestamp so we know when the 
		$this->Sync_items->save_sync_time();
	}

	function logError($message)
	{
		echo $message;
	}

	function save($item_data, $item_id)
	{
		if($this->Item->save($item_data, $item_id))
		{
			//New item
			if($item_id==-1)
			{
				var_dump($item_data);
				exit();
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_adding').' '.
				$item_data['name'],'item_id'=>$item_data['item_id']));
				$item_id = $item_data['item_id'];
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_updating').' '.
				$item_data['name'],'item_id'=>$item_id));
			}
			
			$inv_data = array
			(
				'trans_date'=>date('Y-m-d H:i:s'),
				'trans_items'=>$item_id,
				'trans_user'=>1,
				'trans_comment'=>'Item synced from remote inventory',
				'trans_inventory'=>$item_data['quantity']
			);
			$this->Inventory->insert($inv_data);
			$items_taxes_data = array();
			$tax_names[] = 'DEFAULT TAX';
			$tax_percents[] = 10;
			for($k=0;$k<count($tax_percents);$k++)
			{
				if (is_numeric($tax_percents[$k]))
				{
					$items_taxes_data[] = array('name'=>$tax_names[$k], 'percent'=>$tax_percents[$k] );
				}
			}
			$this->Item_taxes->save($items_taxes_data, $item_id);
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('items_error_adding_updating').' '.
			$item_data['name'],'item_id'=>-1));
		}

	}
}
?>