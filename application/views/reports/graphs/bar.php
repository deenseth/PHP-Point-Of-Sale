<?php
$graph=new PHPGraphLib(600,400);
$graph->setDataCurrency("dollar");
$graph->setDataValues(true);
$graph->addData($data);
$graph->setTitle($title);
$graph->setGradient("blue", "black");
$graph->setBarOutlineColor("black");
$graph->createGraph();
?>