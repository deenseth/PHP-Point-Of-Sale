function enable_search(suggest_url)
{	
	$('#search').click(function()
    {
    	$(this).attr('value','');
    });

    $("#search").autocomplete(suggest_url,{max:100});
    $("#search").result(function(event, data, formatted)
    {
		do_search(true);
    });
    
	$('#search_form').submit(function(event)
	{
		event.preventDefault();
		do_search(true);
	});
}

function do_search(show_feedback,on_complete)
{	
	if(show_feedback)
		$('#spinner').show();
		
	$('#sortable_table tbody').load($('#search_form').attr('action'),{'search':$('#search').val()},function()
	{
		if(typeof on_complete=='function')
			on_complete();
				
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
	if(typeof enable_email.url=='undefined')
	{
		enable_email.url=email_url;
	}
	
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
	$('#delete').click(function(event)
	{
		event.preventDefault();
		
		if(confirm(confirm_message))
		{
			do_delete($("#delete").attr('href'));
		}
	});
}

function do_delete(url)
{
	$.post(url, { 'ids[]': get_selected_values() },function(response)
	{
		do_search(false,function()
		{
			set_feedback(response.text,response.class_name,response.keep_displayed);
		});
	},"json");
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
	if(text!='')
	{
		$('#feedback_bar').removeClass();
		$('#feedback_bar').addClass(classname);
		$('#feedback_bar').text(text);
		$('#feedback_bar').css('opacity','1');

		if(!keep_displayed)
		{
			$('#feedback_bar').fadeTo(5000, 1);
			$('#feedback_bar').fadeTo("fast",0);
		}
	}
	else
	{
		$('#feedback_bar').css('opacity','0');
	}
}
