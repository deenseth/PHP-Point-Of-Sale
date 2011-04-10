<script type="text/javascript">
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
	var listID = $('#listpicker').val();
	if (!listID) {
		alert("Please select a list");
		return;
	}
    
    $.post('<?=base_url()?>index.php/mailchimpdash/createrepeatablecampaign',
            {title: $('#newcampaign-title-input').val(),
             listID: listID,
             group: $('#grouppicker').val(),
             fromEmail: $('#fromEmail').val(),
             fromName: $('#fromName').val(),
             toName: $('#toName').val(),
             interval: $('#interval-picker').val(),
             reportName: '<?=$report_name?>',
             blurb: $('#campaigntext').val(),
             reportParams: $('#reportparams').val()
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
<h3 id="exportthis">Create a Repeatable Campaign From This Report</h3>
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
    <div id="newcampaign-campaigntext">
        <label for="campaigntext">Blurb</label><br/>
        <textarea id="campaigntext" name="campaigntext" rows="5" cols="30"></textarea>
        <br/>
        <span style="color: #cc0000;">The blurb you enter will show every time a campaign is sent.</span>
    </div>
    <br/>
    <div id="interval-picker-wrapper">
    	<label for="interval-picker">Select Your Interval:</label>
    	<select id="interval-picker">
    		<option value="daily">Daily</option>
    		<option value="weekly">Weekly</option>
    		<option value="monthly">Monthly</option>
    	</select>
    	<br/>
    	<span style="color: #cc0000;">This interval automatically creates the date range for reporting.</span>
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
    <br/><br/>
    <p>More questions about repeatable campaigns? <a href="<?=base_url()?>index.php/mailchimpdash/repeatablecampaignhelp" target="_blank">Learn more!</a>
</div>