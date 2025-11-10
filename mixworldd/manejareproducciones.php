<?php 

session_start();

try {
    
    include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
    
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