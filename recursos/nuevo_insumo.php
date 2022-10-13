<?php 
require('conexion.php');


$nombre = $_POST['nombre'];
$costo = $_POST['costo'];
$cantidad = $_POST['cant'];
$fechacom = $_POST['fecha_com'];
$descrip = $_POST['descrip'];


$consulta = "INSERT INTO insumo (Nombre, Costo, Cantidad, Fecha_compra, Descripcion) VALUES ('".$nombre."', '".$costo."', '".$cantidad."', '".$fechacom."', '".$descrip."')";
	if(mysqli_query($conexion, $consulta)){
		die('<script>$("#modal1").closeModal(); Materialize.toast("Insumo agregado." , 4000);</script>');
	} else {
		die('console.log(Error)');
	}
?>
