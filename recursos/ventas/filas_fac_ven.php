<?php
require('../conexion.php');
$cod = $_GET['codxv'];


$Sql2 = "SELECT a.cod_producto, a.cant_producto, a.precio_det_venta, b.nombre_producto FROM detalle_venta a, producto b WHERE a.cod_producto = b.cod_producto AND a.cod_venta = ".$cod;
$Busq2 = $conexion->query($Sql2);
$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC);

// while($arr2 = $Busq2->fetch_array())
// {
// $fila2[] = array('codpla'=>$arr2['Codpla'], 'cant'=>$arr2['Cantidad'], 'precio'=>$arr2['Precio'], 'nombre'=>$arr2['Nombre']);
// }

$celdas = "";
$filas = "";
foreach($fila2 as $a  => $valor){ 

		$celdas = "<tr><td> ".$valor['nombre_producto']." </td><td style='text-align:center'> ".$valor['cant_producto']." </td><td style='text-align:center'>".$valor['precio_det_venta']." </td></tr>";
		$filas = $filas ."". $celdas;

	
} 

die($filas);

?>