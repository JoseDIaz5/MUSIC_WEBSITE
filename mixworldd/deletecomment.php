<?php

session_start();

if (isset($_SESSION["idusu"])) {
    
    try {
        
        include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
        
        $id=$_GET["id"];
        
        $idsong=$_GET["idsong"];
        
        $consulta="CALL DELETE_COMMENT(:idcomment)";
        
        $resultado=$conexion->prepare($consulta);
        
        $resultado->execute(array(":idcomment"=>$id));
        
        $cantidad=$resultado->rowCount();
        
        if ($cantidad!=0) {
            
            header("location:cancion.php?song=".$_SESSION['idsong']);
        }
        
    } catch (Exception $e) {

        die("Error: " . $e->getMessage());
    }
    
}else {
    
    header("location:index.php");
}

?>