<?php $this->load->view("partial/header"); ?>
<script type="text/javascript">
$(document).ready(function() 
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
}); 
</script>

<div id="title_bar">
	<div id="title" class="float_left"><?php echo $this->lang->line('common_list_of').' '.$this->lang->line('module_customers'); ?></div>
	<div class="float_right">
		<a href='http://www.google.com' class="none"><div class='big_button'><span><?php echo $this->lang->line('customer_new_customer'); ?></span></div></a>
	</div>
</div>

<div class="table_action_header">
	<ul>
		<li class="float_left"><span>Delete</span></li>
		<li class="float_left"><span>Email</span></li>
		<li class="float_left"><span>View Recent Sales</span></li>
		<li class="float_right"><a href="#">Search</a></li>
	</ul>
</div>
<table class="tablesorter">
<thead>
	<tr>
	<th><input type="checkbox" id="select_all_checkbox" /></th>
	<th>Last Name</th>
	<th>First Name</th>
	<th>E-Mail</th>
	<th>Phone Number</th>
	<th>&nbsp;</th>
	</tr>
</thead>
<tbody>
<tr> 
	<td><input type="checkbox" /></td>
    <td>Smith</td> 
    <td>John</td> 
    <td>jsmith@gmail.com</td> 
    <td>$50.00</td> 
    <td><a href="#">edit</a></td> 
</tr> 
<tr> 
	<td><input type="checkbox" /></td>
    <td>Bach</td> 
    <td>Frank</td> 
    <td>fbach@yahoo.com</td> 
    <td>$50.00</td> 
    <td><a href="#">edit</a></td> 
</tr> 
<tr> 
	<td><input type="checkbox" /></td>
    <td>Doe</td> 
    <td>Jason</td> 
    <td>jdoe@hotmail.com</td> 
    <td>$100.00</td> 
    <td><a href="#">edit</a></td>     
</tr> 
<tr> 
	<td><input type="checkbox" /></td>
    <td>Conway</td> 
    <td>Tim</td> 
    <td>tconway@earthlink.net</td> 
    <td>$50.00</td> 
    <td><a href="#">edit</a></td>         
</tr> 
</tbody>
</table>

<?php $this->load->view("partial/footer"); ?>