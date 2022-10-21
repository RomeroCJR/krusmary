<?php

require('../conexion.php');
require('../sesiones.php');
session_start();
date_default_timezone_set("America/La_Paz");
$fecha = date("Y-m-d H:i:s");

$cod_usuario = $_SESSION['Cod_usuario'];
$total = $_GET['subtotal'];
$json = json_decode($_GET['json']);

// die(var_dump(json_decode($json)));
if($_GET['sw'] == 1){
	$ci = $_GET['ci']; //DEBE UTULIZARSE EL ID NO EL CI
	$nombre = $_GET['nombre'];
	$apellido_p = $_GET['apellido_p'];
	$apellido_m = $_GET['apellido_m'];
	$telf = $_GET['telf'];
}
// $razon = $_GET['razon'];
// $val = $_GET['value'];

// die(empty($_GET['ci']).'--'.empty($nombre).'--'.empty($apellidos));
// if ($val == '1') {
// 	$apellidos = " ";
// }


$id = 1;
if(!empty($_GET['ci'])){
	// $ci = '1';
	$result = $conexion->query("SELECT * FROM cliente WHERE ci_cliente = ".$ci);
	// $rows = mysqli_num_rows($result);
	if (!empty($result) AND mysqli_num_rows($result) < 1) {
		$insertar_cli = $conexion->query("INSERT INTO cliente (ci_cliente, nombre_cliente, ap_paterno_cliente, ap_materno_cliente, nro_celular_cliente) VALUES (".$ci.", '".$nombre."', '".$apellido_p."', '".$apellido_m."', '".$telf."')");
		if ($insertar_cli) {
			$id = mysqli_insert_id($conexion);
		}else{
			die(mysqli_error($conexion));
		}
	}else{
		$update = $conexion->query('UPDATE cliente SET nombre_cliente = "'.$nombre.'", ap_paterno_cliente = "'.$apellido_p.'", ap_materno_cliente = "'.$apellido_m.'", nro_celular_cliente = "'.$telf.'" WHERE ci_cliente = '.$ci);
		if ($update) {
			$res = $conexion->query("SELECT cod_cliente FROM cliente WHERE ci_cliente = ".$ci);
			$res = mysqli_fetch_assoc($res);
			$id = $res['cod_cliente'];
		}else{
			die(mysqli_error($conexion));
		}
		
	}
	// die($result['Ci'].','.$result['Nombre'].'-'.$result['Apellidos']);
}

// die(mysqli_error($conexion));

// $telf = $_POST['telf'];
// $total = $_POST['tot_ped'];
// $cont = $_POST['cont'];

// $consultaVC = "SELECT * FROM cliente WHERE Ci = ".$ci."";
// $resultadoCVC = mysqli_query($conexion, $consultaVC) or die(mysqli_error($conexion));
// $dvc = mysqli_fetch_array($resultadoCVC);

// if (!$dvc) {
// 	$consultaIC = "INSERT INTO cliente (Ci, Nombre, Apellidos, Telefono) VALUES ('".trim($ci)."', '".trim($nombre)."', '".trim($ap)."', '".trim($telf)."')";
// 	$resultadoCIC = mysqli_query($conexion, $consultaIC) or die(mysql_error());
// }else if (!(trim($ci) == $dvc["Ci"] and trim($nombre) == $dvc["Nombre"] and trim($ap) == $dvc["Apellidos"])) {
//  	die('<script>Materialize.toast("El número de cédula no coincide con el nombre y apellidos." , 4000);</script>');
// }

//DEBE UTILIZARSE EL ID PARA LA INSERCION NO EL CI...
$consulta = "INSERT INTO venta(cod_usuario, cod_cliente, fecha_venta, total_venta) VALUES(".$cod_usuario.", ".$id.", '".$fecha."', ".$total.")";
	if(mysqli_query($conexion, $consulta)){

		// $cOC = "SELECT MAX(Codv) as codv FROM venta WHERE Cicli = '".$ci."' AND Estado = 1";
		// $rCOC = mysqli_query($conexion, $cOC) or die(mysqli_error($conexion));
		// $roc = mysqli_fetch_array($rCOC);
		$lastid = mysqli_insert_id($conexion);
		// for ($v=0; $v < $cont; $v++) { 
		// 	$cDV = "INSERT INTO det_plato (Codpla, Codv, Cantidad, Precio) VALUES (".$_POST[$v].", ".$roc['codv'].", ".$_POST[$v.'c'].", (SELECT Precio FROM plato WHERE Codpla = ".$_POST[$v]."))";
		// 	if(!(mysqli_query($conexion, $cDV))) {die($_POST[$v]."--".$roc['codv']."--".$_POST[$v.'c']);}
		// }
		//(SELECT precio_producto FROM producto WHERE cod_producto = ".$value[0].") <-- ESTO ERA PRECIO PRODUCTO EN LA SIGUIENTE LINEA
		foreach ($json as $key => $value) {
			$consulta_detven = "INSERT INTO detalle_venta (cod_producto, cod_venta, cant_producto, precio_det_venta) VALUES (".$value[0].", ".$lastid.", ".$value[2].", ".$value[3].")";
			if(!(mysqli_query($conexion, $consulta_detven))) {
				die(mysqli_error($conexion));
			}
		}

		die($lastid.'');
	} else {
		die(mysqli_error($conexion));
	}




// die($ci."--".$nombre."--".$ap."--".$telf."--".$total."--".$cont."--".$_POST['1']."--".$_POST['1c']);

?>