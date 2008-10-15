function enable_search()
{
	$('#search').click(function()
    {
    	$(this).attr('value','');
    });
        
     $('#search_form').submit(function(event)
     {
     	event.preventDefault();
     	do_search(true);
     });
}

function do_search(show_feedback)
{
	if(show_feedback)
	{
		$('#spinner').show();
		set_feedback($('#search').val(),'success_message',false);
	}
	
	$('#sortable_table tbody').load($('#search_form').attr('action'),{'search':$('#search').val()},function()
	{
		$('#spinner').hide();
		//re-init elements in new table, as table tbody children were replaced
		tb_init('#sortable_table a.thickbox');
		$("#sortable_table").trigger("update");
		enable_email();
	});
}

function enable_email(email_url)
{
	//store url in function cache
	if(enable_email.url==undefined)
	{
		enable_email.url=email_url;
	}
	
	do_email(enable_email.url);
	$('#select_all, #sortable_table tbody :checkbox').click(function()
	{
		do_email(enable_email.url);
	});
}

function do_email(url)
{
	$.post(url, { 'ids[]': get_selected_values() },function(response)
	{
		$('#email').attr('href',response);
	});

}

function enable_delete(confirm_message)
{
	$('#delete').click(function()
	{
		if(confirm(confirm_message))
		{
			do_delete($("#delete").attr('href'));
		}
		
		return false;
	});
}

function do_delete(url)
{
	$.post(url, { 'ids[]': get_selected_values() },function()
	{
		do_search(false);
	});
}

function select_all_enable()
{
	$('#select_all').click(function()
	{
		if($(this).attr('checked'))
		{	
			$("#sortable_table tbody :checkbox").each(function()
			{
				$(this).attr('checked',true)
			});
		}
		else
		{
			$("#sortable_table tbody :checkbox").each(function()
			{
				$(this).attr('checked',false)
			});    	
		}
	 });	
}

function get_selected_values()
{
	var selected_values = new Array();
	$("#sortable_table tbody :checkbox:checked").each(function()
	{
		selected_values.push($(this).val());
	});
	return selected_values;
}

function set_feedback(text, classname, keep_displayed)
{
	$('#feedback_bar').css('class',classname);
	$('#feedback_bar').text(text);
	$('#feedback_bar').fadeTo("slow",1,function()
	{
		if(!keep_displayed)
		{
			$('#feedback_bar').fadeTo(5000, 1);
			$('#feedback_bar').fadeTo("fast",0);
		}
	});
}
