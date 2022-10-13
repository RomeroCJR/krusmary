<?php 

require('../factura/phpqrcode/qrlib.php');


$numfac = $_POST['numfac'];
$cntdo = $_POST['contenido'];

// die($numfac."--".$cntdo);

$dir = '../../images/qrcodes/';
if(!file_exists($dir)){
	mkdir($dir);
}

$filename = $dir.''.$numfac.'.png';
// $filename = "images/qrcodes/".$numfac.'.png';

$tamanio = 10;
$level = 'M';
$frameSize = 3;
$contenido = $cntdo;


QRcode::png($contenido,$filename,$level,$tamanio,$frameSize);



$ruta = "images/qrcodes/".$numfac.'.png';
die($ruta);


?>