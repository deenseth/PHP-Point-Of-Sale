<?php
require_once ("secure_area.php");
class Mailchimpdash extends Secure_area 
{
    public function __construct()
    {
        parent::__construct();

        if ($key = $this->Appconfig->get('mc_api_key')) {
            $this->load->library('MailChimp', array($key), 'MailChimp');
        } else {
            show_error($this->lang->line('common_mailchimp_dashboard_rejected'));
        } 
    }

    public function index()
    {
        $this->load->view("mailchimpdash/index");
    }
    
    public function lists($list_id = null, $filter = null)
    {
        $data['lists'] = $this->MailChimp->lists();
        if ($list_id) {
            $data['list_id'] = $list_id;
        } 
                
        if ($filter) {
            $data['filter'] = $filter;
        }
        
        $this->load->view("mailchimpdash/lists", $data);
    }
    
    public function listsajax()
    {        
        if ($id = $this->input->post('listid')) { 
            if ($start = $this->input->post('start')) {
                $members = $this->MailChimp->listMembers($id, 'subscribed', NULL, $start, 25);
            } else {
                $members = $this->MailChimp->listMembers($id, 'subscribed', NULL, 0, 25);
            }
        } else { 
            $data['message'] = $this->lang->line('common_list_error');
        }
        
        if (!$members) { 
            $data['message'] = $this->lang->line('common_list_nomembers');
        }
        
        $data['total'] = $members['total'];
        $data['start'] = $start;        
        
        if ($members['total'] > $start+25) {
            $data['visible'] = ($start+1)." through ".$start+25;
        } else {
            $data['visible'] = ($start+1)." through ".$members['total'];
        }
        
        if ($filters = $this->input->post('filters')) {
            $filters = explode(',', $filters);
            $data['filters'] = $filters;
        }
        
        $data['members'] = array();
        
        foreach ($members['data'] as $member) 
        {
            $person = $this->Person->get_by_email($member['email']);
            
            if (!$person) {
                $person = $this->MailChimp->getPersonDataByEmail($member['email'], $id);               
            }
            
            if (!$filters 
                || in_array(strtolower($this->Person->get_person_type($person->person_id)).'s', $filters)) { 
                $data['members'][] = $person;
            }
        }
        
        $data['listid'] = $id;
        
        // style for info bar at bottom;
        if ($start == 0 && $members['total'] <= 25) { 
            $style = 'width: 860px; float; none;';
        } else if ($members['total'] <= 25) {
            $style = 'margin-right: 127px;';
        } else if ($start == 0) {
            $style = 'margin-left: 127px;';
        }
        
        $data['style'] = $style; 
        
        $this->load->view("mailchimpdash/listsajax",$data);
    }
    
    public function listremoveajax()
    {
        $listID = $this->input->post('listid');
        $email = $this->input->post('email');
        
        if ($result = $this->MailChimp->listUnsubscribe($listID, $email, false, false, false)) {
            echo json_encode(array('success'=>true,'message'=>"Unsubscribed {$email} from list"));
        } else {
            echo json_encode(array('success'=>false,'message'=>"Could not unsubscribe {$email} from list: ".$this->MailChimp->errorMessage));
        }
    }
    
    public function update_email_row($person_id, $list)
    {
        $person = $this->Person->get_info($person_id);
        echo display_email_data($person, $list, false);
    }
    
}
?>