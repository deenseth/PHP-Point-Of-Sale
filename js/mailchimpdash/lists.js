function listPage(listId, slice)
{
	var lv = $('#lists-view');
	var filters = getFilters();
	lv.load( SITE_URL + '/mailchimpdash/listsajax', {listid: listId, start: slice, filters: filters});
}

var filters = '';
function getFilters()
{
	filters = '';
	$('#lists-options input').each(function(){
		if ($(this).is(':checked')) {
			if (filters != '') {
				filters += ',';
			}
			filters += $(this).attr('id').replace(/lists-options-/, '');
		}
	});
	return filters;
}

function post_person_form_submit(response)
{
    var dom = $('tr#person-'+response.person_id);
    $.post( SITE_URL + '/mailchimpdash/update_email_row/' + response.person_id + '/' + $('#listid').val(), function(data){dom.replaceWith(data);});
    if (response.success) {
        set_feedback(response.message, 'success_message', false);
    } else {
        set_feedback(response.message, 'error_message', true);
    }
}

function reloadFilters()
{
	var slice = $('#slice').val();
	var listid = $('#listid').val();
	if (typeof(slice) != undefined && typeof(listid) != undefined) {
		listPage(listid, slice);
	}
}

$(document).ready(function(){
	
	$('#lists-buttons .button').click(function(){
		
		var id = $(this).attr('id').replace(/button_/, '');		
		
		var lv = $('#lists-view');
		
		if (lv.is(':hidden')) {
		
			lv.slideDown(1000, function() {
				listPage(id, 0)
			});
			
		} else {
			
			lv.slideUp(1000, function() {
				lv.html('<div id="lists-loading"><img id="lists-loading" src="'+BASE_URL+'images/spinner_small.gif" /></div>');
				listPage(id, 0)
				lv.slideDown(1000);
			});
						
			
		}
		
		return false;
	});
	
	$('input[type="checkbox"]').click(function(){reloadFilters();});
	
});


function listremove(obj)
{
	var emailval = $(obj).parent('td').parent('tr').find('td.email a').attr('href').replace(/mailto:/, '');
	var listidval = $('#listid').val();
	$.post(SITE_URL + '/mailchimpdash/listremoveajax',
			{email: emailval, 
			 listid: listidval 
			},
			function(data){
				if (typeof(data) != 'object') {
					var response = JSON.parse(data);
				} else {
					var response = data;
				}
				if (response.success) {
				  set_feedback(response.message, 'success_message', false);
				  $(obj).parent('td').parent('tr').fadeOut(250);
			  } else {
				  set_feedback(response.message, 'error_message', true);
			  }
			},
		  "json"
	  );
	
}

