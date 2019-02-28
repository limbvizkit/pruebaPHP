<?php
//Comenzamos con PHP para recibir por POST 2 variables
  	header('Content-Type: text/html;charset=utf-8');
  	require_once('conexion/funciones_db.php');
	
	$expediente = $_GET['expediente'];
	$folio = $_GET['folio'];
	$nomPac = $_GET['nomPac'];
	
    $usuario1 = new FuncionesDB();
    
    #$medicinas[] = $usuario1->medicamento();

?>
 
<!DOCTYPE html> 
<html>
<head>
  <meta charset="UTF-8" name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
  <title>Captura Medicamentos</title>
  <link rel="stylesheet" href="css/Prueba1.min.css" >
  <link rel="stylesheet" href="css/jquery.mobile.icons.min.css" >
  <link rel="stylesheet" href="css/jquery.mobile.structure-1.4.5.min.css" >
  <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.mobile-1.4.5.min.js"></script>
  <!--link rel="stylesheet" href="css/jquery.mobile-1.4.4.min.css" >
  <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
  <script type="text/javascript" src="js/jquery.mobile-1.4.4.min.js"></script-->
  <!--link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css">
	<script  src="http://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous">
  </script>
  <script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script-->
<style type="text/css">
  .auto-style1 {
	  font-size: large;
  }
  .auto-style2 {
	  color: #808080;
  }
	/*button[type=submit], button[type=button] {
	 -webkit-appearance: none; -moz-appearance: none;
	 display: block;
	 margin: 1.5em 0;
	 font-size: 1em;
	 line-height: 2.5em;
	 color: #333;
	 font-weight: bold;
	 height: 2.5em; width: 100%;
	 background: #fdfdfd; background: -moz-linear-gradient(top, #fdfdfd 0%, #bebebe 100%);
	 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fdfdfd), color-stop(100%,#bebebe)); 
	 background: -webkit-linear-gradient(top, #fdfdfd 0%,#bebebe 100%);
	 background: -o-linear-gradient(top, #fdfdfd 0%,#bebebe 100%);
	 background: -ms-linear-gradient(top, #fdfdfd 0%,#bebebe 100%);
	 background: linear-gradient(to bottom, #fdfdfd 0%,#bebebe 100%);
	 border: 1px solid #bbb;
	 -webkit-border-radius: 10px; 
	 -moz-border-radius: 10px; 
	 border-radius: 10px;
	}*/
   .auto-style3 {
	   text-align: left;
   }
   .auto-style4 {
	   font-family: serif;
	   font-size: small;
	   color: #808080;
	   line-height: 100%;
   }
   .auto-style5 {
	   text-align: center;
   }
   .suggest-element {
	width:100%;
	cursor:pointer;
	background-color: #ECECEC;
    margin-top: 1px;
    padding-bottom: 5px;
    padding: 5px;
	float:left;
	}

	.suggest-element:hover {
		background-color:#999999;
		color:#FFFFFF;
	}

	#suggestions {
		width:425px;
		height:165px;
		overflow: auto;
	}
	
	#suggestions .item{
	    float: left;
	    width: 396px;
	}
	
	#result {
		background-color: #EDEDED;
	    clear: both;
	    color: #999999;
	    margin-bottom: 10px;
	    padding: 5px;
	    width: 500px;
	}
   </style>
</head>
<body> 
<script type="text/javascript">
	/*if((navigator.userAgent.match(/MSIE/i)) || (navigator.userAgent.match(/Chrome/i)) || (navigator.userAgent.match(/Firefox/i))) {
		document.write('<style type="text/css" media="screen">#header{font-family:Verdana;font-size:16px;width:90%;}</style>');	
	}*/
	function mostrar(){
		document.getElementById('interacciones').style="display:block;";
	}
	function ocultar(){
		document.getElementById('interacciones').style="display:none;";
	}
	//Mostrar recuadro si se selecc OTROS en Medicamentos
	function verOtro(e){
  		var valr = e.tipoMed.options[e.tipoMed.selectedIndex].value;
  		if( valr == "7") {
			document.getElementById("otro").type='text';
		}else{
			document.getElementById("otro").type='hidden';
		}
	}
	//Mostrar otro recuadro si se selecc OTROS en Frecuencia
	function verOtroFrec(f){
  		var valf = f.frecuencia.options[f.frecuencia.selectedIndex].value;
  		if( valf == "7") {
			document.getElementById("otroFrec").type='text';
		}else{
			document.getElementById("otroFrec").type='hidden';
		}
  }
  //Mostrar otro recuadro si se selecc OTROS en Vía de Admon
	function verOtroVia(f){
  		var valv = f.via.options[f.via.selectedIndex].value;
  		if( valv == "9") {
			document.getElementById("otroVia").type='text';
		}else{
			document.getElementById("otroVia").type='hidden';
		}
  }

  var id = "";
  $(document).ready(function(e) {
	//Al escribr dentro del input con id="service"
	//$('#service').keypress(function(){
	//$('#service').on('keydown', (function(){
	//$('#service').keydown(function(){
	//$('#service').keyup(function(){
	$('#service').bind('input keyup', function(){
		//Obtenemos el value del input
		var service = $(this).val();
		var dataString0 = 'service='+service;
		var n = dataString0.length;
		if(n > 11){
			var dataString = dataString0;
		} else {
			var dataString = 'service=" "';
		}
		//Le pasamos el valor del input al ajax
		$.ajax({
            type: "POST",
            url: "autocomplete.php",
            data: dataString,
            //Esta linea segun es para q ya funcione bien en la Tablet, hacer pruebas!!!!!!! OTRA opción es eliminar la linea anterior de tipo de dato. Probar tambien
            //async: false,
            success: function(data) {
				//A ver si acepta style
				$('#suggestions').height(180);
				
				//Escribimos las sugerencias que nos manda la consulta
				$('#suggestions').fadeIn(1000).html(data);
				//Al hacer click en alguna de las sugerencias
				$('.suggest-element').live('click', function(){
					//Obtenemos la id unica de la sugerencia pulsada
					id = $(this).attr('id'); //id del Medicamento
					var valor = $(this).attr('data'); //Nombre del Medicamento
					var sal = $(this).attr('sal'); //Nombre de la Sal
					var idSal = $(this).attr('idSal');//id de la Sal
					//Editamos el valor del input con data de la sugerencia pulsada
					//$('#service').val($('#'+id).attr('data'));
					$('#service').val(valor);
					//Hacemos desaparecer el resto de sugerencias
					$('#suggestions').fadeOut(1000);
					//$('#result').html('<p>Has seleccionado el '+id+' '+$('#'+id).attr('data')+'</p>');
					//Add valor del id del elemento seleccionado
					$('#idMed').val(id);
					$('#sal').val(sal);
					$('#idSal').val(idSal);
				});
            }
        });
    });
});

</script>

<script type="text/javascript" src="js/jquery.js"></script>

<p align="center" >
<strong><span class="auto-style1">Captura de Medicamentos: <?php echo $expediente; ?> <?php echo ' '.urldecode($nomPac); ?> </span></strong>
</p>
<hr class="auto-style2" style="height: 5">
<form method="post" action="guardaMedicamento.php" autocomplete="off">
	<div class="auto-style3">
	&nbsp;&nbsp; <strong>TIPO DE MEDICAMENTO:</strong>
	<select name="tipoMed" id="tipoMed" onchange="verOtro(this.form)" style="background-color:#C6E2FF" required>
        <option value="">Tipo Medicamento</option>
        <option value="1"> ANTIBIÓTICO </option>
		<option value="2"> ANALGÉSICO </option>
		<option value="3"> ANTIÁCIDO </option>
		<option value="4"> ANTIEMÉTICO </option>
		<option value="5"> ANESTÉSICO </option>
		<option value="6"> ANTIESPASMÓDICO </option>
		<option value="7"> OTROS </option>
	</select>
	<br>
	<input id="otro" type="hidden" name="otro" style="width: 600px; height: 35px; background-color:#C6E2FF" >
	<br>
	<br>
	&nbsp; <strong>FECHA DE INICIO:</strong>&nbsp;<input type="date" name="fechaIni" style="background-color:#C6E2FF" required>&nbsp;&nbsp;&nbsp; 
		<strong>MEDICAMENTO:</strong>&nbsp;
		<!--div id="result"></div-->
		<input type="text" size="80" id="service" name="medicamento" style="background-color:#C6E2FF" accept-charset="utf-8">
		<input type="hidden" size="10" id="idMed" name="idMed" accept-charset="utf-8" >
		<input id="sal" name="sal" type="hidden" accept-charset="utf-8" >
		<input id="idSal" name="idSal" type="hidden" >

		<div id="suggestions"></div>
		<br>
		<br>
		&nbsp; <strong>DOSIS:</strong> &nbsp;<input type="text" name="dosis" style="background-color:#C6E2FF" required>
		<br>
		<br>
		<strong>&nbsp;&nbsp;VÍA DE ADMON</strong>
		<select name="viadmon"  id="via" onchange="verOtroVia(this.form)" required>
       		<option value="">Seleccione:</option>
			<option value="1"> IV </option>
			<option value="2"> VO </option>
			<option value="3"> IM </option>
			<option value="4"> SL </option>
			<option value="5"> SUBARACNOIDEA </option>
			<option value="6"> NASAL </option>
			<option value="7"> RECTAL </option>
			<option value="8"> VAGINAL </option>
			<option value="9"> OTRA </option>
		</select>
		<br>
		<input id="otroVia" type="hidden" name="otroVia" style="width: 600px; height: 35px; background-color:#C6E2FF" >
		<br>
		<br>
		<strong>&nbsp;FRECUENCIA:</strong>&nbsp;
		<!--input type="text" name="frecuencia" required>&nbsp;-->
		<select name="frecuencia" id="frecuenca" onchange="verOtroFrec(this.form)" required>
       		<option value="">Seleccione:</option>
			<option value="1"> 4h </option>
			<option value="2"> 6h </option>
			<option value="3"> 8h </option>
			<option value="4"> 12h </option>
			<option value="5"> 24h </option>
			<option value="6"> DU </option>
			<option value="7"> OTRA </option>
		</select>
		<br>
		<input id="otroFrec" type="hidden" name="otroFrec" style="width: 600px; height: 35px; background-color:#C6E2FF" >
		<br>
		<br>
		<!--&nbsp; <strong>DÍA DE CONSUMO:</strong>&nbsp;<input type="date" name="dia" >
		&nbsp; <strong>ULTIMA HORA DE CONSUMO:</strong>&nbsp; 
		<input type="time" name="hrConsumo" >
		<br>
		<br-->
		<input name="expediente" type="hidden" value="<?php echo $expediente ?>" >
		<input name="folio" type="hidden" value="<?php echo $folio ?>" >
		<input name="nomPac" type="hidden" value="<?php echo $nomPac ?>" >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type="Submit" name="enviarMedicamento" style="background-color:lime" value="GUARDAR">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="cerrar" type="button" onclick="window.close();" style="background-color:red" value="SALIR"> 
	</div>
	</form>
</body>
</html>