<?php // content="text/plain; charset=utf-8"
	require_once ('jpgraph-4.1.0/src/jpgraph.php');
	require_once ('jpgraph-4.1.0/src/jpgraph_bar.php');
	require_once('../conexion/config.php');
	
	if(isset($_GET['tipo'])){
		$tipo= $_GET['tipo'];
	} else {
		$tipo=NULL;
	}
	#Query para ver el numero de interacciones totales que tenemos por tipo
	$sqlCountIntTipo = "SELECT COUNT(*) AS conteo FROM interacciones WHERE severidad='$tipo'"; 
					#"SELECT idInteraccion,nombreFarmaco,nombreFarmaco2 FROM interacciones WHERE severidad='$tipo'";
    $sqlCountIntTipo1= mysqli_query($conexion, $sqlCountIntTipo) or die (mysqli_error($conexion));
	$conteo = mysqli_fetch_array($sqlCountIntTipo1);
	$conteo=$conteo[0];
	
	//Query para obtener los datos que conformaran la grafica (etiquetas y tamaño de barras)
	$nombrePar=array();
	$valor = array();
	$sqlIntTipo = "SELECT nombreFarmaco,nombreFarmaco2,CONCAT(nombreFarmaco, nombreFarmaco2) AS nombres,COUNT(*) AS conteo 
					FROM interacciones WHERE severidad='$tipo' GROUP BY nombres"; 
					#"SELECT idInteraccion,nombreFarmaco,nombreFarmaco2 FROM interacciones WHERE severidad='$tipo'";
    $sqlIntTipo1 = mysqli_query($conexion, $sqlIntTipo) or die (mysqli_error($conexion));
	while ($row = mysqli_fetch_array($sqlIntTipo1)) {
	#Le quitamos a la cadena lo q sigue despues del primer espacio en el nombre para q no se haga un nombresote O_O!!!
		$str1 = explode(" ", utf8_encode(trim($row[0])));
		$str2 = explode(" ", utf8_encode(trim($row[1])));
	#Agregamos las cadenas concatenadas al arreglo de etiquetas
		array_push($nombrePar, $str1[0].' - '.$str2[0]);
	#Obtenemos el porcentaje con la formula y lo agregamos al arreglo de valores de barras
		array_push($valor, ($row[3]*100)/$conteo);
	}
	
	#listado de valores para el largo de las barras
	$datay = $valor;
	
	mysqli_close($conexion);
	
	// Creamos un objeto del tipo Graph. Estas 2 lineas siempre son requeridas
	$graph = new Graph(900,700,'auto');//dimensiones ancho,alto
	$graph->SetScale("textlin");
	
	$theme_class=new UniversalTheme;
	$graph->SetTheme($theme_class);
	if($tipo == 1){
		$graph->title->Set('PRESENCIA DE INTERACCIONES FARMACOLÓGICAS DE SEVERIDAD "CONTRAINDICADA"');
	}else {
		$graph->title->Set('PRESENCIA DE INTERACCIONES FARMACOLÓGICAS DE SEVERIDAD "SERIA"');
	}
	$graph->Set90AndMargin(300,40,50,40);//izq, der, sup, inf
	$graph->img->SetAngle(90);
	
	// set major and minor tick positions manually
	$graph->SetBox(false);
	
	//$graph->ygrid->SetColor('gray');
	$graph->ygrid->Show(false);
	$graph->ygrid->SetFill(false);
	$graph->xaxis->SetTickLabels($nombrePar);#array('A','B','C','D','F','G'));
	$graph->yaxis->HideLine(false);
	$graph->yaxis->HideTicks(false,false);
	
	// For background to be gradient, setfill is needed first.
	$graph->SetBackgroundGradient('#00CED1', '#FFFFFF', GRAD_HOR, BGRAD_PLOT);
	
	//crear la barra
	$b1plot = new BarPlot($datay);
	
	// ...agrega la barra a la grafica
	$graph->Add($b1plot);
	
	$b1plot->SetWeight(0);
	$b1plot->SetFillGradient("#0B0B61","#90EE90",GRAD_HOR);
	$b1plot->SetWidth(27);
	$b1plot->SetShadow();
	$b1plot->value->Show();//Mostrar valor numerico de la barra en la parte superior
	$b1plot->value->SetColor("black","darkred");
	#$b1plot->SetValuePos('bottom'); //mover el valor numerico de la parte superior al centro o abajo
	
	// Mostramos la grafica
	$graph->Stroke();
?>