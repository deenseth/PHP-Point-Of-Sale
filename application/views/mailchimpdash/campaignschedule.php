<script src="<?php echo base_url();?>js/jsDatePick.jquery.min.1.3.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<script src="<?php echo base_url();?>js/date.js" type="text/javascript" language="javascript" charset="UTF-8"></script>
<link rel="stylesheet" rev="stylesheet" href="<?php echo base_url();?>css/jsDatePick_ltr.css" />

<h3>Schedule Your Campaign</h3>
<br/><br/><br/>
<p>Select a date and time below (time is set to 24 hours)</p>
<form>
    <input id="datepicker" value="<?php echo date('m-d-Y')?>" style="margin-right: 27px;"/>
    <input type="text" id="time" value="<?php echo strftime('%H:%M');?>"/>
    <br/><br/>
    <div id="submit-wrapper" style="float: right;">
        <a onClick='schedule()' class="button pill">Submit</a>
    </div>
    <div class="clear"><!--   --></div>
</form>


<script type="text/javascript">
new JsDatePick({
    useMode:2,
    target:"datepicker"
});

function schedule(){

    mydate = Date.parse($('#datepicker').val() + ' ' + $('#time').val());
    if (mydate === null) {
        alert('Could not parse date -- please try again.');
    }

    mydate.setTimezone('GMT');

    var datestring = mydate.toString('yyyy-MM-d HH:mm:ss');

    var url = document.location.href.replace(/\/campaigns(chedule)?.*/, '/campaignajax/schedule');
    $.post(url, {cid: '<?php echo $cid?>', scheduletime: datestring}, function(response){
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
    });

}

</script>