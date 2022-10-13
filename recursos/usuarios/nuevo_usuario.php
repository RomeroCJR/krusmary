<?php
require('../conexion.php');
define ('SITE_ROOT', realpath(dirname(__FILE__)));
$ci = $_POST['ci'];
$nombre = $_POST['nombre'];
$apellido_p = $_POST['apellido_p'];
$apellido_m = $_POST['apellido_m'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$rol = $_POST['rol'];
$login = $_POST['login'];
$password = $_POST['passw'];


$cVU = "SELECT COUNT(*) as conteo FROM usuario WHERE ci_usuario = ".$ci;
$rVU = mysqli_query($conexion, $cVU) or die(mysqli_error($conexion));
$dVU = mysqli_fetch_array($rVU);
if($dVU['conteo'] > 0){
	die('existe_ci');
}

$cVU = "SELECT COUNT(*) as conteo FROM datos WHERE login = '".$login."' ";
$rVU = mysqli_query($conexion, $cVU) or die(mysqli_error($conexion));
$dVU = mysqli_fetch_array($rVU);
if($dVU['conteo'] > 0){
	die('existe_login');
}

$consulta = "INSERT INTO usuario (ci_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario, nro_celular_usuario, correo_usuario) VALUES ('".$ci."', '".$nombre."', '".$apellido_p."', '".$apellido_m."', '".$telefono."' , '".$email."')";
	if(mysqli_query($conexion, $consulta)){
		$id = mysqli_insert_id($conexion);
		$consulta2 = "INSERT INTO `datos`(`cod_usuario`, `login`, `clave`) VALUES ('".$id."','".$login."','".$password."')";
		if(mysqli_query($conexion, $consulta2)){
			$conexion->query("INSERT INTO `usu_rol`(`cod_usuario`, `cod_rol`) VALUES ('".$id."','".$rol."')");
			die('1');
		}
		
	} else {
		die(mysqli_error($conexion));
	}
?>