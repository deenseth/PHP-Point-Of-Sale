<? if ($message) {  ?>
   <h3><?=$message?></h3>
<? } else { ?>
<script src="<?php echo base_url();?>js/thickbox.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function(){
    tb_init('a.thickbox');
});
</script>
<input type="hidden" value="<?=$listid?>" id="listid"/>
<table id='lists-members'>
    <tbody>
<? foreach ($members as $member) { ?>
    <?=display_email_data($member, $listid)?>
<? } ?>
    </tbody>
</table>

<? } ?> 