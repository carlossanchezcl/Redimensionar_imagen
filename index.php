<?php
function copyTransparent($destination, $imagen)
{
//Dimensiones nvas de imagen
$max_ancho = 450; $max_alto = 179; 
$dimensions = getimagesize($destination);
//list($ancho,$alto) =getimagesize ($rtOriginal);
$ancho = $dimensions[0];
$alto = $dimensions[1];

$x_ratio = $max_ancho / $ancho; $y_ratio = $max_alto / $alto; 
if( ($ancho <= $max_ancho) && ($alto <= $max_alto) ){ 
$ancho_final = $ancho;  $alto_final = $alto; } 
elseif (($x_ratio * $alto) < $max_alto){    $alto_final = ceil($x_ratio * $alto);   $ancho_final = $max_ancho; } 
else{   $ancho_final = ceil($y_ratio * $ancho);     $alto_final = $max_alto; }

$im = imagecreatetruecolor($ancho_final,$alto_final);
$src_ = imagecreatefrompng($destination);
// Prepare alpha channel for transparent background
$alpha_channel = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagecolortransparent($im, $alpha_channel);
// Fill image
imagefill($im, 0, 0, $alpha_channel);
// Copy from other
imagecopyresampled($im,$src_,0,0,0,0,$ancho_final, $alto_final,$ancho,$alto); 
// Save transparency
imagesavealpha($im,true);
$calidad=9; 
// Save PNG
imagepng($im,'firma/'.$imagen,$calidad);
imagedestroy($im);
}
$destination = 'firma/imgfirma.png';
$imagen="imgfirma.png";
$imagen= "csa_".$imagen;
$carpeta = 'firma';
copyTransparent($destination,$imagen);
echo 'Imagen creada '.$imagen.' y copiada en la carpeta '.$carpeta;
?>