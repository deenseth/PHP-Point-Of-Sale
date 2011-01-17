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
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_giftcards_manage_table($this->Giftcard->get_all(),$this);
		$this->load->view('giftcards/manage',$data);
	}

	function refresh()
	{
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_giftcards_manage_table($this->Giftcard->get_all(),$this);
		$this->load->view('giftcards/manage',$data);
	}

	function find_giftcard_info()
	{
		$giftcard_number=$this->input->post('scan_giftcard_number');
		echo json_encode($this->Giftcard->find_giftcard_info($giftcard_number));
	}

	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_giftcards_manage_table_data_rows($this->Giftcard->search($search),$this);
		echo $data_rows;
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Giftcard->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}

	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest_category()
	{
		$suggestions = $this->Giftcard->get_category_suggestions($this->input->post('q'));
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
		$suppliers = array('' => $this->lang->line('giftcards_none'));

		$this->load->view("giftcards/form",$data);
	}
	
	function count_details($giftcard_id=-1)
	{
		$data['giftcard_info']=$this->Giftcard->get_info($giftcard_id);
		$this->load->view("giftcards/count_details",$data);
	} //------------------------------------------- Ramel

	function generate_barcodes($giftcard_ids)
	{
		$result = array();

		$giftcard_ids = explode(',', $giftcard_ids);
		foreach ($giftcard_ids as $giftcard_id)
		{
			$giftcard_info = $this->Giftcard->get_info($giftcard_id);

			$result[] = array('name' =>$giftcard_info->name, 'id'=> $giftcard_id);
		}

		$data['giftcards'] = $result;
		$this->load->view("barcode_sheet", $data);
	}
	
	function save($giftcard_id=-1)
	{
		$giftcard_data = array(
		'giftcard_number'=>$this->input->post('giftcard_number'),
		'value'=>$this->input->post('value')
		);
		
		$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
		$cur_giftcard_info = $this->Giftcard->get_info($giftcard_id);


		if($this->Giftcard->save($giftcard_data,$giftcard_id))
		{
			log_message( 'debug', 'Giftcard save successful.' );
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

	/**
	 * Display form: Import data from an excel file
	 * @author: Nguyen OJB
	 * @since: 10.1
	 */
	function excel_import()
	{
		$this->load->view("giftcards/excel_import", null);
	}

	/**
	 * Read data from excel file -> save it to databse
	 * @author: Nguyen OJB
	 * @since: 10.1
	 */
	function do_excel_import()
	{
		$msg = "do_excel_import";
		$failCodes = null;
		$successCode = null;
		if ($_FILES['file_path']['error']!=UPLOAD_ERR_OK)
		{
			$msg = $this->lang->line('giftcards_excel_import_failed');
			echo json_encode( array('success'=>false,'message'=>$msg) );
			return ;
		}
		else
		{
			$this->load->library('spreadsheetexcelreader');
			$this->spreadsheetexcelreader->store_extended_info = false;
			$success = $this->spreadsheetexcelreader->read($_FILES['file_path']['tmp_name']);

			$rowCount = $this->spreadsheetexcelreader->rowcount(0);
			if($rowCount > 2){
				for($i = 3; $i<=$rowCount; $i++){
					$giftcard_code = $this->spreadsheetexcelreader->val($i, 'A');
					$giftcard_id = $this->Giftcard->get_giftcard_id($giftcard_code);
					$giftcard_data = array(
					'name'			=>	$this->spreadsheetexcelreader->val($i, 'B'),
					'description'	=>	$this->spreadsheetexcelreader->val($i, 'K'),
					'category'		=>	$this->spreadsheetexcelreader->val($i, 'C'),
					//'supplier_id'	=>	null,
					'giftcard_number'	=>	$this->spreadsheetexcelreader->val($i, 'A'),
					'cost_price'	=>	$this->spreadsheetexcelreader->val($i, 'E'),
					'unit_price'	=>	$this->spreadsheetexcelreader->val($i, 'F'),
					'quantity'		=>	$this->spreadsheetexcelreader->val($i, 'I'),
					'reorder_level'	=>	$this->spreadsheetexcelreader->val($i, 'J')
					);

					if($this->Giftcard->save($giftcard_data,$giftcard_id)) {
						$successCode[] = $giftcard_code;
						
						//Ramel Inventory Tracking
						//update Inventory count details from Excel Import
							$giftcard_code = $this->spreadsheetexcelreader->val($i, 'A');
							$giftcard_id = $this->Giftcard->get_giftcard_id($giftcard_code);
							$employee_id=$this->Employee->get_logged_in_employee_info()->person_id;
							$emp_info=$this->Employee->get_info($employee_id);
							$comment ='Qty Excel Imported: means BEGIN/RESET/ACTUAL count';
							$excel_data = array
								(
								'trans_giftcards'=>$giftcard_id,
								'trans_user'=>$employee_id,
								'trans_comment'=>$comment,
								'trans_inventory'=>$this->spreadsheetexcelreader->val($i, 'I')
								);
								$this->db->insert('inventory',$excel_data);
						//------------------------------------------------Ramel
					}
					else//insert or update giftcard failure
					{
						$failCodes[] = $giftcard_code ;
					}
				}

			} else {
				// rowCount < 2
				echo json_encode( array('success'=>true,'message'=>'Your upload file has no data or not in supported format.') );
				return;
			}
		}

		$success = true;
		if(count($failCodes) > 1){
			$msg = "Most giftcards imported. But some were not, here is list of their CODE (" .count($failCodes) ."): ".implode(", ", $failCodes);
			$success = false;
		}else{
			$msg = "Import giftcards successful";
		}

		echo json_encode( array('success'=>$success,'message'=>$msg) );
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