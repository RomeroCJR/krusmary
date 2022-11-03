<?php

require('../conexion.php');

if(isset($_GET["term"]))
{

    //NUEVA CONSULTA, RECOGE PRECIO DE ÚLTIMA VENTA REALIZADA... TEST
    $result = $conexion->query("SELECT * FROM cliente WHERE estado_cliente = 1  AND ci_cliente LIKE '".$_GET["term"]."%' ORDER BY nombre_cliente ASC");

    $total_row = mysqli_num_rows($result); 
    $output = array();
    if($total_row > 0){
      foreach($result as $row)
      {
        $temp_array = array();
        // $temp_array['stock_actual'] = $row['stock_actual'];
        $temp_array['nombre_cliente'] = $row['nombre_cliente'];
        $temp_array['ap_paterno_cliente'] = $row['ap_paterno_cliente'];
        $temp_array['ap_materno_cliente'] = $row['ap_materno_cliente'];
        $temp_array['nro_celular_cliente'] = $row['nro_celular_cliente'];
        $temp_array['value'] = $row['ci_cliente'];
        $temp_array['label'] = '<div>'.$row['ci_cliente'].' '.$row['nombre_cliente'].' '.$row['ap_paterno_cliente'].' '.$row['ap_materno_cliente'].'</div>';
        $output[] = $temp_array;
      }
    }else{
      $output['value'] = '';
      $output['label'] = 'No se encontraron coincidencias';
    }

 echo json_encode($output);
}
?>

