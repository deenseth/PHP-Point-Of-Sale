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
        
        $data['members'] = $members['data'];
        
        $this->load->view("mailchimpdash/listsajax",$data);
    }
    
}
?>