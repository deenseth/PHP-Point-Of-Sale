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
    
}
?>