<?php
	require('../conexion.php');

	$id = $_POST['mod_id'];
	$old_ci = $_POST['old_ci'];
	$ci = $_POST['mod_ci'];
	$nombre = strtoupper($_POST['mod_nombre']);
	$ap_paterno = strtoupper($_POST['mod_ap_paterno']);
	$ap_materno = $_POST['mod_ap_materno'];
	$telefono = $_POST['mod_telefono'];
	$email = $_POST['mod_email'];
	$rol = $_POST['mod_rol'];
	$login = $_POST['mod_login'];
	$password = $_POST['mod_passw'];

	if(isset($_POST['mod_ap_materno'])){
		$ap_materno = strtoupper($ap_materno);
	}

	if($ci != $old_ci){
		$res_vu = $conexion->query("SELECT * FROM usuario WHERE ci_usuario = ".$ci);
		if (mysqli_num_rows($res_vu) > 0) {
			die('existe');
		}
	}
	

	$conexion->query("UPDATE `datos` SET `login`='".$login."',`clave`='".$password."' WHERE cod_usuario = ".$id);
	$conexion->query("UPDATE `usu_rol` SET `cod_rol`='".$rol."' WHERE cod_usuario = ".$id);
	$result = $conexion->query("UPDATE `usuario` SET `ci_usuario`=".$ci.",`nombre_usuario`='".$nombre."',`ap_paterno_usuario`='".$ap_paterno."',`ap_materno_usuario`='".$ap_materno."',`nro_celular_usuario`='".$telefono."',`correo_usuario`='".$email."' WHERE cod_usuario = ".$id);
	if ($result) {
		die('1');
	}
	die(mysqli_error($conexion));

?>