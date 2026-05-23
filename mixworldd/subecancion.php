<?php 

session_start();


if (!isset($_SESSION["idusu"])) {
    
    header("location:index.php");
}

try{   
    
    include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
    
    $formatos=['audio/mpeg','audio/wav','audio/flac','audio/mp4','audio/x-m4a','audio/m4a'];
    
    $formatosimg=['image/png','image/jpeg','image/jpg',''];
    
    $iduser=$_SESSION["idusu"];
    
    $title=$_POST["titulo"];
    
    $desc=$_POST["area"];
    
    $derechos=intval($_POST["confirmacionderechos"]);
    
    $nombrec=$_FILES['song']['name'];
    
    $tipocancion=$_FILES['song']['type'];
    
    
    
    if (!empty($_FILES["song"]["tmp_name"])) {
        
        $real_mime= mime_content_type($_FILES["song"]["tmp_name"]);
        
        if (!in_array($real_mime, $formatos)) {
            
            http_response_code(400);
            
            echo "FORMATO DE AUDIO NO SOPORTADO";
            
            exit;
        }
        
        $extension_audio=pathinfo($_FILES["song"]["name"],PATHINFO_EXTENSION);
        
        $nombre_audio_limpio=preg_replace("/[^a-zA-Z0-9]/", "_", pathinfo($_FILES["song"]["name"],PATHINFO_FILENAME));
        
        $nombre_recortado=substr($nombre_audio_limpio, 0,100);
        
        $nombrec=uniqid($nombre_recortado . "_",true) . "." . $extension_audio;
    }
    
    
    
    $nombre_final_img="";
    
    $tipoimg="";
    
    if (!empty($_FILES["imagesong"]["tmp_name"])) {
        
        $real_mime_img= mime_content_type($_FILES["imagesong"]["tmp_name"]);
        
        if (!in_array($real_mime_img, $formatosimg)) {
            
            http_response_code(400);
            
            echo "FORMATO DE IMAGEN NO SOPORTADO";
            
            exit;
            
        }
        
        $extension=pathinfo($_FILES["imagesong"]["name"],PATHINFO_EXTENSION);
        
        $nombre_limpio=preg_replace("/[^a-zA-Z0-9]/", "_", pathinfo($_FILES["imagesong"]["name"],PATHINFO_FILENAME));
        
        $nombre_final_img=uniqid($nombre_limpio . "_",true) . "." . $extension;
        
        $tipoimg=$_FILES['imagesong']['type'];
    }
    
    $token_hash=bin2hex(random_bytes(16));
    
    
    
    $carpeta=$_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/songs/";
    
    $consulta="CALL INSERT_SONG(:id_usu,:h,:title,:cancion,:desc,:imgcan,:permission)";
    
    $consultados="CALL SEARCH_ID_PROFILE(:idusuario)";
    
    $consultatres="CALL UPDATE_SONGS_COUNT_ADDITION(:iduser)";
    
    $resultado=$conexion->prepare($consultados);
    
    $resultado->execute(array(":idusuario"=>$_SESSION["iduser"]));
    
    $idusu=null;
    
    if($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
        
        $idusu=intval($fila["ID"]);
    }
    
    $resultado->closeCursor();
    
    if(!$idusu){
        
        throw new Exception("No se encontró el perfil");
    }
    
    $subida_audio=move_uploaded_file($_FILES["song"]["tmp_name"], $carpeta.$nombrec);
    
    $subida_img=true;
    
    if (!empty($_FILES["imagesong"]["tmp_name"])) {
        
        $subida_img=move_uploaded_file($_FILES["imagesong"]["tmp_name"], $carpeta.$nombre_final_img);
    }
    
    if ($subida_audio && $subida_img) {
        
        $resultado=$conexion->prepare($consulta);
        
        $resultado->execute(array(":id_usu"=>$idusu,":h"=>$token_hash,":title"=>$title,":cancion"=>$nombrec,":desc"=>$desc,":imgcan"=>$nombre_final_img,":permission"=>$derechos));
        
        $registro=$resultado->rowCount();
        
        $resultado->closeCursor();
        
        $resultado=$conexion->prepare($consultatres);
        
        $resultado->execute(array(":iduser"=>$_SESSION["iduser"]));
        
        $resultado->closeCursor();
        
        if ($registro>0) {
            
            echo "EXITO";
            
            exit;
            
        }else {
            
            http_response_code(400);
            
            echo "ERROR_BD: No se pudo registrar la canción.";
            
            exit;
        }
    }else {
        
        http_response_code(500);
        
        echo "ERROR_ARCHIVOS: No se pudo mover los archivos al servidor";
        
        exit;
    }
    
    
}catch(Exception $e){
    
    http_response_code(500);
    
    die("Error " . $e->getCode() . " " . $e->getMessage() . " " . $e->getLine());
    
}

?>