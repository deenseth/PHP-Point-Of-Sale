<?php
require_once ("person_controller.php");
class Customers extends Person_controller
{
	function __construct()
	{
		parent::__construct('customers');
	}
	
	function index()
	{
	    $data['mailchimp']=($this->config->item('mc_api_key') !== null);
		$data['controller_name']=strtolower($this->uri->segment(1));
		$data['form_width']=$this->get_form_width();
		$data['manage_table']=get_people_manage_table($this->Customer->get_all(),$this);
		$this->load->view('people/manage',$data);
	}
	
	/*
	Returns customer table data rows. This will be called with AJAX.
	*/
	function search()
	{
		$search=$this->input->post('search');
		$data_rows=get_people_manage_table_data_rows($this->Customer->search($search),$this);
		echo $data_rows;
	}
	
	/*
	Displays the form associated with removal of customers from a mailing list
	 */
	function listremove()
	{
	    // grab customer ids from url -- via regex, in spite of jwz
        $data['personids']=explode(',', preg_replace('/.*customerids:([\d,]+).*/', '$1', uri_string()));
        
	    if ($key = $this->config->item('mc_api_key')) {
            $this->load->library('MailChimp', array($key) , 'MailChimp');
            $data['lists']=$this->MailChimp->lists();
        }
        
        $data['ajaxUrl']=site_url(strtolower($this->uri->segment(1)).'/listremoveajax');
        
        $this->load->view("people/list_remove",$data);
	}
	
	/*
	Ajax call responsible for removing customers from selected mailing list
	 */
	function listremoveajax()
	{
	    if ($key = $this->config->item('mc_api_key')) {
            $this->load->library('MailChimp', array($key) , 'MailChimp');
            $data['lists']=$this->MailChimp->lists();
        } else {
            echo '0:You don\'t have a MailChimp API registered.';
        }
        
        $lists = $this->MailChimp->lists();
        
        $removed = 0;
        $unremoved = 0;
        
        foreach ($this->input->post('personid') as $customerid) 
        {
            $customer = $this->Customer->get_info($customerid);
            
            foreach ($lists as $list)
            {
                if ($this->input->post($list['name'])) {
                    if ($this->MailChimp->listUnsubscribe($list['id'], $customer->email, null, 'html', false)) {
                        $removed++;
                    } else {
                        $unremoved++;
                    }
                        
                }
            }
        }
        $removedText = $removed > 0 ? "{$removed} Removed." : '';
        $unremovedText = $unremoved > 0 ? "Unable to remove {$unremoved}." : '';
        echo "1:{$removedText} {$unremovedText}"; 
	}
	
	
	/*
	Responsible for displaying the form responseible for adding customers to a particular mailing list
	 */
	function listadd()
	{
	    // grab customer ids from url -- via regex, in spite of jwz
	    $data['personids']=explode(',', preg_replace('/.*customerids:([\d,]+).*/', '$1', uri_string()));  
	   
	    if ($key = $this->config->item('mc_api_key')) {
	        $this->load->library('MailChimp', array($key) , 'MailChimp');
	        $data['lists']=$this->MailChimp->lists();
	    }
	   
	    $data['ajaxUrl']=site_url(strtolower($this->uri->segment(1)).'/listaddajax');
	    
	    $this->load->view("people/list_add",$data);
	   
	}
	
	/*
	Ajax call responsible for adding customers to selected mailing list
	 */
	
	function listaddajax()
	{
	   if ($key = $this->config->item('mc_api_key')) {
            $this->load->library('MailChimp', array($key) , 'MailChimp');
            $data['lists']=$this->MailChimp->lists();
        } else {
            echo '0:You don\'t have a MailChimp API registered.';
        }
        
        $lists = $this->MailChimp->lists();
        
        $added = 0;
        $unadded = 0;
        
        foreach ($this->input->post('personid') as $customerid) 
        {
            $customer = $this->Customer->get_info($customerid);
            
            foreach ($lists as $list)
            {
                if ($this->input->post($list['name'])) {
                    if ($this->MailChimp->listSubscribe($list['id'], $customer->email, null, 'html', false)) {
                        $added++;
                    } else {
                        $unadded++;
                    }
                        
                }
            }
        }
        $addedText = $added > 0 ? "{$added} Added." : '';
        $unaddedText = $unadded > 0 ? "Unable to add {$unadded}." : '';
        echo "1:{$addedText} {$unaddedText}"; 
	}
	
	/*
	Gives search suggestions based on what is being searched for
	*/
	function suggest()
	{
		$suggestions = $this->Customer->get_search_suggestions($this->input->post('q'),$this->input->post('limit'));
		echo implode("\n",$suggestions);
	}
	
	/*
	Loads the customer edit form
	*/
	function view($customer_id=-1)
	{
		$data['person_info']=$this->Customer->get_info($customer_id);
		$this->load->view("customers/form",$data);
	}
	
	/*
	Inserts/updates a customer
	*/
	function save($customer_id=-1)
	{
		$person_data = array(
		'first_name'=>$this->input->post('first_name'),
		'last_name'=>$this->input->post('last_name'),
		'email'=>$this->input->post('email'),
		'phone_number'=>$this->input->post('phone_number'),
		'address_1'=>$this->input->post('address_1'),
		'address_2'=>$this->input->post('address_2'),
		'city'=>$this->input->post('city'),
		'state'=>$this->input->post('state'),
		'zip'=>$this->input->post('zip'),
		'country'=>$this->input->post('country'),
		'comments'=>$this->input->post('comments')
		);
		$customer_data=array(
		'account_number'=>$this->input->post('account_number')=='' ? null:$this->input->post('account_number'),
		'taxable'=>$this->input->post('taxable')=='' ? 0:1,
		);
		if($this->Customer->save($person_data,$customer_data,$customer_id))
		{
			//New customer
			if($customer_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_adding').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$customer_data['person_id']));
			}
			else //previous customer
			{
				echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_updating').' '.
				$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>$customer_id));
			}
		}
		else//failure
		{	
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('customers_error_adding_updating').' '.
			$person_data['first_name'].' '.$person_data['last_name'],'person_id'=>-1));
		}
	}
	
	/*
	This deletes customers from the customers table
	*/
	function delete()
	{
		$customers_to_delete=$this->input->post('ids');
		
		if($this->Customer->delete_list($customers_to_delete))
		{
			echo json_encode(array('success'=>true,'message'=>$this->lang->line('customers_successful_deleted').' '.
			count($customers_to_delete).' '.$this->lang->line('customers_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>$this->lang->line('customers_cannot_be_deleted')));
		}
	}
	
	/*
	get the width for the add/edit form
	*/
	function get_form_width()
	{			
		return 350;
	}
}
?>