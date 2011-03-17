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
    <? if ($start > 0) { ?>
    <a class="button pill left" id="nav-button-prev" onClick="listPage('<?=$listid?>', <?=$start-25?>)">Previous</a>
    <? } ?>
    <div id="lists-nav-buttons-info" style="<?=$style?>>">
        Viewing <?=$visible?> of <?=$total?> members
    </div>
    <? if ($start+25 < $total) { ?>
    <a class="button pill right" id="nav-button-next" onClick="listPage('<?=$listid?>', <?=$start+25?>)">Next</a>
    <? } ?>
    <div class="clear"><!--  --></div>
</div>


<? } ?> 