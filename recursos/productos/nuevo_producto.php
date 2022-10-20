<?php
require('../conexion.php');
define ('SITE_ROOT', realpath(dirname(__FILE__)));
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$descripcion = $_POST['descripcion'];
$categoria = $_POST['categoria'];
$nombreimg = $_FILES['imagen']['name'];
$archivo = $_FILES['imagen']['tmp_name'];


// die($nombre.'--'.$precio.'--'.$descripcion.'--'.$categoria.'--'.$nombreimg);

$ruta = $_SERVER['DOCUMENT_ROOT']."/krusmary/images";
// $ruta = "C:/xampp/htdocs/sidelex/images";
$ruta = $ruta."/".$nombreimg;
move_uploaded_file($archivo, $ruta);
$ruta2 = "images/".$nombreimg;

$consulta = "INSERT INTO producto (nombre_producto, precio_producto, descripcion_producto, foto_producto, cod_categoria) VALUES ('".$nombre."', '".$precio."', '".$descripcion."' , '".$ruta2."', '".$categoria."' )";
	if(mysqli_query($conexion, $consulta)){
		$id = mysqli_insert_id($conexion);
		$res = $conexion->query("INSERT INTO `inventario`(`cod_producto`, `stock`) VALUES (".$id.",'0')");
		if ($res) {
			die($res);
		}else{
			die(mysqli_error($conexion));
		}
	} else {
		die(mysqli_error($conexion));
	}
?>