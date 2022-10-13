<?php 
	require("../conexion.php");

	$cant = $_GET['cant'];
	$id = $_GET['id'];

	$result = $conexion->query("UPDATE `stock` SET `Stock`= ".$cant." WHERE Codpla = ".$id);
	if ($result) {
		echo '1';
	}else{
		echo mysqli_error($conexion);
	}

?>