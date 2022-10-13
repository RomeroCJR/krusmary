<?php 
	require('../conexion.php');
	require('../factura/CodigoControlV7.php');
	$numero_autorizacion = $_GET['aut'];
	$numero_factura = $_GET['numfac'];
	$nit_cliente = $_GET['nit'];
	$fecha_c = $_GET['fecha'];
	$monto_compra = $_GET['total'];
	$clave = $_GET['llave'];

	// die($numero_autorizacion." ".$numero_factura." ".$nit_cliente." ".$fecha_compra." ".$monto_compra." ".$clave);
	$fecha_compra = strtotime(str_replace("/", "-", $fecha_c));
	$codigo_control = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);
	echo $codigo_control;
	
?>
