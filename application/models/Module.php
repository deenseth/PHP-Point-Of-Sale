<?php
class Module extends Model 
{
    function Module()
    {
        parent::Model();
  		$this->load->database(get_database_configuration($this->config));      
    }
	
	function get_module_name($module_id)
	{
		$query = $this->db->get_where('modules', array('id' => $module_id), 1);
		
		if ($query->num_rows() ==1)
		{
			$row = $query->row();
			return $this->lang->line($row->name_lang_key);
		}
		
		return $this->lang->line('error_unknown');
	}
	
	function get_module_desc($module_id)
	{
		$query = $this->db->get_where('modules', array('id' => $module_id), 1);
		if ($query->num_rows() ==1)
		{
			$row = $query->row();
			return $this->lang->line($row->desc_lang_key);
		}
	
		return $this->lang->line('error_unknown');	
	}
	
	function get_modules()
	{
		$modules=array();
		$query = $this->db->get_where('modules');
		foreach($query->result() as $row)
		{
			$modules=$row->id;
		}
		return $modules;
	}
}
?>
