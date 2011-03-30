<script type="text/javascript">
var summarydata = '';
$('.summary_row').each(function(){
    summarydata += $(this).text() + "\n";
});
$('#campaigntext').val(summarydata);

var listsToGroups = [];

<? foreach ($lists as $list) { ?>
<? if (!$list['groupings']) { continue; } ?>
listsToGroups['<?=$list['id']?>'] = [];
    <? foreach ($list['groupings'] as $grouping) { ?>
    <? foreach ($grouping['groups'] as $group) { ?>
    listsToGroups['<?=$list['id']?>'].push(['<?=$grouping['id']?>-<?=$group['name']?>', '<?=$grouping['name']?>: <?=$group['name']?>']);
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

function campaignCreate()
{
    $.post('<?=base_url()?>index.php/mailchimpdash/generatechartcampaign',
  		                   {title: $('#newcampaign-title-input').val(),
                            chartLocation: $('#newcampaign-chart img').attr('src'),
                            campaignText: $('#campaigntext').val(),
                            listID: $('#listpicker').val(),
                            group: $('#grouppicker').val(),
                            fromEmail: $('#fromEmail').val(),
                            fromName: $('#fromName').val(),
                            toName: $('#toName').val()
                           },
                           function(response) {
                        	   if (typeof(response) != 'object') {
                                   var data = JSON.parse(response);
                               } else {
                                   var data = response;
                               }
                               if (data.success) {
                                   set_feedback(data.message, 'success_message', false);
                               } else {
                                   set_feedback(data.message, 'error_message', true);
                               }
                               tb_remove();
                           });
}
</script>
<link rel="stylesheet" href="<?=base_url()?>css/mailchimpdash/charttocampaign.css" />
<h3 id="exportthis">Export This Report To a Campaign</h3>
<div id="newcampaign">
    <div id="newcampaign-fromemail">
        <label for="fromName">Campaign "From" Email</label><br/>
        <input type="text" id="fromEmail" name="fromEmail" />
    </div>
    <div id="newcampaign-fromname">
        <label for="fromName">Campaign "From" Name</label><br/>
        <input type="text" id="fromName" name="fromName" />
    </div>
    <div id="newcampaign-toname">
        <label for="toName">Campaign "To" Name</label><br/>
        <input type="text" id="toName" name="toName" />
    </div>
    <div id="newcampaign-title">
        <label for="newcampign-title-input">Campaign Title</label><br/>
        <input type="text" id="newcampaign-title-input" name="newcampaign-title-input" />
    </div>
    <div id="newcampaign-chart">
        <img src="<?=base_url().'saved_charts/'.$filename?>" alt="" style="height: 50%; width: 50%;"/>
    </div>
    <div id="newcampaign-campaigntext">
        <label for="campaigntext">Campaign Text</label><br/>
        <textarea id="campaigntext" name="campaigntext" rows="5" cols="30"></textarea>
    </div>
    <br/>
    <div id="newcampaign-listpicker">
        <label for="listpicker">Choose Your List:</label>
        <select id="listpicker" onChange='changeGroups(this);'>
            <option value=""></option>
            <? foreach ($lists as $list) { ?>
            <option value="<?=$list['id']?>"><?=$list['name']?></option>
            <? } ?>
        </select>
        <div id="grouppicker-wrapper" style="display: none;">
        <label for="grouppicker">Group:</label>
        <select id="grouppicker"/>
        </div>
    </div>
    <br/>
    <div id="newcampaign-buttonwrapper">
        <a class="button pill" onClick="campaignCreate()">Create Campaign</a>
    </div>
</div>