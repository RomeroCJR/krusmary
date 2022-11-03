<?php 
    require('../conexion.php');
    $ci = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $telf = $_POST['telf'];
    $pass = $_POST['pass_registro'];

    $apellidos = explode(" ", $apellidos);
    $ap_paterno = $apellidos[0];
    $ap_materno = NULL;
    if(isset($apellidos[1])){
        $ap_materno = $apellidos[1];
    }
    
    $result = $conexion->query("SELECT * FROM `cliente` WHERE ci_cliente = ".$ci);
    $res = $result->fetch_all(MYSQLI_ASSOC);
    if(mysqli_num_rows($result) > 0){
        if($res[0]['clave_cliente'] != NULL || $res[0]['clave_cliente'] != ""){
            die("0");
        }
    }
    
    if(mysqli_num_rows($result)>0){
        $result = $conexion->query("UPDATE `cliente` SET `nombre_cliente`='".$nombre."',`ap_paterno_cliente`='".$ap_paterno."',`ap_materno_cliente`='".$ap_materno."',`nro_celular_cliente`='".$telf."',`clave_cliente`='".$pass."' WHERE ci_cliente = ".$ci);
    }else{
        $result = $conexion->query("INSERT INTO `cliente`( `ci_cliente`, `nombre_cliente`, `ap_paterno_cliente`, `ap_materno_cliente`, `nro_celular_cliente`, `clave_cliente`) VALUES ('".$ci."','".$nombre."','".$ap_paterno."','".$ap_materno."','".$telf."','".$pass."')");
    }

    if($result){
        echo $result;
    }
?>