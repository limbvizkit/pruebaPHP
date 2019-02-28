<?php
  	header('Content-Type: text/html;charset=utf-8');
	$expediente = $_POST['expediente'];
	$folio = $_POST['folio'];

	require_once('funciones_db.php');
	
    $usuario1 = new FuncionesDB();
    $resultado[] = $usuario1->consulta2($expediente,$folio);

    if (empty($resultado[0])) {
    	echo '<!DOCTYPE html> <html> <body>  No exisen datos para el numero colocado <br><br>';
    	echo '<a href="javascript:history.back()">REGRESAR</a> </body></html>';
    	exit();
    } else {
	    $nombre_pac = $resultado[0][0]['NOMBRE'];
	    $expediente_pac = $resultado[0][0]['NO_EXP_PAC'];
	    $edad_pac = $resultado[0][0]['EDAD_PAC'];
   	    $sexo_pac = $resultado[0][0]['SEXO_PAC'];
   	    $diag_ingreso_pac = $resultado[0][0]['MOTIV_ING_PAC'];

	    $date = $resultado[0][0]['FEC_ING_PAC']; //HR_ING_PAC
	    $dia_ing_pac = $date->format(' d ');
	    $mes_ing_pac = $date->format(' m ');
	    $anio_ing_pac = $date->format(' Y ');

	    $date1 = $resultado[0][0]['FEC_SAL_REG05'];
	    $dia_sal_pac = $date1->format(' d ');
	    $mes_sal_pac = $date1->format(' m ');
	    $anio_sal_pac = $date1->format(' Y ');
	    
	    $date2 = $resultado[0][0]['NACIO_PA'];
	    $dia_nac_pac = $date2->format(' d ');
	    $mes_nac_pac = $date2->format(' m ');
	    $anio_nac_pac = $date2->format(' Y ');
	}
	
	$medicinas[] = $usuario1->medicamento();
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="es-mx" http-equiv="Content-Language" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>FORMATO CONCILIACION</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
  <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
<style type="text/css">
.auto-style1 {
	border-style: solid;
	border-width: 1px;
}
.auto-style3 {
	font-size: small;
	font-family: "Times New Roman", Times, serif;
	border: 1px solid #000000;
	background-color: #6600FF;
}
.auto-style8 {
	font-family: "Times New Roman", Times, serif;
	border: 1px solid #000000;
}
.auto-style9 {
	border: 1px solid #000000;
}
.auto-style10 {
	font-family: "Times New Roman", Times, serif;
	font-size: x-small;
}
.auto-style12 {
	font-size: xx-small;
	font-family: "Times New Roman", Times, serif;
}
.auto-style13 {
	font-size: xx-small;
	font-family: "Times New Roman", Times, serif;
	text-align: center;
	border: 1px solid #000000;
}
.auto-style14 {
	font-size: xx-small;
	font-family: "Times New Roman", Times, serif;
	border: 1px solid #000000;
}
.auto-style15 {
	border-width: 0;
	text-align: center;
	font-family: "Times New Roman", Times, serif;
	font-size: large;
}
.auto-style16 {
	font-family: "Times New Roman", Times, serif;
	font-size: medium;
}
.auto-style17 {
	font-size: small;
	font-family: "Times New Roman", Times, serif;
	border: 1px solid #000000;
}
.auto-style18 {
	font-size: small;
	font-family: "Times New Roman", Times, serif;
}
.auto-style19 {
	font-size: small;
	font-family: "Times New Roman", Times, serif;
	text-align: center;
	border: 1px solid #000000;
}
.auto-style20 {
	border: 1px solid #000000;
	font-size: small;
}
.auto-style21 {
	text-decoration: underline;
}
</style>
</head>

<body>

<table class="auto-style1" style="width: 113%; float: left;" align="center">
	<tr>
		<td rowspan="2" style="width: 115px"><img src="img3.jpg" /></td>
		<td class="auto-style15" colspan="7"><strong>DEPARTAMENTO DE FARMACIA CLÍNICA</strong></td>
	</tr>
	<tr>
		<td class="auto-style15" colspan="4"><strong>CONCILIACIÓN DE MEDICAMENTOS</strong></td>
		<td class="auto-style8" colspan="3"><strong>Hab:&nbsp;&nbsp; </strong></td>
	</tr>
	<tr>
		<td class="auto-style9" colspan="4">
		<img class="auto-style10" height="22" src="img5.gif" width="24" />
		<span class="auto-style16"><strong>DATOS GENERALES DEL PACIENTE</strong></span></td>
		<td class="auto-style9" colspan="4">
		<img alt="" class="auto-style10" height="24" src="img7.gif" width="27" />
		<span class="auto-style18"><strong>FECHAS Y TURNO DE REGISTRO</strong></span></td>
	</tr>
	<tr>
		<td class="auto-style17" colspan="4"><strong>NOMBRE DEL PACIENTE: &nbsp; </strong><?php echo '   '.$nombre_pac ?> </td>
		<td class="auto-style17" style="width: 106px"><strong>No. Exp: 
			<?php echo $expediente_pac ?></strong></td>
		<td class="auto-style3" style="width: 23px"><strong>DÍA</strong></td>
		<td class="auto-style3" style="width: 25px"><strong>MES</strong></td>
		<td class="auto-style3" style="width: 40px"><strong>AÑO</strong></td>
	</tr>
	<tr>
		<td class="auto-style17" style="width: 115px"><strong>EDAD: &nbsp; </strong><?php echo '   '.$edad_pac?> </td>
		<td class="auto-style17" style="width: 43px"><strong>SEXO:</strong></td>
		<td class="auto-style17" style="width: 16px"><?php echo $sexo_pac?></td>
		<td class="auto-style17"><strong>ENFERMEDADES CONCOMITANTES:</strong></td>
		<td class="auto-style17" style="width: 106px"><strong>FECHA DE INGRESO:</strong></td>
		<td class="auto-style8" style="width: 23px">
			<?php echo $dia_ing_pac ?>
		</td>
		<td class="auto-style8" style="width: 25px">
			<?php echo $mes_ing_pac ?>
		</td>
		<td class="auto-style8" style="width: 40px">
			<?php echo $anio_ing_pac ?>
		</td>
	</tr>
	<tr>
		<td class="auto-style17" colspan="4"><strong>DIAGNÓSTICO DE INGRESO: &nbsp;&nbsp; </strong><?php echo $diag_ingreso_pac?> </td>
		<td class="auto-style17" style="width: 106px"><strong>FECHA DE EGRESO:</strong></td>
		<td class="auto-style8" style="width: 23px">
			<?php echo $dia_sal_pac ?>
		</td>
		<td class="auto-style8" style="width: 25px">
			<?php echo $mes_sal_pac ?>
		</td>
		<td class="auto-style8" style="width: 40px">
			<?php echo $anio_sal_pac ?>
		</td>
	</tr>
	<tr>
		<td class="auto-style17" colspan="4"><strong>ALERGIAS (MEDICAMENTOS Y/O 
		ALIMENTOS), OTROS:&nbsp;&nbsp; </strong></td>
		<td class="auto-style17" style="width: 106px"><strong>FECHA DE NAC:</strong></td>
		<td class="auto-style8" style="width: 23px">
			<?php echo $dia_nac_pac ?>
		</td>
		<td class="auto-style8" style="width: 25px">
			<?php echo $mes_nac_pac ?>
		</td>
		<td class="auto-style8" style="width: 40px">
			<?php echo $anio_nac_pac ?>
		</td>
	</tr>
</table>
<table class="auto-style1" style="width: 100%; float: left;" align="center">
	<tr>
		<td class="auto-style9" colspan="7">
		<img alt="" class="auto-style12" height="26" src="img9.gif" width="31" />
		<span class="auto-style18"><strong>INGRESO HOSPITALARIO ( HISTORIA FARMACOLÓGICA)</strong></span></td>
		<td class="auto-style19" rowspan="3"><strong>MEDICAMENTOS<br />
		QUE TRAE<br />
		EL PACIENTE</strong></td>
		<td class="auto-style20" colspan="3"><span class="auto-style18"><strong>
		URGENCIAS ( ) </strong></span><strong><br class="auto-style18" />
		</strong><span class="auto-style18"><strong>TOCOCIRUGIA ( )</strong></span></td>
		<td class="auto-style19" colspan="6">
		<img alt="" height="25" src="imgB.gif" width="23" /> <strong>TRANSICIÓN 
		HOSPITALARIA<br />
&nbsp;Y/O CAMBIO DE MÉDICO</strong></td>
		<td class="auto-style19" colspan="3">
		<img alt="" height="25" src="imgD.gif" width="25" /> <strong>EGRESO
		<br />
		HOSPITALARIO</strong></td>
	</tr>
	<tr>
		<td class="auto-style13" rowspan="2"><strong>No</strong></td>
		<td class="auto-style13" rowspan="2"><strong>MEDICAMENTO</strong></td>
		<td class="auto-style13" rowspan="2"><strong>DOSIS</strong></td>
		<td class="auto-style13" rowspan="2"><strong>VÍA <br />
		DE <br />
		ADMON</strong></td>
		<td class="auto-style13" rowspan="2"><strong>FRECUENCIA</strong></td>
		<td class="auto-style13" rowspan="2"><strong>ULTIMA HORA<br />
		DE<br />
		CONSUMO</strong></td>
		<td class="auto-style13" rowspan="2" style="width: 152px"><strong>MOTIVO <br />
		DE<br />
		CONSUMO</strong></td>
		<td class="auto-style13" colspan="3"><strong>RECOMENDACIÓN</strong></td>
		<td class="auto-style13" colspan="3"><strong>CAMBIO DE <br />
		SERVICO <br />
		Y/O MÉDICO</strong></td>
		<td class="auto-style13" colspan="3"><strong>RECOMENDACIÓN</strong></td>
		<td class="auto-style13" colspan="3"><strong>RECOMENDACIÓN</strong></td>
	</tr>
	<tr>
		<td class="auto-style13" style="width: 6px"><strong>C</strong></td>
		<td class="auto-style13"><strong>DC</strong></td>
		<td class="auto-style13"><strong>IT</strong></td>
		<td class="auto-style13"><strong>H</strong></td>
		<td class="auto-style13"><strong>UCI</strong></td>
		<td class="auto-style13"><strong>M</strong></td>
		<td class="auto-style13"><strong>C</strong></td>
		<td class="auto-style13"><strong>DC</strong></td>
		<td class="auto-style13"><strong>IT</strong></td>
		<td class="auto-style13"><strong>C</strong></td>
		<td class="auto-style13"><strong>DC</strong></td>
		<td class="auto-style13"><strong>IT</strong></td>
	</tr>
	<tr>
		<td class="auto-style14">&nbsp;</td>
		<td class="auto-style14">
		<?php 
		/*foreach($medicinas as $valor) {
				//echo 'Nombre: ' . $valor[DESC_PROD] . '<br />';
				print_r($valor);
          	}   */
          	#$nombre_prod = $medicinas [0][0]['CVE_PROD'];
          	#$desc_prod = $medicinas [0][0]['DESC_PROD'];
          	//echo count($medicinas[0]).'   ';
          	//echo $medicinas [0][0]['CVE_PROD'].' '.$medicinas [0][0]['DESC_PROD'];
          	
          	/*for($i=0;$i<count($medicinas );$i++) {
				for($j=0;$j<count($medicinas [$i]);$j++) {
					echo $medicinas [$i][$j]['DESC_PROD'].'<br />';
				}
			}*/
          	  
		?>
		<select class="auto-style21">
        <option value="0">Seleccióne Medicamento:</option>
        <?php 
        for($i=0;$i<count($medicinas );$i++) {
				for($j=0;$j<count($medicinas [$i]);$j++) {
					echo '<option value ="'.$medicinas [$i][$j]['CVE_PROD'].'">'.$medicinas [$i][$j]['DESC_PROD'].'</option>';
				}
			}
			/*echo '<option value="1"> ABILIFY </option>';
			echo '<option value="2"> ACETENSIL </option>';
			echo '<option value="3"> ÁCIDO ALENDRÓNICO TEVA </option>';
			echo '<option value="4"> BACTROBAN</option>';
			echo '<option value="5"> BELUSTINE</option>';
			echo '<option value="6"> NAPROXENO SÓDICO </option>';*/	
        ?>
      </select>
      
		</td>
		<form method="post">
		<td class="auto-style14">		
			<input name="Text1" style="width: 66px" type="text">
		</td>
		<td class="auto-style14">
			<input name="Text2" style="width: 66px" type="text">
		</td>
		<td class="auto-style14">
			<input name="Text3" style="width: 104px" type="text">
		</td>
		<td class="auto-style14">
			<input name="Text4" style="width: 66px" type="text">
		</td>
		<td class="auto-style14" style="width: 152px">
			<input name="Text5" style="width: 196px" type="text">
		</td>
		<td class="auto-style14">
			<input name="Text6" style="width: 160px" type="text">
		</td>
		<td class="auto-style14" style="width: 6px">
			<input name="chk1" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk2" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk3" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk4" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk5" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk6" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk7" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk8" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="chk9" style="width: 21px" type=checkbox align="middle">
		</td>
		<td class="auto-style14">
			<input name="radio1" style="width: 21px" type=radio align="middle">
		</td>
		<td class="auto-style14">
			<input name="radio1" style="width: 21px" type=radio align="middle">
		</td>
		<td class="auto-style14">
			<input name="radio1" style="width: 21px" type=radio align="middle">
		</td>
		</form>
	</tr>
</table>

</body>

</html>
