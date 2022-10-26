<?php 
    require('../conexion.php');
    $cod = $_GET['cod'];

    $result = $conexion->query("SELECT a.cod_pedido, a.cod_producto, a.cant_producto, a.precio_det_pedido, b.nombre_producto FROM detalle_pedido a, producto b WHERE a.cod_producto = b.cod_producto AND a.cod_pedido = ".$cod);
    $res = $result->fetch_all(MYSQLI_ASSOC);
    if($result){
        echo json_encode($res);
    }else{
        echo mysqli_error($conexion);
    }

?>