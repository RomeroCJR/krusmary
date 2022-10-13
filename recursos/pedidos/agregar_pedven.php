<?php
require('../conexion.php');
require('../sesiones.php');
session_start();

$ciusu = $_SESSION['Ci_Usuario'];
$codped = $_POST['__codiped'];

$cVE = "SELECT Estado FROM pedido WHERE Codped = ".$codped;
$rVE = mysqli_query($conexion, $cVE) or die(mysqli_error($conexion));
$dVE = mysqli_fetch_array($rVE);

if ($dVE['Estado'] == 1) {
$consulta = "INSERT INTO venta(Ciusu, idcli, Fecha, Total, Codped ) SELECT b.Ci, a.idcli, a.Fecha, a.Total, a.Codped FROM pedido a, usuario b WHERE b.Ci = ".$ciusu." AND a.Codped = ".$codped;
	if(mysqli_query($conexion, $consulta)){
		$consultaUE = "UPDATE pedido SET Estado = 0 WHERE Codped = ".$codped;
		mysqli_query($conexion, $consultaUE);
		$cADP = "INSERT INTO det_plato( Codpla, Codv, Cantidad, Precio  ) SELECT a.Codpla, b.Codv, a.Cant, a.Precio FROM det_ped a, venta b WHERE a.Codped = ".$codped." AND a.Codped = b.Codped";
		mysqli_query($conexion, $cADP);
		
		die('aceptado');
	} else {
		die(mysqli_error($conexion));
	}
}

if ($dVE['Estado'] == 2) {
	die('rechazado');
}else{
	die('already');
}
?>

<!-- 1: PEDIDO PENDIENTE -->
<!-- 0: PEDIDO ACEPTADO -->
<!-- 2: PEDIDO RECHAZADO -->