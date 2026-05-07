
<?php

    session_start();
    
    if (isset($_SESSION["idusu"])) {
        
        try {
            
            include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
            
            $formatosimg=['image/png','image/jpeg','image/jpg',''];
            
            $carpetaimg = $_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/perfiles/";
            
            if (!empty($_FILES["imagenperfil"]["tmp_name"])) {
                
                $real_mime=mime_content_type($_FILES["imagenperfil"]["tmp_name"]);
                
                if (!in_array($real_mime, $formatosimg)) {
                    
                    http_response_code(400);
                    
                    echo "FORMATO DE IMAGEN DE PERFIL NO SOPORTADO";
                    
                    exit;
                }
            }
            
            if (!empty($_FILES["contportada"]["tmp_name"])) {
                
                $real_mime_portada=mime_content_type($_FILES["contportada"]["tmp_name"]);
                
                if (!in_array($real_mime_portada, $formatosimg)) {
                    
                    http_response_code(400);
                    
                    echo "FORMATO DE IMAGEN DE PORTADA NO SOPORTADO";
                    
                    exit;
                }
            }
                
            $perfil = ($_FILES["imagenperfil"]["name"] != '') ? $_FILES["imagenperfil"]["name"] : $_POST["profileimg"];
                
            $portada = ($_FILES["contportada"]["name"] != '') ? $_FILES["contportada"]["name"] : $_POST["portadaimg"];
            
            $facebook = !empty($_POST["facebook"]) ? $_POST["facebook"] : null;
            
            $instagram = !empty($_POST["instagram"]) ? $_POST["instagram"] : null;
            
            $x = !empty($_POST["twitter"]) ? $_POST["twitter"] : null;
            
            $usuario = $_POST["usuario"];
            
            $id = $_POST["id"];
            
            if (!empty($_FILES["imagenperfil"]["tmp_name"])) {
                
                move_uploaded_file($_FILES["imagenperfil"]["tmp_name"], $carpetaimg . $perfil);
            }
            if (!empty($_FILES["contportada"]["tmp_name"])) {
                
                move_uploaded_file($_FILES["contportada"]["tmp_name"], $carpetaimg . $portada);
            }
            
            
            $idh=$_POST["idh"];
            
            $consulta="CALL UPDATE_USER(:id,:user,:perfil,:portada,:face,:insta,:xuser)";
            
            $resultado=$conexion->prepare($consulta);
            
            $resultado->execute(array(":user"=>$usuario,":perfil"=>$perfil,":portada"=>$portada,":face"=>$facebook,":insta"=>$instagram,":xuser"=>$x,":id"=>$id));
            
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