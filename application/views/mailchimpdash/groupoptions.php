<script type="text/javascript">
var listsToGroups = [];

<? foreach ($lists as $list) { ?>
<? if (!$list['groupings']) { continue; } ?>
listsToGroups['<?=$list['id']?>'] = [];
    <? foreach ($list['groupings'] as $grouping) { ?>
    <? foreach ($grouping['groups'] as $group) { ?>
    listsToGroups['<?=$list['id']?>'].push(['<?=$grouping['id']?>-<?=$group['name']?>', '<?=$grouping['name']?><?=$add ? ': '.$group['name'] : ''?>']);
    <? } ?>
    <? } ?>
<? } ?>

function changeGroups(dom)
{
	var selected = $(dom).find(':selected').val();
	if (selected != '') {
		grouping = listsToGroups[selected];
		if (typeof(grouping) != 'undefined') {
			var optionstring = '<option value=""></option>';
			$(grouping).each(function(){
				optionstring = optionstring + '<option value="'+this[0]+'">'+this[1]+'</option>';
				});
            $('#grouppicker').html(optionstring);
            $('#grouppicker-wrapper').show();
		} else {
			$('#grouppicker-wrapper').hide();
		}
	} else {
		$('#grouppicker').hide();
	} 
}
</script>
<link rel="stylesheet" href="<?=preg_replace('/index.php.*/', '', base_url())?>css/mailchimpdash/charttocampaign.css" />
<h3 id="exportthis"><?=$add ? 'Add to' : 'Create'?> Group</h3>
<div id="groupoptions">
    <div id="groupoptions-listpicker">
        <label for="listpicker">Choose Your List:</label>
        <select id="listpicker" onChange='changeGroups(this);'>
            <option value=""></option>
            <? foreach ($lists as $list) { ?>
            <option value="<?=$list['id']?>"><?=$list['name']?></option>
            <? } ?>
        </select>
        <div id="grouppicker-wrapper" style="display: none;">
        <label for="grouppicker"><?=$add ? 'Group:' : 'Grouping'?></label>
        <select id="grouppicker"/>
        <? if (!$add) { ?>
        <label for="grouptext">Group</label>
        <input type="text" id="group" />
        <? } ?>
        </div>
    </div>
    <br/>
    <div id="groupoptions-buttonwrapper">
        <a class="button pill" onClick="<?=$add ? 'groupAdd()' : 'groupCreate()'?>">Add to Group</a>
    </div>
</div>