<?php
require('../sesiones.php');
require('../conexion.php');
session_start();
// $ci = $_POST['ci_cliente'];
// $nombre = $_POST['nombre_c'];
// $ap = $_POST['ap_c'];

$id = $_SESSION['id_cliente'];
$telf = $_GET['telf'];
$dir = $_GET['dir'];
$total = $_GET['subtotal'];
// $cont = $_POST['cont'];
$colat = $_GET['colat'];
$colng = $_GET['colng'];
$json = $_GET['json'];
$json = json_decode($json);



$consultaVP = "SELECT * FROM pedido WHERE idcli = ".$id." ORDER BY Codped DESC LIMIT 1";
$resultadoVP = mysqli_query($conexion, $consultaVP) or die(mysqli_error($conexion));
$rvp = mysqli_fetch_array($resultadoVP);

$resc = $conexion->query("SELECT Estado FROM cliente WHERE id = ".$id);
$resc = $resc->fetch_all(MYSQLI_ASSOC);

if ($resc[0]['Estado'] == '0') {
	die('<script>M.toast({html: "Usted ha sido bloqueado del servicio."});</script>');
}


if ($rvp['Estado'] == 1) {
	die('<script>M.toast({html: "Usted ya tiene un pedido activo."});</script>');
}

if (($_SERVER["REQUEST_TIME"] - strtotime($rvp['Fecha'])) < 1800) {
	die('<script>M.toast({html: "Usted realizó un pedido recientemente, Espere unos minutos."});</script>');
}


if (intval($telf) < 40000000) {
	die('<script>M.toast({html: "Ingrese un número de teléfono válido."});</script>');
}


$result = $conexion->query("INSERT INTO pedido (idcli, Total, Direccion, Lat, Lng) VALUES ('".$id."', '".$total."', '".$dir."', '".$colat."', '".$colng."')");

if($result == 1){

	$id_pedido = mysqli_insert_id($conexion); 
	foreach ($json as $key => $value) {
		$consulta_detped = "INSERT INTO det_ped (Codped, Codpla, Cant, Precio) VALUES (".$id_pedido.", ".$value[0].", ".$value[2].", (SELECT Precio FROM plato WHERE Codpla = ".$value[0]."))";
		if(!(mysqli_query($conexion, $consulta_detped))) {die(mysqli_error($conexion));}
	}

	die(true);
} else {
	die('<script>M.toast(html:{"Error desconocido"});</script>');
}

?>