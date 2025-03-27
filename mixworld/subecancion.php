<?php 

    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
    try{
        
        $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
        
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $conexion->exec("SET CHARACTER SET utf8");
        
        $title=$_POST["titulo"];
        
        $desc=$_POST["area"];
        
        $nombrec=$_FILES['song']['name'];
        
        $imagencan=$_FILES['imagesong']['name'];
        
        $tipocancion=$_FILES['song']['type'];
        
        $tipoimg=$_FILES['imagesong']['type'];
        
        $carpeta=$_SERVER["DOCUMENT_ROOT"] . "/MIXWORLD/intranet/songs/";
        
        move_uploaded_file($_FILES['song']['tmp_name'], $carpeta.$nombrec);
        
        $carpetaimg=$_SERVER["DOCUMENT_ROOT"] . "/MIXWORLD/intranet/songsimages/";
        
        move_uploaded_file($_FILES['imagesong']['tmp_name'], $carpeta.$imagencan);
        
        date_default_timezone_set("America/Costa_Rica");
        
        $fecha=date("l j/m/Y g:i a");
        
        $consulta="CALL INSERT_SONG(:id_usu,:title,:cancion,:desc,:imgcan,:fecha)";
        
        $consultados="CALL SEARCH_ID_PROFILE(:usuario)";
        
        $consultatres="CALL UPDATE_SONGS_COUNT_ADDITION(:iduser)";
        
        if($tipocancion=="audio/mpeg" || $tipocancion=="audio/flac"  || $tipocancion=="audio/wav"  || $tipocancion=="audio/x-m4a"){
            
            if($tipoimg=="image/jpg" || $tipoimg=="image/jpeg" || $tipoimg=="image/png" || $tipoimg==""){
                
                $resultado=$conexion->prepare($consultados);
                
                $resultado->execute(array(":usuario"=>$_SESSION["usuario"]));
                
                while($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                    
                    $idusu=intval($fila["ID"]);
                }
                
                $resultado=$conexion->prepare($consulta);
                
                $resultado->execute(array(":id_usu"=>$idusu,":title"=>$title,":cancion"=>$nombrec,":desc"=>$desc,":imgcan"=>$imagencan,":fecha"=>$fecha));
                
                $registro=$resultado->rowCount();
                
                $resultado=$conexion->prepare($consultatres);
                
                $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
                
                if($registro!=0){
                    
                    header("location:confirmacioncancion.php");
                }else{
                    
                    header("location:cuenta.php");
                }
                
            }else{
                
                header("location:cuenta.php");
            }
        }else{
            
            header("location:cuenta.php");
        }
        
    }catch(Exception $e){
        
        die("Error " . $e->getCode() . " " . $e->getMessage() . " " . $e->getLine());
    }

?>