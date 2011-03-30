<?php $this->load->view("partial/header"); ?>
<div id="edit_sale_wrapper">
<?php 
if ($success)
{
?>
	<h1>You have successfully deleted a sale</h1>
<?php	
}
else
{
?>
	<h1>Could not delete sale</h1>
<?php
}
?>
</div>
<?php $this->load->view("partial/footer"); ?>