<?php 

session_start();

if (isset($_SESSION["idusu"])) {
    
    try {
        
        $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
        
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $conexion->exec("SET CHARACTER SET utf8");
        
        $id=$_GET["id"];
        
        $consultacantidadcanciones="CALL UPDATE_SONGS_COUNT_SUBTRACTION(:iduser)";
        
        $resultado=$conexion->prepare($consultacantidadcanciones);
        
        $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
        
        $consulta="CALL DELETE_SONG(:idsong)";
        
        $resultado=$conexion->prepare($consulta);
        
        $resultado->execute(array(":idsong"=>$id));
        
        $cantidad=$resultado->rowCount();
        
        if ($cantidad!=0) {
            
            header("location:cuenta.php");
        }
        
    } catch (Exception $e) {
        
        die("Error: " . $e->getMessage());
    }
    
}else {
    
    header("location:index.php");
}

?>