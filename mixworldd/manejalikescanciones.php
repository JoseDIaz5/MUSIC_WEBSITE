<?php 

session_start();
   
if (!isset($_SESSION["idusu"])) {
    
    header("location:index.php");
}

try {
    
    $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    
    $conexion->exec("SET CHARACTER SET utf8");
    
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $idcancion=$_POST["id"];
    
    $idusuario=$_SESSION["idusu"];
    
    $consultadislikescanciones="CALL SEARCH_ID_DISLIKES(:idsong,:iduser)";
    
    $resultado=$conexion->prepare($consultadislikescanciones);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $row=$resultado->rowCount();
    
    if ($row>0) {
        
        $eliminadislikecancion="CALL DELETE_DISLIKES(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($eliminadislikecancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacanciones="CALL UPDATE_DISLIKES_SUBTRACTION(:idsong)";
        
        $resultado=$conexion->prepare($actualizacanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $cantidaddislikes="CALL GET_DISLIKES(:idsong)";
        
        $resultado=$conexion->prepare($cantidaddislikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $nomegustascanciones=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-regular fa-face-sad-tear'></i>" . $nomegustascanciones;
    }
    else {
        
        $cantidaddislikes="CALL GET_DISLIKES(:idsong)";
        
        $resultado=$conexion->prepare($cantidaddislikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $nomegustascanciones=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-regular fa-face-sad-tear'></i>" . $nomegustascanciones;
    }
    
    //-----------------------------------------------------------------------------------------------------------------------
    
    $consultacantidadlikes="CALL SEARCH_ID_LIKES(:idsong,:iduser)";
    
    $resultado=$conexion->prepare($consultacantidadlikes);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $cantidad=$resultado->rowCount();
    
    if ($cantidad<1) {
        
        $insertalikescanciones="CALL INSERT_LIKE(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($insertalikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="CALL UPDATE_LIKES_ADDITION(:idsong)";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $likescanciones="CALL GET_LIKES(:idsong)";
        
        $resultado=$conexion->prepare($likescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $likes=$fila["LIKES"];
        }
        
        $like="<i class='fa-solid fa-face-smile-wink'></i>" . $likes;
    }else{
        
        $eliminalikescancion="CALL DELETE_LIKES(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($eliminalikescancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="CALL UPDATE_LIKES_SUBTRACTION(:idsong)";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $likescanciones="CALL GET_LIKES(:idsong)";
        
        $resultado=$conexion->prepare($likescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $likes=$fila["LIKES"];
        }
        
        $like="<i class='fa-regular fa-face-smile-wink'></i>" . $likes;
    }
    
    $datos=array('like'=>$like,'dlike'=>$dislike);
    
    echo json_encode($datos);
    
} catch (Exception $e) {
    
    die("Error: " . $e->getMessage());
}   

?>