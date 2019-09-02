<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Giftcards extends Secure_area implements iData_controller
{
	function __construct()
	{
		parent::__construct('giftcards');
	}

	function index()
	{
		$config['base_url'] = site_url('/gitcards/index/');
		$config['total_rows'] = $this->Giftcard->count_all();
		$config['per_page'] = '20';
		$config["uri_segment"] = 3;
		$this->pagination->initialize($config);
		$data['search'] = '';
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data['manage_table']=get_giftcards_manage_table($this->Giftcard->get_all($config['per_page'], $page),$this);
		$this->load->view('giftcards/manage',$data);
	}

	function search()
	{
		$search=$this->input->post('search');
		$data['controller_name']=strtolower(get_class());
		$data['search'] = $search;
		$data['manage_table']=get_giftcards_manage_table($this->Giftcard->search($search),$this);
		$this->load->view('giftcards/manage',$data);
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Giftcard->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	function get_row()
	{
		$giftcard_id = $this->input->post('row_id');
		$data_row=get_giftcard_data_row($this->Giftcard->get_info($giftcard_id),$this);
		echo $data_row;
	}

	function view($giftcard_id=-1)
	{
		$data['giftcard_info']=$this->Giftcard->get_info($giftcard_id);

		$this->load->view("giftcards/form",$data);
	}
	
	function save($giftcard_id=-1)
	{
		$giftcard_data = array(
		'giftcard_number'=>$this->input->post('giftcard_number'),
		'value'=>$this->input->post('value')
		);

		if( $this->Giftcard->save( $giftcard_data, $giftcard_id ) )
		{
			//New giftcard
			if($giftcard_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('giftcards_successful_adding').' '.
				$giftcard_data['giftcard_number'],'giftcard_id'=>$giftcard_data['giftcard_id']));
				$giftcard_id = $giftcard_data['giftcard_id'];
			}
			else //previous giftcard
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('giftcards_successful_updating').' '.
				$giftcard_data['giftcard_number'],'giftcard_id'=>$giftcard_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('giftcards_error_adding_updating').' '.
			$giftcard_data['giftcard_number'],'giftcard_id'=>-1));
		}

	}

	function delete()
	{
		$giftcards_to_delete=$this->input->post('ids');

		if($this->Giftcard->delete_list($giftcards_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('giftcards_successful_deleted').' '.
			count($giftcards_to_delete).' '.$this->lang->line('giftcards_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('giftcards_cannot_be_deleted')));
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