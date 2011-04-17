<?php
if ($key = $this->config->item('mc_api_key')) {
    $CI =& get_instance();
    $CI->load->library('MailChimp', array($key) , 'MailChimp');
    $lists=$CI->MailChimp->listsWithGroups();
} else {
    return;
}

foreach ($lists as $list) { 
$boxdata = array(  'name'        => $list['id'],
                    'id'          => $list['id'],
                    'value'       => $list['id'],
                    'checked'     => $CI->MailChimp->isEmailSubscribedToList($list['id'], $email),
                    'label'		=> $list['name']
                    );
?>

<div class="list">
    <div class="list-main">
    <?php echo form_checkbox($boxdata);?>
    <?php echo form_label($list['name'], $list['name']);?>
    </div>
    <?php if (count($list['groupings'])) { ?>
    <div class='list-groups'>
    <?php foreach ($list['groupings'] as $grouping) { 
            if ($grouping['form_field'] == 'dropdown') {
                $options = array('');
            }
        ?>
        <div class='list-group'>
        <p class="grouping"><?php echo $grouping['name']?></p>
        <?php foreach ($grouping['groups'] as $group) {
                switch($grouping['form_field']) {
                    case 'checkboxes':
                        $boxdata = array(   'name'        => str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name']),
                                            'id'          => $group['name'],
                                            'value'       => 1,
                                            'checked'     => $CI->MailChimp->isEmailSubscribedToGroup($list['id'], $grouping['name'], $group['name'], $email),
                                            );
                        echo form_checkbox($boxdata);
                        break;
                    case 'radio':
                        $boxdata = array(   'name'        => str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name']),
                                            'id'          => $group['name'],
                                            'value'       => 1,
                                            'checked'     => $CI->MailChimp->isEmailSubscribedToGroup($list['id'], $grouping['name'], $group['name'], $email),
                                            );
                        echo form_radio($boxdata);
                        break;
                    case 'dropdown':
                        $options[str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name'])] = $group['name'];
                        break;
                        
                }        
                if (!in_array($grouping['form_field'], array('hidden', 'dropdown'))) { 
                    echo form_label($group['name'], $group['name']);
                } 
            } 
            if ($grouping['form_field'] == 'dropdown') {                
                $defaultValue = $CI->MailChimp->isEmailSubscribedToGroup($list['id'], $grouping['name'], $group['name'], $email) 
                              ? str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name'])
                              : '';   
                echo form_dropdown($grouping['name'], $options, $defaultValue);
            } ?>
        </div>
    <?php } ?>
        <div class="clear"><!--  --></div>
    </div>
    <?php } ?>
    <div class="clear"><!--  --></div>
</div>
<?php } ?>