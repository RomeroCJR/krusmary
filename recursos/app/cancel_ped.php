<?php 
require('../conexion.php');

$cod = $_GET['cod'];


// $consulta = "DELETE FROM pedido WHERE  Codped = ".$cod."";
// $consulta2 = "DELETE FROM det_ped WHERE  Codped = ".$cod."";
// mysqli_query($conexion, $consulta2) or die(mysqli_error());
// mysqli_query($conexion, $consulta) or die(mysqli_error());

$result = $conexion->query("DELETE FROM detalle_pedido WHERE  cod_pedido = ".$cod);
$result2 = $conexion->query("DELETE FROM pedido WHERE  cod_pedido = ".$cod);
if($result && $result2){
    die('1');
}
echo mysqli_error($conexion);

?>