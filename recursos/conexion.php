<?php 

$conexion = mysqli_connect('localhost','root','','krusmary');
// $conexion = new mysqli('localhost','u604223767_sidelex','Desconocido1','u604223767_sidelex'); //agregado desde sublime
// $conexion = mysqli_connect('localhost','u604223767_cristian','Desconocido1','u604223767_dppl');

$conexion->query("SET NAMES 'utf8'");
if($conexion->connect_error) { 
    die( 'Error: ('. $conexion->connect_errno .' )'. $conexion->connect_error); 
}
?>