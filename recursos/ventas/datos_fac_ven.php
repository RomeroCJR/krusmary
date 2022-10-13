<?php 
require('../conexion.php');
require('../factura/CodigoControlV7.php');

$codv = $_POST['codped']; //para bd factura
$fecha = $_POST['fechax']; //para bd factura
$hora = $_POST['horax']; //para bd factura

$nit_cliente = $_POST['cix']; //para bd factura
$numero_autorizacion = $_POST['autx'];
$fecha_c = $_POST['fechax'];
$monto_compra = $_POST['montox'];
$clave = $_POST['llavex'];



$fecha_compra = strtotime(str_replace("/", "-", $fecha_c));

$consultaNumFac = "SELECT count(*) as numfac FROM factura WHERE Estado = 1";
$resultadoConsultaNF = mysqli_query($conexion, $consultaNumFac) or die(mysqli_error($conexion));
$datosCNF = mysqli_fetch_array($resultadoConsultaNF);

$numero_factura = (int)$datosCNF['numfac'] + 1; //para bd factura

$codigo_control = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);


// die($codped.",".$fecha.",".$hora.",".$nit_cliente.",".$numero_factura);

$consultaInsertarNuevaFactura = "INSERT INTO factura (Codtal, Codv, Ci_cli, Fecha, Hora, Nro_fac) VALUES((SELECT MAX(Codtal) FROM talonario WHERE Estado = 1), ".$codv.", ".$nit_cliente.", '".$fecha."', '".$hora."', ".$numero_factura.")";

	if(mysqli_query($conexion, $consultaInsertarNuevaFactura)){
		$result = $conexion->query("UPDATE `talonario` SET `Cant_emitidos`= ".$numero_factura." WHERE Codtal = (SELECT MAX(Codtal))");	
		if ($result) {
			die($codigo_control.','.$numero_factura);
		}
		
	} else {
		die(mysqli_error($conexion));
	}






?>