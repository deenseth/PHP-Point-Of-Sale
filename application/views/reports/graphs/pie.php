<?php
$graph = new PHPGraphLibPie(600, 400); //for pie graph
$graph->setPrecision(2);
$graph->setDataLabels(true);
$graph->setBars(false);
$graph->setLine(true);
$graph->setDataPoints(true);
$graph->setDataPointColor('maroon');
$graph->setDataValues(true);
$graph->setDataValueColor('maroon');
$graph->setGoalLine(.0025);
$graph->setGoalLineColor('red');
$graph->addData($data);
$graph->setTitle($title);
$graph->setGradient("blue", "black");
$graph->setBarOutlineColor("black");
$graph->createGraph();
?>
