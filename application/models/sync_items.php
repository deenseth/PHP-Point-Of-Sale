<?php
class Sync_items extends CI_Model
{
	/*
	Deletes one item
	*/
	function clear_sync()
	{
		$this->db->where('category', 'Remote Inventory');
		return $this->db->update('items', array('deleted' => 1));
	}
}
?>
