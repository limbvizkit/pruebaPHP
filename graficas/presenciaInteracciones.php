<?php 
	require_once ('jpgraph-4.1.0/src/jpgraph.php');
	require_once ('jpgraph-4.1.0/src/jpgraph_line.php');
	
	$datay1 = array(52.1,24.49,27.5,21.3,25.6,22.6,18,25,13.8,26.4,40.2,0,0);
	
	// Setup the graph
	$graph = new Graph(1300,700);
	$graph->SetScale("textlin");
	
	$theme_class=new UniversalTheme;
	
	$graph->SetTheme($theme_class);
	$graph->img->SetAntiAliasing(false);
	$graph->title->Set('PRESENCIA DE INTERACCIONES FARMACOLÓGICAS 2017');
	$graph->SetBox(false);
	
	$graph->img->SetAntiAliasing();
	
	$graph->yaxis->HideZeroLabel();
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false);
	
	$graph->xgrid->Show();
	$graph->xgrid->SetLineStyle("solid");
	$graph->xaxis->SetTickLabels(array('MEDIA 2016','MEDIA 2017','ENERO','FEBRERO','MARZO','ABRIL','MAYO','JUNIO','JULIO','AGOSTO','SEPTIEMBRE','OCTUBRE','NOVIEMBRE','DICIEMBRE'));
	$graph->xgrid->SetColor('#E3E3E3');
	
	// Create the first line
	$p1 = new LinePlot($datay1);
	$graph->Add($p1);
	$p1->SetColor("#6495ED");
	$p1->SetLegend('PORCENTAJE');
	$p1->mark->SetType(MARK_FILLEDCIRCLE,'',1.0);
	$p1->mark->SetColor('#6495ED');
	$p1->mark->SetFillColor('#6495ED');
	$p1->SetCenter();
	$p1->value->SetFormat('%.2f');
	$p1->value->Show();
	$p1->value->SetColor('#000000');

	// Create the second line
	/*$p2 = new LinePlot($datay2);
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
	$p6->SetCenter();*/

	$graph->legend->SetFrameWeight(1);
	
	// Output line
	$graph->Stroke();
	
?>