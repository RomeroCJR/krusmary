<?php 
	require("../conexion.php");
	session_start();
	$id = $_SESSION['id_cliente'];
	$ci = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$telf = $_POST['telf'];
	
	$telf = "+591".$telf;

	$res = $conexion->query("UPDATE `cliente` SET `Ci`= ".$ci.",`Nombre`='".$nombre."',`Apellidos`='".$apellidos."',`Telefono`='".$telf."' WHERE id = ".$id);

	if ($res) {
		echo "1";
	}else{
		echo mysqli_error($conexion);
	}


?>