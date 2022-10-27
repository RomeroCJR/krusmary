<?php 
	require('../conexion.php');
	require('../factura/CodigoControlV7.php');
	$numero_autorizacion = $_GET['aut'];
	$numero_factura = $_GET['numfac'];
	$nit_cliente = $_GET['nit'];
	$fecha_c = $_GET['fecha'];
	$monto_compra = $_GET['total'];
	$clave = $_GET['llave'];

	
	$fecha_compra = strtotime(str_replace("/", "-", $fecha_c));
	// die($numero_autorizacion." ".$numero_factura." ".$nit_cliente." ".$fecha_compra." ".$monto_compra." ".$clave);
	$monto_compra = str_replace('.', ',', $monto_compra);
	// die($monto_compra);
	$codigo_control = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, (float)$monto_compra, $clave);
	echo $codigo_control;
	
?>
