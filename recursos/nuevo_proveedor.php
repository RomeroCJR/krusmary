<?php
require('conexion.php');

$ci = $_POST['__ci'];
$nombre = $_POST['__nombre'];
$apellidos = $_POST['__ap'];
$telefono = $_POST['__telf'];
$empresa = $_POST['__emp'];

$consulta = "INSERT INTO proveedor (Ci, Nombre, Apellidos, Telefono, Code) VALUES ('".$ci."', '".$nombre."', '".$apellidos."', '".$telefono."', '".$empresa."')";
	if(mysqli_query($conexion, $consulta)){
		die('<script>$("#modal1").closeModal(); Materialize.toast("Proveedor agregado." , 4000);</script>');
	} else {
		die('Error');
	}
?>