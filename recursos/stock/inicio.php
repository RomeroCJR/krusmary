<?php 
	require("../conexion.php");

	$cant = $_GET['cant'];
	$id = $_GET['id'];

	$result = $conexion->query("UPDATE `inventario` SET `stock_previo`=`stock`, `stock`= ".$cant." WHERE cod_producto = ".$id);
	if ($result) {
		echo $result;
	}else{
		echo mysqli_error($conexion);
	}

?>