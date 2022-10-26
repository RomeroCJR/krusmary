<?php 
	require('../conexion.php');

	$idcli = $_GET['idcli'];
	$codped = $_GET['codped'];

	$res = $conexion->query('SELECT estado_cliente FROM cliente WHERE cod_cliente = '.$idcli);
	$res = $res->fetch_all(MYSQLI_ASSOC);

	$status = '';
	if ($res[0]['estado_cliente'] == '1') {
		$result = $conexion->query('UPDATE cliente SET estado_cliente = 0 WHERE cod_cliente = '.$idcli);
		$status = 'Desbloquear cliente';
	}else{
		$result = $conexion->query('UPDATE cliente SET estado_cliente = 1 WHERE cod_cliente = '.$idcli);
		$status = 'Bloquear cliente';
	}

	
	// $res = $conexion->query("UPDATE pedido SET Estado = 2 WHERE Codped = ".$codped);

	if ($result) {
		echo $status;
	}else{
		echo mysqli_error($conexion);
	}
?>
