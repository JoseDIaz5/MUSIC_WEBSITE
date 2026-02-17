<?php 

session_start();

if (isset($_SESSION["idusu"])) {
    
    try {
        
        include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
        
        $id=$_GET["id"];
        
        $consultaarchivocancion="CALL GET_SONG_FILES_NAME(:idsong)";
        
        $resultado=$conexion->prepare($consultaarchivocancion);
        
        $resultado->execute(array(":idsong"=>$id));
        
        $fila=$resultado->fetch(PDO::FETCH_ASSOC);
            
        $songfilename=$fila["CANCION"];
        
        $imagefilename=$fila["IMAGEN_CANCION"];
        
        $rutaarchivo=$_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/songs/";
        
        $archivos=[$songfilename,$imagefilename];
        
        foreach ($archivos as $archivo){
            
            $ruta=$rutaarchivo.$archivo;
            
            if (!empty($archivo) && file_exists($ruta)) {
                
                unlink($ruta);
            }
        }
        
        $consultacantidadcanciones="CALL UPDATE_SONGS_COUNT_SUBTRACTION(:iduser)";
        
        $resultado=$conexion->prepare($consultacantidadcanciones);
        
        $resultado->execute(array(":iduser"=>$_SESSION["iduser"]));
        
        $consulta="CALL DELETE_SONG(:idsong)";
        
        $resultado=$conexion->prepare($consulta);
        
        $resultado->execute(array(":idsong"=>$id));
        
        $cantidad=$resultado->rowCount();
        
        if ($cantidad!=0) {
            
            header("location:cuenta.php");
        }
        
    } catch (Exception $e) {
        
        die("Error: " . $e->getMessage());
    }
    
}else {
    
    header("location:index.php");
}

?>