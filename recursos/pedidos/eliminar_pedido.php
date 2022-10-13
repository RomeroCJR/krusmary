<?php 
require("../conexion.php");

$id = $_GET['id'];

//Borrando detalle de pedido y pedido
$res1 = $conexion->query("DELETE FROM `det_ped` WHERE Codped = ".$id);
$res2 = $conexion->query("DELETE FROM pedido WHERE Codped = ".$id);
//......................

$res = $conexion->query("SELECT Codv FROM venta WHERE Codped = ".$id);
if (mysqli_num_rows($res)>0) {
	$res = $res->fetch_all();
	$codv = $res[0][0];
	//Borrando detalle de venta y venta
	$res3 = $conexion->query("DELETE FROM det_plato WHERE Codv = ".$codv);
	$res4 = $conexion->query("DELETE FROM venta WHERE Codped = ".$id);
	//.....................

	//Borrando factura
	$res5 = $conexion->query("DELETE FROM `factura` WHERE Codp = ".$id);
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