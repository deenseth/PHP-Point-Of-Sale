<?php
class Inventory extends Model 
{	
	function insert($inventory_data)
	{
		return $this->db->insert('inventory',$inventory_data);
	}
}

?>