<?php 
require('../conexion.php');

$codp = $_GET['codpla'];

$result = $conexion->query('UPDATE plato SET Estado = 0 WHERE Codpla = '.$codp);
echo $result;

?>