<?php 
    require('../conexion.php');
    $id = $_GET['id'];
    $result = $conexion->query('SELECT cod_categoria, nombre_categoria FROM `categoria` WHERE cod_categoria <> '.$id.' AND estado_categoria = 1');
    $result = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($result);

?>