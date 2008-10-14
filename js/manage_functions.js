function enable_search()
{
	$('#search').click(function()
    {
    	$(this).attr('value','');
    });
        
     $('#search_form').submit(function()
     {
     	$('#spinner').show();
     	$('#table_holder').load($(this).attr('action'),{'search':$('#search').val()},function()
     	{
     	    $('#spinner').hide();
     	    tb_init('.tablesorter a.thickbox');
     	    select_all_enable();
     		init_table_sorting();
     	});
     	
     	return false;
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
	console.log(selected_values);
	return selected_values;
}
