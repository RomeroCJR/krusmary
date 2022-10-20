<?php 
	require("../conexion.php");
	$id = $_GET['id'];

	$result = $conexion->query("UPDATE `cliente` SET `estado_cliente`='0' WHERE cod_cliente = ".$id);
	if ($result) {
		echo $result;
	}else{
		echo mysqli_error($conexion);
	}
?>