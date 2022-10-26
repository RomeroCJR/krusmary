<?php 
require('../conexion.php');
require('../factura/CodigoControlV7.php');
require('../sesiones.php');
session_start();
$ciuser = $_SESSION['Ci_Usuario'];

$codped = $_POST['codped']; //para bd factura
$fecha = $_POST['fechax']; //para bd factura
$hora = $_POST['horax']; //para bd factura

$nit_cliente = $_POST['cix']; //para bd factura
$numero_autorizacion = $_POST['autx'];
$fecha_c = $_POST['fechax'];
$monto_compra = $_POST['montox'];
$clave = $_POST['llavex'];
$monto_compra = str_replace('.',',',$monto_compra);

$result = $conexion->query('SELECT cod_cliente FROM cliente WHERE ci_cliente = '.$nit_cliente);
$result = $result->fetch_all(MYSQLI_ASSOC);
$cod_cli = $result[0]['cod_cliente'];
// die($codped." ".$fecha." ".$hora." ".$nit_cliente." ".$numero_autorizacion." ".$fecha_c." ".$monto_compra." ".$clave);

$fecha_compra = strtotime(str_replace("/", "-", $fecha_c));

$consultaNumFac = "SELECT count(*) as numfac FROM factura WHERE estado_factura = 1";
$resultadoConsultaNF = mysqli_query($conexion, $consultaNumFac) or die(mysqli_error($conexion));
$datosCNF = mysqli_fetch_array($resultadoConsultaNF);

$numero_factura = (int)$datosCNF['numfac'] + 1; //para bd factura

// die($numero_factura."<<<");
// $codigo_control = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);

$codigo_control = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);


// die($codped.",".$fecha.",".$hora.",".$nit_cliente.",".$numero_factura);

// $consultaInsertarNuevaFactura = "INSERT INTO factura (Codtal, Codp, Ci_cli, Fecha, Hora, Nro_fac) VALUES((SELECT MAX(Codtal) FROM talonario WHERE Estado = 1), ".$codped.", ".$nit_cliente.", '".$fecha."', '".$hora."', ".$numero_factura.")";	
$consultaInsertarNuevaFactura = "INSERT INTO factura (cod_talonario, cod_pedido, cod_cliente, fecha_factura, hora_factura, nro_factura	) VALUES((SELECT MAX(cod_talonario) FROM talonario WHERE estado_talonario = 1), ".$codped.", ".$cod_cli.",'".$fecha."', '".$hora."', ".$numero_factura.")";	

	if(mysqli_query($conexion, $consultaInsertarNuevaFactura)){
		$result = $conexion->query("UPDATE `talonario` SET `cantidad_emitida`= ".$numero_factura." WHERE cod_talonario = (SELECT MAX(cod_talonario))");	
		if ($result) {
			die($codigo_control.','.$numero_factura);
		}
		
	} else {
		die(mysqli_error($conexion));
	}






?>