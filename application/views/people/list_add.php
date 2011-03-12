<?php foreach ($lists as $list) { ?>
    <?php echo form_checkbox($list['name'], $list['name'], 0);?>
    <?php echo form_label($list['name'], $list['name']);?>
    <br/>
<? } ?>