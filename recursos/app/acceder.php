<?php
	
//Conectamos a la base de datos
require('../conexion.php');

//Obtenemos los datos del formulario de acceso
$telf = $_GET["telf"]; 
$telf = "+".$telf;

//Consulta registrar numero de celular si es que no existe
$result = $conexion->query("INSERT INTO `cliente`(`Telefono`) VALUES ('".$telf."')");

if($result == 1){

	session_start();
	// $_SESSION['telfcli'] = $telf;
	// $consultaNA = "SELECT Nombre, Apellidos, Telefono FROM cliente WHERE Telefono = ".$telf;
	// $resultadoNA = mysqli_query($conexion, $consultaNA);
	// if(empty($resultadoNA)){
	// 	$datosNA = array('Nombre' => '', 'Apellidos' => '', 'Telefono' => '', 'estado' => '');
	// }else{
	// 	$datosNA = mysqli_fetch_array($resultadoNA) or die("Error...");
	// }
	
	// $_SESSION['Nombre'] = $datosNA['Nombre'];
	// $_SESSION['Apellidos'] = $datosNA['Apellidos'];

	$_SESSION['id_cliente'] = mysqli_insert_id($conexion); 
	$_SESSION['estado_app'] = 'Autenticado';
	$_SESSION['telf'] = $telf;

	die("1");
	/* Sesión iniciada, si se desea, se puede redireccionar desde el servidor */

} else {
	die('<script>console.log("ocurrió algun tipo de error")</script>');
}

?>
