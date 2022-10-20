<?php 
    require('../conexion.php');
    $id = $_POST['mod_id'];
    $nombre = $_POST['mod_nombre'];
    $des = $_POST['mod_des'];
    
    $result = $conexion->query("UPDATE `rol` SET `nombre_rol`='".$nombre."',`descripcion_rol`='".$des."' WHERE cod_rol = ".$id);
    if($result){
        echo $result;
    }else{
        echo mysqli_error($conexion);
    }

?>