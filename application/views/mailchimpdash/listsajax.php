<? if ($message) {  ?>
   <h3><?=$message?></h3>
<? } else { ?>
<input type="hidden" value="<?=$listid?>" id="listid"/>
<table id='lists-members'>
    <tbody>
<? foreach ($members as $member) { ?>
    <?=display_email_data($member, $listid)?>
<? } ?>
    </tbody>
</table>

<? } ?> 