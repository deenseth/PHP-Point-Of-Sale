<?php
class AppConfig extends Model 
{
	
	function exists($key)
	{
		$this->db->from('app_config');	
		$this->db->where('app_config.key',$key);
		$query = $this->db->get();
		
		return ($query->num_rows()==1);
	}
	
	function get_all()
	{
		$this->db->from('app_config');
		$this->db->order_by("key", "asc");
		return $this->db->get();		
	}
	
	function get($key)
	{
		$query = $this->db->get_where('app_config', array('key' => $key), 1);
		
		if($query->num_rows()==1)
		{
			return $query->row()->value;
		}
		
		return "";
		
	}
	
	function save($key,$value)
	{
		$config_data=array(
		'key'=>$key,
		'value'=>$value
		);
		
		$this->db->set($config_data);
		
		if (!$this->exists($key))
		{
			return $this->db->insert('app_config');
		}
		
		$this->db->where('key', $key);
		return $this->db->update('app_config');		
	}
		
	function delete($key)
	{
		return $this->db->delete('app_config', array('key' => $key)); 
	}
	
	function delete_all()
	{
		return $this->db->empty_table('app_config'); 
	}
}

?>