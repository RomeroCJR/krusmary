<?php 
require("../conexion.php");

$id = $_GET['id'];

//Borrando detalle de pedido y pedido
$res1 = $conexion->query("DELETE FROM `detalle_pedido` WHERE cod_pedido = ".$id);
$res2 = $conexion->query("DELETE FROM pedido WHERE cod_pedido = ".$id);
//......................

$res = $conexion->query("SELECT cod_venta FROM venta WHERE cod_pedido = ".$id);
if (mysqli_num_rows($res)>0) {
	$res = $res->fetch_all();
	$codv = $res[0][0];
	//Borrando detalle de venta y venta
	$res3 = $conexion->query("DELETE FROM detalle_venta WHERE cod_venta = ".$codv);
	$res4 = $conexion->query("DELETE FROM venta WHERE cod_pedido = ".$id);
	//.....................

	//Borrando factura
	$res5 = $conexion->query("DELETE FROM `factura` WHERE cod_pedido = ".$id);
	//.....................

	if ($res5) {
		die('1');
	}
}else{
	if ($res2) {
		die('1');
	}else{
		die(mysqli_error($conexion));
	}
}


?>