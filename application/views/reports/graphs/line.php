<?php
$line_data = array();
$labels = array();
foreach($data as $label=>$value)
{
    $line_data[] = (float)$value;
	$labels[] = $label;
}

$hol = new hollow_dot();
$hol->size(3)->halo_size(1)->tooltip('#x_label#<br>#val#');

$line = new line();
$line->set_default_dot_style($hol); 
$line->set_values($line_data);

$chart = new open_flash_chart();
$chart->set_title(new title($title));
$chart->add_element($line);

$x = new x_axis();
$x->steps(1);
$x->set_labels_from_array($labels);
$chart->set_x_axis( $x );

$y = new y_axis();
$y->set_tick_length(7);
$y->set_range(0, max($data) + 50, 10);
$chart->set_y_axis( $y );
$chart->set_bg_colour("#f3f3f3");


echo $chart->toPrettyString();
?>