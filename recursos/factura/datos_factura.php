<?php 
	require("../conexion.php");
	$aut = $_POST['autorizacion'];
	$llave = $_POST['llave'];
	$num_ini = $_POST['num_inicial'];
	$limit = $_POST['limite'];


	$result = $conexion->query("UPDATE `talonario` SET `Autorizacion`='".$aut."',`Fecha_emision`='".$limit."',`Llave_dosif`='".$llave."',`Num_inicio`= ".$num_ini." WHERE 1");
	if ($result) {
		echo '1';
	}else{
		echo mysqli_error($conexion);
	}
?>