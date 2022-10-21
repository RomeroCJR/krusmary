<?php
require('../conexion.php');

$id = $_POST['mod_id'];
$nombre= $_POST['mod_nombre'];

$result = $conexion->query("UPDATE `categoria` SET `nombre_categoria`= '".$nombre."' WHERE cod_categoria=".$id);

if ($result) {
    echo $result;
}else{
    echo mysqli_error($conexion);
}

?>