<?php 
	require("../conexion.php");

	$cod = $_GET['cod'];
	$codf = 'a.cod_venta = '.$cod;
	$ress = $conexion->query('SELECT cod_pedido FROM venta WHERE cod_venta = '.$cod);
	$ress = $ress->fetch_all(MYSQLI_ASSOC);
	if($ress[0]['cod_pedido'] != NULL){
		$codf = 'a.cod_pedido = '.$ress[0]['cod_pedido'];
	}

	// die($codf);
	// die(var_dump($ress));
	// $res = $conexion->query('SELECT nro_factura, ci_cli, Fecha, Hora FROM factura WHERE Codv = '.$cod.' OR Codp = '.$cod);
	$res = $conexion->query('SELECT a.nro_factura, b.ci_cliente, a.fecha_factura, a.hora_factura, b.cod_cliente FROM factura a, cliente b WHERE a.cod_cliente = b.cod_cliente AND '.$codf);
	$res = $res->fetch_all();


	$result = $conexion->query("SELECT total_venta FROM venta WHERE cod_venta = ".$cod);
	$result = $result->fetch_all();

	$r = $conexion->query("SELECT nombre_cliente as Nombre, CONCAT(ap_paterno_cliente,' ',(SELECT IFNULL(ap_materno_cliente, ''))) AS Apellidos FROM cliente WHERE cod_cliente = ".$res[0][4]);
	$r = $r->fetch_all();


	//PARA OBTENER LAS FILAS DEL DETALLE DE VENTA
	$Sql2 = "SELECT a.cod_producto, a.cant_producto, a.precio_det_venta, b.nombre_producto FROM detalle_venta a, producto b WHERE a.cod_producto = b.cod_producto AND a.cod_venta = ".$cod;
	$Busq2 = $conexion->query($Sql2);
	$fila2 = $Busq2->fetch_all(MYSQLI_ASSOC);


	$celdas = "";
	$filas = "";
	foreach($fila2 as $a  => $valor){ 

			$celdas = "<tr><td> ".$valor['nombre_producto']." </td><td style='text-align:center'> ".$valor['cant_producto']." </td><td style='text-align:center'>".$valor['precio_det_venta']." </td></tr>";
			$filas = $filas ."". $celdas;

		
	} 


	$cad = array($res[0][0],$res[0][1],$r[0][0]." ".$r[0][1],$res[0][2],$res[0][3], $result[0][0], $filas);

	echo json_encode($cad);
	// echo json_encode($res);
?>