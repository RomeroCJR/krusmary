<?php 
	require("../conexion.php");

	$cod = $_GET['cod'];

	$res = $conexion->query('SELECT Nro_fac, Ci_cli, Fecha, Hora FROM factura WHERE Codv = '.$cod.' OR Codp = '.$cod);
	$res = $res->fetch_all();

	$result = $conexion->query("SELECT Total FROM venta WHERE Codv = ".$cod);
	$result = $result->fetch_all();

	$r = $conexion->query("SELECT Nombre, Apellidos FROM cliente WHERE Ci = ".$res[0][1]);
	$r = $r->fetch_all();


	//PARA OBTENER LAS FILAS DEL DETALLE DE VENTA
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


	$cad = array($res[0][0],$res[0][1],$r[0][0]." ".$r[0][1],$res[0][2],$res[0][3], $result[0][0], $filas);

	echo json_encode($cad);
	// echo json_encode($res);
?>