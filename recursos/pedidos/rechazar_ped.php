<?php 
	require("../conexion.php");

	$id = $_GET['id'];

	$res = $conexion->query("UPDATE `det_ped` SET `Estado`= 0 WHERE Codped = ".$id);
	$result = $conexion->query("UPDATE `pedido` SET `Estado`= 2 WHERE Codped = ".$id);

	if ($result) {
		die('1');
	}
	else{
		die(mysqli_error($conexion));
	}

?>