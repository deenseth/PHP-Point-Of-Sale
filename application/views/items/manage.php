<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function()
{
    //init_table_sorting();
    enable_select_all();
    enable_checkboxes();
    enable_row_selection();
    //enable_search('<?php echo site_url("$controller_name/suggest")?>','<?php echo $this->lang->line("common_confirm_search")?>');
    enable_delete('<?php echo $this->lang->line($controller_name."_confirm_delete")?>','<?php echo $this->lang->line($controller_name."_none_selected")?>');
    enable_bulk_edit('<?php echo $this->lang->line($controller_name."_none_selected")?>');

    $('#generate_barcodes').click(function()
    {
    	var selected = get_selected_values();
    	if (selected.length == 0)
    	{
    		alert('<?php echo $this->lang->line('items_must_select_item_for_barcode'); ?>');
    		return false;
    	}

    	$(this).attr('href','index.php/items/generate_barcodes/'+selected.join(','));
    });

    $("#low_inventory").click(function()
    {
    	$('#items_filter_form').submit();
    });

    $("#is_serialized").click(function()
    {
    	$('#items_filter_form').submit();
    });

    $("#no_description").click(function()
    {
    	$('#items_filter_form').submit();
    });

});

</script>


<h1 id="title"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_'.$controller_name); ?></h1>
<hr>
<div class="actions">
	<div class="search-box">
		<img src='<?php echo base_url()?>images/spinner_small.gif' alt='spinner' id='spinner' />
		<?php echo form_open("$controller_name/search",array('id'=>'search_form')); ?>
		<input type="text" name ='search' value="<?php echo $search; ?>" id='search'/>
		</form>
	</div>
	<div id="new_button" class="btn-group">
		<?php echo anchor("$controller_name/view/-1", $this->lang->line($controller_name.'_new'),
		array('class'=>'btn btn-success','title'=>$this->lang->line($controller_name.'_new')));
		?>
		<?php echo anchor("$controller_name/bulk_edit",$this->lang->line("items_bulk_edit"),array('class'=>'btn btn-default', 'id'=>'bulk_edit','title'=>$this->lang->line('items_edit_multiple_items'))); ?>
		<?php echo anchor("$controller_name/generate_barcodes",$this->lang->line("items_generate_barcodes"),array('class'=>'btn btn-default','id'=>'generate_barcodes', 'target' =>'_blank','title'=>$this->lang->line('items_generate_barcodes'))); ?>
		<?php echo anchor("$controller_name/excel_import", "Excel Import",
		array('class'=>'btn btn-default','title'=>'Import Items from Excel'));
		?>
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