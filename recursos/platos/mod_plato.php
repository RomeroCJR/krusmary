<?php
	require('../conexion.php');
	define ('SITE_ROOT', realpath(dirname(__FILE__)));
	$id = $_POST['mod_codpla'];
	$nombre = $_POST['mod_nombre'];
	$precio = $_POST['mod_precio'];
	$descripcion = $_POST['mod_descripcion'];
	$nombreimg = $_FILES['imagen']['name'];
	$archivo = $_FILES['imagen']['tmp_name'];
	$old_pic = $_POST['old_pic'];

	if (!empty($archivo)) {
		$ruta = $_SERVER['DOCUMENT_ROOT']."/sidelex/images";
		$ruta = $ruta."/".$nombreimg;
		move_uploaded_file($archivo, $ruta);
		$ruta2 = "images/".$nombreimg;
	}else{
		$ruta2 = $old_pic;
	}

	$result = $conexion->query("UPDATE `plato` SET `Nombre`='".$nombre."',`Precio`=".$precio.",`Descripcion`='".$descripcion."',`Foto`='".$ruta2."' WHERE Codpla = ".$id);
	if ($result) {
		echo '1';
	}else{
		echo mysqli_error($conexion);
	}

?>