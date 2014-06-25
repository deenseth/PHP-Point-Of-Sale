<?php
class Sync_items extends CI_Model
{
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
}
?>
