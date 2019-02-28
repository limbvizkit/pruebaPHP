<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Jose Aguilar - jQuery Ajax Autocomplete</title>
<style>
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
	width:346px;
	height:155px;
	overflow: auto;
}

#suggestions .item{
    float: left;
    width: 319px;
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
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript">

$(document).ready(function() {	

	//Al escribr dentro del input con id="service"

	$('#service').keypress(function(){

		//Obtenemos el value del input

		var service = $(this).val();		

		var dataString = 'service='+service;
		
		//$('#result').remove();

		

		//Le pasamos el valor del input al ajax

		$.ajax({

            type: "POST",

            url: "autocomplete.php",

            data: dataString,

            success: function(data) {

				//Escribimos las sugerencias que nos manda la consulta

				$('#suggestions').fadeIn(1000).html(data);

				//Al hacer click en algua de las sugerencias

				$('.suggest-element').live('click', function(){

					//Obtenemos la id unica de la sugerencia pulsada

					var id = $(this).attr('id');

					//Editamos el valor del input con data de la sugerencia pulsada

					$('#service').val($('#'+id).attr('data'));

					//Hacemos desaparecer el resto de sugerencias

					$('#suggestions').fadeOut(1000);
					
					$('#result').html('<p>Has seleccionado el '+id+' '+$('#'+id).attr('data')+'</p>');
					
				});              

            }

        });

    });              

});    

</script>
</head>
<body>
<div id="result"></div>
<form>
  <input type="text" size="50" id="service" name="service" accept-charset="utf-8" />
  <div id="suggestions"></div>
</form>
</body>
</html>
