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
    
    $consultalikescanciones="CALL SEARCH_ID_LIKES(:idsong,:iduser)";
    
    $resultado=$conexion->prepare($consultalikescanciones);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $row=$resultado->rowCount();
    
    if($row>0){
        
        $eliminalikecancion="CALL DELETE_LIKES(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($eliminalikecancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacanciones="CALL UPDATE_LIKES_SUBTRACTION(:idsong)";
        
        $resultado=$conexion->prepare($actualizacanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $cantidadlikes="CALL GET_LIKES(:idsong)";
        
        $resultado=$conexion->prepare($cantidadlikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $megustacanciones=$fila["LIKES"];
        }
        
        $like="<i class='fa-regular fa-face-smile-wink'></i>" . $megustacanciones;
    }
    else {
        
        $cantidadlikes="CALL GET_LIKES(:idsong)";
        
        $resultado=$conexion->prepare($cantidadlikes);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $megustacanciones=$fila["LIKES"];
        }
        
        $like="<i class='fa-regular fa-face-smile-wink'></i>" . $megustacanciones;
    }
    
    //-----------------------------------------------------------------------------------------------------------------------------
    
    $consultacantidaddislikes="CALL SEARCH_ID_DISLIKES(:idsong,:iduser)";
    
    $resultado=$conexion->prepare($consultacantidaddislikes);
    
    $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
    
    $cantidad=$resultado->rowCount();
    
    if ($cantidad<1) {
        
        $insertadislikescanciones="CALL INSERT_DISLIKE(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($insertadislikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="CALL UPDATE_DISLIKES_ADDITION(:idsong)";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $dislikescanciones="CALL GET_DISLIKES(:idsong)";
        
        $resultado=$conexion->prepare($dislikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $dislikes=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-solid fa-face-sad-tear'></i>" . $dislikes;
    }else {
        
        $eliminadislikescancion="CALL DELETE_DISLIKES(:idsong,:iduser)";
        
        $resultado=$conexion->prepare($eliminadislikescancion);
        
        $resultado->execute(array(":idsong"=>$idcancion,":iduser"=>$idusuario));
        
        $actualizacioncanciones="CALL UPDATE_DISLIKES_SUBTRACTION(:idsong)";
        
        $resultado=$conexion->prepare($actualizacioncanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        $dislikescanciones="CALL GET_DISLIKES(:idsong)";
        
        $resultado=$conexion->prepare($dislikescanciones);
        
        $resultado->execute(array(":idsong"=>$idcancion));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $dislikes=$fila["DISLIKES"];
        }
        
        $dislike="<i class='fa-regular fa-face-sad-tear'></i>" . $dislikes;
    }
    
    $datos=array('like'=>$like,'dlike'=>$dislike);
    
    echo json_encode($datos);
    
} catch (Exception $e) {

    die("Error: " . $e->getMessage());
}

?>