<?php 
    require('../conexion.php');
    $cod = $_GET['cod'];
    $result = $conexion->query("UPDATE `categoria` SET `estado_categoria` = 1 WHERE cod_categoria = ".$cod);
    if ($result) {
        echo $result;
    }else{
        echo mysqli_error($conexion);
    }

?>