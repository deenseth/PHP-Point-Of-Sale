<?php $this->load->view("partial/header"); ?>
<div id="register_wrapper">
<?php echo form_open("sales/add_item",array('id'=>'add_item_form')); ?>
<label id="item_label" for="item">Find/Scan Item</label>
<input type="text" name="item" id="item"/>
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
<th>Delete</th>
<th>Name</th>
<th>Price</th>
<th>Tax</th>
<th>Quantity</th>
<th>Item Total</th>
<th>Edit</th>
</tr>
</thead>
<tbody id="cart_contents">
<?php
foreach($cart as $item_id=>$item)
{
	echo form_open("sales/edit_item/$item_id");
?>
	<tr>
	<td><?php echo anchor("sales/delete_item/$item_id","[Delete]");?></td>
	<td><?php echo $item['name']; ?></td>
	<td><?php echo form_input(array('name'=>'price','value'=>$item['price'],'size'=>'6'));?></td>
	<td><?php echo form_input(array('name'=>'tax','value'=>$item['tax'],'size'=>'4'));?></td>
	<td><?php echo form_input(array('name'=>'quantity','value'=>$item['quantity'],'size'=>'3'));?></td>
	<td><?php echo to_currency($item['price']*$item['quantity']*(1+($item['tax']/100))); ?></td>
	<td><?php echo form_submit("edit_item", "Edit Item");?></td>
	</tr>
	</form>
<?php
}
?>
</tbody>
</table>
</div>


<?php $this->load->view("partial/footer"); ?>

<script type="text/javascript" language="javascript">
$(document).ready(function()
{

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
