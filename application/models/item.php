<?php
class Item extends Model
{
	private $AWS_Access_Key='0RTAFSRZ27W8KM2JAJ02';
	private $AWS_AssociateTag='phppos-20';
	
	/*
	Determines if a given item_id is an item
	*/
	function exists($item_id)
	{
		$this->db->from('items');	
		$this->db->where('item_id',$item_id);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
		
	/*
	Returns all the items
	*/
	function get_all()
	{
		$this->db->from('items');
		$this->db->order_by("name", "asc");
		return $this->db->get();		
	}
	
	/*
	Gets information about a particular item
	*/
	function get_info($item_id)
	{
		$this->db->from('items');
		$this->db->where('item_id',$item_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$item_obj=new stdClass();
			
			//Get all the fields from items table
			$fields = $this->db->list_fields('items');
			
			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}
			
			return $item_obj;
		}
	}
	
	/*
	Get an item id given an item number
	*/
	function get_item_id($item_number)
	{
		$this->db->from('items');
		$this->db->where('item_number',$item_number);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row()->item_id;
		}
		
		return false;
	}
	
	/*
	Uses Amazon to find out pricing, name, description of item, list price....
	If amazon does not have information use UPCDatabase.com for basic information
	*/
	function find_item_info($item_number)
	{
		//Get blank info object
		$item_info = $this->get_info(-1);
		
		$request = "http://ecs.amazonaws.com/onca/xml?Service=AWSECommerceService".
		"&AWSAccessKeyId=$this->AWS_Access_Key&AssociateTag=$this->AWS_AssociateTag&SearchIndex=All".
		"&Operation=ItemLookup&ItemId=$item_number&IdType=UPC&ResponseGroup=ItemAttributes,OfferSummary";
		$session = curl_init($request); 
   		curl_setopt($session, CURLOPT_HEADER, false); 
    	curl_setopt($session, CURLOPT_RETURNTRANSFER, true); 
    	$response = curl_exec($session); 
    	curl_close($session);  
		$parsed_xml = simplexml_load_string($response);
		//UPC Search
		if($parsed_xml->Items->Request->IsValid && count($parsed_xml->Items->Request->Errors)==0)
		{
			$item_info->item_number=$item_number;
			$item_info->name=(string)$parsed_xml->Items->Item[0]->ItemAttributes->Title;
			$item_info->description=(string)$parsed_xml->Items->Item[0]->ItemAttributes->Title;
			$item_info->category=(string)$parsed_xml->Items->Item[0]->ItemAttributes->Binding;		
			$item_info->unit_price=(string)$parsed_xml->Items->Item[0]->ItemAttributes->ListPrice->FormattedPrice;
			
			//No list price, get lowest new price
			if($item_info->unit_price==null)
			{
				$item_info->unit_price=(string)$parsed_xml->Items->Item[0]->OfferSummary->LowestNewPrice->FormattedPrice;
			}
			
			//remove any non numberic symbols
			$item_info->unit_price=preg_replace("/[^0-9\.]/","",$item_info->unit_price);
			$item_info->url=(string)$parsed_xml->Items->Item[0]->DetailPageURL;
			$item_info->provider=(string)$this->lang->line('items_amazon');
			return $item_info;
		}
		else
		{
			$this->load->library('xmlrpc');

			$this->xmlrpc->server('http://www.upcdatabase.com/rpc', 80);
			$this->xmlrpc->method('lookupUPC');

			$request = array($item_number);
			$this->xmlrpc->request($request);
	
			if ($this->xmlrpc->send_request())
			{
				$parsed_xml = $this->xmlrpc->display_response();
				if(is_array($parsed_xml))
				{
					$item_info->item_number=$item_number;
					$item_info->name=$parsed_xml['description'];
					$item_info->description=$parsed_xml['issuerCountry'].' - '.$parsed_xml['size'];
					$item_info->url="http://www.upcdatabase.com/item/$item_number";
					$item_info->provider=$this->lang->line('items_upc_database');						
				}
			}
		}
		
		return $item_info;
	}
	
	/*
	Gets information about multiple items
	*/
	function get_multiple_info($item_ids)
	{
		$this->db->from('items');
		$this->db->where_in('item_id',$item_ids);
		$this->db->order_by("item", "asc");
		return $this->db->get();		
	}
	
	/*
	Inserts or updates a item
	*/
	function save(&$item_data,$item_id=false)
	{		
		if (!$item_id or !$this->exists($item_id))
		{
			if($this->db->insert('items',$item_data))
			{
				$item_data['item_id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		
		$this->db->where('item_id', $item_id);
		return $this->db->update('items',$item_data);		
	}
	
	/*
	Updates multiple items at once
	*/
	function update_multiple($item_data,$item_ids)
	{
		$this->db->where_in('item_id',$item_ids);
		return $this->db->update('items',$item_data);		
	}
	
	/*
	Deletes one item
	*/
	function delete($item_id)
	{
		return $this->db->delete('items', array('item_id' => $item_id)); 
	}
	
	/*
	Deletes a list of items
	*/
	function delete_list($item_ids)
	{
		$this->db->where_in('item_id',$item_ids);
		return $this->db->delete('items');		
 	}
 	
 	/*
	Get search suggestions to find items
	*/
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('items');
		$this->db->like('name', $search); 
		$this->db->order_by("name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->name;		
		}
		
		$this->db->from('items');
		$this->db->distinct();		
		$this->db->like('category', $search); 
		$this->db->order_by("category", "asc");		
		$by_category = $this->db->get();
		foreach($by_category->result() as $row)
		{
			$suggestions[]=$row->category;		
		}

		$this->db->from('items');
		$this->db->like('item_number', $search); 
		$this->db->order_by("item_number", "asc");		
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=$row->item_number;		
		}

				
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	
	}
	
	function get_item_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		
		$this->db->from('items');
		$this->db->like('name', $search); 
		$this->db->order_by("name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=$row->item_id.'|'.$row->name;		
		}
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function get_category_suggestions($search)
	{
		$suggestions = array();
		$this->db->distinct();
		$this->db->select('category');
		$this->db->from('items');
		$this->db->like('category', $search); 		
		$this->db->order_by("category", "asc");		
		$by_category = $this->db->get();
		foreach($by_category->result() as $row)
		{
			$suggestions[]=$row->category;		
		}
				
		return $suggestions;
	}
	
	/*
	Preform a search on items
	*/
	function search($search)
	{
		$this->db->from('items');
		$this->db->like('name', $search); 
		$this->db->or_like('item_number', $search);
		$this->db->or_like('category', $search);
		$this->db->order_by("name", "asc");				
		return $this->db->get();	
	}

}
?>
