<?php 
    require('../conexion.php');
    $cod = $_GET['cod_venta'];

    $result = $conexion->query("SELECT a.cod_venta, a.cod_producto, a.cant_producto, a.precio_det_venta, b.nombre_producto FROM detalle_venta a, producto b WHERE a.cod_producto = b.cod_producto AND a.cod_venta = ".$cod);
    $res = $result->fetch_all(MYSQLI_ASSOC);
    if($result){
        echo json_encode($res);
    }else{
        echo mysqli_error($conexion);
    }

?>