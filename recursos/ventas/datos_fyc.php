<?php 
require('../conexion.php');
$cod = $_GET['codx'];



	$Sql = "SELECT a.cod_venta, a.cod_cliente, a.total_venta, b.ci_cliente, b.nombre_cliente, CONCAT(b.ap_paterno_cliente,' ',(SELECT IFNULL(b.ap_materno_cliente, ''))) AS apellidos, b.nro_celular_cliente FROM venta a, cliente b WHERE a.cod_venta = '".$cod."' AND a.cod_cliente = b.cod_cliente;";
	$resultado = mysqli_query($conexion, $Sql) or die(mysqli_error($conexion));
	$datos = mysqli_fetch_assoc($resultado);
	// die(mysqli_error($conexion));
	die(json_encode($datos));

// die($datos['Codv'].",".$datos['Cicli'].",".$datos['Total'].",".$datos['Nombre'].",".$datos['Apellidos'].",".$datos['Telefono']);

?>