<?php
class Module extends Model 
{
    function __construct()
    {
        parent::__construct();
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
	
	function get_all_modules()
	{
		//The home module is allowed by all users, this is NOT stored in database
		$modules=array('home');
		
		$this->db->from('modules');
		$this->db->order_by("sort", "asc");
		$query = $this->db->get();		
		
		foreach($query->result() as $row)
		{
			$modules[]=$row->module_id;
		}
		return $modules;
	}
	
	function get_allowed_modules()
	{
		$allowed_modules=array();
		foreach($this->get_all_modules() as $module_id)
		{
			if($this->Employee->has_permission($module_id))
			{
				$allowed_modules[]=$module_id;
			}
		}
		return $allowed_modules;
	}
}
?>
