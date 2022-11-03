<?php

require('../conexion.php');

if(isset($_GET["term"]))
{

    //NUEVA CONSULTA, RECOGE PRECIO DE ÚLTIMA VENTA REALIZADA... TEST
    $result = $conexion->query("SELECT a.cod_producto as id, a.nombre_producto, b.stock, a.precio_producto, a.foto_producto FROM producto a, inventario b WHERE a.cod_producto = b.cod_producto AND  a.estado_producto = 1  AND CONCAT(a.cod_producto,' ',a.nombre_producto) LIKE '%".$_GET["term"]."%' ORDER BY a.cod_producto ASC");

    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
        $temp_array = array();
        // $temp_array['stock_actual'] = $row['stock_actual'];
        $temp_array['stock'] = $row['stock'];
        $temp_array['id'] = $row['id'];
        $temp_array['precio'] = $row['precio_producto'];
        $temp_array['value'] = $row['nombre_producto'];
        $temp_array['label'] = '<div style="height:60px">'.$row['nombre_producto'].'<img class="zoom right" src="'.$row['foto_producto'].'" height="50" /></div>';
        $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

 echo json_encode($output);
}
?>

