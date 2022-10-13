<?php
require('../conexion.php');
define ('SITE_ROOT', realpath(dirname(__FILE__)));
$ci = $_POST['mod_ci'];
$nombre = $_POST['mod_nombre'];
$apellidos = $_POST['mod_apellidos'];
$direccion = $_POST['mod_direccion'];
$telefono = $_POST['mod_telefono'];
$email = $_POST['mod_email'];
$rol = $_POST['mod_rol'];
$fnac = $_POST['mod_fnac'];
$nombreimg = $_FILES['mod_imagen']['name'];
$archivo = $_FILES['mod_imagen']['tmp_name'];
$password = $_POST['mod_passw'];
$old_ci = $_POST['old_ci'];
$old_pic = $_POST['old_pic'];


if(!empty($archivo)){
$ruta = $_SERVER['DOCUMENT_ROOT']."/sidelex/images";
$ruta = $ruta."/".$nombreimg;
move_uploaded_file($archivo, $ruta);
$ruta2 = "images/".$nombreimg;
}else{
	$ruta2 = $old_pic;
}


if ($ci != $old_ci) {
	$res_vu = $conexion->query("SELECT * FROM usuario WHERE Ci = ".$ci);
	if (mysqli_num_rows($res_vu) > 0) {
		die('existe');
	}
}

$conexion->query("DELETE FROM datos WHERE Ci = ".$old_ci);
$result = $conexion->query("UPDATE `usuario` SET `Ci`=".$ci.",`Nombre`='".$nombre."',`Apellidos`='".$apellidos."',`Direccion`='".$direccion."',`Telefono`='".$telefono."',`Email`='".$email."',`Fecha_nac`='".$fnac."',`Foto`='".$ruta2."',`Codrol`=".$rol." WHERE Ci = ".$old_ci);
if ($result) {
	$res = $conexion->query("INSERT INTO `datos`(`Ci`, `Usuario`, `Password`) VALUES (".$ci.",'".$ci."','".$password."')");
	if ($res) {
		die('1');
	}
}
die(mysqli_error($conexion));

?>