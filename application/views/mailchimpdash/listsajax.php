<? if ($message) {  ?>
   <h3><?=$message?></h3>
<? } else { ?>

<? foreach ($members as $member) { ?>
    <?=display_email_data($member, $listid)?>
<? } ?>

<? } ?> 