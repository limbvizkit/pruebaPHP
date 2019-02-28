<?php
include_once('../fpdf/fpdf.php');
#Consultas POO
require_once('../conexion/funciones_db.php');

class PDF extends FPDF
{
    function Footer(){
		//if($idf == '1'){
			// Posición: a 1,5 cm del final
			$this->SetY(-15);
			// Arial italic 8
			$this->SetFont('Arial','I',8);
			$this->SetTextColor(255,255,255);
			$this->SetFillColor(160,210,250);
			/* Cell(ancho, alto, txt, border, ln, alineacion)
			 * ancho=0, extiende el ancho de celda hasta el margen de la derecha
			 * alto=10, altura de la celda a 10
			 * txt= Texto a ser impreso dentro de la celda
			 * border=T Pone margen en la posición Top (arriba) de la celda
			 * ln=0 Indica dónde sigue el texto después de llamada a Cell(), en este caso con 0, enseguida de nuestro texto
			 * alineación=C Texto alineado al centro
			 */
			//$this->Cell(0,10,utf8_decode('HOJA DE RESGUARDO DE BIENES'),'T',0,'C');
		$this->Cell(0,10,utf8_decode('www.henridunant.com.mx Río Pánuco No. 100, Col. Lomas de Los Volcanes C.P. 62350 Cuernavaca, Morelos Tels. 316-7992, 316-0486 y 322-2442'),'T',0,'C',true);
		//}
		/*if($idf == '2'){
			// Posición: a 1,5 cm del final
			$this->SetY(-5);
			$this->SetTextColor(255,255,255);
			$this->SetFillColor(160,210,250);
			// Arial italic 8
			$this->SetFont('Arial','I',8);*/
			/* Cell(ancho, alto, txt, border, ln, alineacion, formato)
			 * ancho=0, extiende el ancho de celda hasta el margen de la derecha
			 * alto=10, altura de la celda a 10
			 * txt= Texto a ser impreso dentro de la celda
			 * border=T Pone margen en la posición Top (arriba) de la celda
			 * ln=0 Indica dónde sigue el texto después de llamada a Cell(), en este caso con 0, enseguida de nuestro texto
			 * alineación=C Texto alineado al centro
			 * formato=true Toma el formato definido por FillColor (Color de fondo)BasicTable
			 */
			/*$this->Cell(0,10,utf8_decode('www.henridunant.com.mx Río Pánuco No. 100, Col. Lomas de Los Volcanes C.P. 62350 Cuernavaca, Morelos Tels. 316-7992, 316-0486 y 322-2442'),'T',0,'C',true);
		}*/
    }
 
    function Header(){
		//if($idh == '1'){
			//Define tipo de letra a usar, Arial, Negrita, 15
			$this->SetFont('Arial','B',12);

			/* Líneas paralelas
			 * Line(x1,y1,x2,y2)
			 * El origen es la esquina superior izquierda
			 * Cambien los parámetros y chequen las posiciones
			 * */
			$this->Line(40,8,206,8);
			$this->Line(40,30,206,30);

			/* Explicaré el primer Cell() (Los siguientes son similares)
			 * 30 : de ancho
			 * 25 : de alto
			 * ' ' : sin texto
			 * 0 : sin borde
			 * 0 : Lo siguiente en el código va a la derecha (en este caso la segunda celda)
			 * 'C' : Texto Centrado
			 * $this->Image('images/logo.png', 152,12, 19) Método para insertar imagen
			 *     'images/logo.png' : ruta de la imagen
			 *         152 : posición X (recordar que el origen es la esquina superior izquierda)
			 *         12 : posición Y
			 *     19 : Ancho de la imagen <span class="wp-smiley emoji emoji-wordpress" title="(w)">(w)</span>
			 *     Nota: Al no especificar el alto de la imagen (h), éste se calcula automáticamente
			 * */
			$this->Cell(30,25,'',0,0,'C',$this->Image('../img/logoNew2.jpg', 10,5,25));
			$this->Cell(180,5,'HOSPITAL HENRI DUNANT, A.C.',0,0,'C');
			$this->Ln(8);
			$this->Cell(230,5,'ACTA DE ALTA Y ENTREGA DE ACTIVOS FIJOS,',0,0,'C');
			$this->Ln();
			$this->Cell(230,5,'EQUIPO MENOR Y/O HERRAMIENTAS DE TRABAJO',0,0,'C');

			#$this->Cell(111,25,'HOSPITAL HENRI DUNANT, A.C. ACTA ALTA Y ENTREGA DE ACTIVOS FIJOS, EQUIPO MENOR Y/O HERRAMIENTAS DE TRABAJO',0,0,'C', $this->Image('../img/logoPeque.jpg',20,12,20));
			#$this->Cell(40,25,'',0,0,'C',$this->Image('../img/logoPeque.jpg', 175, 12, 19));
			//Se da un salto de línea de 18
			$this->Ln(18);
		//}
    }
	
	/* function Header(){		 
		//$this->SetXY(55,7);
		$this->Cell(0,7,' ANTECEDENTES PERSONALES: ',1 ,1 , 'C');
		//$this->Ln(10);
	 }*/
	
    
    function cabecera($cabecera){
        $this->SetXY(30,55);
        $this->SetFont('Arial','B',12);
        foreach($cabecera as $columna)
        {
            $this->Cell(85,7,$columna,1, 2 , 'L' );
        }
    }
    
    function datos($datos){
        $this->SetXY(115,55);
        $this->SetFont('Arial','',10);
        foreach ($datos as $columna)
        {
            $this->Cell(80,7,utf8_decode($columna),'TRB',2,'L' );
            #$this->Cell(65,7,utf8_decode($columna['ApellidoPat']),'TRB',2,'L' );
        }
    }
	
	function datosSimple($datos){
 
        $this->SetXY(55,7);
        $this->SetFont('Arial','',7);
        foreach ($datos as $columna)
        {
             $this->Cell(155,7,$columna,1, 2 , 'L' );
        }
    }
	
	function datosSimple2($datos){
 
        $this->SetXY(55,19);
		$this->SetFillColor(255,255,255);
        $this->SetFont('Arial','',9);
        foreach ($datos as $columna)
        {
             $this->MultiCell(150,7,$columna,1, 2, 'L' );
			 $this->SetX(55);
        }
    }
    
    //El método tabla integra a los métodos cabecera y datos
    function tabla($cabecera,$datos){
        $this->cabecera ($cabecera);
        $this->datos($datos);
    }
	
	//El método Simple integra a el método datos
    function tablaSimple($datos){
        $this->datosSimple($datos);
    }
	//El método Simple integra a el método datos simple
    function tablaSimple2($datos){
        $this->datosSimple2($datos);
    }
    
    // Una tabla más completa
	function otraTabla($cabecera, $datos)
	{
		$this->SetXY(10,105);
        $this->SetFont('Arial','B',9);

	    // Anchuras de las columnas
	    $w = array(15, 30, 50, 30, 25, 25, 20);
	    // Cabeceras
	    for($i=0;$i<count($cabecera);$i++)
	        $this->Cell($w[$i],7,$cabecera[$i],1,0,'C');
	    $this->Ln();
	    $this->Ln();
	    // Datos
	    $this->SetFont('Arial','',7);
	    #$img = $this->Image('../img/107.jpg', 190,113,9);
	    $x=186;
	    $y=113;
	    foreach($datos as $row)
	    {
	    	if($row['idImagen'] != NULL && $row['idImagen']!= ''){
	    		$img = $this->Image($row['idImagen'], $x,$y,20);
	    	} else {
	    		$img = '';
	    	}
		    $this->Cell($w[0],6,$row['cantidad'].' '.$row['unidad'],'LR');
   		    $this->Cell($w[1],6,$row['tipoActivo'],'LR');
   		    $this->Cell($w[2],6,$row['descActivo'],'LR');
 		    $this->Cell($w[3],6,$row['numSerie'],'LR');
 		   	$this->Cell($w[4],6,$row['marca'],'LR');
 		   	$this->Cell($w[5],6,$row['modelo'],'LR');
 		   	$this->Cell($w[6],6,$img,'LR');
	        #$this->Cell($w[0],6,$row[0],'LR');
	        #$this->Cell($w[1],6,$row[1],'LR');
	        #$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R');
	        #$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R');
	        $this->Ln();
	        $this->Ln();
	        $y=$y+15;
	    }
	    // Línea de cierre
	    $this->Cell(array_sum($w),0,'','T');
	}
	
	// Una tabla más completa
	function BasicTable($header, $data)
	{
		#Forma POO instanciamos y mandamos llamar un objeto de la instancia
		//$usuario1 = new FuncionesDB();
		
		// Anchuras de las columnas
		$w = array(5,15,78,12,12,8,23,78,11,7,7,8,8,12,10,7,7,28);
		// Cabeceras
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C');
		$this->Ln();
		// Datos
		$c=1;
		$res=1;
		$x=167;
		$y=24;
		for($r=0;$r<count($data);$r++){
			for($s=0;$s<count($data[0]);$s++){								
				
				$usuario1 = NULL;
				$usuario1 = new FuncionesDB();
				$nombre_pacT = NULL;				
				$res=$res++;
				
				$hora1G = new DateTime($data[$r]['hora']);
				$horaNew = $hora1G->format('H:i');
				$hora2G = new DateTime($data[$r]['horaFin']);
				$horaNew2 = $hora2G->format('H:i');
				if($s==0){
					$this->Cell($w[$s],7,$c++,1,0,'C');
					$s++;					
				}
				
				if($s == 2){
					$expediente=NULL;
					$folio=NULL;
					$expediente=$data[$r][1];
					$folio=$data[$r][2];
					
					#La funcion retorna un arreglo lo mandamos a una variable
					$resultado[] = $usuario1->consultaBasicos($expediente,$folio);
					#El arreglo esta vacio
					//if (!empty($resultado[0])){
						$nombre_pacT = utf8_decode($resultado[$r][0]['NOMBRE']);
						//$nombre_pacT1 = utf8_decode($resultado[1][0]['NOMBRE']);
					//}
					//$this->SetXY(10,25);
					$this->Cell($w[$s],7,$nombre_pacT,1,0,'C');
					$s++;
				}
				
				if($s == 3){
					//$this->SetXY(10,25);
					$this->Cell($w[$s],7,$horaNew.'h.',1,0,'C');
					$s++;
				}
				if($s == 4){
					//$this->SetXY(10,25);
					$this->Cell($w[$s],7,$horaNew2.'h.',1,0,'C');
					$s++;
				}
				if($s == 7){
					$cad=$data[$r][7];
					$cad=substr($cad,0,1).strtolower(substr($cad,1));
					if( strlen($cad) > 74 ){
						$this->Cell($w[$s],7,substr($cad,0,74),1,0,'C');
						$s++;
					} else {
						$this->Cell($w[$s],7,$cad,1,0,'C');
						$s++;
					}
				}
				if($s == 16){
					$cad=$data[$r][16];
					if($cad=='VERDE'){
						$this->Cell($w[$s],7,'V',1,0,'C');
						$s++;
					}
					if($cad=='ROJO'){
						$this->Cell($w[$s],7,'R',1,0,'C');
						$s++;
					}
					if($cad=='AMARILLO'){
						$this->Cell($w[$s],7,'A',1,0,'C');
						$s++;
					}
				}
				if($s <= 17){
					//$this->SetXY(10,25);
					$this->Cell($w[$s],7,$data[$r][$s],1,0,'C');
				}
				
			}
			$this->Ln();
		}
		
		/*foreach($data as $row)
		{
			for($r=0; $r<count($row); $r++){
				$this->Cell($w[$r],7,$row[0][5],1,0,'C');
				//$this->Cell($w[1],7,$row[0][1],1,0,'C');
				//$this->Cell($w[2],7,$row[0][2],1,0,'C');
			}
			$this->Ln();*/
			/*$this->Cell($w[0],7,$row[0],1,0,'LR');
			$this->Cell($w[1],7,$row[1],1,0,'LR');
			$this->Cell($w[2],7,$row[2],1,0,'LR');
			$this->Cell($w[3],7,$row[3],1,0,'LR');
			$this->Cell($w[4],7,$row[4],1,0,'LR');
			$this->Cell($w[5],7,$row[5],1,0,'LR');
			$this->Cell($w[6],7,$row[6],1,0,'LR');
			$this->Ln();*/
		//}
		// Línea de cierre
		$this->Cell(array_sum($w),0,'','T');
	}
	
	//Tabla con Saltos de linea
	var $widths;
	var $aligns;

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths=$w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns=$a;
	}

	function Row($data)
	{
		//Calculate the height of the row
		$nb=0;
		for($i=0;$i<count($data);$i++)
			$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=5*$nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			//Save the current position
			$x=$this->GetX();
			$y=$this->GetY();
			//Draw the border
			$this->Rect($x,$y,$w,$h);
			//Print the text
			$this->MultiCell($w,5,$data[$i],0,$a);
			//Put the position to the right of the cell
			$this->SetXY($x+$w,$y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if($this->GetY()+$h>$this->PageBreakTrigger)
			//$this->AddPage($this->CurOrientation);
			$this->AddPage('P', 'Letter');
	}

	function NbLines($w,$txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
			$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
			$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
				$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
						$i++;
				}
				else
					$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
				$i++;
		}
		return $nl;
	}
	
}

?>
