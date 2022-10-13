<?php
require('../conexion.php');

$telf = $_GET["telf"]; 
$telf = "+".$telf;

//Consulta registrar numero de celular si es que no existe
$result = $conexion->query("SELECT * FROM cliente WHERE Telefono = ".$telf);
$res = $result->fetch_assoc();

if ($res['Estado'] == '0') {
	die('ban');
}

if(mysqli_num_rows($result) > 0){
	session_start();
	$_SESSION['id_cliente'] = $res['id'];	
	$_SESSION['estado_app'] = 'Autenticado';
	$_SESSION['telf'] = $telf;
	die("1");
}

die("proceder con el registro");

?>
