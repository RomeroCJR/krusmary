<?php

require('../conexion.php');
require('../sesiones.php');
session_start();

$ciusu = $_SESSION['Ci_Usuario'];
$total = $_GET['subtotal'];
$json = json_decode($_GET['json']);

// die(var_dump(json_decode($json)));

$ci = $_GET['ci']; //DEBE UTULIZARSE EL ID NO EL CI
$nombre = $_GET['nombre'];
$apellidos = $_GET['apellidos'];
$telf = $_GET['telf'];
// $razon = $_GET['razon'];
$val = $_GET['value'];

// die(empty($_GET['ci']).'--'.empty($nombre).'--'.empty($apellidos));
if ($val == '1') {
	$apellidos = " ";
}


$id = 1;
if(!empty($_GET['ci'])){
	// $ci = '1';
	$result = $conexion->query("SELECT * FROM cliente WHERE Ci = ".$ci);
	// $rows = mysqli_num_rows($result);
	if (!empty($result) AND mysqli_num_rows($result) < 1) {
		$insertar_cli = $conexion->query("INSERT INTO cliente (Ci, Nombre, Apellidos, Telefono, tipo) VALUES (".$ci.", '".$nombre."', '".$apellidos."', '".$telf."',".$val.")");
		if ($insertar_cli == 1) {+
			$id = mysqli_insert_id($conexion);
		}else{
			die(mysqli_error($conexion));
		}
	}else{
		$update = $conexion->query('UPDATE cliente SET Nombre = "'.$nombre.'", Apellidos = "'.$apellidos.'", Telefono = "'.$telf.'", tipo = '.$val.' WHERE Ci = '.$ci);
		if ($update == 1) {
			$res = $conexion->query("SELECT id FROM cliente WHERE Ci = ".$ci);
			$res = mysqli_fetch_assoc($res);
			$id = $res['id'];
		}else{
			die(mysqli_error($conexion));
		}
		
	}
	// die($result['Ci'].','.$result['Nombre'].'-'.$result['Apellidos']);
}


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
$consulta = "INSERT INTO venta(Ciusu, idcli, Total) VALUES(".$ciusu.", ".$id.", ".$total.")";
	if(mysqli_query($conexion, $consulta)){

		// $cOC = "SELECT MAX(Codv) as codv FROM venta WHERE Cicli = '".$ci."' AND Estado = 1";
		// $rCOC = mysqli_query($conexion, $cOC) or die(mysqli_error($conexion));
		// $roc = mysqli_fetch_array($rCOC);
		$lastid = mysqli_insert_id($conexion);
		// for ($v=0; $v < $cont; $v++) { 
		// 	$cDV = "INSERT INTO det_plato (Codpla, Codv, Cantidad, Precio) VALUES (".$_POST[$v].", ".$roc['codv'].", ".$_POST[$v.'c'].", (SELECT Precio FROM plato WHERE Codpla = ".$_POST[$v]."))";
		// 	if(!(mysqli_query($conexion, $cDV))) {die($_POST[$v]."--".$roc['codv']."--".$_POST[$v.'c']);}
		// }

		foreach ($json as $key => $value) {
			$consulta_detven = "INSERT INTO det_plato (Codpla, Codv, Cantidad, Precio) VALUES (".$value[0].", ".$lastid.", ".$value[2].", (SELECT Precio FROM plato WHERE Codpla = ".$value[0]."))";
			if(!(mysqli_query($conexion, $consulta_detven))) {die('<script>M.toast({html: "Error en consulta inserción detalle pedido"});</script>');}
		}

		die($lastid.'');
	} else {
		die('error');
	}




// die($ci."--".$nombre."--".$ap."--".$telf."--".$total."--".$cont."--".$_POST['1']."--".$_POST['1c']);

?>