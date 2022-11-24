<?php 
	require("../conexion.php");
	$id = $_POST['mod_id'];
	$ci = $_POST['mod_ci'];
	$nombre = $_POST['mod_nombre'];
	$ap_paterno = $_POST['mod_ap_paterno'];
	$ap_materno = $_POST['mod_ap_materno'];
	$telf = $_POST['mod_telefono'];

	$result = $conexion->query("UPDATE `cliente` SET `ci_cliente`= ".$ci.",`nombre_cliente`= UPPER('".$nombre."'), `ap_paterno_cliente`= UPPER('".$ap_paterno."'), `ap_materno_cliente`=UPPER('".$ap_materno."'),`nro_celular_cliente`='".$telf."' WHERE cod_cliente = ".$id);

	if ($result) {
		echo $result;
	}else{
		echo mysqli_error($conexion);
	}

?>