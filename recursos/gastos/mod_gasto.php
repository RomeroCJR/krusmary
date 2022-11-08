<?php 
	session_start();
	require("../conexion.php");
	date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d H:i:s");
	$gasto = $_POST['mod_monto'];
	$descripcion = $_POST['mod_descripcion'];
	$id = $_POST['mod_id'];


	$result = $conexion->query("UPDATE `caja` SET `monto_caja`='".$gasto."',`descripcion_caja`='".$descripcion."' WHERE cod_caja = ".$id);
	if($result) {
		echo $result;
	}else{
		echo mysqli_error($conexion);
	}

?>