<?php 
require("../conexion.php");
$ci = $_GET['ci'];


$conexion->query("UPDATE datos SET Estado = '0' WHERE Ci = ".$ci);
$res = $conexion->query("UPDATE `usuario` SET `Estado` = '0' WHERE Ci = ".$ci);

if ($res) {
	die($res);
}else{
	die($conexion->mysql_error());
}

?>