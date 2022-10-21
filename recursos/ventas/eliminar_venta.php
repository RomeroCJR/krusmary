<?php 
	require("../conexion.php");

	$id = $_GET['id'];

	//Borrando detalle de venta y venta
	$res3 = $conexion->query("DELETE FROM detalle_venta WHERE cod_venta = ".$id);
	$res4 = $conexion->query("DELETE FROM venta WHERE cod_venta = ".$id);
	//.....................

	//Borrando factura
	$res5 = $conexion->query("DELETE FROM `factura` WHERE cod_venta = ".$id);
	//.....................

	if ($res5 && $res3 && $res4) {
		die('1');
	}else{
		die(mysqli_error($conexion));
	}
?>

