<?php 
	require_once ('jpgraph-4.1.0/src//jpgraph.php');
	require_once ('jpgraph-4.1.0/src//jpgraph_pie.php');
	require_once ('jpgraph-4.1.0/src//jpgraph_pie3d.php');
	require_once('../conexion/configLogin.php');
	
	/*Para la grafica de barras las incidencias que más ocurren
		SELECT reporte AS valor, COUNT( * ) AS veces
		FROM incidencias t
		GROUP BY reporte
		HAVING veces = ( 
		SELECT COUNT( * ) maximo
		FROM incidencias
		WHERE reporte NOT LIKE '%Ocupada%' AND reporte NOT LIKE '%bien%' AND reporte NOT LIKE '%limpieza%'
		GROUP BY reporte
		ORDER BY maximo DESC 
		LIMIT 1 )
	*/
	
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}
	
	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}

	session_name($rol);
	session_start();
	
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   header("location: index.html"); 
	}
	$valor = $_SESSION[$rol];
	
	if (isset($_GET['habitacion']))
	{
		$habitacion=$_GET['habitacion'];
	}
	
	$queryHabOcup = "SELECT COUNT(idIncidencia)
					FROM incidencias as i
					LEFT JOIN habitaciones as h ON h.idHabitacion=i.idHabitacion
					WHERE h.numeroHabitacion = '$habitacion' AND i.reporte LIKE '%Ocupada%'";
				
	$habOcu0 = mysqli_query($conexion, $queryHabOcup);
	$habOcu1 = mysqli_fetch_array($habOcu0);
	$habOcu = $habOcu1[0];
	
	$queryHabNOcup = "SELECT COUNT(idIncidencia)
					FROM incidencias as i
					LEFT JOIN habitaciones as h ON h.idHabitacion=i.idHabitacion
					WHERE h.numeroHabitacion = '$habitacion' AND (i.reporte NOT LIKE '%Ocupada%' AND i.reporte NOT LIKE '%bien%')";
				
	$habNOcu0 = mysqli_query($conexion, $queryHabNOcup);
	$habNOcu1 = mysqli_fetch_array($habNOcu0);
	$habNOcu = $habNOcu1[0];

	
	$data = array($habOcu, $habNOcu);
 
	$graph = new PieGraph(750,650);
	$graph->SetShadow();
	$theme_class= new VividTheme;
	$graph->SetTheme($theme_class);
	
	$titulo = utf8_decode("Ocupación de la Habbitación");
	$graph->title->Set($titulo);
	$graph->title->SetFont(FF_FONT2,FS_BOLD);
	 
	$p1 = new PiePlot3D($data);
	$leyenda = array('Pacientes: '. $habOcu .' (%d) ', 'Incidencias: '. $habNOcu .' (%d)');
	$p1->SetLegends($leyenda);
	$p1->SetCenter(0.5);
	 
	$graph->Add($p1);
	$p1->ShowBorder();
	$p1->SetColor('black');
	$p1->ExplodeSlice(1);
	$graph->Stroke();
	 
?>