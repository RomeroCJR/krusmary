<?php
require('../conexion.php');
$cod = $_POST['codxv'];


$Sql2 = "SELECT a.Codpla, a.Cantidad, a.Precio, b.Nombre FROM det_plato a, plato b WHERE a.Codpla = b.Codpla AND a.Codv = ".$cod;
$Busq2 = $conexion->query($Sql2);
while($arr2 = $Busq2->fetch_array())
{
$fila2[] = array('codpla'=>$arr2['Codpla'], 'cant'=>$arr2['Cantidad'], 'precio'=>$arr2['Precio'], 'nombre'=>$arr2['Nombre']);
}


$celdas = "";
$filas = "";
foreach($fila2 as $a  => $valor){ 

		$celdas = "<tr><td> ".$valor['nombre']." </td><td style='text-align:center'> ".$valor['cant']." </td><td style='text-align:center'>".$valor['precio']." </td></tr>";
		$filas = $filas ."". $celdas;

	
} 

die($filas);

?>