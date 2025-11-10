<?php

try {
    
    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
    include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
    
    $consultaseguidores="CALL SEARCH_FOLLOWERS(:idfollower)";
    
    $resultado=$conexion->prepare($consultaseguidores);
    
    $resultado->execute(array(":idfollower"=>$_SESSION["iduser"]));
    
    $rows=$resultado->rowCount();
    
    if ($rows>0) {
        
        $resultado->closeCursor();
        
        $actualizaseguidores="CALL UPDATE_FOLLOWERS_DELETE(:idfollowed)";
        
        $resultados=$conexion->prepare($actualizaseguidores);
        
        $resultados->execute(array(":idfollowed"=>$_SESSION["iduser"]));
        
        $resultados->closeCursor();
    }
    
    $consultaseguidor="CALL SEARCH_FOLLOWER(:idfollowed)";
    
    $resultado=$conexion->prepare($consultaseguidor);
    
    $resultado->execute(array(":idfollowed"=>$_SESSION["iduser"]));
    
    $rowst=$resultado->rowCount();
    
    if ($rowst>0) {
        
        $resultado->closeCursor();
        
        $actualizasiguiendo="CALL UPDATE_FOLLOWER_DELETE(:idfollowing)";
        
        $resultados=$conexion->prepare($actualizasiguiendo);
        
        $resultados->execute(array(":idfollowing"=>$_SESSION["iduser"]));
        
        $resultados->closeCursor();
    }
    
    $consultalikes="CALL SEARCH_LIKES(:iduser)";
    
    $resultado=$conexion->prepare($consultalikes);
    
    $resultado->execute(array(":iduser"=>$_SESSION["iduser"]));
    
    $rowsl=$resultado->rowCount();
    
    if ($rowsl>0) {
        
        $resultado->closeCursor();
        
        $actualizalikes="CALL UPDATE_LIKES_DELETE(:iduser)";
            
        $userid=$_SESSION["iduser"];
        
        $resultados=$conexion->prepare($actualizalikes);
        
        $resultados->execute(array(":iduser"=>$userid));
        
        $resultados->closeCursor();
    }
    
    $consultadislikes="CALL SEARCH_DISLIKES(:iduser)";
    
    $resultado=$conexion->prepare($consultadislikes);
    
    $resultado->execute(array(":iduser"=>$_SESSION["iduser"]));
    
    $rowsd=$resultado->rowCount();
    
    if ($rowsd>0) {
        
        $resultado->closeCursor();
        
        $actualizadislikes="CALL UPDATE_DISLIKES_DELETE(:iduser)";
        
        $userid=$_SESSION["iduser"];
        
        $resultados=$conexion->prepare($actualizadislikes);
        
        $resultados->execute(array(":iduser"=>$userid));
        
        $resultados->closeCursor();
    }
    
    $eliminaperfiles="CALL DELETE_PROFILE(:iduser)";
    
    $resultado=$conexion->prepare($eliminaperfiles);
        
    $resultado->execute(array(":iduser"=>$_SESSION["iduser"]));
    
    if ($resultado->rowCount()!=0) {
        
        session_destroy();
        
        header("location:index.php");
    }
    
} catch (Exception $e) {
    
    die("ERROR: " . $e->getMessage());
}

?>