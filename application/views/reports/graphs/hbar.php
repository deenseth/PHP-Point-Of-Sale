<?php
$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
$this->output->set_header("Pragma: public");

$title = new title($title);

$hbar = new hbar( '#86BBEF' );
$hbar->set_tooltip($this->lang->line('reports_revenue').': #val#' );
$labels = array();
$max_value = 0;
foreach($data as $label=>$value)
{
	if ($max_value < $value)
	{
		$max_value = $value;
	}
	$labels[] = $label;
	$hbar->append_value( new hbar_value(0,$value) );
}
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->add_element( $hbar );

$step_count = $max_value/10;
$x = new x_axis();
$x->set_offset( false );
$x->steps($max_value/10);

$x_labels = array();
for($k=0;$k<=$max_value;$k+=$step_count)
{
	$x_labels[] = (string)$k;
}
$x->set_labels_from_array($x_labels);
$chart->set_x_axis( $x );

$y = new y_axis();
$y->set_offset( true );
$y->set_labels($labels);
$chart->add_y_axis( $y );

if (isset($yaxis_label))
{
	$y_legend = new y_legend($yaxis_label );
	$y_legend->set_style( '{font-size: 20px; color: #000000}' );
	$chart->set_y_legend( $y_legend );
}

if (isset($xaxis_label))
{
	$x_legend = new x_legend($xaxis_label );
	$x_legend->set_style( '{font-size: 20px; color: #000000}' );
	$chart->set_x_legend( $x_legend );
}

$chart->set_bg_colour("#f3f3f3");

echo $chart->toPrettyString();
?>