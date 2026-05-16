<?php
    
    if(isset($_POST["subedatos"])){
        
        $contrasena=$_POST["contra"];
        
        $contrasenados=$_POST["confirmar"];
        
        if($contrasena==$contrasenados && preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,64}$/", $contrasena) && preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,64}$/", $contrasenados)){
            
            try{
                
                include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
                
                $carpeta=$_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/perfiles/";
                
                $formatosimg=['image/png','image/jpeg','image/jpg'];
                
                $nombre_final_perfil=null;
                
                if (!empty($_FILES["imagenperfil"]["name"])) {
                    
                    $real_mime=mime_content_type($_FILES["imagenperfil"]["tmp_name"]);
                    
                    if (!in_array($real_mime, $formatosimg)) {
                        
                        http_response_code(400);
                        
                        echo "FORMATO DE IMAGEN DE PERFIL NO SOPORTADO";
                        
                        exit;
                    }
                    
                    $extension=pathinfo($_FILES["imagenperfil"]["name"],PATHINFO_EXTENSION);
                    
                    $nombre_limpio=preg_replace("/[^a-zA-Z0-9]/","_", pathinfo($_FILES['imagenperfil']['name'],PATHINFO_FILENAME));
                    
                    $nombre_final_perfil=uniqid($nombre_limpio . "_",true) . "." . $extension;
                    
                    move_uploaded_file($_FILES["imagenperfil"]["tmp_name"], $carpeta.$nombre_final_perfil);
                }
                
                $nombre_final_portada=NULL;
                
                if (!empty($_FILES["contportada"]["name"])) {
                    
                    $real_mime_portada=mime_content_type($_FILES["contportada"]["tmp_name"]);
                    
                    if (!in_array($real_mime_portada, $formatosimg)) {
                        
                        http_response_code(400);
                        
                        echo "FORMATO DE IMAGEN DE PORTADA NO SOPORTADO";
                        
                        exit;
                    }
                    
                    $extension=pathinfo($_FILES["contportada"]["name"],PATHINFO_EXTENSION);
                    
                    $nombre_limpio=preg_replace("/[^a-zA-Z0-9]/","_", pathinfo($_FILES['contportada']['name'],PATHINFO_FILENAME));
                    
                    $nombre_final_portada=uniqid($nombre_limpio . "_",true) . "." . $extension;
                    
                    move_uploaded_file($_FILES["contportada"]["tmp_name"], $carpeta.$nombre_final_portada);
                    
                }
                
                $usuario=$_POST["usuario"];
                
                $correo=$_POST["correo"];
                
                $contra=$_POST["contra"];
                
                $pass_c=password_hash($contra, PASSWORD_DEFAULT);
                
                if (!empty($_POST["facebook"])) {
                    
                    $facebook=$_POST["facebook"];
                }
                else {
                    
                    $facebook=NULL;
                }
                if (!empty($_POST["twitter"])) {
                    
                    $twitter=$_POST["twitter"];
                }
                else {
                    
                    $twitter=NULL;
                }
                if (!empty($_POST["instagram"])) {
                    
                    $instagram=$_POST["instagram"];
                }
                else {
                    
                    $instagram=NULL;
                }
                
                $token=bin2hex(random_bytes(16));
                
                $token_hash=hash("sha256", $token);
                    
                $consulta="CALL CREATE_USER(:h,:usuario,:correo,:contra,:perfil,:portada,:fuser,:iuser,:xuser)";
                
                $resultado=$conexion->prepare($consulta);
                
                $resultado->execute(array("h"=>$token_hash,":usuario"=>$usuario, ":correo"=>$correo, ":contra"=>$pass_c, ":perfil"=>$nombre_final_perfil, ":portada"=>$nombre_final_portada,":fuser"=>$facebook,":iuser"=>$instagram,":xuser"=>$twitter));
                
                $consultados="CALL GET_ID_USER()";
                
                $resultados=$conexion->prepare($consultados);
                
                $resultados->execute();
                
                $registro=$resultado->rowCount();
                
                while($fila=$resultados->fetch(PDO::FETCH_ASSOC)){
                    
                    $idusu=$fila["ID"];
                }

                if($registro!=0){
                    
                    session_start();

                    $_SESSION["idusu"]=$token_hash;
                    
                    $_SESSION["iduser"]=$idusu;
                    
                    $_SESSION["usuario"]=$_POST["usuario"];
                    
                    $_SESSION["picture"]=$nombre_final_perfil;
                    
                    $_SESSION["portada"]=$nombre_final_portada;
                    
                    http_response_code(200);
                    exit;
                }
                
                $resultado->closeCursor();
                
                $resultados->closeCursor();
                
            }catch(Exception $e){
                
                die("Error" . $e->getMessage());
            }
        }else {
            
            header("location:crearcuenta.php");
        }
    }

?>