function enable_search()
{
	$('#search').click(function()
    {
    	$(this).attr('value','');
    });
        
     $('#search_form').submit(function()
     {
     	do_search();
     	return false;
     });
}

function do_search()
{
	$('#spinner').show();
	$('#table_holder').load($('#search_form').attr('action'),{'search':$('#search').val()},function()
	{
		$('#spinner').hide();
		tb_init('.tablesorter a.thickbox');
		select_all_enable();
		init_table_sorting();
	});
}

function enable_email(url)
{
	do_email(url);
	$('#select_all,.tablesorter tbody :checkbox').click(function()
	{
		do_email(url);
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

function do_email(url)
{
	$.post(url, { 'ids[]': get_selected_values() },function(response)
	{
		$('#email').attr('href',response);
	});

}

function select_all_enable()
{
	$('#select_all').click(function()
	{
		if($(this).attr('checked'))
		{	
			$(".tablesorter tbody :checkbox").each(function()
			{
				$(this).attr('checked',true)
			});
		}
		else
		{
			$(".tablesorter tbody :checkbox").each(function()
			{
				$(this).attr('checked',false)
			});    	
		}
	 });	
}

function get_selected_values()
{
	var selected_values = new Array();
	$(".tablesorter tbody :checkbox:checked").each(function()
	{
		selected_values.push($(this).val());
	});
	return selected_values;
}
