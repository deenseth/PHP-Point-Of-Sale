<?php
if ($key = $this->config->item('mc_api_key')) {
    $CI =& get_instance();
    $CI->load->library('MailChimp', array($key) , 'MailChimp');
    $lists=$CI->MailChimp->listsWithGroups();
} else {
    return;
}
?>

<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/list-manage-form-wrapper.css" />

<div id='list-manage-form-wrapper'>
    <h3>List Subscriptions</h3>
    <div class="list" id="header">
        <p class="descriptor" id="lists-descriptor">Lists</p>
        <div class="list-groups">
            <p class="descriptor">Groups</p>
        </div>
        <div class="clear"><!--  --></div>
    </div>
    <?php echo $this->load->view('partial/list_manage_form.php', array('email'=>$email))?>
</div>