<?php 
require('../conexion.php');

$codp = $_GET['codpro'];

$result = $conexion->query("UPDATE `producto` SET `estado_producto`='0' WHERE cod_producto = ".$codp);
if($result){
    echo $result;
}else{
    echo mysqli_error($conexion);
}


?>