<?php
	require "eliminar/conexion.php";
	$rol=NULL;

 	if (isset($_GET['rol']))
	{
		$rol=$_GET['rol'];
	}
	if (isset($_POST['rol']))
	{
		$rol=$_POST['rol'];
	}

	session_name($rol);
	session_start();
	//Si la variable sesión está vacía
	if (!isset($_SESSION[$rol])) 
	{
	   /* nos envía a la siguiente dirección en el caso de no poseer autorización */
	   #echo "Variable de session VACIA!!!!!";
	   header("location: index.php");
	}
	
	if(isset($_REQUEST['consultaSala']))
	{
		//recuperar las variables
		$fecha=$_POST['fecha'];
		//$sala=$_POST['sala'];
		
		$sqlSala = "SELECT p.idSala, p.fecha, p.hrInicio, p.hrFin, d.cirugia
					FROM programaparto AS p
					LEFT JOIN datosnuevosparto AS d ON p.idCirugia=d.id
					WHERE p.fecha='$fecha' ORDER BY idSala,hrInicio";
		$resultado=$mysqli->query($sqlSala);
		
		$sqlSala0 = "SELECT id, idCirugia, idSala, fecha, GROUP_CONCAT(SUBSTR(p.hrInicio,1,2) SEPARATOR ',') as hrIni, GROUP_CONCAT(SUBSTR(p.hrFin,1,2) SEPARATOR ',') as hrFinal
					FROM programaparto AS p
					WHERE fecha='$fecha'
					GROUP BY idSala";
		$resultado0=$mysqli->query($sqlSala0);
				
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" >
<title>Salas Disponibles</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous" />
<meta http-equiv="refresh" content="300">
<style type="text/css">
/* Datagrid */
	body {
  	text-align: center;
    	background-color: #E8F0FE;
    	font-family: Helvetica,Arial,sans-serif;
    }
	table {
	  border-collapse: collapse;
	  box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	}
	th, td {
	  padding: 0.25rem;
	  text-align: center;
	}
	tbody tr:nth-child(odd) {
	  background: #eee;
	  width: 40px;
	}
	.centro{
	  padding: 0.5rem;
	  background: #4285F4 ;
	  color: white;
	  text-align: center;
	  font-size: 21px;
	
	}
	
	#cuadro{
		width: 90%;
		background: #F8F8F8 ;
		padding: 25px;
		margin: 5px auto;
		box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
	}
	#titulo{
		width: 100%;
		background: #4285F4;
		color:white;
	}
	.auto-style1 {
		background-color:maroon;
	}
	.auto-styleRed {
		background-color:#00FF00;
	}

</style>
</head>

<body>
	<div id="cuadro">
		<center><img src="../img/logoNew2.jpg" width="200" height="200"/><br /></center>
		<div id="titulo">
			<center><h1>Disponibilidad de Salas PARTO</h1></center>
		</div>
		<form method="post">
		<!--&nbsp;Sala de Operaciones
			<select id="sala" name="sala" style="width:230px; height:40px" required >
				<option value="">Seleccionar</option>
			    <option value="1"> SALA 1 </option>
				<option value="2"> SALA 2 </option>
				<option value="3"> SALA 3 </option>
				<option value="4"> SALA DE EXPULSIÓN </option>
			</select-->
			
			&nbsp;&nbsp; Fecha
				<input class="box" type="date" name="fecha" required />&nbsp;&nbsp;&nbsp;
			
			<input type="hidden" name="rol" value="<?php echo $rol ?>" />
			<input class="btn btn-info" type="submit" name="consultaSala" value="Consultar" />
		</form>
		
		<?php if(isset($_REQUEST['consultaSala'])) { ?>
		<table class="table table-bordered">
		<br>
		<?php $date1 = date_create_from_format('Y-m-d',$fecha)->format('d-m-Y'); ?>
		Ocupación para la Fecha: <?php echo $date1 ?>
		<thead>
			<tr class="centro">
				<td>SALA</td>
				<td>CIRUGÍA</td>
				<td>HORAS DE OCUPACIÓN</td>
			</tr>
			</thead>
			<tbody>
			<?php while($row=$resultado->fetch_assoc()){ ?>
				<tr>
					<td>
						<?php if($row['idSala'] == 1){
							echo "SALA 1";
						} else 
						if($row['idSala'] == 2){
							echo "SALA 2";
						} else 
						if($row['idSala'] == 3){
							echo "SALA 3";
						} else 
						if($row['idSala'] == 4){
							echo "SALA DE EXPULSIÓN";
						} else {
							echo "";
						} ?>
					</td>
					<td>
						<?php echo utf8_encode($row['cirugia']) ?>
					</td>
					<td>
						<?php echo $row['hrInicio'];?> - <?php echo $row['hrFin'];?>
					</td>					
				</tr>
			<?php } ?>
			</tbody>
			</table>
			
			<table class="table table-bordered">
			<br>
			<?php $date2 = date_create_from_format('Y-m-d',$fecha)->format('d-m-Y'); ?>
			Ocupación para la Fecha: <?php echo $date2 ?>
			<thead>
			<tr class="centro">
				<td>SALA/HORA</td>
				<td>0</td>
				<td>1</td>
				<td>2</td>
				<td>3</td>
				<td>4</td>
				<td>5</td>
				<td>6</td>
				<td>7</td>
				<td>8</td>
				<td>9</td>
				<td>10</td>
				<td>11</td>
				<td>12</td>
				<td>13</td>
				<td>14</td>
				<td>15</td>
				<td>16</td>
				<td>17</td>
				<td>18</td>
				<td>19</td>
				<td>20</td>
				<td>21</td>
				<td>22</td>
				<td>23</td>
			</tr>
			</thead>
			<tbody>
			<?php while($row0=$resultado0->fetch_assoc()){ ?>
				<tr>
					<td>
						<?php if($row0['idSala'] == 1){
							echo "SALA 1";
						} else 
						if($row0['idSala'] == 2){
							echo "SALA 2";
						} else 
						if($row0['idSala'] == 3){
							echo "SALA 3";
						} else 
						if($row0['idSala'] == 4){
							echo "SALA DE EXPULSIÓN";
						} else {
							echo "NADA";
						} ?>
					</td>
					<?php
						//Creamos 2 arreglos con los resultados del Query
						$cadenasIni = explode(",", $row0['hrIni']);
						$cadenasFin = explode(",", $row0['hrFinal']);
						
						//Unimos los 2 Arreglos
						$resultado = array_merge($cadenasIni, $cadenasFin);
												
						//Arreglo para mostrar las horas ocupadas
						$horas = array("<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td class='auto-styleRed'>", "<td class='auto-styleRed'> </td>",
						"<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>",
						"<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>"	, "<td class='auto-styleRed'> </td>",
					 	"<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>",
						"<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>",
						"<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>", "<td class='auto-styleRed'> </td>",
						"<td class='auto-styleRed'> </td>");
												
						//saco el numero de elementos
						$longitud = count($resultado);
						//Ordenamos el arreglo de menor a mayor
						//orden ascendente
						sort($resultado);
						
						//Recorremos todos los elementos
						for($i=0; $i<$longitud; $i++)
						{
							//Le quitamos los 0's a la izq de las horas antes de las 10
							$elemt =ltrim($resultado[$i], '0');
							if($i%2==0){
								if($i+1 < $longitud){
									$elemt1 =ltrim($resultado[$i+1], '0');
									for($x=$elemt; $x<=$elemt1; $x++)
									{
										$horas[$x] = "<td class='auto-style1'> X </td>";
									} #for de llenado de X
								 } #if longitud de arreglo
							 } #if del Residuo
						} #for principal
						
						foreach ($horas as $hr){
							echo $hr;
						}
					?>
				</tr>
			<?php } #se cierra While ?>
			</tbody>
			</table>

	<?php } #se cierra If principal ?>
		<br>
		<br>
		<a class="btn btn-danger" onclick="window.close();" style="width: 140px; height: 60px"> CERRAR </a>
	</div>
</body>

</html>
