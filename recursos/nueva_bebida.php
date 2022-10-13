<?php
require('conexion.php');

$nombre = $_POST['__nombre'];
$precio = $_POST['__precio'];
$cantidad = $_POST['__cant'];

$consulta = "INSERT INTO bebida (Nombre, Precio, Cantidad) VALUES ('".$nombre."', '".$precio."', '".$cantidad."')";
	if(mysqli_query($conexion, $consulta)){
		die('<script>$("#modal1").closeModal(); Materialize.toast("Bebida agregada." , 4000);</script>');
	} else {
		die('Error');
	}
?>