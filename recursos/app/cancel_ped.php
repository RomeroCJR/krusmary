<?php 
require('../conexion.php');

$cod = $_GET['cod'];


$consulta = "DELETE FROM pedido WHERE  Codped = ".$cod."";
$consulta2 = "DELETE FROM det_ped WHERE  Codped = ".$cod."";
mysqli_query($conexion, $consulta2) or die(mysqli_error());
mysqli_query($conexion, $consulta) or die(mysqli_error());

$result = $conexion->query("DELETE FROM det_ped WHERE  Codped = ".$cod);
$result2 = $conexion->query("DELETE FROM pedido WHERE  Codped = ".$cod);

die($result.$result2);

?>