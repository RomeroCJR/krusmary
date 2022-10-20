<?php 
    require('../conexion.php');
    $id = $_GET['id'];
    $result = $conexion->query('SELECT cod_rol AS codrol, nombre_rol AS nombre FROM `rol` WHERE cod_rol <> '.$id.' AND estado_rol = 1');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($result);

?>