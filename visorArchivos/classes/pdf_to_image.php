<?php

class pdf2image{
	#Funcion para convertir un PDF a PNG
	public function convert_pdf_to_image($pdf_file, $page_number, $destination_file, $areas, $serie, $subSerie, $tipoDocsInt, $nombreDoc, $caracterDocs,$ao, $at, $ac, $t, $l, $f, $c, $a, $dispDoc, $r, $c1, $plazo, $permisosFin, $conexion){
		$directory = $_SERVER['DOCUMENT_ROOT']; #Raiz de directorio actual(c:/xampp/htdocs)
		$source_path = $directory.'/conectaSQLSRV/visorArchivos/input/'.$pdf_file; #Concatena Raiz con la dirección del archivo PDF que se subio
		$destination_path = $directory.'/conectaSQLSRV/visorArchivos/output/'.$destination_file; #Concatena Raiz con la direccion destino del archivo de salida PNG 
		
		$tipoDocsInt=utf8_decode($tipoDocsInt);
		$nombreDoc=utf8_decode($nombreDoc);
		$caracterDocs = utf8_decode($caracterDocs);
		$dispDoc = utf8_decode($dispDoc);
		
		#Verificamos que la carpeta donde esta el PDF no esta vacia
		$stream = fopen($source_path, "r");
		#Verificamos que se puede leer el archivo PDF desde su carpeta origen
		$content = fread ($stream, filesize($source_path));
	 	
		if(!$stream || !$content)
			echo "!!!ERROR STREAM O CONTENT!!!";

		$count = 0;
	 	#Expresiones regulares para sacar el numero de hojas del PDF
		$regex  = "/\/Count\s+(\d+)/";
		$regex2 = "/\/Page\W*(\d+)/";
		$regex3 = "/\/N\s+(\d+)/";
	 
		if(preg_match_all($regex, $content, $matches))
			$count = max($matches);
		
	 	#echo '<br/>&nbsp;&nbsp;<input type="button" value="CERRAR" onclick="window.close();" height="75" width="161"></input><br/>';
		echo ' PAGINAS: '.$count[0].'<br/>';


		// checamos cual SO
		if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
			#El archivo PDF tiene mas de 1 pagina
			if((int)$page_number == 1000){
				for ($i=0; $i <= $count[0]; $i++) {
					#Como son varias paginas a cada 1 le pondremos el mismo nombre con un _Num de archivo 
					$rutaArchivo = str_replace('.png', '_'.$i.'.png', $destination_path);
					$archivoGuardar = str_replace('.png', '_'.$i.'.png', $destination_file);
					$command = $directory.'/conectaSQLSRV/visorArchivos/gs/win/bin/gswin32.exe -q -sDEVICE=pngalpha -dBATCH -dNOPAUSE -dFirstPage='.$i.' -dLastPage='.($i+1).' -r150x150 -sOutputFile='.$rutaArchivo.' '.$source_path;
					#exec($command,$retArr, $retVal);
					pclose(popen("start $command","r"));
					if($i > 0){
						$nombreDocFin = $nombreDoc.'_'.$i;
						#Guardamos el archivo recien creado en la BD
						$queryAddArchivo = "INSERT INTO datosdocumentos (idDocumento, areaDepto, serie, subSerie, tipoDocsIntegran, nombreDocumento, caracterDoc, ao, at, ac, t, l, f, c, a, disposicionDoc, r, c1, plazo, rutaArchivo, estatus, fechaAlta, permisos) 
									VALUES (NULL, '$areas', '$serie', '$subSerie', '$tipoDocsInt', '$nombreDoc', '$caracterDocs','$ao', '$at', '$ac', '$t', '$l', '$f', '$c', '$a', '$dispDoc', '$r', '$c1', '$plazo', 'output/$archivoGuardar', '1',NULL, '$permisosFin')";
						$result0 = mysqli_query($conexion, $queryAddArchivo);
						if(!$result0){
							echo'<span class="auto-style1">!!! ERROR AL REALIZAR INSERCIÓN DEL DOCUMENTO PROTEGIDO NUMERICO!!!
									<br/> Revisar el guardado en la BD y en el listado de archivos</span>';
							echo '<br/>Query Add: '.$queryAddArchivo;
							echo'<br/><input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
							exit;
						}
					} #else {
						#echo '<br/><span class="auto-style3"><strong>!!!! SE GUARDO EL DOCUMENTO PROTEGIDO NUMERICO CORRECTAMENTE !!!!</strong></span><br>';
						#echo '<br/>Query Add: '.$queryAddArchivo;
						#echo'<br/><input name="cerrar" type="button" class="btn btn-info btn-lg btn-danger" onclick="window.close();" value="CERRAR" style="width: 137px; height: 44px" >';
						#exit;
					#}
				}
				/*if(empty($retVal)){
					return 'Success';
				} else {
					return '<br> Ocurrio error mientras se convertia el archivo utilizando el siguiente comando. <br>'.$command;
				}*/
			} else { #El archivo pdf solo tiene 1 pagina o solo se convertira la pagina seleccionada a PNG
				$command = $directory.'/conectaSQLSRV/visorArchivos/gs/win/bin/gswin32.exe -q -sDEVICE=pngalpha -dBATCH -dNOPAUSE -dFirstPage='.(int)$page_number.' -dLastPage='.(int)($page_number+1).' -r150x150 -sOutputFile='.$destination_path.' '.$source_path;
				exec($command, $retArr, $retVal);
				
				if(empty($retVal)){
					return 'Success';
				} else{
					return '<br> Ocurrio error mientras se convertia el archivo utilizando el siguiente comando. <br>'.$command;
				}
			}
		} else {
			#Si se ejecuta el programa en Linux (Nunca va pasar por q el servidor es Win pero ahi q se quede :3)
			$command = 'gs -q -sDEVICE=pngalpha -dBATCH -dNOPAUSE -dFirstPage='.(int)$page_number.' -dLastPage='.(int)($page_number+1).' -r150x150 -sOutputFile='.$destination_path.' '.$source_path;
			exec($command, $retArr, $retVal);
		}
		echo $command; #Descomentar si se quiere ver el comando Ejecutado sobre la imagen del PDF
	}

	// Obetenemos la ruta del directorio actual
	public function get_directory_path(){
		$current_folder = realpath(dirname(__FILE__));
		$current_folder = str_replace('\\classes', '/', $current_folder);
		$current_folder = str_replace('/classes', '/', $current_folder);
		return $current_folder;
	}

	#Funcion para eliminar caracteres extraños de una cadena
	public function scanear_string($string)
	{
 
    $string = trim($string);
 
 	$string = str_replace(' ', '_', $string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
 
    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
 
    //Esta parte se encarga de reemplazar cualquier caracter extraño por ''
    $string = str_replace(
        array("\\", "¨", "º", "-", "~",
             "#", "@", "|", "!", "\"",
             "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             " "),
        '',
        $string
    );
 
 
    return $string;
	}
}
?>