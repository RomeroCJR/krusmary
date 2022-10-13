<?php
require('../conexion.php');
define ('SITE_ROOT', realpath(dirname(__FILE__)));
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$descripcion = $_POST['descripcion'];
$nombreimg = $_FILES['imagen']['name'];
$archivo = $_FILES['imagen']['tmp_name'];


$ruta = $_SERVER['DOCUMENT_ROOT']."/sidelex/images";
// $ruta = "C:/xampp/htdocs/sidelex/images";
$ruta = $ruta."/".$nombreimg;
move_uploaded_file($archivo, $ruta);
$ruta2 = "images/".$nombreimg;

$consulta = "INSERT INTO plato (Nombre, Precio, Descripcion, Foto) VALUES ('".$nombre."', '".$precio."', '".$descripcion."' , '".$ruta2."')";
	if(mysqli_query($conexion, $consulta)){
		$id = mysqli_insert_id($conexion);
		$res = $conexion->query("INSERT INTO `stock`(`Codpla`, `Stock`) VALUES (".$id.",'0')");
		if ($res) {
			die('1');
		}else{
			die(mysqli_error($conexion));
		}
	} else {
		die(mysqli_error($conexion));
	}
?>