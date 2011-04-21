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
        $data['removeAjaxUrl']=site_url(strtolower($this->uri->segment(1)).'/listremoveajax');
        $data['addAjaxUrl']=site_url(strtolower($this->uri->segment(1)).'/listaddajax');
        $data['controller_name'] = get_class();
        
        $this->load->view("people/list_manage",$data);
    }
    
    /*
    Ajax call responsible for removing people from selected mailing list
     */
    function listremoveajax()
    {
        if ($key = $this->Appconfig->get('mc_api_key')) {
            $this->load->library('MailChimp', array($key) , 'MailChimp');
            $data['lists']=$this->MailChimp->lists();
        } else {
            // not likely to encounter -- functionality hidden behind key
            return;
        }
        
        $lists = $this->MailChimp->listsWithGroups();
        
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
                
                if ($this->input->post($list['id'])) {
                    if ($this->MailChimp->listUnsubscribe($list['id'], $person->email, null, 'html', false)) {
                        $removed++;
                    } else {
                        $unremoved++;
                    }   
                } else {
                    
                    foreach($list['groupings'] as $grouping) 
                    {
                        $changed = false;
                        
                        if ($grouping['form_field'] == 'dropdown') {
                            $val = $this->input->post($grouping['name']);
                            if ($val !== 0 && $val !== null) {
                                $selected = true;
                                $group = end(explode('---', $val));
                                $changed = true;
                                foreach ($merge_vars['GROUPINGS'] as &$chimpGrouping)
                                {
                                    if (substr_count($chimpGrouping['groups'], $group)) {
                                        $chimpGrouping['groups'] = substr_replace($group, '', $chimpGrouping['groups']);
                                    }
                                    break;
                                }
                            }
                        } else {
                        
                            foreach ($grouping['groups'] as $group)
                            {
                                if ($this->input->post(str_replace(' ', '_', 
                                                      $list['name'].'---'.$grouping['name'].'---'.$group['name'])) == 1) {
                                    foreach ($merge_vars['GROUPINGS'] as &$chimpGrouping)
                                    {
                                        if ($chimpGrouping['name'] == $grouping['name']) {
                                            $chimpGrouping['groups'] = str_replace($group['name'], '', $chimpGrouping['groups']);
                                            $chimpGrouping['groups'] = str_replace(',,', ',', $chimpGrouping['groups']);
                                            $changed = true;
                                            break;
                                        }
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
        echo json_encode(array('success'=>(!$this->errorMessage), 'message'=>"{$removedText} {$unremovedText} {$this->errorMessage}", 'personid'=>json_encode($this->input->post('personid'))));
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
            // not likely to encounter -- functionality hidden behind key
            return;
        }
        
        $lists = $this->MailChimp->listsWithGroups();
        
        $added = 0;
        $unadded = 0;
        
        foreach ($this->input->post('personid') as $personid) 
        {
            if ($this->MailChimp->handleSubscriptionForPerson($personid)) {
                $added++;
            } else {
                $unadded++;
            }
        }
        
        
        $s = $added > 1 ? 's':'';
        $addedText = $added > 0 ? "{$added} Addition{$s}." : '';
        $unaddedText = $unadded > 0 ? "{$unadded} Unsuccessful." : '';
        echo json_encode(array('success'=>(!$this->errorMessage), 'message'=>"{$addedText} {$unaddedText} {$this->errorMessage}", 'personid'=>json_encode($this->input->post('personid'))));
    }
		
}
?>