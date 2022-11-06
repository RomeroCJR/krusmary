<?php 
require('../sesiones.php');
require('../conexion.php');
session_start();
date_default_timezone_set("America/La_Paz");
$fecha_actual = date("Y-m-d H:i:s");
$id = $_SESSION['cod_cliente'];


function fechaString ($fecha) {
  $fecha = substr($fecha, 0, 10);
  $numeroDia = date('d', strtotime($fecha));
  $dia = date('l', strtotime($fecha));
  $mes = date('F', strtotime($fecha));
  $anio = date('Y', strtotime($fecha));
  $dias_ES = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
  $dias_EN = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  $nombredia = str_replace($dias_EN, $dias_ES, $dia);
$meses_ES = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
  $meses_EN = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
  $nombreMes = str_replace($meses_EN, $meses_ES, $mes);
  return $nombredia." ".$numeroDia." de ".$nombreMes." de ".$anio;
}


$consulta = "SELECT * FROM pedido WHERE cod_cliente = '".$id."' ORDER BY cod_pedido DESC LIMIT 1;";
$resultadoVP = mysqli_query($conexion, $consulta) or die(mysqli_error($conexion));
$rvp = mysqli_fetch_array($resultadoVP);

// $_SERVER["REQUEST_TIME"]

$nuevo = strtotime($rvp['fecha_entrega'].' '.$rvp['hora_entrega']) - strtotime($fecha_actual);
// die(strtotime($rvp['fecha_entrega'].' '.$rvp['hora_entrega']).'-----------'.strtotime($fecha_actual));
// die($nuevo.'---'.$fecha_actual.'----'.$rvp['fecha_entrega'].' '.$rvp['hora_entrega']);

if (($nuevo > 1800)  && ($rvp['estado_pedido'] == '0')) {
	$array = $rvp['total_pedido'].",".$rvp['fecha_pedido'].",".$rvp['cod_pedido'].",ACEPTADO,".fechaString($rvp['fecha_entrega']).",".date("H:m:s", strtotime($rvp['hora_entrega']));
	die($array);
}


if ($rvp['estado_pedido'] == 1) {

	$array = $rvp['total_pedido'].",".$rvp['fecha_pedido'].",".$rvp['cod_pedido'].",PENDIENTE,".fechaString($rvp['fecha_entrega']).",".date("H:m:s", strtotime($rvp['hora_entrega']));
	die($array);
}

if ($rvp['estado_pedido'] == 2) {

	$array = $rvp['total_pedido'].",".$rvp['fecha_pedido'].",".$rvp['cod_pedido'].",RECHAZADO,".fechaString($rvp['fecha_entrega']).",".date("H:m:s", strtotime($rvp['hora_entrega']));
	die($array);
}else{
	die("sinpedidos");
}




?>