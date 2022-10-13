<?php 
	require("../conexion.php");

	$id = $_GET['id'];

	//Borrando detalle de venta y venta
	$res3 = $conexion->query("DELETE FROM det_plato WHERE Codv = ".$id);
	$res4 = $conexion->query("DELETE FROM venta WHERE Codv = ".$id);
	//.....................

	//Borrando factura
	$res5 = $conexion->query("DELETE FROM `factura` WHERE Codv = ".$id);
	//.....................

	if ($res5) {
		die('1');
	}else{
		die(mysqli_error($conexion));
	}
?>

