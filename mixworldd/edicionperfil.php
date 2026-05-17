
<?php

    session_start();
    
    if (isset($_SESSION["idusu"])) {
        
        try {
            
            include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
            
            $formatosimg=['image/png','image/jpeg','image/jpg',''];
            
            $carpetaimg = $_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/perfiles/";
            
            $perfil=$_POST["profileimg"];
            
            $portada=$_POST["portadaimg"];
            
            if (!empty($_FILES["imagenperfil"]["tmp_name"])) {
                
                $real_mime=mime_content_type($_FILES["imagenperfil"]["tmp_name"]);
                
                if (!in_array($real_mime, $formatosimg)) {
                    
                    http_response_code(400);
                    
                    echo "FORMATO DE IMAGEN DE PERFIL NO SOPORTADO";
                    
                    exit;
                }
                
                $extensionperfil=pathinfo($_FILES["imagenperfil"]["name"],PATHINFO_EXTENSION);
                
                $nombre_perfil_limpio=preg_replace("/[^a-zA-Z0-9]/", "_", pathinfo($_FILES["imagenperfil"]["name"],PATHINFO_FILENAME));
                
                $perfilvieja=$_POST["profileimg"];
                
                $perfil=uniqid($nombre_perfil_limpio . "_",true) . "." . $extensionperfil;
                
                if (!empty($perfilvieja) && $perfilvieja!="defaultuser.png") {
                    
                    $ruta_perfil_vieja=$carpetaimg.$perfilvieja;
                    
                    if (file_exists($ruta_perfil_vieja)) {
                        
                        unlink($ruta_perfil_vieja);
                    }
                }
                
                move_uploaded_file($_FILES["imagenperfil"]["tmp_name"], $carpetaimg . $perfil);
            }
            
            if (!empty($_FILES["contportada"]["tmp_name"])) {
                
                $real_mime_portada=mime_content_type($_FILES["contportada"]["tmp_name"]);
                
                if (!in_array($real_mime_portada, $formatosimg)) {
                    
                    http_response_code(400);
                    
                    echo "FORMATO DE IMAGEN DE PORTADA NO SOPORTADO";
                    
                    exit;
                }
                
                $extensionportada=pathinfo($_FILES["contportada"]["name"],PATHINFO_EXTENSION);
                
                $nombre_portada_limpio=preg_replace("/[^a-zA-Z0-9]/", "_", pathinfo($_FILES["contportada"]["name"],PATHINFO_FILENAME));
                
                $portadavieja=$_POST["portadaimg"];
                
                $portada=uniqid($nombre_portada_limpio . "_",true) . "." . $extensionportada;
                
                if (!empty($portadavieja) && $portadavieja!="default.png") {
                    
                    $ruta_portada_vieja=$carpetaimg.$portadavieja;
                    
                    if (file_exists($ruta_portada_vieja)) {
                        
                        unlink($ruta_portada_vieja);
                    }
                }
                
                move_uploaded_file($_FILES["contportada"]["tmp_name"], $carpetaimg . $portada);
            }
                
            $facebook = !empty($_POST["facebook"]) ? $_POST["facebook"] : null;
            
            $instagram = !empty($_POST["instagram"]) ? $_POST["instagram"] : null;
            
            $x = !empty($_POST["twitter"]) ? $_POST["twitter"] : null;
            
            $usuario = $_POST["usuario"];
            
            $id = $_POST["id"];
            
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