<? if ($message) {  ?>
   <h3><?=$message?></h3>
<? } else { ?>
<input type="hidden" value="<?=$listid?>" id="listid"/>
<input type="hidden" value="<?=$start?>" id="slice"/>
<table id='lists-members'>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th class="actions">Actions</th>
    <tbody>
<? foreach ($members as $member) { ?>
    <? if ($row = display_email_data($member, $listid, $filters)) { ?>
        <?=$row?>
    <? $rowSeen = true; } ?>
<? } ?>
    <? if (!$rowSeen) { ?>
    <tr><td colspan="4"><em>No users found given your filter settings for this grouping</em></td></tr>
    <? } ?>
    </tbody>
</table>
<div id="lists-nav-buttons">
    <? if ($start > 0) { ?>
    <a class="button pill left" id="nav-button-prev" onClick="listPage('<?=$listid?>', <?=$start-25?>)">Previous</a>
    <? } ?>
    <div id="lists-nav-buttons-info" style="<?=$style?>>">
        Viewing <?=$visible ?> of <?=$total?> members.
        <? if ($filters) { ?>
        Filters applied: <?=ucwords(implode(', ', $filters))?>
        <? } ?>
    </div>
    <? if ($start+25 < $total) { ?>
    <a class="button pill right" id="nav-button-next" onClick="listPage('<?=$listid?>', <?=$start+25?><?=$cid ? ', ' : ''?>)">Next</a>
    <? } ?>
    <div class="clear"><!--  --></div>
</div>


<? } ?> 