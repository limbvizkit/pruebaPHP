<?php 
	require_once ('jpgraph-4.1.0/src/jpgraph.php');
	require_once ('jpgraph-4.1.0/src/jpgraph_line.php');
	
	$datay1 = array(20,15,23,15,80,20,45,10,5,45);
	$datay2 = array(12,9,12,8,41,15,30,8,48,36);
	$datay3 = array(5,17,32,24,4,2,36,2,9,24);
	$datay4 = array(50,1,3,4,14,20,4,2,9,44);
	$datay5 = array(15,10,33,14,40,20,6,21,19,34);
	$datay6 = array(1,31,13,10,20,30,16,29,39,24);

	
	// Setup the graph
	$graph = new Graph(1300,700);
	$graph->SetScale("textlin");
	
	$theme_class=new UniversalTheme;
	
	$graph->SetTheme($theme_class);
	$graph->img->SetAntiAliasing(false);
	$graph->title->Set('Tipos de Medicamentos');
	$graph->SetBox(false);
	
	$graph->img->SetAntiAliasing();
	
	$graph->yaxis->HideZeroLabel();
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false);
	
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle("solid");
	$graph->xaxis->SetTickLabels(array('Ene','Feb','Mar','Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'));
	$graph->xgrid->SetColor('#E3E3E3');
	
	// Create the first line
	$p1 = new LinePlot($datay1);
	$graph->Add($p1);
	$p1->SetColor("#6495ED");
	$p1->SetLegend('ANTIBIÓTICOS');
	$p1->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
	$p1->mark->SetColor('#6495ED');
	$p1->mark->SetFillColor('#6495ED');
	$p1->SetCenter();
	$p1->value->SetFormat('%d');
	$p1->value->Show();
	$p1->value->SetColor('#000000');

	// Create the second line
	$p2 = new LinePlot($datay2);
	$graph->Add($p2);
	$p2->SetColor("#B22222");
	$p2->SetLegend('ANALGÉSICO');
	$p2->mark->SetType(MARK_UTRIANGLE,'',1.0);
	$p2->mark->SetColor('#B22222');
	$p2->mark->SetFillColor('#B22222');
	#$p2->value->SetMargin(14);
	$p2->SetCenter();
	
	// Create the third line
	$p3 = new LinePlot($datay3);
	$graph->Add($p3);
	$p3->SetColor("#FF1493");
	$p3->SetLegend('ANTIÁCIDO');
	$p3->mark->SetType(MARK_SQUARE,'',1.0);
	$p3->mark->SetColor('#FF1493');
	$p3->mark->SetFillColor('#FF1493');
	$p3->SetCenter();

	// Create the forth line
	$p4 = new LinePlot($datay4);
	$graph->Add($p4);
	$p4->SetColor("#58FA58");
	$p4->SetLegend('ANTIEMÉTICO');
	$p4->mark->SetType(MARK_DIAMOND,'',1.0);
	$p4->mark->SetColor('#58FA58');
	$p4->mark->SetFillColor('#58FA58');
	$p4->SetCenter();

	// Create the 5ta line
	$p5 = new LinePlot($datay5);
	$graph->Add($p5);
	$p5->SetColor("#0B0B3B");
	$p5->SetLegend('ANESTÉSICO');
	$p5->mark->SetType(MARK_CROSS,'',1.0);
	$p5->mark->SetColor('#0B0B3B');
	$p5->mark->SetFillColor('#0B0B3B');
	$p5->SetCenter();
	
	// Create the 6ta line
	$p6 = new LinePlot($datay6);
	$graph->Add($p6);
	$p6->SetColor("#CCBB22");
	$p6->SetLegend('ANTIESPASMÓDICO');
	$p6->mark->SetType(MARK_STAR,'',1.0);
	$p6->mark->SetColor('#0B0B3B');
	$p6->mark->SetFillColor('#0B0B3B');
	$p6->SetCenter();

	$graph->legend->SetFrameWeight(1);
	
	// Output line
	$graph->Stroke();
	
?>