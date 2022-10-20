<?php
	require('../conexion.php');
	define ('SITE_ROOT', realpath(dirname(__FILE__)));
	$id = $_POST['mod_codpro'];
	$nombre = $_POST['mod_nombre'];
	$precio = $_POST['mod_precio'];
	$descripcion = $_POST['mod_descripcion'];
	$categoria = $_POST['mod_categoria'];
	$nombreimg = $_FILES['imagen']['name'];
	$archivo = $_FILES['imagen']['tmp_name'];
	$old_pic = $_POST['old_pic'];

	if (!empty($archivo)) {
		$ruta = $_SERVER['DOCUMENT_ROOT']."/krusmary/images";
		$ruta = $ruta."/".$nombreimg;
		move_uploaded_file($archivo, $ruta);
		$ruta2 = "images/".$nombreimg;
	}else{
		$ruta2 = $old_pic;
	}

	$result = $conexion->query("UPDATE `producto` SET `nombre_producto`='".$nombre."',`precio_producto`=".$precio.",`descripcion_producto`='".$descripcion."', `foto_producto`='".$ruta2."', `cod_categoria`='".$categoria."' WHERE cod_producto = ".$id);
	if ($result) {
		echo $result;
	}else{
		echo mysqli_error($conexion);
	}

?>