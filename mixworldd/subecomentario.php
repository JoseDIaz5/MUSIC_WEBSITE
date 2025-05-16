<?php

try{
    
    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $comenta=$_POST["comenta"];
    
    $idcancion=$_SESSION["idcancion"];
    
    $idusuario=$_SESSION["idusu"];
    
    date_default_timezone_set("America/Costa Rica");
    
    $fechacomentario=date("d/m/Y");
    
    $consulta="CALL INSERT_COMMENTS(:idsong,:iduser,:comment,:date)";
    
    $resultado=$conexion->prepare($consulta);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario,":comment"=>$comenta,":date"=>$fechacomentario));
    
    header("location:cancion.php?id=" . $idcancion);
    
}catch(Exception $e){
    
    die("ERROR: " . $e->getMessage() . " " . $e->getLine());
}

?>