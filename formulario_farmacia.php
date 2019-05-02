<?php
  	header('Content-Type: text/html;charset=utf-8');
  	#Archivo con la conexion para MYSQL
  	require_once('conexion/config.php');
  	#Agregamos el archivo donde se crea la conexion y se realizan las consultas a SQLSRV
	require_once('conexion/funciones_db.php');
	
	$cuarto=NULL;
  	$fechaEgresoPac=NULL;
	$ingresaPac=NULL;
	$alergiasPac=NULL;
	$pesoPac=NULL;
	$tallaPac=NULL;
	$conciliacionPac=NULL;
	$conciliacionE=NULL;
	$conciliacionCambServ=NULL;
	$conciliacionCambMed=NULL;
	$traeMedicamentoPac=NULL;
	$tieneCultivo=NULL;
	$casa=NULL;
	$medEgre=NULL;
	$cultivo=NULL;
	$diagnosticoPac=NULL;
	$concomitantesPac=NULL;
	$expediente = NULL;
	$folio = NULL;
	$idMed = NULL;
	$frecuencia=NULL;
	$tipoMed=NULL;
	$viadmon=NULL;
	$dosis=NULL;
	$fechaInicio=NULL;
	$cadcero=NULL;
	$depCreati=NULL;
	$dateD=NULL;
	$hrD=NULL;
  	
  	#Se presiono el boton enviar de acces.php o de aqui mismo !OoO!
  	if(isset($_REQUEST['enviar']))
	{
	
		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		if (isset($_POST['permisos']))
		{
			$permisos=$_POST['permisos'];
		}
		/*session_name($rol);
		session_start();*/
		//Si la variable sesión está vacía
		#if (!isset($_SESSION[$rol])) 
		#{
		   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
		#  header("location: index.html"); 
		#}
		#Si el numero de expediente no contiene los 0's al comienzo se los ponemos
		/*if(isset($_POST['expediente'])){
			$expediente = $_POST['expediente'];
			if(strlen($expediente)<8){
				for($i=0 ; $i<(8 - strlen($expediente)) ; $i++)
				{
					$cadcero.='0';
				}
				$expediente = $cadcero.$expediente;
			}
		}*/
		if (isset($_POST['expediente']))
		{
			$expediente=$_POST['expediente'];
		}
		if (isset($_POST['folio']))
		{
			$folio=$_POST['folio'];
		}
				
		#Este valor nos permitira saber si el enviar que se presiono es el de aqui para eliminar un medicamento
		if(isset($_POST["checkbox"])) {
			#Si llego el valor eliminamos el registro con el o los id que llegaron
			$deleteId = implode(",", $_POST['checkbox']);
			#Una condición para realizar una Eliminación
			if($deleteId != NULL && $deleteId != ''){
			    $sql = "DELETE FROM medpacientes WHERE id IN ($deleteId)";
			    $queryDelMed= mysqli_query($conexion, $sql); #or die (mysqli_error($conexion));
			    if(!$queryDelMed){
			    	echo "<br/><span style='color:red'> !!!NO SE PUDO ELIMINAR EL/LOS MEDICAMENTOS SELECCIONADOS!!! <br/> 
			    			VERIFICAR QUE NO TIENEN REVISIONES, DOSIS O SE DESCONTINUO EL MEDICAMENTO </span><br/>";
			    	#echo $sql;
			    } else {
			    	echo "<br/><span style='color:green'> EL/LOS MEDICAMENTOS SELECCIONADOS SE ELIMINARON CORRECTAMENTE </span><br/>";
			    	#echo $sql;
			    }
		    } 
		}
		#Descomentar si se desea habilitar busqueda por numero de folio y activar el recuadro en vistaFarmacia.php
		/*if($_POST['folio']){
			$folio = $_POST['folio'];
		}*/
		
	}
	
	#Se presiono el boton para actualizar un medicamento de aqui mismo
	if(isset($_REQUEST['updMed']))
	{
	
		if (isset($_POST['rol']))
		{
			$rol=$_POST['rol'];
		}
		if (isset($_POST['permisos']))
		{
			$permisos=$_POST['permisos'];
		}

		if(isset($_POST['expediente'])){
			$expediente = $_POST['expediente'];
		}
		
		if(isset($_POST['folio'])){
			$folio= $_POST['folio'];
		}
		
		#Estas variables son de aqui para actualizar un Medicamento
		#if(isset($_POST['idMed'])){
		#	$idMed = $_POST['idMed'];
		#}
		if(isset($_POST['tipoMed'])){
			$tipoMed= $_POST['tipoMed'];
		}
		if(isset($_POST['frecuencia'])){
			$frecuencia= $_POST['frecuencia'];
		}
		if(isset($_POST['viadmon'])){
			$viadmon= $_POST['viadmon'];
		}
		if(isset($_POST['dosis'])){
			$dosis= $_POST['dosis'];
		}
		if(isset($_POST['fechaInicio'])){
			$fechaInicio= $_POST['fechaInicio'];
		}
				
    	#Esta condicion para realizar una Actualización
    	if(isset($_POST["checkbox"])) {
			#Si llego el valor Actualizamos el registro con el o los id que llegaron
			$idMed = implode(",", $_POST['checkbox']);
    		$sqlUdpMed ="UPDATE medpacientes SET tipoMedicamento = '$tipoMed', fechaInicio = '$fechaInicio', dosis = '$dosis', idViaAdmon = '$viadmon',
    		 			frecuencia = '$frecuencia' WHERE id = $idMed";
    		$sqlUdpMed1 = mysqli_query($conexion, $sqlUdpMed); #or die (mysqli_error($conexion));
		    if(!$sqlUdpMed1){
		    	echo "<br/> !!!NO SE PUDO ACTUALIZAR EL MEDICAMENTO SELECCIONADO!!! <br/>";
	    		echo '<br/>Query UPD: '.$sqlUdpMed;
		    } else {
		    	echo "<br/> EL MEDICAMENTOS SE ACTUALIZO CORRECTAMENTE <br/>";
		    	#echo '<br/>Query UPD: '.$sqlUdpMed;
		    }
    	}
    }

	#Query's para obtener datos basicos y los medicamentos capturados de un paciente
	if(isset($_REQUEST['updMed']) || isset($_REQUEST['enviar'])){
		#Obtenemos datos basicos de MYSQL si es que ya los tiene el paciente
		$queryBasicos = 'SELECT habitacion,fechaEgreso,alergias,peso,talla,conciliacion,conciliacionE,conciliacionCambServ,conciliacionCambMed,traeMedicamento, diagnostico,concomitantes, depCreatinina,
						 CASE ingresa WHEN "1" THEN "HOSPITAL" ELSE "URGENCIAS" END AS ingresa1,medicamentoCasa,medEgre,tieneCultivo,cultivo
						 FROM paciente WHERE numeroExpediente='.'"'.$expediente.'" AND (folio = 0 || folio= '.'"'.$folio.'")';
		$idBas = mysqli_query($conexion, $queryBasicos ) or die (mysqli_error($conexion));
		$idbas1 = mysqli_fetch_array($idBas );
		if($idbas1 != NULL){
			$fechaEgresoPac = $idbas1 ['fechaEgreso'];
			$ingresaPac = $idbas1 ['ingresa1'];
			$alergiasPac = $idbas1 ['alergias'];
			$pesoPac = $idbas1 ['peso'];
			$tallaPac = $idbas1 ['talla'];
			$conciliacionPac = $idbas1 ['conciliacion'];
			$conciliacionE = $idbas1 ['conciliacionE'];
			$conciliacionCambServ = $idbas1 ['conciliacionCambServ'];
			$conciliacionCambMed = $idbas1 ['conciliacionCambMed'];
			$traeMedicamentoPac = $idbas1 ['traeMedicamento'];
			$diagnosticoPac = $idbas1 ['diagnostico'];
			$concomitantesPac = $idbas1 ['concomitantes'];
			$depCreati = $idbas1 ['depCreatinina'];
			$casa = $idbas1 ['medicamentoCasa'];
			$medEgre = $idbas1 ['medEgre'];
			$cuarto = $idbas1 ['habitacion'];
			$tieneCultivo = $idbas1 ['tieneCultivo'];
			$cultivo = $idbas1 ['cultivo'];
		}
		
		#Consulta para mostrar la dosis guardada de un medicamento del 2do bloque 
		$queryMed = 'SELECT DISTINCT (id), numeroExpediente, fechaInicio, m.idMedicamento, nombreMedicamento, dosis, v.viaAdmon,
		 				frecuencia, CASE nombreOtroTipo WHEN "" THEN t.nombreTipo ELSE nombreOtroTipo END AS tipoDeMed,
		 				m.tipoMedicamento, m.idViaAdmon, f.nombreFrecuencia, h.idMedPaciente, r.idRecomendacionHist, folio 
					FROM medpacientes as m
					LEFT JOIN tipomedicamento AS t ON m.tipoMedicamento = t.tipoMedicamento
					LEFT JOIN viadeadmon AS v on m.idViaAdmon = v.idViaAdmon
					LEFT JOIN frecuencia AS f ON m.frecuencia=f.idFrecuencia
					LEFT JOIN historicomed AS h ON m.id=h.idMedPaciente
					LEFT JOIN recomendacionhist as r ON r.idRecomendacionHist=h.idRecomendacionHist
					WHERE numeroExpediente='.'"'.$expediente.'" AND (folio = 0 || folio= '.'"'.$folio.'") order by fechaInicio, id';
		$rMed = mysqli_query($conexion, $queryMed) or die (mysqli_error($conexion));
	}

	#Se presiono el boton guardar de aqui mismo para guardar datos basicos
	if(isset($_REQUEST['enviarBasicos']))
	{
		#$_SESSION['expediente'] = $_POST['expediente'];
		#$_SESSION['folio'] = $_POST['folio'];
		$expediente = $_POST['expediente'];
		$folio = $_POST['folio'];
		$nomPac = $_POST['nomPac'];
		$edad = $_POST['edad'];
		$sexo = $_POST['sexo'];
		$fecNacPac = $_POST['fecNacPac'];
		$rol = $_POST['rol'];
		
		if(isset ($_POST['habitacion'])){
			$habitacion= $_POST['habitacion'];
		} else {
			$habitacion= NULL;
		}

		if(isset ($_POST['fechaEgreso'])){
			$fechaEgreso = $_POST['fechaEgreso'];
		} else {
			$fechaEgreso = NULL;
		}
		
		if(isset ($_POST['fecha_ing_pac'])){
			$fecha_ing_pac1 = $_POST['fecha_ing_pac'];
		} else {
			$fecha_ing_pac1 = NULL;
		}
		
		if(isset ($_POST['ingresa'])){
			$ingresa = $_POST['ingresa'];
		} else {
			$ingresa = NULL;
		}
		
		if(isset ($_POST['alergias'])){
			$alergias = utf8_decode($_POST['alergias']);
		} else {
			$alergias = 'NEGADAS';
		}
		
		if(isset ($_POST['peso'])){
			$peso= $_POST['peso'];
		} else {
			$peso= NULL;
		}
		
		if(isset ($_POST['talla'])){
			$talla= $_POST['talla'];
		} else {
			$talla= NULL;
		}
		
		if(isset ($_POST['depCreati'])){
			$depCreati= $_POST['depCreati'];
		} else {
			$depCreati= NULL;
		}
			
		if(isset ($_POST['conciliacion'])){
			$conciliacion = $_POST['conciliacion'];
		} else {
			$conciliacion = NULL;
		}
		
		if(isset ($_POST['conciliacionE'])){
			$conciliacionE = $_POST['conciliacionE'];
		} else {
			$conciliacionE = NULL;
		}
		
		if(isset ($_POST['conciliacionCambServ'])){
			$conciliacionCambServ = $_POST['conciliacionCambServ'];
		} else {
			$conciliacionCambServ = NULL;
		}
		
		if(isset ($_POST['conciliacionCambMed'])){
			$conciliacionCambMed = $_POST['conciliacionCambMed'];
		} else {
			$conciliacionCambMed = NULL;
		}
	
		if(isset ($_POST['tieneMedic'])){
			$traeMedic = '1';
		} else {
			$traeMedic = '0';
		}
		
		if(isset ($_POST['casa'])){
			$casa= utf8_decode($_POST['casa']);
		} else {
			$casa= NULL;
		}
		
		if(isset ($_POST['medEgre'])){
			$medEgre = utf8_decode($_POST['medEgre']);
		} else {
			$medEgre = NULL;
		}

		if(isset ($_POST['cultivo'])){
			$cultivo= utf8_decode($_POST['cultivo']);
		} else {
			$cultivo= NULL;
		}
		
		if(isset ($_POST['tieneCultivo'])){
			$tieneCultivo= '1';
		} else {
			$tieneCultivo= '0';
		}

		if(isset ($_POST['diag'])){
			$diag = utf8_decode($_POST['diag']);
		} else {
			$diag= NULL;
		}

		if(isset ($_POST['enferm'])){
			$enferm = utf8_decode($_POST['enferm']);
		} else {
			$enferm= NULL;
		}

		if(isset ($_POST['nombre_med'])){
			$nombreMed1= utf8_decode($_POST['nombre_med']);
		} else {
			$nombreMed1= NULL;
		}
		#Le quitamos a la variable los caracteres &nbsp; que salen de más
		if(isset ($_POST['especialidad_med'])){
			$especialidadMed1 = $_POST['especialidad_med'];
			$string = htmlentities($especialidadMed1, null, 'utf-8');
            $stringEM = str_replace("&nbsp;", "", $string);
		} else {
			$stringEM = NULL;
		}
		#Verificamos si este numero de Expediente ya tiene Datos básicos
		$queryDatosBasic = "SELECT numeroExpediente, folio FROM paciente WHERE numeroExpediente = '$expediente' AND (folio = 0 || folio = '$folio') ";
		$idDB = mysqli_query($conexion, $queryDatosBasic) or die (mysqli_error($conexion));
		$idDB1 = mysqli_fetch_array($idDB);
		$idDBFin = $idDB1 ['numeroExpediente'];
		
		#Ya tiene Datos básicos entonces es actualizacion
		if($idDBFin != NULL){
			$queryUpdDB = "UPDATE paciente SET habitacion = '$habitacion', fechaEgreso = '$fechaEgreso',
			 	ingresa = '$ingresa', alergias = '$alergias', peso = '$peso', talla = '$talla', conciliacion = '$conciliacion',conciliacionE='$conciliacionE',conciliacionCambServ='$conciliacionCambServ',
			 	conciliacionCambMed='$conciliacionCambMed',traeMedicamento = '$traeMedic', diagnostico = '$diag',concomitantes = '$enferm',depCreatinina = '$depCreati',medicamentoCasa= '$casa',medEgre='$medEgre',
			 	tieneCultivo= '$tieneCultivo', cultivo= '$cultivo', usr= '$rol'
			 WHERE numeroExpediente = '$expediente' AND (folio = 0 || folio= '$folio')";
			$result0 = mysqli_query($conexion, $queryUpdDB) or die (mysqli_error($conexion));
			
			if(!$result0){
				echo'! ERROR al realizar actualización de DATOS BÁSICOS!';
				#echo '<br/>Query UPD: '.$queryUpdDB;
			} else {
				echo '<br/>!!!! SE ACTUALIZARON LOS DATOS BÁSICOS CORRECTAMENTE!!!!<br>';
				#echo '<br/>Query UPD: '.$queryUpdDB;
				echo '&nbsp;&nbsp;<input type="image" src="img/reg.png" value="REGRESAR" onclick=location.href="javascript:history.back(-1)"; location.reload();" height="75" width="161"></input><table style="width: 100%">';
				exit;
			}
		}else{#No tiene datos basicos entonces es nueva insercion
			#Guardamos todos los valores recibidos en MySQL
			$query = "INSERT INTO paciente (numeroExpediente, folio, habitacion, fechaIngreso, fechaEgreso, ingresa, nombre, edad, sexo, fechaNacimiento, alergias, peso, talla, conciliacion, conciliacionE,
				conciliacionCambServ, conciliacionCambMed,traeMedicamento, medico, especialidad, diagnostico, concomitantes, depCreatinina, medicamentoCasa, medEgre, tieneCultivo, cultivo, usr)
			VALUES ('$expediente', '$folio', '$habitacion', '$fecha_ing_pac1', '$fechaEgreso', '$ingresa', '$nomPac', '$edad', '$sexo', '$fecNacPac', '$alergias', '$peso', '$talla', '$conciliacion', '$conciliacionE',
				'$conciliacionCambServ','$conciliacionCambMed','$traeMedic', '$nombreMed1', '$stringEM', '$diag', '$enferm', '$depCreati', '$casa', '$medEgre', '$tieneCultivo', '$cultivo', '$rol')";
	
			$result = mysqli_query($conexion, $query);
			if(!$result){
				echo'! ERROR al realizar inserción de datos Basicos !<br>';
				echo $query;
			} else {
				echo 'SE GUARDARON LOS DATOS BASICOS CORRECTAMENTE <br>';
				echo '&nbsp;&nbsp;<input type="image" src="img/reg.png" value="REGRESAR" onclick=location.href="javascript:history.back(-1);" height="75" width="161"><table style="width: 100%">';
				#echo $query;
				exit;
				#echo 'Nac: '.$fecNacPac.' Ingr: '.$fecha_ing_pac1.' Egre: '.$fechaEgreso;
				#echo '<br>'.$query;
			}
		}
		mysqli_close($conexion);
	} 

	#Forma POO instanciamos y mandamos llamar un objeto de la instancia
    $usuario1 = new FuncionesDB();
    #La funcion retorna un arreglo lo mandamos a una variable
    $resultado[] = $usuario1->consultaBasicos($expediente,$folio);
	#El arreglo esta vacio 
    if (empty($resultado[0])) {
    	#Obtenemos datos de MYSQL si es que existen para el expediente dado nombre,numeroExpediente,folio,edad,sexo,diagnostico,medico,especialidad,habitacion,fechaIngreso,fechaNacimiento, medicamentoCasa, cultivo
    	$queryBasicos1 = "SELECT * FROM paciente WHERE numeroExpediente LIKE '%$expediente' AND (folio = 0 || folio= '$folio')";
		$idBas1 = mysqli_query($conexion, $queryBasicos1) or die (mysqli_error($conexion));
		$idbas2 = mysqli_fetch_array($idBas1);
		if($idbas2 != NULL) {
			$nombre_pac = utf8_decode($idbas2 ['nombre']); #tambien puede ser $idbas2[0]
		    $expediente_pac = $idbas2 ['numeroExpediente'];
		    $folio_pac = $idbas2 ['folio'];
		    $edad_pac = $idbas2 ['edad'];
	   	    $sexo_pac = $idbas2 ['sexo'];
	   	    $diag_ingreso_pac = $idbas2 ['diagnostico'];
	   	    $nombre_med = $idbas2 ['medico'];
	   	    $especialidad_med = $idbas2 ['especialidad'];
	   	    $cuarto = $idbas2 ['habitacion'];
	   	    $casa = $idbas2 ['medicamentoCasa'];
	   	    $cultivo = $idbas2 ['cultivo'];
	
		    #$date = $idbas2 ['fechaIngreso']; //HR_ING_PAC
		    #$fecha_ing_pac = $date->format('d-m-Y');
		    
		    #date_create_from_format('d-m-Y',$fecha_nac_pac)->format('Y-m-d')
		    
		    $fecha_ing_pac1 = strtotime($idbas2 ['fechaIngreso']);
		    $fecha_ing_pac = date('d-m-Y',$fecha_ing_pac1);
		    		    
		    #$date2 = $idbas2 ['fechaNacimiento'];
		    #$fecha_nac_pac = $date2->format('d-m-Y');
		    $fecha_nac_pac1 = strtotime($idbas2 ['fechaNacimiento']);
		    $fecha_nac_pac = date('d-m-Y',$fecha_nac_pac1);

		} else {
	    	echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
				<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
				<title>Formulario Farmacia</title>
				<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
				<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
				<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
				</head>
				<body><strong>NO EXISTEN DATOS PARA EL EXPEDIENTE COLOCADO</strong> <br><br>';
	    	echo '&nbsp;&nbsp;<input type="image" src="img/reg.png" value="REGRESAR" onclick=location.href="javascript:history.back(-1);" height="75" width="161">
	    	<table style="width: 100%">
	    	</body></html>';
	    	exit();
    	}
    } else { #El arreglo NO esta vacio, asignamos una variables a los valores recibidos
	    $nombre_pac = utf8_decode($resultado[0][0]['NOMBRE']);
	    $expediente_pac = $resultado[0][0]['NO_EXP_PAC'];
	    $folio_pac = $resultado[0][0]['FOLIO_PAC'];
	    $edad_pac = $resultado[0][0]['EDAD_PAC'];
   	    $sexo_pac = $resultado[0][0]['SEXO_PAC'];
   	    $diag_ingreso_pac = $resultado[0][0]['MOTIV_ING_PAC'];
   	    $nombre_med = $resultado[0][0]['DESC_MEDICO'];
   	    $especialidad_med = $resultado[0][0]['DESC_ESPEC'];
   	    if($cuarto == NULL || trim($cuarto) == ''){
	   	    $cuarto = $resultado[0][0]['CVE_CUARTO'];
		}
	    $date = $resultado[0][0]['FEC_ING_PAC']; //HR_ING_PAC
	    $fecha_ing_pac = $date->format('d-m-Y');
	   /* $dia_ing_pac = $date->format(' d ');
	    $mes_ing_pac = $date->format(' m ');
	    $anio_ing_pac = $date->format(' Y ');*/
	    $hrI = $resultado[0][0]['HR_ING_PAC'];
	    $hrsI = $hrI->format('H');
   	    $minI = $hrI->format('i');
	    $hrIngreso = $hrsI.':'.$minI;
		if($resultado[0][0]['FEC_SAL']!= NULL && $resultado[0][0]['FEC_SAL'] !='' ){
		    $date1 = $resultado[0][0]['FEC_SAL'];
		    $fecha_sal_pac = $date1->format('Y-m-d');
		    /*$dia_sal_pac = $date1->format(' d ');
		    $mes_sal_pac = $date1->format(' m ');
		    $anio_sal_pac = $date1->format(' Y ');*/
	    } else {
	    	$fecha_sal_pac = NULL;
	    }
	    if($fechaEgresoPac == NULL || $fechaEgresoPac == '' || $fechaEgresoPac='0000-00-00'){
	    	$fechaEgresoPac= $fecha_sal_pac;
	    }
	    
	    $date2 = $resultado[0][0]['NACIO_PA'];
	    $fecha_nac_pac = $date2->format('d-m-Y');
	    $dia_nac_pac = $date2->format(' d ');
	    $mes_nac_pac = $date2->format(' m ');
	    $anio_nac_pac = $date2->format(' Y ');
	}
	$excel="EXPEDIENTE: ".$expediente_pac." FOLIO: ".$folio_pac." PACIENTE: ".$nombre_pac."\n FECHA INICIO\tNOMBRE\tDOSIS\tVÍA DE ADMON.\tFRECUENCIA\tDÍA CONSUMO\tHR. CONSUMO\tTIPO DE MEDICAMENTO\n";
	#$medicinas[] = $usuario1->medicamento();
	$expediente=trim($expediente);
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Formulario Farmacia</title>
<link rel="stylesheet" href="css/bootstrap.min.css" />
<!--link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script-->
<style type="text/css">
	.auto-style3 {
		border: 5px solid #000000;
	}
	.auto-style4 {
		text-align: center;
		font-size: large;
	}
	.auto-style5 {
		font-size: x-large;
	}
	.auto-style6 {
		background-color: #C4E3F3;
	}
	.auto-style7 {
		font-weight: bold;
	}
	.styleBD {
		background-image: url('img/logoNew2Agua.jpg');
	}
	#div1 {
    	overflow:scroll;
    	height:440px;
    	width:100%;
	}
</style>
</head>
<!--Al cargar la pagina checamos si tiene conciliacion y trae medicamentos para marcar los checkbox correspondientes-->
<body onload="checarCul(<?php echo $tieneCultivo ?>); reportes(<?php echo $permisos ?>);" class="styleBD">
<!--script type="text/javascript">
if((navigator.userAgent.match(/MSIE/i)) || (navigator.userAgent.match(/Googlebot/i)) || (navigator.userAgent.match(/Chrome/i)) 
	|| (navigator.userAgent.match(/Firefox/i))) {
	"" } else {
		document.write('<style type="text/css" media="screen">#sidebar,#menu{display:none;}#page{width:99%;}#content{width:99%;}</style>');
	}
</script-->
<script type="text/javascript" src="js/funciones.js"></script>

&nbsp;&nbsp;<input type="image" src="img/reg.png" value="REGRESAR" onclick=location.href="vistaFarmacia.php?rol=<?php echo $rol ?>&permisos=<?php echo $permisos ?>" height="75" width="161"/>
<p>
<span class="auto-style7">ELEGIR UNA DE LAS SIGUIENTES OPCIONES:</span></p>
&nbsp;<input class="btn btn-primary" id="btnMostrarDB" type="button" value="DATOS BÁSICOS" onclick="mostrarTb()" style="width: 200px; height: 40px"/>&nbsp;&nbsp;
<input class="btn btn-primary" id="btnMostrarMedic" type="button" value="MEDICAMENTOS CAPTURADOS" onclick="mostrarTbMedic()" style="width: 273px; height: 40px"/>&nbsp;&nbsp;
<input class="btn btn-primary" id="btnReportePaciente" type="button" value="REPORTE GENERAL PACIENTE" onclick="window.open('reporteGralPaciente.php?expediente=<?php echo $expediente ?>&folio=<?php echo $folio ?>')" style="width: 273px; height: 40px" target="_blank" />&nbsp;&nbsp;
<table id="tblBasicos" style="display:none" >
<tr>
<td class="auto-style3">
<div class="auto-style1">
	<form method="post" action="formulario_farmacia.php" autocomplete="off">
		<hr/>
		<div class="auto-style4">
			<strong> <span class="auto-style5">~~~~~ DATOS GENERALES DEL PACIENTE ~~~~~</span></strong><br/>
		</div>
		<hr/>
		<strong> NÚMERO DE EXPEDIENTE:&nbsp; </strong><?php echo $expediente_pac ?>
		<strong> FOLIO:&nbsp; </strong><?php echo $folio_pac ?>
		<strong>&nbsp;&nbsp;HABITACIÓN:</strong>&nbsp;
		<input id="show_habit" name="habitacion" style="width: 53px; height: 40px" type="text" placeholder="s/v" value="<?php echo $cuarto ?>" disabled /> &nbsp;&nbsp;
		<strong> FECHA Y HORA DE INGRESO:&nbsp;</strong> <?php echo $fecha_ing_pac.' '.$hrIngreso.'Hrs' ?>
		<br/>
		<br/> 
		<strong>FECHA DE EGRESO:&nbsp;</strong>
		<input id="show_fegreso" name="fechaEgreso" type="date" style="width: 145px; height: 44px" value="<?php echo $fechaEgresoPac ?>" disabled />
		<strong>INGRESA POR:</strong>&nbsp;<?php echo $ingresaPac  ?>
		<select id="ingresa" name="ingresa" style="width:150px; height:40px" disabled >
            <option value="0">Seleccione:</option>
            <option value="1"> HOSPITAL </option>
            <option value="2"> URGENCIAS </option>
		</select>
		<!--HOSPITAL: (<input id="show_radio0" name="radio1" type="hidden"/>)&nbsp;&nbsp; 
		URGENCIA: (<input id="show_radio1" name="radio1" type="hidden"/>)-->
		<!--br/-->
		<br/>
		<br/>
		<strong> NOMBRE DEL PACIENTE:&nbsp;</strong> <?php echo utf8_encode($nombre_pac) ?>&nbsp;&nbsp;
		<strong> EDAD:&nbsp;&nbsp;</strong><?php echo $edad_pac ?>&nbsp;&nbsp;&nbsp;&nbsp; 
		<strong> SEXO:&nbsp;&nbsp;</strong><?php echo $sexo_pac ?>&nbsp;&nbsp;&nbsp;&nbsp; 
		<strong> FECHA DE NACIMIENTO:&nbsp;</strong><?php echo $fecha_nac_pac ?>
		<br/><br/>
		<strong>ALERGIAS:&nbsp;</strong>
		<input id="show_alergias" name="alergias" style="width: 566px; height: 40px" type="text" placeholder="Colocar Alergias" value="<?php echo utf8_encode($alergiasPac) ?>" disabled />&nbsp;&nbsp; 
		<strong><br/><br/>PESO:&nbsp;</strong>
		<input id="show_peso" name="peso" style="width: 53px; height: 40px" type="text" placeholder="Peso" value="<?php echo $pesoPac ?>" disabled />&nbsp; 
		<strong>TALLA:&nbsp;</strong>
		<input id="show_talla" name="talla" style="width: 74px; height: 40px" type="text" placeholder="Talla" value="<?php echo $tallaPac?>" disabled />
		<strong>DEPURACIÓN DE CREATININA:&nbsp;</strong>
		<input id="show_creati" name="depCreati" style="width: 94px; height: 40px" type="text" placeholder="valor" value="<?php echo $depCreati?>" disabled />
		<br/><br/>
		<strong><center>CONCILIACIÓN:</center>
		<br/>
		<?php 
			$conciIngrS = NULL;
	  		$conciIngrN = NULL;
	  		$conciliacionPac == "1" ? $conciIngrS='checked':$conciIngrN='checked';
	  
	  		$conciEgreS = NULL;
	  		$conciEgreN = NULL;
	  		$conciliacionE == "1" ? $conciEgreS='checked':$conciEgreN='checked';
	  
	  		$conciCambsS = NULL;
	  		$conciCambsN = NULL;
	  		$conciCambsNA = NULL;
	  		if($conciliacionCambServ == "SI"){
				$conciCamsS ='checked';
			} else if($conciliacionCambServ == "NO"){
				$conciCambsN = 'checked';
			} else {
				$conciCambsNA = 'checked';
			}
	  
	  		$conciCambmS = NULL;
	  		$conciCambmN = NULL;
	  		$conciCambmNA = NULL;
	  		if($conciliacionCambMed == "SI"){
				$conciCammS ='checked';
			} else if($conciliacionCambMed == "NO"){
				$conciCambmN = 'checked';
			} else {
				$conciCambmNA = 'checked';
			}
			
		?>
		AL INGRESO: SI: <input id="conciliacion" name="conciliacion" type="radio" value="1" style="width: 45px; height: 35px" <?php echo $conciIngrS ?> /> NO: <input id="conciliacion" name="conciliacion" type="radio" value="0" style="width: 45px; height: 35px" <?php echo $conciIngrN ?> />
		<!--input id="traeMedic" name="tieneMedic" type="checkbox" style="width: 45px; height: 35px" disabled /-->
		<br/><br/>
		<input id="casa" type="text" name="casa" style="width: 797px; height: 40px" placeholder="Colocar Medicamentos de Ingreso" value="<?php echo utf8_encode($casa)?>" disabled />
		<br/><br/>
		AL EGRESO: SI: <input id="conciliacionE" name="conciliacionE" type="radio" value="1" style="width: 45px; height: 35px" <?php echo $conciEgreS ?>/> NO: <input id="conciliacionE" name="conciliacionE" type="radio" value="0" style="width: 45px; height: 35px" <?php echo $conciEgreN ?>/>
		<br/><br/>
		<input id="medEgre" type="text" name="medEgre" style="width: 797px; height: 40px" placeholder="Colocar Medicamentos de Egreso" value="<?php echo utf8_encode($medEgre)?>" disabled />
		<br/><br/>
		AL CAMBIO DE SERVICIO: SI: <input id="conciliacionCambServ" name="conciliacionCambServ" type="radio" value="SI" style="width: 45px; height: 35px" <?php echo $conciCambsS ?> /> NO: <input id="conciliacionCambServ" name="conciliacionCambServ" type="radio" value="NO" style="width: 45px; height: 35px" <?php echo $conciCambsN ?>/> NO APLICA: <input id="conciliacionCambServ" name="conciliacionCambServ" type="radio" value="NO APLICA" style="width: 45px; height: 35px" <?php echo $conciCambsNA ?>/>
		<br/><br/>
		AL CAMBIO DE MÉDICO: SI: <input id="conciliacionCambMed" name="conciliacionCambMed" type="radio" value="SI" style="width: 45px; height: 35px" <?php echo $conciCambmS ?> /> NO: <input id="conciliacionCambMed" name="conciliacionCambMed" type="radio" value="NO" style="width: 45px; height: 35px" <?php echo $conciCambmN ?>/> NO APLICA: <input id="conciliacionCambMed" name="conciliacionCambMed" type="radio" value="NO APLICA" style="width: 45px; height: 35px" <?php echo $conciCambmNA ?>/>
		</strong>
		<br/><br/>
		<strong> CULTIVO: (<input id="cultivo" name="tieneCultivo" type="checkbox" style="width: 45px; height: 35px" disabled />)
		</strong>
		<br/><br/>
		<input id="campoCultivo" type="text" name="cultivo" style="width: 797px; height: 40px" placeholder="Colocar Cultivo" value="<?php echo utf8_encode($cultivo)?>" disabled />
		<br/><br/>
		<strong>MEDICO TRATANTE:&nbsp;</strong> <?php echo utf8_encode($nombre_med) ?>
		<strong>ESPECIALIDAD:&nbsp;</strong> <?php echo $especialidad_med ?>
		<br/><br/>
		<strong>DIAGNÓSTICO:&nbsp;</strong>
		<input id="show_diag" type="text" name="diag" style="width: 797px; height: 40px" placeholder="Colocar Diagnóstico" value="<?php echo utf8_encode($diagnosticoPac) ?>" disabled />
		<br/><br/>
		<strong>ENFERMEDADES CONCOMITANTES:&nbsp;</strong>
		<input id="show_enferm" name="enferm" style="width: 626px; height: 40px" type="text" placeholder="Colocar Enfermedades" value="<?php echo utf8_encode($concomitantesPac) ?>" disabled />
		<br/><br/>
		<!-- Datos complemenatario para guardar en la BD MySQL -->
		<input name="expediente" type="hidden" value="<?php echo $expediente ?>" />
		<input name="folio" type="hidden" value="<?php echo $folio ?>" />
		<input name="nomPac" type="hidden" value="<?php echo $nombre_pac ?>" />
		<input name="edad" type="hidden" value="<?php echo $edad_pac ?>" />
		<input name="sexo" type="hidden" value="<?php echo $sexo_pac ?>" />
		<input name="fecNacPac" type="hidden" value="<?php echo date_create_from_format('d-m-Y',$fecha_nac_pac)->format('Y-m-d') ?>" />
		<input name="nombre_med" type="hidden" value="<?php echo $nombre_med ?>" />
		<input name="especialidad_med" type="hidden" value="<?php echo $especialidad_med ?>" />
		<input name="fecha_ing_pac" type="hidden" value="<?php echo date_create_from_format('d-m-Y',$fecha_ing_pac)->format('Y-m-d') ?>" />
		<input name="rol" type="hidden" value="<?php echo $rol ?>" />
		<input name="permisos" type="hidden" value="<?php echo $permisos ?>" />
		<input name="permisos" type="hidden" value="<?php echo $rol ?>" />
		<br/><br/>
		&nbsp;&nbsp;
		<input class="btn btn-success" id="show_guarda" type="hidden" name="enviarBasicos" value="GUARDAR" style="width: 137px; height: 40px" />
		<input class="btn btn-primary" id="btnMostrar" type="button" value="COMPLEMENTAR DATOS GENERALES" onclick="mostrar('1')" style="width: 308px; height: 40px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input class="btn btn-danger" id="btnOcultar" type="hidden" value="CANCELAR" onclick="mostrar('0')" style="width: 137px; height: 40px"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input class="btn btn-info" id="btnLab" type="button" value="DATOS DE LABORATORIO" onclick="window.open('datosLaboratorio.php?expediente=<?php echo $expediente ?>&folio=<?php echo $folio ?>&nomPac=<?php echo urlencode(utf8_encode($nombre_pac))?>','ventana','width=840,height=680,scrollbars=YES,menubar=NO,resizable=NO,titlebar=NO,status=NO');"return false style="width: 225px; height: 40px"/>
	</form>
	</div>
	</td>
	</tr>
</table>
<!--------------------------------------------------------------- INICIO DE LA SEGUNDA PARTE DE LA PAGINA ---------------------------------------------------------------------->
<form method='post' action='formulario_farmacia.php'>
    <table id="tbMedicamentos" style="width: 100%;display:none" bgcolor= "#FFFFFF" autocomplete="off">
	<tr>
		<td class="auto-style3"> <strong> MEDICAMENTOS CAPTURADOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong>
		<input type="button" class="btn btn-success" value="CAPTURAR NUEVO MEDICAMENTO" onclick ="window.open('capturaMedicamentos.php?expediente=<?php echo $expediente ?>&folio=<?php echo $folio ?>&nomPac=<?php echo urlencode(utf8_encode($nombre_pac))?>','ventana','width=840,height=680,scrollbars=YES,menubar=NO,resizable=NO,titlebar=NO,status=NO');"return false style="width: 303px; height: 61px"/>
		&nbsp;&nbsp;&nbsp;<input type="button" class="btn btn-info" value="RECARGAR LISTADO" onclick ="location.reload()" style="width: 200px; height: 61px"/>
		&nbsp;&nbsp;&nbsp;<!--input type="button" class="btn btn-warning" value="VISTA COMPACTA" onclick ="opcionesMed()" style="width: 200px; height: 61px"/-->

		<hr/>
		<div  id="div1">
		<table style="width: 100%"  border="1px solid black;" class="auto-style6">
			<th class="text-center">&nbsp; OPC &nbsp;</th>
			<th class="text-center">FECHA DE INICIO</th>
			<th class="text-center">NOMBRE</th>
			<th class="text-center">DOSIS</th>
			<th class="text-center">VÍA DE ADMON</th>
			<th class="text-center">FRECUENCIA</th>
			<th class="text-center">ÚLTIMO DÍA/HR CONSUMO</th>
			<th class="text-center">TIPO DE MEDICAMENTO</th>
			<th class="text-center">OPCIONES</th>
			<?php
			$c=0;	  		
			while($row = mysqli_fetch_array($rMed)){
                if($row[2] != NULL){
                    $date1 = date_create_from_format('Y-m-d',$row[2]);
                } else {
                    $date1 = NULL;
                }
                
                $desc = NULL;
                
                if($row[12] != NULL){
                	$desc = "<span style='color:red'>DESCONTINUADO</span>";
                }
                                
                $queryDss = 'SELECT diaConsumo, hrConsumo FROM historicodosis WHERE idMedicamento='.$row[3].' AND idMedPaciente='.$row[0].' ORDER BY diaConsumo DESC, hrConsumo DESC LIMIT 1';
                $dosis = mysqli_query($conexion, $queryDss) or die (mysqli_error($conexion));
                $rowD = mysqli_fetch_array($dosis);
                if($rowD != NULL ){
                    $dateD = date_create_from_format('Y-m-d',$rowD['diaConsumo'])->format('d-m-Y');
                    $hrD = $rowD['hrConsumo'];
                } else {
                    $dateD = NULL;
                    $hrD = NULL;
                }
                
                if( ($row[12] != NULL && $dateD == NULL) || ($row[13] == 2) ){
	                $desc = "<span style='color:green'>PRESCRIPCIÓN AL EGRESO</span>";
                }
                #Aqui comenzamos con los valores dentro de la Tabla central
                #echo '<td> QUERY: '.$queryDss.'</td>';
                echo '<input name="idMed" type="hidden" value="'.$row[0].'" >';
                echo "
				<tr>
				<td class='text-center'>
				<input name='checkbox[]' type='checkbox' id='checkbox[]' value='".$row[0]."' style='width: 45px; height: 35px' ><br/>
				<spam>". ++$c ."</spam>
				</td>
					<td class='text-center'> <input id='show_finicio".$row[0]."' name='fechaInicio' type='date' style='width: 145px; height: 44px' value='".$date1->format('Y-m-d')."' disabled /></td>
					<td class='text-center'>".$row[4]."</td>
					<td class='text-center'><input id='show_dosis".$row[0]."' name='dosis' type='text' style='width: 100px; height: 44px' value='".$row[5]."' disabled /></td>
					<td class='text-center'>
					<select name='viadmon' id='viadmon".$row[0]."' style='width:65px; height:40px' disabled >
			        <option value='".$row[10]."'>".$row[6]."</option>
			   			<option value='1'> IV </option>
						<option value='2'> VO </option>
						<option value='3'> IM </option>
						<option value='4'> SL </option>
						<option value='5'> SUBARACNOIDEA </option>
						<option value='6'> NASAL </option>
						<option value='7'> RECTAL </option>
						<option value='8'> VAGINAL </option>
					</select>
					</td>
					<td class='text-center'>
					<select id='show_frecuencia".$row[0]."' name='frecuencia' style='width: 90px; height: 44px' disabled />
			       		<option value='".$row[7]."'>".$row[11]."</option>
						<option value='1'> 4h </option>
						<option value='2'> 6h </option>
						<option value='3'> 8h </option>
						<option value='4'> 12h </option>
						<option value='5'> 24h </option>
						<option value='6'> DU </option>
					</select>
					</td>
					<td class='text-center'>".$dateD." ".$hrD."
					<br>
					$desc
					<!--span style='color:red'>$desc</span-->
					</td>
					<td class='text-center'> 
					<select name='tipoMed' id='tipoMed".$row[0]."' onchange='verOtro(this.form)' style='width:160px; height:40px' disabled >
				        <option value='".$row[9]."'>".utf8_encode($row[8])."</option>
				        	<option value='1'> ANTIBIÓTICO </option>
							<option value='2'> ANALGÉSICO </option>
							<option value='3'> ANTIÁCIDO </option>
							<option value='4'> ANTIEMÉTICO </option>
							<option value='5'> ANESTÉSICO </option>
							<option value='6'> ANTIESPASMÓDICO </option>
							<!--option value='7'> OTROS </option-->
						</select>
					</td>";
				echo '<input name="expediente" type="hidden" value="'.$expediente.'" >
					  <input name="folio" type="hidden" value="'.$folio.'" >
					  <input name="rol" type="hidden" value="'.$rol.'" >
					  <input name="permisos" type="hidden" value="'.$permisos.'" >';
			    echo '<td>&nbsp; <input  class="btn btn-success" type="button" id="revisionesMed" value="REVISIONES" onclick =window.open(\'revisiones.php?expediente='.$expediente.'&folio='.$folio.'&nomPac='.urlencode(utf8_encode($nombre_pac)).'&idMedic='.trim($row[3]).'&id='.$row[0].'&nMedic='.urlencode(utf8_encode($row[4])).'\');return false style="width: 137px; height: 44px; display:block"/>';
			    echo '<input  class="btn btn-warning" type="button" id="dosisMed" value="DOSIS" onclick =window.open(\'dosis.php?expediente='.$expediente.'&folio='.$folio.'&nomPac='.urlencode(utf8_encode($nombre_pac)).'&idMedic='.trim($row[3]).'&id='.$row[0].'&nMedic='.urlencode(utf8_encode($row[4])).'\');return false style="width: 137px; height: 44px; display:block"/>';
			    echo '<input  class="btn btn-info" type="button" id="histHospMed" value="DESCONTINUAR" onclick =window.open(\'historico.php?expediente='.$expediente.'&folio='.$folio.'&nomPac='.urlencode(utf8_encode($nombre_pac)).'&idMedic='.trim($row[3]).'&id='.$row[0].'&nMedic='.urlencode(utf8_encode($row[4])).'\');return false style="width: 150px; height: 44px; display:block"/>';
			    echo '<input  class="btn btn-primary" type="button" id="btnModifMed'.$row[0].'" value="MODIFICAR" onclick ="dsblqModifMedic('.$row[0].')" style="width: 130px; height: 44px; display:block" />';
			    #echo '&nbsp;&nbsp;<input  class="btn btn-primary" type="submit" name="enviar" id="btnGuardaMed'.$row[0].'" value="GUARDAR" style="width: 130px; height: 44px; ;display:none"  />';
			    echo '</td></tr>';
				
				$excel.= $date1->format('Y-m-d')."\t".$row[4]."\t".$row[5]."\t";
			    $excel.= $row[6]."\t".$row[7]."\t".$dateD."\t";
			    $excel.= $hrD."\t".utf8_encode($row[8])."\n";
			}
			?>
		</table>
		</div>
		<br/>&nbsp;&nbsp;<input  class="btn btn-danger" onclick="return confirmSubmit()" name="enviar" type="submit" value="ELIMINAR" style="width: 140px; height: 50px" />&nbsp;&nbsp;&nbsp;
		<input  class="btn btn-primary" type="submit" name="updMed" id="btnGuardaMed" value="GUARDAR" style="width: 130px; height: 44px;" disabled/>&nbsp;&nbsp;&nbsp;
		<input type="button" class="btn btn-info" value="INTERACCIONES" onclick ="window.open('interacciones.php?expediente=<?php echo $expediente ?>&folio=<?php echo $folio ?>&nomPac=<?php echo urlencode(utf8_encode($nombre_pac))?>','ventana','width=840,height=680,scrollbars=YES,menubar=NO,resizable=NO,titlebar=NO,status=NO');"return false style="width: 157px; height: 44px"/>
		&nbsp;</td>
	</tr>
</table>
</form>
<div id="reportes">
	<form action="excel.php" method = "post">
		<input type="hidden" name="export" value="<?php echo $excel ?>" /> 
		<input type="hidden" name="nombre" value="MedicamentosPorPaciente" />
		<br/>&nbsp;&nbsp;&nbsp;&nbsp; 
		<input id="btExportar" class="btn-success" type="hidden" value="EXPORTAR A EXCEL" style="height: 50px; width: 152px" />
	</form>
</div>
<br/>
<table style="width: 100%" class="auto-style2">
	<tr>
		<td class="auto-style3"> <strong>FACTURACIÓN REAL</strong>
		<hr/>
		&nbsp;&nbsp;&nbsp;
		<input class="btn-primary" type="submit" value="CONSULTAR" onclick ="window.open('consultaMedSurtido.php?expediente=<?php echo $expediente ?>&folio=<?php echo $folio ?>&nomPac=<?php echo urlencode(utf8_encode($nombre_pac))?>','ventana','width=840,height=680,scrollbars=YES,menubar=NO,resizable=NO,titlebar=NO,status=NO');"return false style="width: 137px; height: 44px"/>
		</td>
	</tr>
</table>
<!--?php 
	if($ingresaPac != NULL){
		echo "<script type='text/javascript'>";
		echo "blqBtnMost();";
		echo "</script>";
	}
?-->
</body>

</html>
