<?php 
	require("../conexion.php");
	$aut = $_POST['autorizacion'];
	$llave = $_POST['llave'];
	$num_ini = $_POST['num_inicial'];
	$limit = $_POST['limite'];


	$result = $conexion->query("UPDATE `talonario` SET `autorizacion`='".$aut."',`fecha_emision`='".$limit."',`llave_dosificacion`='".$llave."',`num_inicio`= ".$num_ini." WHERE 1");
	if ($result) {
		echo '1';
	}else{
		echo mysqli_error($conexion);
	}
?>