<?php 
	require("../conexion.php");
	date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d");
	$spend = $_GET['spend'];
	// $fecha = $_GET['date'];
	
	$result = $conexion->query("SELECT * FROM gastos WHERE Estado = 1 ORDER BY id DESC LIMIT 1");
	$result = $result->fetch_all(MYSQLI_ASSOC);

	if ($fecha == $result[0]['Fecha']) {
		$res = $conexion->query("UPDATE `gastos` SET `Monto`= ".$spend." WHERE id = ".$result[0]['id']);
	}else{
		$res = $conexion->query("INSERT INTO `gastos`(`Monto`, `Fecha`) VALUES (".$spend.", '".$fecha."')");
	}

	if ($res) {
		die('1');
	}else{
		die(mysqli_error($conexion));
	}

	
?>