<?php 
require('../conexion.php');
$cod = $_POST['codx'];



	$Sql = "SELECT a.Codv, a.idcli, a.Total, b.Ci, b.Nombre, b.Apellidos, b.Telefono FROM venta a, cliente b WHERE a.Codv = ".$cod." AND a.idcli = b.id;";
	$resultado = mysqli_query($conexion, $Sql) or die(mysqli_error($conexion));
	$datos = mysqli_fetch_assoc($resultado);

	die(json_encode($datos));

// die($datos['Codv'].",".$datos['Cicli'].",".$datos['Total'].",".$datos['Nombre'].",".$datos['Apellidos'].",".$datos['Telefono']);

?>