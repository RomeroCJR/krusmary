<?php 
	session_start();
	require("../conexion.php");
	date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d H:i:s");
	$spend = $_GET['spend'];
	// $fecha = $_GET['date'];
	$descripcion = $_GET['desc'];
	$user = $_SESSION['Cod_usuario'];

	// die($user." ".$spend." ".$descripcion);
	// $result = $conexion->query("SELECT * FROM gastos WHERE Estado = 1 ORDER BY id DESC LIMIT 1");
	// $result = $result->fetch_all(MYSQLI_ASSOC);

	// if ($fecha == $result[0]['Fecha']) {
	// 	$res = $conexion->query("UPDATE `gastos` SET `Monto`= ".$spend." WHERE id = ".$result[0]['id']);
	// }else{
	// 	$res = $conexion->query("INSERT INTO `gastos`(`Monto`, `Fecha`) VALUES (".$spend.", '".$fecha."')");
	// }

	// if ($res) {
	// 	die('1');
	// }else{
	// 	die(mysqli_error($conexion));
	// }

	$result = $conexion->query("INSERT INTO `caja`(`cod_usuario`, `monto_caja`, `descripcion_caja`, `fecha_caja`) VALUES ('".$user."','".$spend."','".$descripcion."','".$fecha."')");
	if($result) {
		echo $result;
	}else{
		echo mysqli_error($conexion);
	}

?>