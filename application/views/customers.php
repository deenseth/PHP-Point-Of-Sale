<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
	function init_table_sorting()
	{
		$(".tablesorter").tablesorter(
		{ 
			sortList: [[1,0]], 
    	    headers: 
    	    { 
    	        0: { sorter: false}, 
    	        5: { sorter: false} 
    	    } 
        
    	}); 
    }
    init_table_sorting();
    
    
    $('#search').click(function()
    {
    	$(this).attr('value','');
    });
    
    $('#search').blur(function()
    {
    	$(this).attr('value','<?php echo $this->lang->line("common_search"); ?>');
    });
    
     $('#search_form').submit(function()
     {
     	$('#spinner').show();
     	$('#table_holder').load($(this).attr('action'),{'search':$('#search').val()},function()
     	{
     	    $('#spinner').hide();
     		init_table_sorting();
     	});
     	
     	return false;
     });
     
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
     })	
}); 
</script>

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_customers'); ?></div>
	<div class="float_right">
		<?php echo anchor('customers/add',
		"<div class='big_button'><span>".$this->lang->line('customer_new_customer')."</span></div>",
		array('class'=>'thickbox none'));
		?>
	</div>
</div>

<div class="table_action_header">
	<ul>
		<li class="float_left"><span><?php echo $this->lang->line("common_delete"); ?></span></li>
		<li class="float_left"><span><?php echo $this->lang->line("common_email"); ?></span></li>
		<li class="float_left"><span><?php echo $this->lang->line("common_view_recent_sales"); ?></span></li>
		<li class="float_right">
		<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
		<form method='post' id='search_form' action='<?php echo site_url("customers/search"); ?>'>
		<input type="text" value="Search" name ='search' id='search'/>
		</form>
		</li>
	</ul>
</div>
<div id="table_holder">
<?php echo $manage_table; ?>
</div>
<br /><br /><br />
<?php $this->load->view("partial/footer"); ?>