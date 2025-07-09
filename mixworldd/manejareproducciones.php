<?php 

session_start();

try {
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idcancion=$_POST["id"];
    
    $insertareproducciones="CALL UPDATE_PLAYBACKS(:idsong)";
    
    $resultado=$conexion->prepare($insertareproducciones);
    
    $resultado->execute(array(":idsong"=>$idcancion));
    
    $consultareproducciones="CALL GET_PLAYBACKS(:idsong)";
    
    $resultado=$conexion->prepare($consultareproducciones);
    
    $resultado->execute(array(":idsong"=>$idcancion));
    
    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
        
        $reproducciones=$fila["REPRODUCCIONES"];
    }
    
    $cantidad="<i class='fa-solid fa-ear-listen'></i>" . $reproducciones;
    
    $datos=array("cantidad"=>$cantidad);
    
    echo json_encode($datos);
    
} catch (Exception $e) {
    
    die("Error: " . $e->getMessage());
}

if (!isset($_SESSION["idusu"])) {
    
    session_destroy();
}

?>