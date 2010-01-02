<?php
class Store_lookup extends Model
{
	/*
	Gets information about a particular store host
	*/
	function get_info($host)
	{
		$this->db->from('store_lookup');	
		$this->db->where('host',$host);
		$query = $this->db->get();
		
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		
		return false;
	}
}
?>
