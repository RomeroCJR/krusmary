<?php 
	require("../conexion.php");
	date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d");
	$id = $_GET['id'];

	$result = $conexion->query("SELECT IF (SUM(a.cant_producto)>0, SUM(a.cant_producto), 0) as cantidad FROM detalle_venta a, venta b WHERE a.cod_venta = b.cod_venta AND a.cod_producto = '".$id."' AND b.fecha_venta LIKE '".$fecha."%'");
	$result = $result->fetch_all();

	echo $result[0][0];

?>