<?php 
	require("../conexion.php");
	date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d");

	$result = $conexion->query("SELECT * FROM gastos WHERE Estado = 1 ORDER BY id DESC LIMIT 1");
	$result = $result->fetch_all(MYSQLI_ASSOC);

	if ($fecha == $result[0]['Fecha']) {
		die($result[0]['Monto']);
	}else{
		die('0');
	}
?>