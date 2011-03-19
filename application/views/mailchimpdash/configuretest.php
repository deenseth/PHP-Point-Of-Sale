<div id="send-test-configure">
<br/><br/>
<h4>Send Test Campaign</h4>
<p>This will send a test email of this campaign to only those emails you list below.</p>
<br/><br/>
<form>
    <label for="test-emails">Enter your emails (separated by commas):</label>
    <textarea rows="3" cols="50" id="test-emails" name="test-emails" ></textarea>
    <br/><br/>
    <a class="pill button" onClick="doSendTest('<?=$campaignid?>')" style="float: right">Submit</a>
    <div class="clear"><!--  --></div>
</form>
</div>
<script type="text/javascript">

function doSendTest(campaignId)
{
	var emailstring = $('#test-emails').val();

	var url = document.location.href.replace(/\/campaigns.*/, '/campaignajax/sendtest');
    $.post(url, {cid: campaignId, emails: emailstring}, function(response){
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