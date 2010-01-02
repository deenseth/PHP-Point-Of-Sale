<?php
class Store extends Model
{
	/*
	Gets information about a particular store
	*/
	function get_info($store_id)
	{
		$this->db->from('stores');	
		$this->db->where('store_id',$store_id);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		
		return false;
	}
	
	/*
	Inserts or updates a store
	*/
	function save(&$store_data,$store_id=false)
	{
		$this->db->where('store_id', $store_id);
		return $this->db->update('stores',$store_data);
	}
}
?>
