<?php 
    require('../conexion.php');
    $cod = $_GET['cod'];
    $result = $conexion->query("SELECT a.cod_pedido, a.cod_cliente, b.ci_cliente as cedula, a.total_pedido, a.fecha_pedido, a.dedicatoria, a.foto_personalizada, a.estado_pedido, b.nombre_cliente, CONCAT(b.ap_paterno_cliente,' ',b.ap_materno_cliente) AS apellidos,b.nro_celular_cliente, a.dedicatoria, a.foto_personalizada, b.estado_cliente FROM pedido a, cliente b WHERE a.cod_cliente = b.cod_cliente AND a.cod_pedido = '".$cod."' ");
    $res = $result->fetch_all(MYSQLI_ASSOC);

    if ($result) {
        echo json_encode($res);
    }else{
        echo mysqli_error($conexion);
    }

?>