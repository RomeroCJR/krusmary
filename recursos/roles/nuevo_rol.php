<?php
require('../conexion.php');

$nombre = $_POST['nombre'];
$des = $_POST['des'];

$consulta = "INSERT INTO rol (nombre_rol, descripcion_rol ) VALUES ('".$nombre."', '".$des."')";
if(mysqli_query($conexion, $consulta)){
    die('1');
} else {
    die(mysqli_error($conexion));
}

?>
