<?php 
    require('../conexion.php');

    $id = $_GET['id'];
    
    $result = $conexion->query("UPDATE `usuario` SET `estado_usuario`= '1' WHERE cod_usuario = ".$id);
    
    if($result){
        die($result);
    }else{
        die(mysqli_error($conexion));
    }

?>