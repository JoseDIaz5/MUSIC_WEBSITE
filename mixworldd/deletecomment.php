<?php

session_start();

if (isset($_SESSION["idusu"])) {
    
    try {
        
        $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
        
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $conexion->exec("SET CHARACTER SET utf8");
        
        $id=$_GET["id"];
        
        $idsong=$_GET["idsong"];
        
        $consulta="CALL DELETE_COMMENT(:idcomment)";
        
        $resultado=$conexion->prepare($consulta);
        
        $resultado->execute(array(":idcomment"=>$id));
        
        $cantidad=$resultado->rowCount();
        
        if ($cantidad!=0) {
            
            header("location:cancion.php?id=$idsong");
        }
        
    } catch (Exception $e) {

        die("Error: " . $e->getMessage());
    }
    
}else {
    
    header("location:index.php");
}

?>