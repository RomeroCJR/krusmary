<?php
require('../conexion.php');

$nombre = $_POST['nombre'];

$consulta = "INSERT INTO categoria( nombre_categoria) VALUES ('".$nombre."')";
if(mysqli_query($conexion, $consulta)){
    die('1');
} else {
    die(mysqli_error($conexion));
}

