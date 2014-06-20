<?php
class Sync_items extends CI_Model
{

	/*
	Deletes one item
	*/
	function clear()
	{
		$this->db->where('category', 'Remote Inventory');
		$this->db->delete('items');
		return ($this->db->affected_rows() > 0) ? TRUE : FALSE;
	}
}
?>
