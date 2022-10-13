<?php 
	require("../conexion.php");
	date_default_timezone_set("America/La_Paz");
	$fecha = date("Y-m-d");
	$id = $_GET['id'];

	$result = $conexion->query("SELECT IF (SUM(a.Cantidad)>0, SUM(a.Cantidad),0) as cantidad FROM det_plato a, venta b WHERE a.Codv = b.Codv AND a.Codpla = ".$id." AND b.Fecha LIKE '%".$fecha."%'");
	$result = $result->fetch_all();

	echo $result[0][0];

?>