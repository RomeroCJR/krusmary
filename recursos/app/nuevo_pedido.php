<?php
require('../sesiones.php');
require('../conexion.php');
session_start();
date_default_timezone_set("America/La_Paz");
// $ci = $_POST['ci_cliente'];
// $nombre = $_POST['nombre_c'];
// $ap = $_POST['ap_c'];

// $id = $_SESSION['id_cliente'];


// $ci = $_POST['ci'];
// $telf = $_POST['celular'];
// $nombre = $_POST['nombre'];
$fecha = $_POST['fecha'];
$hora = $_POST['hora'];
$subtotal = $_POST['subtotal'];
$id_cli = $_POST['cod_cliente'];
// $apellidos = $_POST['apellidos'];
// $ap_paterno = "";
// $ap_materno = "";

// $pos = strpos($apellidos, " ");

// if(!strpos($apellidos, " ")){
	// $apellidos = explode(" ", $apellidos);
	// // die(var_dump($apellidos));
	// $ap_paterno = $apellidos[0];
	// if(isset($apellidos[1])){
		// $ap_materno = $apellidos[1];
	// }else{
		// $ap_materno = "";
	// }
	
// }else{
	// $ap_paterno = $apellidos;
// }


$json = $_POST['json_detalle'];
$json = json_decode($json);
// die($json);
$nombreimg = $_FILES['imagen']['name'];
$archivo = $_FILES['imagen']['tmp_name'];

$ruta = $_SERVER['DOCUMENT_ROOT']."/krusmary/images";
$ruta = $ruta."/".$nombreimg;
move_uploaded_file($archivo, $ruta);
$ruta2 = "images/".$nombreimg;

$mensaje = $_POST['dedicatoria'];
$excepciones = $_POST['excepciones'];


if(empty($nombreimg)){
	$ruta2 = NULL;
}
if(empty($mensaje)){
	$mensaje = NULL;
}
if(empty($excepciones)){
	$excepciones = NULL;
}

// die($ruta2."---".$mensaje);

// $result = $conexion->query('SELECT * FROM cliente WHERE ci_cliente = "'.$ci.'"');
// $res = mysqli_num_rows($result);
// $result = $result->fetch_all(MYSQLI_ASSOC);

// $id_cli = "";
// if($res > 0){
// 	$id_cli = $result[0]['cod_cliente'];
// 	$conexion->query("UPDATE `cliente` SET `nombre_cliente`='".$nombre."',`ap_paterno_cliente`='".$ap_paterno."',`ap_materno_cliente`='".$ap_materno."',`nro_celular_cliente`='".$telf."' WHERE cod_cliente = ".$id_cli);
// }else{
// 	$conexion->query("INSERT INTO `cliente`(`ci_cliente`, `nombre_cliente`, `ap_paterno_cliente`, `ap_materno_cliente`, `nro_celular_cliente`) VALUES ('".$ci."','".$nombre."','".$ap_paterno."','".$ap_materno."','".$telf."')");
// 	$id_cli = mysqli_insert_id($conexion);
// }


$consultaVP = "SELECT a.* FROM pedido a WHERE a.cod_cliente = '".$id_cli."' ORDER BY a.cod_pedido DESC LIMIT 1";
$resultadoVP = mysqli_query($conexion, $consultaVP) or die(mysqli_error($conexion));
$rvp = $resultadoVP->fetch_all(MYSQLI_ASSOC);

$resc = $conexion->query("SELECT estado_cliente FROM cliente WHERE cod_cliente = '".$id_cli."' ");
$resc = $resc->fetch_all(MYSQLI_ASSOC);

if ($resc[0]['estado_cliente'] == '0') {
	die('<script>M.toast({html: "Usted ha sido bloqueado del servicio."});</script>');
}

if(mysqli_num_rows($resultadoVP)>0){
	if ($rvp[0]['estado_pedido'] == 1) {
		die('<script>M.toast({html: "Usted ya tiene un pedido activo."});</script>');
	}
	if (($_SERVER["REQUEST_TIME"] - strtotime($rvp[0]['fecha_pedido'])) < 1800) {
		die('<script>M.toast({html: "Usted realizó un pedido recientemente, Espere unos minutos."});</script>');
	}
}



// if (intval($telf) < 40000000) {
// 	die('<script>M.toast({html: "Ingrese un número de teléfono válido."});</script>');
// }


$result = $conexion->query("INSERT INTO pedido (cod_cliente, total_pedido, dedicatoria, excepciones, foto_personalizada, fecha_entrega, hora_entrega) VALUES ('".$id_cli."', '".$subtotal."', '".$mensaje."', '".$excepciones."', '".$ruta2."', '".$fecha."', '".$hora."')");

// die(mysqli_error($conexion)."---- error");

if($result){

	$id_pedido = mysqli_insert_id($conexion); 
	foreach ($json as $key => $value) {
		$consulta_detped = "INSERT INTO detalle_pedido (cod_pedido, cod_producto, cant_producto, precio_det_pedido) VALUES (".$id_pedido.", ".$value[0].", ".$value[2].", ".$value[3].")";
		if(!(mysqli_query($conexion, $consulta_detped))) {die(mysqli_error($conexion));}
	}

	die('1');
} else {
	die(mysqli_error($conexion));
}

?>