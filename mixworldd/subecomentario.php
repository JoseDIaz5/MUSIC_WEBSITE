<?php

try{
    
    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
    include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
    
    $comenta=$_POST["comenta"];
    
    $idcancion=$_SESSION["idcancion"];
    
    $idsong=$_SESSION["idsong"];
    
    $idusuario=$_SESSION["iduser"];
    
    date_default_timezone_set("America/Costa Rica");
    
    $fechacomentario=date("d/m/Y");
    
    $consulta="CALL INSERT_COMMENTS(:idsong,:iduser,:comment)";
    
    $resultado=$conexion->prepare($consulta);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario,":comment"=>$comenta));
    
    header("location:cancion.php?song=" . $idsong);
    
}catch(Exception $e){
    
    die("ERROR: " . $e->getMessage() . " " . $e->getLine());
}

?>