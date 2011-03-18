<?php
require_once ("secure_area.php");
class Mailchimpdash extends Secure_area 
{
    function __construct()
    {
        parent::__construct();

        if ($key = $this->Appconfig->get('mc_api_key')) {
            $this->load->library('MailChimp', array($key), 'MailChimp');
        } else {
            show_error($this->lang->line('common_mailchimp_dashboard_rejected'));
        } 
    }

    function index()
    {
        $this->load->view("mailchimpdash/index");
    }
    
    function lists()
    {
        $data['lists'] = $this->MailChimp->lists();
        
        $this->load->view("mailchimpdash/lists", $data);
    }
    
    function listsajax()
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
        
        if ($members) {
            
        } else { 
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
    
    function listremoveajax()
    {
        $listID = $this->input->post('listid');
        $email = $this->input->post('email');
        
        if ($result = $this->MailChimp->listUnsubscribe($listID, $email, false, false, false)) {
            echo json_encode(array('success'=>true,'message'=>"Unsubscribed {$email} from list"));
        } else {
            echo json_encode(array('success'=>false,'message'=>"Could not unsubscribe {$email} from list"));
        }
    }    
    
    function campaigns()
    {
        $this->load->view('mailchimpdash/campaigns',$data);
    }
    
}
?>