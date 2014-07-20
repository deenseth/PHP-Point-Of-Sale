<?php
class Sync_items extends CI_Model
{
	private $client;
	private $session;
	private $isCLI;

   	function __construct()
   	{
   		if($this->Appconfig->get('website') && $this->Appconfig->get('magento_soap_user') && $this->Appconfig->get('magento_soap_key'))
		{
			try {
				$api_username = $this->Appconfig->get('magento_soap_user');
				$api_key = $this->Appconfig->get('magento_soap_key');
				$api_url = $this->Appconfig->get('website') . '/api/v2_soap?wsdl=1';
		    	$this->client = new SoapClient($api_url);
		    	//get a session token
		    	$this->session = $this->client->login($api_username, $api_key);
		    } catch (SoapFault $fault) {
				$this->log("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})");
			}
		}
   	}

   	function sync_sales()
   	{
   		//Get the last sync time
		$last_sync = $this->get_last_sync();
		//Get items sold since last sync
		$items_sold = $this->Sale->get_sale_items_after($last_sync);
		
		try {
			//Update inventory on remote server
			foreach ($items_sold as $sold_item) {
				$stock_item = $this->client->catalogInventoryStockItemList($this->session, array($sold_item->item_number));
				$qty = $stock_item[0]->qty;
				$new_qty = $qty - $sold_item->quantity_purchased;
				$result = $this->client->catalogInventoryStockItemUpdate($this->session, $sold_item->item_number, array(
					'qty' => $new_qty
				));
				$this->log("Updated remote inventory for: " . $sold_item->item_number);
			}

			//Save the timestamp so we know the last sync time
			$this->save_sync_time();

		} catch (SoapFault $fault) {
			$this->log("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})");
		}
   	}

   	function sync_inventory()
   	{

   		try {
	   		//Get all products on remote server
			$list = $this->client->catalogProductList($this->session);
			for($i = 0; $i < count($list); $i++){
				$current = $list[$i];
				$attributes = new stdClass();
				$attributes->additional_attributes = array('cost', 'manufacturer', 'price');
			  	$product = $this->client->catalogProductInfo($this->session, $current->product_id, null, $attributes);
			  	$productInventory = $this->client->catalogInventoryStockItemList($this->session, array($current->product_id));
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
			  		$this->log('Name cannot be empty');
			  		continue;
			  	}
			  	if(isset($product->sku)){
			  		$item_data['item_number'] = $product->sku;
			  	}else{
			  		$this->log('sku cannot be empty');
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
			  		$this->log('price cannot be empty');
			  		continue;
			  	}
			  	if(isset($productInventory[0]->qty)){
			  		$item_data['quantity'] = $productInventory[0]->qty;
			  	}else{
			  		$this->log('Quantity cannot be empty');
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

		  		$this->log("Processing: " . $item_data['item_id'] . " " . $item_data['name'] . " " . $item_data['item_number']);
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

			$this->log("Inventory now synced");
		} catch (SoapFault $fault) {
			$this->log("SOAP Fault: (faultcode: {$fault->faultcode}, faultstring: {$fault->faultstring})");
		}
   	}

	/*
	Mark last sync time
	*/
	function save_sync_time()
	{
		$this->db->set('sync_time', 'NOW()', FALSE); 
		$this->db->insert('sync');
	}

	function get_last_sync()
	{	
		$this->db->from('sync');
		$this->db->select('sync_time');
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row()->sync_time;
		}
	}

	function log($message)
	{
		if(is_cli())
      	{
			echo $message . "\r\n";
		}else{
			log_message('info', $message);
		}
	}
}
?>
