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
    
    function lists($list_id = null, $cid = null, $filter = null)
    {
        $data['lists'] = $this->MailChimp->lists();
        if ($list_id) {
            $data['list_id'] = $list_id;
        } 
        
        if ($cid) {
            $data['cid'] = $cid;
        }
        
        if ($filter) {
            $data['filter'] = $filter;
        }
        
        $this->load->view("mailchimpdash/lists", $data);
    }
    
    function listsajax()
    {
        $cid = $this->input->post('campaignid');
        
        if ($cid) {
            $data['cid'] = $cid;
        }
        
        if ($id = $this->input->post('listid')) { 
            if ($start = $this->input->post('start')) {
                $members = $cid ? $this->MailChimp->campaignMembers($cid, null, $start, 25)
                         : $this->MailChimp->listMembers($id, 'subscribed', NULL, $start, 25);
            } else {
                $members = $cid ? $this->MailChimp->campaignMembers($cid, null, 0, 25)
                         : $this->MailChimp->listMembers($id, 'subscribed', NULL, 0, 25);
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
            echo json_encode(array('success'=>false,'message'=>"Could not unsubscribe {$email} from list: ".$this->MailChimp->errorMessage));
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
                    echo json_encode(array('success'=>false, 'message'=>'Could not pause campaign: '.$this->MailChimp->errorMessage));
                }
                break;
            case 'resume':
                $cid = $this->input->post('cid');
                if ($cid && $this->MailChimp->campaignResume($cid)) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully resumed'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not resume campaign: '.$this->MailChimp->errorMessage));
                }
                break;
            case 'delete':
                $cid = $this->input->post('cid');
                if ($cid && $this->MailChimp->campaignDelete($cid)) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully deleted'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not delete campaign: '.$this->MailChimp->errorMessage));
                }
                break;
            case 'send':
                $result = ($cid = $this->input->post('cid')) ? $this->MailChimp->campaignSendNow($cid) : false;
                if ($cid && $result) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully sent'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not send campaign: '.$this->MailChimp->errorMessage));
                }
                break;
            case 'sendtest':
                $cid = $this->input->post('cid');
                $emails = explode(',', preg_replace('/\s+/', '', $this->input->post('emails')));
                $result = $this->MailChimp->campaignSendTest($cid, $emails);
                if ($cid && $result) {
                    echo json_encode(array('success'=>true, 'message'=>'Test campaign successfully sent'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not send test campaign: '.$this->MailChimp->errorMessage));
                }
                break;
            case 'schedule':
                $cid = $this->input->post('cid');
                $scheduletime = $this->input->post('scheduletime');
                if ($cid && $scheduletime && $this->MailChimp->campaignSchedule($cid, $scheduletime)) {
                    echo json_encode(array('success'=>true, 'message'=>'Campaign successfully scheduled'));
                } else {
                    echo json_encode(array('success'=>false, 'message'=>'Could not schedule campaign: '.$this->MailChimp->errorMessage));
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
        $data['listid'] = $campaign['list_id'];
        $data['campaignStats'] = $this->MailChimp->campaignStats($cid);
        $data['campaignAdvice'] = $this->MailChimp->campaignAdvice($cid);
        $data['vipReport'] = $this->MailChimp->campaignShareReport($cid);
        $data['drilldownReportData'] = $this->_getDrilldownReportData($cid);
        $this->load->view('mailchimpdash/report',$data);
    }
    
    private function _getDrilldownReportData($cid)
    {
        $stats =    array('Customer'    =>  array('sent'=>0, 'hard'=>0, 'soft'=>0, 'unsubscribes'=>0),
                          'Employee'    =>  array('sent'=>0, 'hard'=>0, 'soft'=>0, 'unsubscribes'=>0),
                          'Supplier'    =>  array('sent'=>0, 'hard'=>0, 'soft'=>0, 'unsubscribes'=>0),
                          'None'        =>  array('sent'=>0, 'hard'=>0, 'soft'=>0, 'unsubscribes'=>0),
                         );
        $response = $this->MailChimp->campaignMembers($cid);
        if ($response['total'] > 10000) {
            $secondResponse = $this->MailChimp->campaignMembers($cid, null, 1000, $response['total'] - 1000);
            $members = array_merge($response['data'], $secondResponse['data']);
        } else {
            $members = $response['data'];
        }
        
        foreach ($members as $member)
        {
            if ($person = $this->Person->get_by_email($member['email'])) {
                if (($type = $this->Person->get_person_type($person->id)) && ($type != 'Person')) {
                    $stats[$type][$member['status']]++;
                } else {
                    $stats['None'][$member['status']]++;
                }
            } else {
                $stats['None'][$member['status']]++;
            }
        }
        
        $unsubscribes = $this->MailChimp->campaignUnsubscribes($cid, 0, $response['total']);

        foreach ($unsubscribes as $unsub)
        {
            if ($person = $this->Person->get_by_email($unsub['email'])) {
                if (($type = $this->Person->get_person_type($person->id)) && ($type != 'Person')) {
                    $stats[$type]['unsubscribes']++;
                } else {
                    $stats['None']['unsubscribes']++;
                }
            } else {
                $stats['None']['unsubscribes']++;
            }
        }
        
        return $stats;
    }
    
    function charttocampaign($filename=null)
    {
        // screw you thickbox
        if ($filename && !preg_match('/.*random:.*/', $filename)) {
            $data['filename'] = $filename.'.png';
        }
        
        $data['lists'] = $this->MailChimp->listsWithGroups();
        $this->load->view('mailchimpdash/charttocampaign', $data);
    }
    
    function generatechartcampaign()
    {
        $title = $this->input->post('title');
        $listID = $this->input->post('listID');
        $group = $this->input->post('group');
        $chartLocation = $this->input->post('chartLocation');
        $campaignText = $this->input->post('campaignText');
        $fromEmail = $this->input->post('fromEmail');
        $fromName = $this->input->post('fromName');
        $toName = $this->input->post('toName');
        
        $data['title'] = $title;
        $data['png'] = base64_encode(file_get_contents($chartLocation));
        $data['campaignText'] = nl2br(strip_tags($campaignText));
        
        $html = $this->load->view('mailchimpdash/generatechartcampaign', $data, true);
        
        $options = array('list_id'      =>  $listID,
                         'subject'      =>  $title,
                         'from_email'   =>  $fromEmail,
                         'from_name'    =>  $fromName,
                         'to_name'      =>  $toName,
                         'generate_text'=>  true);
        
        $segmentOptions = array();
        if ($group) {
            $ploded = explode('-', $group);
            $groupingID = array_shift($ploded);
            $groupName = implode('-', $ploded);
            
            $segmentOptions['match'] = 'all';
            $segmentOptions['conditions'] = array(array('field'=>'interests-'.$groupingID,
                                                        'op'   =>'one',
                                                        'value'=>$groupName));
        }
        
        $id = $this->MailChimp->campaignCreate('regular', $options, array('html'=>$html), $segmentOptions); 
        
        if ($id) {
            echo json_encode(array('success'=>true,'message'=>"Campaign created"));
        } else {
            echo json_encode(array('success'=>false,'message'=>"Could not create campaign: " . $this->MailChimp->errorMessage));
        }
    }
    
    function generatebasiccampaign()
    {
        $title = $this->input->post('title');
        $listID = $this->input->post('listID');
        $group = $this->input->post('group');
        $campaignText = $this->input->post('campaignText');
        $fromEmail = $this->input->post('fromEmail');
        $fromName = $this->input->post('fromName');
        $toName = $this->input->post('toName');
        $chartHtml = $this->input->post('chartHtml');
        
        $data['title'] = $title;
        $data['campaignText'] = nl2br(strip_tags($campaignText));
        $data['chartHtml'] = $chartHtml;
        
        $html = $this->load->view('mailchimpdash/generatebasiccampaign', $data, true);
        
        $options = array('list_id'      =>  $listID,
                         'subject'      =>  $title,
                         'from_email'   =>  $fromEmail,
                         'from_name'    =>  $fromName,
                         'to_name'      =>  $toName,
                         'generate_text'=>  true);
        
        $segmentOptions = array();
        if ($group) {
            $ploded = explode('-', $group);
            $groupingID = array_shift($ploded);
            $groupName = implode('-', $ploded);
            
            $segmentOptions['match'] = 'all';
            $segmentOptions['conditions'] = array(array('field'=>'interests-'.$groupingID,
                                                        'op'   =>'one',
                                                        'value'=>$groupName));
        }
        
        $id = $this->MailChimp->campaignCreate('regular', $options, array('html'=>$html), $segmentOptions); 
        
        if ($id) {
            echo json_encode(array('success'=>true,'message'=>"Campaign created"));
        } else {
            echo json_encode(array('success'=>false,'message'=>"Could not create campaign: " . $this->MailChimp->errorMessage));
        }
    }
}
?>