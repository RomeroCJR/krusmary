<?php 
	require("../conexion.php");
	$nit = $_POST['NIT'];
	$dir = $_POST['direccion'];
	$act = $_POST['actividad'];
	$ley = $_POST['leyenda'];
	$telf = $_POST['telf'];
	$email = $_POST['email'];

	$result = $conexion->query("UPDATE `empresa` SET `NIT`=".$nit.",`direccion`='".$dir."',`actividad`='".$act."',`leyenda`='".$ley."',`telefono`='".$telf."',`email`='".$email."' WHERE 1");
	if ($result) {
		echo '1';
	}else{
		echo mysqli_error($conexion);
	}
?>