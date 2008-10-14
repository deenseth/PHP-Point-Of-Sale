<?php
function get_sortable_table_template()
{
	$tmpl = array (
	'table_open'          => '<table class="tablesorter">',
	'heading_row_start'   => '<thead><tr>',
	'heading_row_end'     => '</tr></thead><tbody>',
	'table_close'         => '</body></table>'
	);
	
	return $tmpl;
}	
?>