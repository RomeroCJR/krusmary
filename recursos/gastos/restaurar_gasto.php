<?php 
    require('../conexion.php');
    $id = $_GET['id'];
    $result = $conexion->query('UPDATE `caja` SET `estado_caja`= 1 WHERE cod_caja = '.$id);
    if($result){
        echo $result;
    }else{
        echo mysqli_error($conexion);
    }
?>