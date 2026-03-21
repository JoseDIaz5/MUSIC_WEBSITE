<?php 

    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
    try{
        
        include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
        
        $iduser=$_SESSION["idusu"];
        
        $title=$_POST["titulo"];
        
        $desc=$_POST["area"];
        
        $derechos=intval($_POST["confirmacionderechos"]);
        
        $nombrec=$_FILES['song']['name'];
        
        $imagencan=$_FILES['imagesong']['name'];
        
        $tipocancion=$_FILES['song']['type'];
        
        $tipoimg=$_FILES['imagesong']['type'];
        
        $token=bin2hex(random_bytes(16));
        
        $token_hash=hash("sha256", $token);
        
        $carpeta=$_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/songs/";
        
        move_uploaded_file($_FILES['song']['tmp_name'], $carpeta.$nombrec);
        
        move_uploaded_file($_FILES['imagesong']['tmp_name'], $carpeta.$imagencan);
        
        $consulta="CALL INSERT_SONG(:id_usu,:h,:title,:cancion,:desc,:imgcan,:permission)";
        
        $consultados="CALL SEARCH_ID_PROFILE(:idusuario)";
        
        $consultatres="CALL UPDATE_SONGS_COUNT_ADDITION(:iduser)";
        
        if($tipocancion=="audio/mpeg" || $tipocancion=="audio/flac"  || $tipocancion=="audio/wav"  || $tipocancion=="audio/x-m4a"){
            
            if($tipoimg=="image/jpg" || $tipoimg=="image/jpeg" || $tipoimg=="image/png" || $tipoimg==""){
                
                $resultado=$conexion->prepare($consultados);
                
                $resultado->execute(array(":idusuario"=>$_SESSION["iduser"]));
                
                while($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                    
                    $idusu=intval($fila["ID"]);
                }
                
                $resultado=$conexion->prepare($consulta);
                
                $resultado->execute(array(":id_usu"=>$idusu,":h"=>$token_hash,":title"=>$title,":cancion"=>$nombrec,":desc"=>$desc,":imgcan"=>$imagencan,":permission"=>$derechos));
                
                $registro=$resultado->rowCount();
                
                $resultado=$conexion->prepare($consultatres);
                
                $resultado->execute(array(":iduser"=>$_SESSION["iduser"]));
                
                if($registro!=0){
                    
                    header("location:confirmacioncancion.php");
                }else{
                    
                    header("location:cuenta.php?user=$iduser");
                }
                
            }else{
                
                header("location:cuenta.php?user=$iduser");
            }
        }else{
            
            header("location:cuenta.php?user=$iduser");
        }
        
    }catch(Exception $e){
        
        die("Error " . $e->getCode() . " " . $e->getMessage() . " " . $e->getLine());
    }

?>