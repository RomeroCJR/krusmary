<?php 
	require("../conexion.php");

	$id = $_GET['id'];

	$res = $conexion->query("UPDATE `detalle_pedido` SET `estado_det_pedido`= 0 WHERE cod_pedido = ".$id);
	$result = $conexion->query("UPDATE `pedido` SET `estado_pedido`= 2 WHERE cod_pedido = ".$id);

	if ($result) {
		die($result);
	}
	else{
		die(mysqli_error($conexion));
	}

?>