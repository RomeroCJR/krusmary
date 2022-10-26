<?php 
require('../conexion.php');
require('../factura/CodigoControlV7.php');


$data_arr = $_GET['data_arr'];
$data = json_decode($data_arr);
// die( ($data_arr->autx));

$codv = $data->codped; //para bd factura
$fecha = $data->fechax; //para bd factura
$hora = $data->horax; //para bd factura
// die($fecha.' '.$hora);
$nit_cliente = $data->cix; //para bd factura
$numero_autorizacion = $data->autx;
$fecha_c = $data->fechax;
$monto_compra = $data->montox;
$clave = $data->llavex;
$monto_compra = str_replace('.',',',$monto_compra);

$result = $conexion->query('SELECT cod_cliente FROM cliente WHERE ci_cliente = '.$nit_cliente);
$result = $result->fetch_all(MYSQLI_ASSOC);
$cod_cli = $result[0]['cod_cliente'];


$fecha_compra = strtotime(str_replace("/", "-", $fecha_c));

$consultaNumFac = "SELECT count(*) as numfac FROM factura WHERE estado_factura = 1";
$resultadoConsultaNF = mysqli_query($conexion, $consultaNumFac) or die(mysqli_error($conexion));
$datosCNF = mysqli_fetch_array($resultadoConsultaNF);

$numero_factura = (int)$datosCNF['numfac'] + 1; //para bd factura
// die($numero_autorizacion." ".$numero_factura." ".$nit_cliente." ".$fecha_compra." ".$monto_compra." ".$clave);
$codigo_control = CodigoControlV7::generar($numero_autorizacion, $numero_factura, $nit_cliente, $fecha_compra, $monto_compra, $clave);


// die($codped.",".$fecha.",".$hora.",".$nit_cliente.",".$numero_factura);

$consultaInsertarNuevaFactura = "INSERT INTO factura (cod_talonario, cod_venta, cod_cliente, fecha_factura, hora_factura, nro_factura) VALUES((SELECT MAX(cod_talonario) FROM talonario WHERE estado_talonario = 1), ".$codv.", ".$cod_cli.", '".$fecha."', '".$hora."', ".$numero_factura.")";

	if(mysqli_query($conexion, $consultaInsertarNuevaFactura)){
		$result = $conexion->query("UPDATE `talonario` SET `cantidad_emitida`= ".$numero_factura." WHERE cod_talonario = (SELECT MAX(cod_talonario))");	
		if ($result) {
			die($codigo_control.','.$numero_factura);
		}
		
	} else {
		die(mysqli_error($conexion));
	}






?>