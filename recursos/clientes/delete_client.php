<?php 
	require("../conexion.php");
	$id = $_GET['id'];

	$result = $conexion->query("DELETE FROM `cliente` WHERE id=".$id);
	if ($result) {
		echo "1";
	}else{
		echo mysqli_error($conexion);
	}
?>