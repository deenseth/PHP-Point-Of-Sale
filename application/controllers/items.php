<?php
require_once ("Secure_Area.php");
require_once ("interfaces/iData_Controller.php");
class Items extends Secure_Area implements iData_Controller 
{
	function __construct()
	{
		parent::__construct('items');
		$this->load->language('items');
	}
	
	function index()
	{
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_items_manage_table($this->Item->get_all(),$this);
		$this->load->view('items/manage',$data);
	}
	
	function find_item_info()
	{
		$item_number=$this->input->post('scan_item_number');
		echo json_encode($this->Item->find_item_info($item_number));
	}
	
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_items_manage_table_data_rows($this->Item->search($search),$this);
		echo $data_rows;
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Item->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest_category()
	{
		$suggestions = $this->Item->get_category_suggestions($this->input->post('q'));
		echo implode("\n",$suggestions);
	}
	
	function get_row()
	{
		$item_id = $this->input->post('row_id');
		$data_row=get_item_data_row($this->Item->get_info($item_id),$this);
		echo $data_row;
	}
	
	function view($item_id=-1)
	{
		$data['item_info']=$this->Item->get_info($item_id);
		$this->load->view("items/form",$data);
	}
	
	function bulk_edit()
	{
		$this->load->view("items/form_bulk");
	}
	
	function save($item_id=-1)
	{
		$item_data = array(
		'name'=>$this->input->post('name'),
		'description'=>$this->input->post('description'),
		'category'=>$this->input->post('category'),
		'item_number'=>$this->input->post('item_number')=='' ? null:$this->input->post('item_number'),
		'unit_price'=>$this->input->post('unit_price'),
		'tax_percent'=>$this->input->post('tax_percent'),
		'quantity'=>$this->input->post('quantity'),
		'reorder_level'=>$this->input->post('reorder_level')
		);
		
		if($this->Item->save($item_data,$item_id))
		{
			//New item
			if($item_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_adding').' '.
				$item_data['name'],'item_id'=>$item_data['item_id']));
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_updating').' '.
				$item_data['name'],'item_id'=>$item_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('items_error_adding_updating').' '.
			$item_data['name'],'item_id'=>-1));
		}

	}
	
	function bulk_update()
	{		
		$items_to_update=$this->input->post('item_ids');
		$item_data = array();
		
		foreach($_POST as $key=>$value)
		{
			if($value!='' and $key!='item_ids')
			{
				$item_data["$key"]=$value;
			}
		}
		
		if($this->Item->update_multiple($item_data,$items_to_update))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_bulk_edit')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('items_error_updating_multiple')));
		}
	}
	
	function delete()
	{
		$items_to_delete=$this->input->post('ids');
		
		if($this->Item->delete_list($items_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_deleted').' '.
			count($items_to_delete).' '.$this->lang->line('items_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('items_cannot_be_deleted')));
		}
	}
	
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{			
		return 360;
	}
}
?>