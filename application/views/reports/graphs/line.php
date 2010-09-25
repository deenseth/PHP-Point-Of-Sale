<?php
$graph=new PHPGraphLib(600,400);
$graph->setBars(false);
$graph->setLine(true);
$graph->setDataPoints(true);
$graph->setDataPointColor('maroon');
$graph->setDataValues(true);
$graph->setDataValueColor('maroon');
$graph->setGoalLine(.0025);
$graph->setGoalLineColor('red');
$graph->setDataCurrency("dollar");
$graph->addData($data);
$graph->setTitle($title);
$graph->setGradient("blue", "black");
$graph->setBarOutlineColor("black");
$graph->createGraph();
?>