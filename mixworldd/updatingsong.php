
<?php

    session_start();
    
    if (isset($_SESSION["idusu"])) {
        
        try {
            
            include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
            
            $formatosimg=['image/png','image/jpeg','image/jpg'];
            
            $carpetaimg=$_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/songs/";
            
            if(!empty($_FILES["imagencancion"]["tmp_name"])){
                
                $real_mime=mime_content_type($_FILES["imagencancion"]["tmp_name"]);
                
                if (!in_array($real_mime, $formatosimg)) {
                    
                    http_response_code(400);
                    
                    echo "FORMATO DE IMAGEN DE CANCION NO SOPORTADO";
                    
                    exit;
                }
            }
            
            $iduser=$_SESSION["idusu"];
            
            $titulo=$_POST["titulo"];
            
            $descripcion=$_POST["comenta"];
            
            $id=$_POST["id"];
            
            if ($_FILES["imagencancion"]["name"]=='') {
                
                $imagenfinal=$_POST["imagesong"];
            }else {
                
                $imagenfinal=$_FILES["imagencancion"]["name"];
                
                
                
                move_uploaded_file($_FILES['imagencancion']['tmp_name'], $carpetaimg.$imagenfinal);
            }
            
            
            
            $ids=$_POST["idsongh"];
            
            $consulta="CALL UPDATE_SONG(:songimage,:title,:description,:idsong)";
            
            $resultado=$conexion->prepare($consulta);
            
            $resultado->execute(array(":songimage"=>$imagenfinal,":title"=>$titulo,":description"=>$descripcion,":idsong"=>$id));
            
            http_response_code(200);
            
            exit;
            
        } catch (Exception $e) {
            
            http_response_code(500);
            
            die("Error: " . $e->getMessage());
            
            exit;
        }
    }else {
        
        header("location:index.php");
    }

?>