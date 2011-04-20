<script type="text/javascript">
var listsToGroups = [];

<?php foreach ($lists as $list) { ?>
<?php if (!$list['groupings']) { continue; } ?>
listsToGroups['<?php echo $list['id']?>'] = [];
    <?php foreach ($list['groupings'] as $grouping) { ?>
    <?php foreach ($grouping['groups'] as $group) { ?>
    listsToGroups['<?php echo $list['id']?>'].push(['<?php echo $grouping['id']?>-<?php echo $group['name']?>', '<?php echo $grouping['name']?>: <?php echo $group['name']?>']);
    <?php } ?>
    <?php } ?>
<?php } ?>

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

    $.post('<?php echo base_url()?>index.php/mailchimpdash/creatersscampaign',
            {title: $('#newcampaign-title-input').val(),
             listID: listID,
             group: $('#grouppicker').val(),
             fromEmail: $('#fromEmail').val(),
             fromName: $('#fromName').val(),
             toName: $('#toName').val(),
             interval: $('#interval-picker').val(),
             reportName: '<?php echo $report_name?>',
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
<link rel="stylesheet" href="<?php echo base_url()?>css/mailchimpdash/charttocampaign.css" />
<h3 id="exportthis">Create a RSS Campaign From This Report</h3>
<div id="newcampaign">
    <div id="newcampaign-fromemail">
        <label for="fromName">Campaign "From" Email</label><br/>
        <input type="text" id="fromEmail" name="fromEmail" value=""/>
    </div>
    <div id="newcampaign-fromname">
        <label for="fromName">Campaign "From" Name</label><br/>
        <input type="text" id="fromName" name="fromName" value=""/>
    </div>
    <div id="newcampaign-toname">
        <label for="toName">Campaign "To" Name</label><br/>
        <input type="text" id="toName" name="toName" value="" />
    </div>
    <div id="newcampaign-title">
        <label for="newcampign-title-input">Campaign Title</label><br/>
        <input type="text" id="newcampaign-title-input" name="newcampaign-title-input" value="" />
    </div>
    <br/>
    <div id="interval-picker-wrapper">
    	<label for="interval-picker">Select Your Interval:</label>
    	<select id="interval-picker" value="value="<?php echo $report ? $report->interval : ''?>"">
    		<option value="daily">Daily</option>
    		<option value="weekly">Weekly</option>
    		<option value="monthly">Monthly</option>
    	</select>
    	<br/>
    </div>
    <br/>
    <div id="newcampaign-listpicker">
        <label for="listpicker">Choose Your List:</label>
        <select id="listpicker" onChange='changeGroups(this);'>
            <option value="value="<?php echo $report ? $report->list_id : ''?>""></option>
            <?php foreach ($lists as $list) { ?>
            <option value="<?php echo $list['id']?>"><?php echo $list['name']?></option>
            <?php } ?>
        </select>
        <div id="grouppicker-wrapper" style="display: none;">
        <label for="grouppicker">Group:</label>
        <select id="grouppicker" value="value="<?php echo $report->grouping_id ? $report->grouping_id . '-' . $report->grouping_value : ''?>""/>
        </div>
    </div>
    <br/>
    <div id="newcampaign-buttonwrapper">
        <a class="button pill" onClick="campaignCreate()">Create Campaign</a>
    </div>
</div>