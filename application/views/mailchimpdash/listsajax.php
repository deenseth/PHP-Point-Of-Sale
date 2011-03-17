<? if ($message) {  ?>
   <h3><?=$message?></h3>
<? } else { ?>

<table id='lists-members'>
    <tbody>
<? foreach ($members as $member) { ?>
    <?=display_email_data($member, $listid)?>
<? } ?>
    </tbody>
</table>
<script type="text/javascript" language="javascript" charset="UTF-8">

$(document).ready(function(){
    tb_init('a.thickbox');
});

</script>
<? } ?> 