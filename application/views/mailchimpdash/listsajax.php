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
<div id="lists-nav-buttons">
    <a class="button pill left" id="nav-button-prev">Previous</a>
    <div id="lists-nav-buttons-info">Viewing N of M members</div>
    <a class="button pill right" id="nav-button-next">Next</a>
    <div class="clear"><!--  --></div>
</div>


<? } ?> 