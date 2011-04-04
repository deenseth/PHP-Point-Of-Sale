<?php
require_once (APPPATH."libraries/anet_php_sdk/AuthorizeNet.php");
class Credit_card_receiver extends Controller 
{
	function index()
	{		
		$redirect_url = site_url('sales/complete');
		$api_login_id = $this->config->item('authorize_net_api_login_id');
		$md5_setting = $this->config->item('authorize_net_md5_hash');
		
		$response = new AuthorizeNetSIM($api_login_id, $md5_setting);
		if ($response->isAuthorizeNet())
		{
			if ($response->approved)
			{
				$redirect_url .= '?response_code=1&transaction_id=' .
				$response->getTransactionId();
			}
			else
			{
				$redirect_url .= '?response_code='.$response->response_code . 
				'&response_reason_text=' . $response->response_reason_text;
			}
			
			echo AuthorizeNetDPM::getRelayResponseSnippet($redirect_url);
		}
		else
		{
			echo "Error. Check your MD5 Setting.";
		}
	}
}
?>