<?php
$title = new title($title);

$pie = new pie();
$pie->set_alpha(0.6);
$pie->set_start_angle( 35 );
$pie->add_animation( new pie_fade() );
$pie->set_tooltip( '#val# of #total#<br>#percent# of 100%' );
$pie->set_colours( array('#1C9E05','#FF368D') );

$pie_values = array();
foreach($data as $label=>$value)
{
	$pie_values[] = new pie_value((float)$value, $label);
}
$pie->set_values($pie_values);
$chart = new open_flash_chart();
$chart->set_title( $title );
$chart->set_bg_colour("#f3f3f3");
$chart->add_element( $pie );


$chart->x_axis = null;

echo $chart->toPrettyString();
?>