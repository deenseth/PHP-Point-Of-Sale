<div id="table_holder">
	<table class="tablesorter report table table-bordered table-striped" id="sortable_table">
		<thead>
			<tr>
				<?php if ($headers['details']) { ?>
				<th>+</th>
				<?php } ?>
				<?php foreach ($headers['summary'] as $header) { ?>
				<th><?php echo $header; ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($summary_data as $key=>$row) { ?>
			<tr>
				<?php if ($headers['details']) { ?>
				<td><a href="#" class="expand">+</a></td>
				<?php } ?>
				<?php foreach ($row as $cell) { ?>
				<td><?php echo $cell; ?></td>
				<?php } ?>
			</tr>
			<?php if ($headers['details']) { ?>
			<tr>
				<td colspan="100">
				<table class="innertable table">
					<thead>
						<tr>
							<?php foreach ($headers['details'] as $header) { ?>
							<th><?php echo $header; ?></th>
							<?php } ?>
						</tr>
					</thead>
				
					<tbody>
						<?php foreach ($details_data[$key] as $row2) { ?>
						
							<tr>
								<?php foreach ($row2 as $cell) { ?>
								<td><?php echo $cell; ?></td>
								<?php } ?>
							</tr>
						<?php } ?>
					</tbody>
				</table>
				
				</td>
			</tr>
			<?php } ?>
			<?php } ?>
		</tbody>
	</table>
</div>
<ul class="list-group">	
<?php foreach($overall_summary_data as $name=>$value) { ?>
	<li class="list-group-item"><?php echo $this->lang->line('reports_'.$name). ': '.to_currency($value); ?></li>
<?php }?>
</ul>