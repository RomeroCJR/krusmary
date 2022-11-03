<?php
	
//Conectamos a la base de datos
require('../conexion.php');

//Obtenemos los datos del formulario de acceso
$ci_cliente = $_POST['usuario'];
$pass = $_POST['pass'];


$result = $conexion->query("SELECT * FROM cliente WHERE ci_cliente = '".$ci_cliente."' AND clave_cliente = '".$pass."'");
$res = $result->fetch_all(MYSQLI_ASSOC);
if(mysqli_num_rows($result) > 0){

	session_start();

	$_SESSION['cod_cliente'] = $res[0]['cod_cliente'];
	$_SESSION['nombre_cliente'] = $res[0]['nombre_cliente'];
	$_SESSION['apellidos_cliente'] = $res[0]['ap_paterno_cliente']." ".$res[0]['ap_materno_cliente'];
	$_SESSION['ap_paterno_cliente'] = $res[0]['ap_paterno_cliente'];
	$_SESSION['ap_materno_cliente'] = $res[0]['ap_materno_cliente'];
	$_SESSION['telf_cliente'] = $res[0]['nro_celular_cliente'];
	$_SESSION['clave_cliente'] = $res[0]['clave_cliente'];
	$_SESSION['estado_app'] = 'Autenticadox';

	die('1');
	/* Sesión iniciada, si se desea, se puede redireccionar desde el servidor */

} else {
	die(mysqli_error($conexion));
}

?>
