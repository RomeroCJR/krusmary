<?php
require('../conexion.php');

$ci = $_POST['ci'];
$nombre = $_POST['nombre'];
$ap_paterno = $_POST['ap_paterno'];
$ap_materno = $_POST['ap_materno'];
$telefono = $_POST['telefono'];

$consulta = "INSERT INTO cliente (ci_cliente, nombre_cliente, ap_paterno_cliente, ap_materno_cliente, nro_celular_cliente) VALUES ('".$ci."', UPPER('".$nombre."'), UPPER('".$ap_paterno."'), UPPER('".$ap_materno."'), '".$telefono."')";
	if(mysqli_query($conexion, $consulta)){
		die('1');
	} else {
		die(mysqli_error($conexion));
	}
