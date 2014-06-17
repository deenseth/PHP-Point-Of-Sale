<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
{ 
    init_table_sorting();
    enable_select_all();
    enable_row_selection();
    enable_search('<?php echo site_url("$controller_name/suggest")?>','<?php echo $this->lang->line("common_confirm_search")?>');
    enable_email('<?php echo site_url("$controller_name/mailto")?>');
    enable_delete('<?php echo $this->lang->line($controller_name."_confirm_delete")?>','<?php echo $this->lang->line($controller_name."_none_selected")?>');
}); 

function init_table_sorting()
{
	//Only init if there is more than one row
	if($('.tablesorter tbody tr').length >1)
	{
		$("#sortable_table").tablesorter(
		{ 
			sortList: [[1,0]], 
			headers: 
			{ 
				0: { sorter: false}, 
				6: { sorter: false} 
			} 

		}); 
	}
}
</script>

<h1 id="title"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_'.$controller_name); ?></h1>
<hr>
<div class="actions">
	<div class="search-box">
		<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
		<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
		<input type="text" name ='search' id='search'/>
		</form>
	</div>
	<div id="new_button" class="btn-group">
		<?php echo anchor("$controller_name/view/-1", $this->lang->line($controller_name.'_new'), array('class'=>'btn btn-success','title'=>$this->lang->line($controller_name.'_new')));?>
		<?php echo anchor("$controller_name/delete",$this->lang->line("common_delete"),array('class'=>'btn btn-danger','id'=>'delete')); ?>
	</div>
	<br style="clear:both" />
</div>

<div id="table_holder">
	<?php echo $manage_table; ?>
</div>
<?php echo $this->pagination->create_links();?>
<div id="feedback_bar"></div>
<?php $this->load->view("partial/footer"); ?>