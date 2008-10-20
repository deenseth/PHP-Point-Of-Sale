function enable_search(suggest_url,confirm_search_message)
{	
	//Keep track of enable_search has been called
	if(!enable_search.enabled)
		enable_search.enabled=true;
		
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

		if(get_selected_values().length >0)
		{
			if(!confirm(confirm_search_message))
				return;
		}
		do_search(true);
	});
}
enable_search.enabled=false;

function do_search(show_feedback,on_complete)
{	
	//If search is not enabled, don't do anything
	if(!enable_search.enabled)
		return;
		
	if(show_feedback)
		$('#spinner').show();
		
	$('#sortable_table tbody').load($('#search_form').attr('action'),{'search':$('#search').val()},function()
	{
		if(typeof on_complete=='function')
			on_complete();
				
		$('#spinner').hide();
		//re-init elements in new table, as table tbody children were replaced
		tb_init('#sortable_table a.thickbox');
		update_sortable_table();	
		$('#sortable_table tbody :checkbox').click(function()
		{
			do_email(enable_email.url);
		});
		$("#select_all").attr('checked',false);
	});
}

function enable_email(email_url)
{
	//Keep track of enable_email has been called
	if(!enable_email.enabled)
		enable_email.enabled=true;

	//store url in function cache
	if(!enable_email.url)
	{
		enable_email.url=email_url;
	}
	
	$('#select_all, #sortable_table tbody :checkbox').click(function()
	{
		do_email(enable_email.url);
	});
}
enable_email.enabled=false;
enable_email.url=false;

function do_email(url)
{
	//If email is not enabled, don't do anything
	if(!enable_email.enabled)
		return;

	$.post(url, { 'ids[]': get_selected_values() },function(response)
	{
		$('#email').attr('href',response);
	});

}

function enable_delete(confirm_message,none_selected_message)
{
	//Keep track of enable_delete has been called
	if(!enable_delete.enabled)
		enable_delete.enabled=true;
	
	$('#delete').click(function(event)
	{
		event.preventDefault();
		if($("#sortable_table tbody :checkbox:checked").length >0)
		{
			if(confirm(confirm_message))
			{
				do_delete($("#delete").attr('href'));
			}
		}
		else
		{
			alert(none_selected_message);
		}
	});
}
enable_delete.enabled=false;

function do_delete(url)
{
	//If delete is not enabled, don't do anything
	if(!enable_delete.enabled)
		return;
	
	var person_ids = get_selected_values();
	var selected_rows = get_selected_rows();
	$.post(url, { 'ids[]': person_ids },function(response)
	{
		//delete was successful, remove checkbox rows
		if(response.success)
		{
			$(selected_rows).each(function(index, dom)
			{
				$(this).find("td").animate({backgroundColor:"green"},1200,"linear")
				.end().animate({opacity:0},1200,"linear",function()
				{
					$(this).remove();
				});
			});	
			set_feedback(response.message,'success_message',false);	
		}
		else
		{
			set_feedback(response.message,'error_message',true);	
		}
		

	},"json");
}

function enable_select_all()
{
	//Keep track of enable_select_all has been called
	if(!enable_select_all.enabled)
		enable_select_all.enabled=true;

	$('#select_all').click(function()
	{
		if($(this).attr('checked'))
		{	
			$("#sortable_table tbody :checkbox").each(function()
			{
				$(this).attr('checked',true);
			});
		}
		else
		{
			$("#sortable_table tbody :checkbox").each(function()
			{
				$(this).attr('checked',false);
			});    	
		}
	 });	
}
enable_select_all.enabled=false;

function update_sortable_table()
{
	//let tablesorter know we changed <tbody> and then triger a resort
	$("#sortable_table").trigger("update");
	
	
	if(typeof $("#sortable_table")[0].config!="undefined")
	{
		var sorting = $("#sortable_table")[0].config.sortList; 		
		$("#sortable_table").trigger("sorton",[sorting]);
	}
}

function update_row(person_id,url)
{
	$.post(url, { 'person_id': person_id },function(response)
	{
		//Replace previous row
		var row_to_update = $("#sortable_table tbody tr :checkbox[value="+person_id+"]").parent().parent();
		row_to_update.replaceWith(response);	
		reinit_row(person_id);
		hightlight_row(person_id);
	});
}

function reinit_row(checkbox_id)
{
	var new_checkbox = $("#sortable_table tbody tr :checkbox[value="+checkbox_id+"]");
	var new_row = new_checkbox.parent().parent();
	
	//Re-init some stuff as we replaced row
	update_sortable_table();
	tb_init(new_row.find("a.thickbox"));
	//re-enable e-mail
	new_checkbox.click(function()
	{
		do_email(enable_email.url);
	});
}

function hightlight_row(checkbox_id)
{
	var new_checkbox = $("#sortable_table tbody tr :checkbox[value="+checkbox_id+"]");
	var new_row = new_checkbox.parent().parent();

	new_row.find("td").animate({backgroundColor:"#e1ffdd"},"slow","linear")
		.animate({backgroundColor:"#e1ffdd"},5000)
		.animate({backgroundColor:"#ffffff"},"slow","linear");
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

function get_selected_rows() 
{ 
	var selected_rows = new Array(); 
	$("#sortable_table tbody :checkbox:checked").each(function() 
	{ 
		selected_rows.push($(this).parent().parent()); 
	}); 
	return selected_rows; 
}

function get_visible_checkbox_ids()
{
	var person_ids = new Array();
	$("#sortable_table tbody :checkbox").each(function()
	{
		person_ids.push($(this).val());
	});
	return person_ids;
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
