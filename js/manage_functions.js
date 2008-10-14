function enable_search()
{
	$('#search').click(function()
    {
    	$(this).attr('value','');
    });
        
     $('#search_form').submit(function(event)
     {
     	event.preventDefault();
     	do_search();
     });
}

function do_search()
{
	$('#spinner').show();
	$('#table_holder').load($('#search_form').attr('action'),{'search':$('#search').val()},function()
	{
		$('#spinner').hide();
		
		//re-init elements in new table, as table was replaced
		tb_init('#sortable_table a.thickbox');
		select_all_enable();
		init_table_sorting();
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
		do_search();
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
