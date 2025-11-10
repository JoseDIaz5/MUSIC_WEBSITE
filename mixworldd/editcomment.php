<?php

    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
    try {
        
        include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
        
        $commentid=$_POST["id"];
        
        $comment=$_POST["comment"];
        
        $consultaedita="CALL UPDATE_COMMENT(:comment,:idc)";
        
        $resultado=$conexion->prepare($consultaedita);
        
        $resultado->execute(array(":comment"=>$comment,":idc"=>$commentid));
        
        $getcomment="CALL GET_COMMENT(:idc)";
        
        $resultado=$conexion->prepare($getcomment);
        
        $resultado->execute(array(":idc"=>$commentid));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
            
            $editedcomment=$fila["COMENTARIO"];
        }
        
        $datos=array('editedcomment'=>$editedcomment);
        
        echo json_encode($datos);
        
    } catch (Exception $e) {
        
        die("Error: " . $e->getMessage());
    }

?>