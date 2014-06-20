<?php
class Sync extends CI_Controller
{

	function index()
	{
		$this->Item->clear_sync();
		exit;
		$client = new SoapClient('https://local.fairytale-boutique.com/api/v2_soap?wsdl=1');

		// If somestuff requires api authentification,
		// then get a session token
		$session = $client->login('raspberrypos', '99kXNM3zrNPr');

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
		  	
		  	$item_data = array(
		  		'name'=>$product->name,
		  		'description'=>$product->description,
		  		'category'=>'Remote Inventory',
		  		'supplier_id'=>null,
		  		'item_number'=>$product->sku,
		  		'cost_price'=>$cost,
		  		'unit_price'=>$price,
		  		'quantity'=>$productInventory[0]->qty,
		  		'reorder_level'=>0,
		  		'location'=>'in store',
		  		'allow_alt_description'=>0,
		  		'is_serialized'=>0
		  	);

		  	$this->save($item_data); 
		}
	}

	function save($item_data, $item_id=-1)
	{
		if($this->Item->save($item_data,$item_id))
		{
			//New item
			if($item_id==-1)
			{
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
			$tax_names = $this->input->post('tax_names');
			$tax_percents = $this->input->post('tax_percents');
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