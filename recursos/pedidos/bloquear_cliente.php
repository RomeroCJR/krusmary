<?php 
	require('../conexion.php');

	$idcli = $_GET['idcli'];
	$codped = $_GET['codped'];

	$result = $conexion->query('UPDATE cliente SET Estado = 0 WHERE id = '.$idcli);
	// $res = $conexion->query("UPDATE pedido SET Estado = 2 WHERE Codped = ".$codped);

	if ($result) {
		echo '1';
	}else{
		echo mysqli_error($conexion);
	}
?>
