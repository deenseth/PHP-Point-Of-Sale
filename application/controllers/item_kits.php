<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Item_kits extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('item_kits');
	}

	function index()
	{
		$config['base_url'] = site_url('?c=item_kits&m=index');
		$config['total_rows'] = $this->Item_kit->count_all();
		$config['per_page'] = '20'; 
		$this->pagination->initialize($config);
		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_item_kits_manage_table( $this->Item_kit->get_all($config['per_page'], $this->input->get('per_page')),$this);
		$this->load->view('item_kits/manage',$data);
	}

	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_items_manage_table_data_rows($this->Item_kit->search($search),$this);
		echo $data_rows;
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Item_kit->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function get_row()
	{
		$item_kit_id = $this->input->post('row_id');
		$data_row=get_item_kit_data_row($this->Item_kit->get_info($item_kit_id),$this);
		echo $data_row;
	}

	function view($item_kit_id=-1)
	{
		$data['item_kit_info']=$this->Item_kit->get_info($item_kit_id);
		$this->load->view("item_kits/form",$data);
	}
	
	function save($item_id=-1)
	{
		$item_data = array(
		'name'=>$this->input->post('name'),
		'description'=>$this->input->post('description'),
		'category'=>$this->input->post('category'),
		'supplier_id'=>$this->input->post('supplier_id')=='' ? null:$this->input->post('supplier_id'),
		'item_number'=>$this->input->post('item_number')=='' ? null:$this->input->post('item_number'),
		'cost_price'=>$this->input->post('cost_price'),
		'unit_price'=>$this->input->post('unit_price'),
		'quantity'=>$this->input->post('quantity'),
		'reorder_level'=>$this->input->post('reorder_level'),
		'location'=>$this->input->post('location'),
		'allow_alt_description'=>$this->input->post('allow_alt_description'),
		'is_serialized'=>$this->input->post('is_serialized')
		);
		
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$cur_item_info = $this->Item->get_info($item_id);


		if($this->Item->save($item_data,$item_id))
		{
			//New item
			if($item_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_adding').' '.
				$item_data['name'],'item_id'=>$item_data['item_id']));
				$item_id = $item_data['item_id'];
			}
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('items_successful_updating').' '.
				$item_data['name'],'item_id'=>$item_id));
			}
			
			$inv_data = array
			(
				'trans_date'=>date('Y-m-d H:i:s'),
				'trans_items'=>$item_id,
				'trans_user'=>$employee_id,
				'trans_comment'=>$this->lang->line('items_manually_editing_of_quantity'),
				'trans_inventory'=>$cur_item_info ? $this->input->post('quantity') - $cur_item_info->quantity : $this->input->post('quantity')
			);
			$this->Inventory->insert($inv_data);
			$items_taxes_data = array();
			$tax_names = $this->input->post('tax_names');
			$tax_percents = $this->input->post('tax_percents');
			for($k=0;$k<count($tax_percents);$k++)
			{
				if (is_numeric($tax_percents[$k]))
				{
					$items_taxes_data[] = array('name'=>$tax_names[$k], 'percent'=>$tax_percents[$k] );
				}
			}
			$this->Item_taxes->save($items_taxes_data, $item_id);
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('items_error_adding_updating').' '.
			$item_data['name'],'item_id'=>-1));
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