<?php

session_start();

if (!isset($_SESSION["idusu"])) {
    
    header("location:index.php");
}

try {
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idusuarioseguido=$_POST["id"];
    
    $idusuarioseguidor=$_SESSION["idusu"];
    
    $consultaseguidores="CALL SEARCH_ID_FOLLOWERS(:follower,:followed)";
    
    $resultado=$conexion->prepare($consultaseguidores);
    
    $resultado->execute(array(":follower"=>$idusuarioseguidor,":followed"=>$idusuarioseguido));
    
    $row=$resultado->rowCount();
    
    if ($row>0) {
        
        $eliminaseguidor="CALL DELETE_FOLLOWERS(:follower,:followed)";
        
        $resultado=$conexion->prepare($eliminaseguidor);
        
        $resultado->execute(array(":follower"=>$idusuarioseguidor,":followed"=>$idusuarioseguido));
        
        $actualizaseguidores="CALL UPDATE_FOLLOWERS_SUBTRACTION(:idfollowed)";
        
        $resultado=$conexion->prepare($actualizaseguidores);
        
        $resultado->execute(array(":idfollowed"=>$idusuarioseguido));
        
        $actualizaseguidor="CALL UPDATE_FOLLOWING_SUBTRACTION(:idfollower)";
        
        $resultado=$conexion->prepare($actualizaseguidor);
        
        $resultado->execute(array(":idfollower"=>$idusuarioseguidor));
        
        $valorseguir="Seguir";
    }else {
        
        $insertaseguidor="CALL INSERT_FOLLOWERS(:idfollower,:idfollowed)";
        
        $resultado=$conexion->prepare($insertaseguidor);
        
        $resultado->execute(array(":idfollower"=>$idusuarioseguidor,":idfollowed"=>$idusuarioseguido));
        
        $actualizaseguidores="CALL UPDATE_FOLLOWERS_ADDITION(:idfollowed)";
        
        $resultado=$conexion->prepare($actualizaseguidores);
        
        $resultado->execute(array(":idfollowed"=>$idusuarioseguido));
        
        $actualizaseguidor="CALL UPDATE_FOLLOWING_ADDITION(:idfollower)";
        
        $resultado=$conexion->prepare($actualizaseguidor);
        
        $resultado->execute(array(":idfollower"=>$idusuarioseguidor));
        
        $valorseguir="Siguiendo";
    }
    
    $datos=array("siguiendo"=>$valorseguir);
    
    echo json_encode($datos);
    
} catch (Exception $e) {
    
    die("Error: " . $e->getMessage());
}

?>