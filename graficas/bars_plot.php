<?php
	require_once ('jpgraph-4.1.0/src/jpgraph.php');
	require_once ('jpgraph-4.1.0/src/jpgraph_bar.php');

	$data1y=array(20,15,23,15,80,20,45,10,50,45);
	$data2y=array(12,9,12,18,41,15,30,38,48,36);
	$data3y=array(5,17,32,24,4,2,36,22,9,24);
	$data4y=array(50,10,3,4,14,20,4,52,9,44);
	$data5y=array(15,19,33,24,40,20,46,21,19,34);
	$data6y=array(10,31,13,10,20,30,16,29,39,24);	
	
	// Create the graph. These two calls are always required
	$graph = new Graph(1300,700,'auto');
	$graph->SetScale("textlin");
	
	$theme_class=new UniversalTheme;
	$graph->SetTheme($theme_class);
	
	$graph->yaxis->SetTickPositions(array(0,5,10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90), array(15,45,75,105,135));
	$graph->SetBox(false);
	
	$graph->ygrid->SetFill(false);
	$graph->xaxis->SetTickLabels(array('Ene','Feb','Mar','Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'));
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false);
	
	// Create the bar plots
	$b1plot = new BarPlot($data1y);
	$b2plot = new BarPlot($data2y);
	$b3plot = new BarPlot($data3y);
	$b4plot = new BarPlot($data4y);
	$b5plot = new BarPlot($data5y);
	$b6plot = new BarPlot($data6y);
	
	// Create the grouped bar plot
	$gbplot = new GroupBarPlot(array($b1plot,$b2plot,$b3plot,$b4plot,$b5plot,$b6plot));
	// ...and add it to the graPH
	$graph->Add($gbplot);
	
	
	$b1plot->SetColor("white");
	$b1plot->SetFillColor("#6495ED");
	
	$b2plot->SetColor("white");
	$b2plot->SetFillColor("#B22222");
	
	$b3plot->SetColor("white");
	$b3plot->SetFillColor("#FF1493");
	
	$b4plot->SetColor("white");
	$b4plot->SetFillColor("#58FA58");
	
	$b5plot->SetColor("white");
	$b5plot->SetFillColor("#0B0B3B");
	
	$b6plot->SetColor("white");
	$b6plot->SetFillColor("#CCBB22");
	
	$graph->title->Set("Tipos de Medicamentos");
	
	// Display the graph
	$graph->Stroke();
?>