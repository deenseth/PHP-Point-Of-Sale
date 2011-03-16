<? if ($message) {  ?>
   <h3><?=$message?></h3>
<? } else { ?>

<? foreach ($members as $member) { ?>
<p><?=$member['email']?></p>
<? } ?>

<? } ?> 