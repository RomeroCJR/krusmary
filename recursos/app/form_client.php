<?php 
	require("../conexion.php");
	session_start();
	$id = $_SESSION['cod_cliente'];
	$ci = $_POST['cedula'];
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$telf = $_POST['telf'];
	$clave = $_POST['clave'];
	$apellidos = explode(" ",$apellidos);
	$ap_paterno = $apellidos[0];
	$ap_materno = NULL;
	if(isset($apellidos[1])){
		$ap_materno = $apellidos[1];
	}


	$res = $conexion->query("UPDATE `cliente` SET `ci_cliente`= ".$ci.",`nombre_cliente`= UPPER('".$nombre."'),`ap_paterno_cliente`= UPPER('".$ap_paterno."'),`ap_materno_cliente`= UPPER('".$ap_materno."'),`nro_celular_cliente`='".$telf."',`clave_cliente`='".$clave."' WHERE cod_cliente = ".$id);

	if ($res) {
		echo $res;
	}else{
		echo mysqli_error($conexion);
	}


?>