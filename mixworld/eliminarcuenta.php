<?php

try {
    
    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $consultaseguidores="CALL SEARCH_FOLLOWERS(:idfollower)";
    
    $resultado=$conexion->prepare($consultaseguidores);
    
    $resultado->execute(array(":idfollower"=>$_SESSION["idusu"]));
    
    $rows=$resultado->rowCount();
    
    if ($rows>0) {
        
        $resultado->closeCursor();
        
        $actualizaseguidores="CALL UPDATE_FOLLOWERS_DELETE(:idfollowed)";
        
        $resultados=$conexion->prepare($actualizaseguidores);
        
        $resultados->execute(array(":idfollowed"=>$_SESSION["idusu"]));
        
        $resultados->closeCursor();
    }
    
    $consultaseguidor="CALL SEARCH_FOLLOWER(:idfollowed)";
    
    $resultado=$conexion->prepare($consultaseguidor);
    
    $resultado->execute(array(":idfollowed"=>$_SESSION["idusu"]));
    
    $rowst=$resultado->rowCount();
    
    if ($rowst>0) {
        
        $resultado->closeCursor();
        
        $actualizasiguiendo="CALL UPDATE_FOLLOWER_DELETE(:idfollowing)";
        
        $resultados=$conexion->prepare($actualizasiguiendo);
        
        $resultados->execute(array(":idfollowing"=>$_SESSION["idusu"]));
        
        $resultados->closeCursor();
    }
    
    $consultalikes="CALL SEARCH_LIKES(:iduser)";
    
    $resultado=$conexion->prepare($consultalikes);
    
    $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
    
    $rowsl=$resultado->rowCount();
    
    if ($rowsl>0) {
        
        $resultado->closeCursor();
        
        $actualizalikes="CALL UPDATE_LIKES_DELETE(:iduser)";
            
        $userid=$_SESSION["idusu"];
        
        $resultados=$conexion->prepare($actualizalikes);
        
        $resultados->execute(array(":iduser"=>$userid));
        
        $resultados->closeCursor();
    }
    
    $consultadislikes="CALL SEARCH_DISLIKES(:iduser)";
    
    $resultado=$conexion->prepare($consultadislikes);
    
    $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
    
    $rowsd=$resultado->rowCount();
    
    if ($rowsd>0) {
        
        $resultado->closeCursor();
        
        $actualizadislikes="CALL UPDATE_DISLIKES_DELETE(:iduser)";
        
        $userid=$_SESSION["idusu"];
        
        $resultados=$conexion->prepare($actualizadislikes);
        
        $resultados->execute(array(":iduser"=>$userid));
        
        $resultados->closeCursor();
    }
    
    $eliminaperfiles="CALL DELETE_PROFILE(:iduser)";
    
    $resultado=$conexion->prepare($eliminaperfiles);
        
    $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
    
    if ($resultado->rowCount()!=0) {
        
        session_destroy();
        
        header("location:index.php");
    }
    
} catch (Exception $e) {
    
    die("ERROR: " . $e->getMessage());
}

?>