<?php
require_once ("interfaces/iperson_controller.php");
require_once ("secure_area.php");
abstract class Person_controller extends Secure_area implements iPerson_controller
{
	function __construct($module_id=null)
	{
		parent::__construct($module_id);		
	}
	
	/*
	This returns a mailto link for persons with a certain id. This is called with AJAX.
	*/
	function mailto()
	{
		$people_to_email=$this->input->post('ids');
		
		if($people_to_email!=false)
		{
			$mailto_url='mailto:';
			foreach($this->Person->get_multiple_info($people_to_email)->result() as $person)
			{
				$mailto_url.=$person->email.',';	
			}
			//remove last comma
			$mailto_url=substr($mailto_url,0,strlen($mailto_url)-1);
			
			echo $mailto_url;
			exit;
		}
		echo '#';
	}
	
	/*
	Gets one row for a person manage table. This is called using AJAX to update one row.
	*/
	function get_row()
	{
		$person_id = $this->input->post('row_id');
		$data_row=get_person_data_row($this->Person->get_info($person_id),$this);
		echo $data_row;
	}
	
   /*
    Displays the form associated with subscription management
     */
    function listmanage()
    {
        // grab person ids from url -- via regex, in spite of jwz
        $data['personids']=explode(',', preg_replace('/.*personids:([\d,]+).*/', '$1', uri_string()));
        
        if ($key = $this->config->item('mc_api_key')) {
            $this->load->library('MailChimp', array($key) , 'MailChimp');
            $lists=$this->MailChimp->lists();
            // add groups to lists
            foreach ($lists as &$list) 
            {
                $list['groupings'] = array();
                if ($groupings = $this->MailChimp->listInterestGroupings($list['id'])) {
                    $list['groupings'] = $groupings;
                }
            }
            $data['lists']=$lists;
        }
        
        $data['removeAjaxUrl']=site_url(strtolower($this->uri->segment(1)).'/listremoveajax');
        $data['addAjaxUrl']=site_url(strtolower($this->uri->segment(1)).'/listaddajax');
        
        $this->load->view("people/list_manage",$data);
    }
    
    /*
    Ajax call responsible for removing people from selected mailing list
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
        
        foreach ($this->input->post('personid') as $personid) 
        {
            $person = $this->Person->get_info($personid);
            if (!$person->email) {
                $unremoved++;
                continue;
            }
            foreach ($lists as $list)
            {
                $response = $this->MailChimp->listMemberInfo($list['id'], $person->email);
                $individual = array_shift($response['data']);
                $merge_vars = $individual['merges'];
                $list['groupings'] = array();
                if ($groupings = $this->MailChimp->listInterestGroupings($list['id'])) {
                    $list['groupings'] = $groupings;
                }
                
                if ($this->input->post($list['name'])) {
                    if ($this->MailChimp->listUnsubscribe($list['id'], $person->email, null, 'html', false)) {
                        $removed++;
                    } else {
                        $unremoved++;
                    }   
                } else {
                    
                    foreach($list['groupings'] as $grouping) 
                    {
                        $changed = false;
                        foreach ($grouping['groups'] as $group)
                        {
                            if ($this->input->post(str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name'])) == 1) {
                                foreach ($merge_vars['GROUPINGS'] as &$chimpGrouping)
                                {
                                    if ($chimpGrouping['name'] == $grouping['name']) {
                                        $chimpGrouping['groups'] = str_replace($group['name'], '', $chimpGrouping['groups']);
                                        $chimpGrouping['groups'] = str_replace(',,', ',', $chimpGrouping['groups']);
                                        $changed = true;
                                    }
                                }
                            }
                        }
                        if ($changed) {
                            if ($this->MailChimp->listUpdateMember($list['id'], $person->email, $merge_vars)) {
                                $removed++;
                            } else {
                                $unremoved++;
                            }
                        }
                    }
                }
            }
        }
        $s = $removed > 1 ? 's':'';
        $removedText = $removed > 0 ? "{$removed} Removal{$s}." : '';
        $unremovedText = $unremoved > 0 ? "{$unremoved} Unsuccessful." : '';
        echo "1:{$removedText} {$unremovedText}"; 
    }
    
    
    /*
    Responsible for displaying the form responseible for adding people to a particular mailing list
     */
    function listadd()
    {
        // grab person ids from url -- via regex, in spite of jwz
        $data['personids']=explode(',', preg_replace('/.*personids:([\d,]+).*/', '$1', uri_string()));  
       
        if ($key = $this->config->item('mc_api_key')) {
            $this->load->library('MailChimp', array($key) , 'MailChimp');
            $data['lists']=$this->MailChimp->lists();
        }
       
        $data['ajaxUrl']=site_url(strtolower($this->uri->segment(1)).'/listaddajax');
        
        $this->load->view("people/list_add",$data);
       
    }
    
    /*
    Ajax call responsible for adding people to selected mailing list
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
        
        foreach ($this->input->post('personid') as $personid) 
        {
            $person = $this->Person->get_info($personid);
            if (!$person->email) {
                $unadded++;
                continue;
            }
            foreach ($lists as $list)
            {
                if ($this->input->post($list['name'])) {
                    if ($this->MailChimp->listSubscribe($list['id'], $person->email, null, 'html', false)) {
                        $added++;
                    } else {
                        $unadded++;
                    }
                        
                }
            }
        }
        $s = $added > 1 ? 's':'';
        $addedText = $added > 0 ? "{$added} Addition{$s}." : '';
        $unaddedText = $unadded > 0 ? "{$unadded} Unsuccessful." : '';
        echo "1:{$addedText} {$unaddedText}"; 
    }
		
}
?>