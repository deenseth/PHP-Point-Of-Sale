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
    
    function lists($list_id = null)
    {
        $data['lists'] = $this->MailChimp->lists();
        if ($list_id) {
            $data['list_id'] = $list_id;
        } 
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
    
    function campaigns($page=1)
    {
        $slice = ($page-1)*25;
        $response = $this->MailChimp->campaigns(array(), $slice);
        $data['total'] = $response['total'];
        $data['slice'] = $response['slice'];
        $data['page'] = $page;
        $data['campaigns'] = $response['data'];
        $this->load->view('mailchimpdash/campaigns',$data);
    }
    
    function campaignajax($method)
    {
        switch ($method) {
            case 'pause':
                $cid = $this->input->post('cid');
                if ($cid && $this->MailChimp->campaignPause($cid)) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully paused'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not pause campaign'));
                }
                break;
            case 'resume':
                $cid = $this->input->post('cid');
                if ($cid && $this->MailChimp->campaignResume($cid)) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully resumed'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not resume campaign'));
                }
                break;
            case 'delete':
                $cid = $this->input->post('cid');
                if ($cid && $this->MailChimp->campaignDelete($cid)) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully deleted'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not delete campaign'));
                }
                break;
            case 'send':
                $result = ($cid = $this->input->post('cid')) ? $this->MailChimp->campaignSendNow($cid) : false;
                if ($cid && $result) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully sent'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not send campaign'));
                }
                break;
            case 'sendtest':
                $cid = $this->input->post('cid');
                $emails = explode(',', preg_replace('/\s+/', '', $this->input->post('emails')));
                $result = $this->MailChimp->campaignSendTest($cid, $emails);
                if ($cid && $result) {
                    echo json_encode(array('success'=>true, 'message'=>'Test campaign successfully sent'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not send test campaign'));
                }
                break;
            case 'schedule':
                $cid = $this->input->post('cid');
                $scheduletime = $this->input->post('scheduletime');
                if ($cid && $scheduletime && $this->MailChimp->campaignSchedule($cid, $scheduletime)) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully scheduled'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not schedule campaign'));
                }
                break;
        }
    }
    
    function configuretest($cid)
    {
        $data['campaignid'] = $cid;
        $this->load->view('mailchimpdash/configuretest',$data);
    }
    
    function campaignschedule($cid)
    {
        $data['cid'] = $cid;
        $this->load->view('mailchimpdash/campaignschedule',$data);
    }
    
    function campaignshow($cid)
    {
        // @todo revisit this workaround
        // this is kind of annoying -- fix yer api, mailchimp!
        $response = $this->MailChimp->campaigns(array('id'=>$cid), 0, 1000);
        foreach ($response['data'] as $campaign) 
        {
            if ($campaign['id'] == $cid) {
                echo display_campaign_data($campaign);
                die;
            }
        }
    }
    
    function report($cid)
    {
        // @todo revisit this workaround
        // this is kind of annoying -- fix yer api, mailchimp!
        $response = $this->MailChimp->campaigns(array('id'=>$cid), 0, 1000);
        foreach ($response['data'] as $campaign) 
        {
            if ($campaign['id'] == $cid) {
                $data['campaign'] = $campaign;
                break;
            }
        }
        $this->load->view('mailchimpdash/report',$data);
    }
}
?>