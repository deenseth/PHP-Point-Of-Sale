<h1>
	<?php echo $title ?>
	<small><?php echo $subtitle ?></small>
</h1>
<div id="table_holder">
	<table class="tablesorter report table table-bordered table-striped" id="sortable_table">
		<thead>
			<tr>
				<?php foreach ($headers as $header) { ?>
				<th><?php echo $header; ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($data as $row) { ?>
			<tr>
				<?php foreach ($row as $cell) { ?>
				<td><?php echo $cell; ?></td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>
<ul class="list-group">	
<?php foreach($summary_data as $name=>$value) { ?>
	<li class="list-group-item"><?php echo $this->lang->line('reports_'.$name). ': '.to_currency($value); ?></li>
<?php }?>
</ul>