<?php 
require('conexion.php');

$cod = $_POST['codin'];

$consulta = "UPDATE insumo SET Estado = 0 WHERE Codi = ".$cod;
	if(mysqli_query($conexion, $consulta)){
		die('<script>$("#modal2").closeModal(); Materialize.toast("Registro eliminado." , 4000);</script>');
	} else {
		die('console.log(Error)');
	}

?>