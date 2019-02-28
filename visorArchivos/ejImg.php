<?php
header("Content-type: image/png");  

$img1 = "./output/LASA2017.png";
$img2 = "./output/GUION_SIMULACRO_FUGA_DE_GAS_LP_1.png";

// Creamos las dos imágenes a utilizar  
$imagen1 = imagecreatefrompng($img1);
$imagen2 = imagecreatefrompng($img2);
// Creamos imagen destino
$imagen3 = imagecreatetruecolor(1250, 4100);
// Dibujamos un rectangulo lleno de color verde, 
// que sera nuestro color transparente
imagecolortransparent($imagen3, 0x00FF00); 
imagefilledrectangle($imagen3, 0, 0, 1250, 4100, 0x00FF00);
// Copiamos una de las imágenes sobre la otra  
imagecopy($imagen3,$imagen1,0,0,0,0,1250,2000);
imagecopy($imagen3,$imagen2,0,2010,0,0,1250,2000);  

// Damos salida a la imagen final  
imagepng($imagen3);

// Destruimos ambas imágenes  
imagedestroy($imagen1);
imagedestroy($imagen2);
imagedestroy($imagen3);

?>
