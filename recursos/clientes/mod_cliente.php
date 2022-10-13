<?php 
	require("../conexion.php");
	$id = $_POST['mod_id'];
	$ci = $_POST['mod_ci'];
	$nombre = $_POST['mod_nombre'];
	$apellidos = $_POST['mod_apellidos'];
	$telf = $_POST['mod_telefono'];

	// echo $id." ".$ci." ".$nombre." ".$apellidos." ".$telf

	$result = $conexion->query("UPDATE `cliente` SET `Ci`= ".$ci.",`Nombre`='".$nombre."',`Apellidos`='".$apellidos."',`Telefono`='".$telf."' WHERE id = ".$id);

	if ($result) {
		echo "1";
	}else{
		echo mysqli_error($conexion);
	}

?>