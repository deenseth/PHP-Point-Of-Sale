function expand(dom) 
{
	var ele = $(dom);
	var body = ele.parent('.campaign-header-right').parent('.campaign-header').parent('.campaign').find('.campaign-body');
	body.slideToggle(100);
	if (ele.css('background-image').match(/minus/)) {
		ele.css('background-image', ele.css('background-image').replace(/minus/, 'plus'));
	} else {
		ele.css('background-image', ele.css('background-image').replace(/plus/, 'minus'));
	}
}

function campaignPause(campaignId)
{
	json = {cid:campaignId};
	var url = document.location.href.replace(/\/campaigns.*/, '/campaignajax/pause');
	$.post(url, {cid: campaignId}, function(response){
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

function campaignResume(campaignId)
{
	json = {cid:campaignId};
	var url = document.location.href.replace(/\/campaigns.*/, '/campaignajax/resume');
	$.post(url, {cid: campaignId}, function(response){
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

function campaignDelete(campaignId)
{
	if (!confirm('This will delete this campaign forever. Are you sure?')) {
		return;
	}
	
	json = {cid:campaignId};
	var url = document.location.href.replace(/\/campaigns.*/, '/campaignajax/delete');
	$.post(url, {cid: campaignId}, function(response){
		if (typeof(response) != 'object') {
			var data = JSON.parse(response);
		} else {
			var data = response;
		}
		if (data.success) {
			set_feedback(data.message, 'success_message', false);
			var box = $('campaign-'+campaignId);
			box.slideUp(500);
			box.remove();
		} else {
			set_feedback(data.message, 'error_message', true);
		}
	});
	
	
}

function campaignSend(campaignId)
{
	json = {cid:campaignId};
	var url = document.location.href.replace(/\/campaigns.*/, '/campaignajax/send');
	$.post(url, {cid: campaignId}, function(response){
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

function campaignSchedule(campaignId)
{
	json = {cid:campaignId};
	var url = document.location.href.replace(/\/campaigns.*/, '/campaignajax/schedule');
	$.post(url, {cid: campaignId}, function(response){
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