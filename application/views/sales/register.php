<?php $this->load->view("partial/header"); 
if(isset($error))
{
	echo "<div class='error_message'>".$error."</div>";
}
?>
<div id="register_wrapper">
<?php echo form_open("sales/add_item",array('id'=>'add_item_form')); ?>
<label id="item_label" for="item"><?php echo $this->lang->line('sales_find_or_scan_item'); ?></label>
<?php echo form_input(array('name'=>'item','id'=>'item','size'=>'35'));?>

<div id="new_item_button_register" >
		<?php echo anchor("items/view/-1/",
		"<div class='small_button'><span>".$this->lang->line('items_new')."</span></div>",
		array('class'=>'thickbox none','title'=>$this->lang->line('items_new')));
		?>
	</div>

</form>
<table id="register">
<thead>
<tr>
<th><?php echo $this->lang->line('common_delete'); ?></th>
<th><?php echo $this->lang->line('items_name'); ?></th>
<th><?php echo $this->lang->line('items_unit_price'); ?></th>
<th><?php echo $this->lang->line('items_tax_percent'); ?></th>
<th><?php echo $this->lang->line('items_quantity'); ?></th>
<th><?php echo $this->lang->line('sales_item_total'); ?></th>
<th><?php echo $this->lang->line('sales_edit'); ?></th>
</tr>
</thead>
<tbody id="cart_contents">
<?php
if(count($cart)==0)
{
?>
<tr><td colspan='7'>
<div class='warning_message' style='padding:7px;'><?php echo $this->lang->line('sales_no_items_in_cart'); ?></div>
</tr></tr>
<?php
}
else
{
	foreach($cart as $item_id=>$item)
	{
		echo form_open("sales/edit_item/$item_id");
	?>
		<tr>
		<td><?php echo anchor("sales/delete_item/$item_id",'['.$this->lang->line('common_delete').']');?></td>
		<td><?php echo $item['name']; ?></td>
		<td><?php echo form_input(array('name'=>'price','value'=>$item['price'],'size'=>'6'));?></td>
		<td><?php echo form_input(array('name'=>'tax','value'=>$item['tax'],'size'=>'3'));?></td>
		<td><?php echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'2'));?></td>
		<td><?php echo to_currency($item['price']*$item['quantity']*(1+($item['tax']/100))); ?></td>
		<td><?php echo form_submit("edit_item", $this->lang->line('sales_edit_item'));?></td>
		</tr>
		</form>
	<?php
	}
}
?>
</tbody>
</table>
</div>


<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$('#item').focus();
	$('#item').click(function()
    {
    	$(this).attr('value','');
    });

    $("#item").autocomplete('<?php echo site_url("sales/item_search"); ?>',
    {
    	minChars:0,
    	max:100,
    	formatItem: function(row, i, max) {
			return row[row.length-1];
		}
    	
    });
    $("#item").result(function(event, data, formatted)
    {
		$("#add_item_form").submit();
    });    
});

function post_item_form_submit(response)
{
	if(response.success)
	{
		$("#item").attr("value",response.item_id);
		$("#add_item_form").submit();		
	}
}
</script>
