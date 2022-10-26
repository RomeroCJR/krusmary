<?php
require('../conexion.php');
require('../sesiones.php');
session_start();

$cod_usuario = $_SESSION['Cod_usuario'];
$codped = $_POST['__codiped'];


$cVE = "SELECT estado_pedido FROM pedido WHERE cod_pedido = ".$codped;
$rVE = mysqli_query($conexion, $cVE) or die(mysqli_error($conexion));
$dVE = mysqli_fetch_array($rVE);

if ($dVE['estado_pedido'] == 1) {
$consulta = "INSERT INTO venta(cod_usuario, cod_cliente, fecha_venta, total_venta, cod_pedido ) SELECT b.cod_usuario, a.cod_cliente, a.fecha_pedido, a.total_pedido, a.cod_pedido FROM pedido a, usuario b WHERE b.cod_usuario = ".$cod_usuario." AND a.cod_pedido = ".$codped;
	if(mysqli_query($conexion, $consulta)){
		$consultaUE = "UPDATE pedido SET estado_pedido = 0 WHERE cod_pedido = ".$codped;
		mysqli_query($conexion, $consultaUE);
		$cADP = "INSERT INTO detalle_venta( cod_producto, cod_venta, cant_producto, precio_det_venta  ) SELECT a.cod_producto, b.cod_venta, a.cant_producto, a.precio_det_pedido FROM detalle_pedido a, venta b WHERE a.cod_pedido = ".$codped." AND a.cod_pedido = b.cod_pedido";
		mysqli_query($conexion, $cADP);
		
		die('aceptado');
	} else {
		die(mysqli_error($conexion));
	}
}

if ($dVE['estado_pedido'] == 2) {
	die('rechazado');
}else{
	die('already');
}
?>

<!-- 1: PEDIDO PENDIENTE -->
<!-- 0: PEDIDO ACEPTADO -->
<!-- 2: PEDIDO RECHAZADO -->