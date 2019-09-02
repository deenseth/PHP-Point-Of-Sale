<?php if ($message) {  ?>
   <h3><?php echo $message?></h3>
<?php } else { ?>
<input type="hidden" value="<?php echo $listid?>" id="listid"/>
<input type="hidden" value="<?php echo $start?>" id="slice"/>
<table id='lists-members'>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th class="actions">Actions</th>
    <tbody>
<?php foreach ($members as $member) { ?>
    <?php if ($row = display_email_data($member, $listid, $filters)) { ?>
        <?php echo $row?>
    <?php $rowSeen = true; } ?>
<?php } ?>
    <?php if (!$rowSeen) { ?>
    <tr><td colspan="4"><em>No users found given your filter settings for this grouping</em></td></tr>
    <?php } ?>
    </tbody>
</table>
<div id="lists-nav-buttons">
    <?php if ($start > 0) { ?>
    <a class="button pill left" id="nav-button-prev" onClick="listPage('<?php echo $listid?>', <?php echo $start-25?>)">Previous</a>
    <?php } ?>
    <div id="lists-nav-buttons-info" style="<?php echo $style?>>">
        Viewing <?php echo $visible ?> of <?php echo $total?> members.
        <?php if ($filters) { ?>
        Filters applied: <?php echo ucwords(implode(', ', $filters))?>
        <?php } ?>
    </div>
    <?php if ($start+25 < $total) { ?>
    <a class="button pill right" id="nav-button-next" onClick="listPage('<?php echo $listid?>', <?php echo $start+25?><?php echo $cid ? ', ' : ''?>)">Next</a>
    <?php } ?>
    <div class="clear"><!--  --></div>
</div>


<?php } ?> 