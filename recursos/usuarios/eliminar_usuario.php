<?php 
require("../conexion.php");
$id = $_GET['id'];

$conexion->query("UPDATE `datos` SET `estado_dato`='0' WHERE cod_usuario = ".$id);

$res = $conexion->query("UPDATE `usuario` SET `estado_usuario` = '0' WHERE cod_usuario = ".$id);

if ($res) {
	die($res);
}else{
	die($conexion->mysqli_error($conexion));
}

?>