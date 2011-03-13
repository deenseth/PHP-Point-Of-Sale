<?php foreach ($lists as $list) { 
$boxdata = array(  'name'        => $list['name'],
                    'id'          => $list['name'],
                    'value'       => $list['name'],
                    'checked'     => false,
                    );
?>

<div class="list">
    <div class="list-main">
    <?php echo form_checkbox($boxdata);?>
    <?php echo form_label($list['name'], $list['name']);?>
    </div>
    <? if (count($list['groupings'])) { ?>
    <div class='list-groups'>
    <? foreach ($list['groupings'] as $grouping) { 
            if ($grouping['form_field'] == 'dropdown') {
                $options = array('');
            }
        ?>
        <div class='list-group'>
        <p class="grouping"><?=$grouping['name']?></p>
        <?php foreach ($grouping['groups'] as $group) {
                switch($grouping['form_field']) {
                    case 'checkboxes':
                        $boxdata = array(   'name'        => str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name']),
                                            'id'          => $group['name'],
                                            'value'       => 1,
                                            'checked'     => false,
                                            );
                        echo form_checkbox($boxdata);
                        break;
                    case 'radio':
                        $boxdata = array(   'name'        => str_replace(' ', '_', $list['name'].'---'.$grouping['name'].'---'.$group['name']),
                                            'id'          => $group['name'],
                                            'value'       => 1,
                                            'checked'     => false,
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
                echo form_dropdown($grouping['name'], $options, '');
            } ?>
        </div>
    <? } ?>
    </div>
    <? } ?>
    <div class="clear"><!--  --></div>
</div>
<? } ?>