<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
function init_table_sorting()
{
	//Only init if there are rows
	if($('#sortable_table tbody tr').length >0)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				5: { sorter: false} 
			} 
	
		}); 
	}
}

function post_save_customer()
{
	$('#customers_form').submit(function(event)
	{
		event.preventDefault();
		
		$.post($(this).attr('action'), $(this).serializeArray(),function()
		{
			tb_remove();
			do_search();	
		});
 	});
}

$(document).ready(function() 
{ 
    init_table_sorting();
    select_all_enable();
    enable_search();
    enable_delete("<?php echo $this->lang->line('customer_confirm_delete')?>");
    enable_email("<?php echo site_url('customers/email')?>");
}); 
</script>

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_customers'); ?></div>
	<div class="float_right">
		<?php echo anchor('customers/view',
		"<div class='big_button'><span>".$this->lang->line('customer_new_customer')."</span></div>",
		array('class'=>'thickbox none'));
		?>
	</div>
</div>

<div id="table_action_header">
	<ul>
		<li class="float_left"><span><?php echo anchor('customers/delete',$this->lang->line("common_delete"),array('id'=>'delete')); ?></a></span></li>
		<li class="float_left"><span><a href="#" id="email"><?php echo $this->lang->line("common_email");?></a></span></li>
		<li class="float_right">
		<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
		<?php echo form_open('customers/search',array('id'=>'search_form')); ?>
		<input type="text" name ='search' id='search'/>
		</form>
		</li>
	</ul>
</div>
<div id="table_holder">
<?php echo get_customer_manage_table($this->Customer->get_all_customers()); ?>
</div>
<br /><br /><br />
<?php $this->load->view("partial/footer"); ?>