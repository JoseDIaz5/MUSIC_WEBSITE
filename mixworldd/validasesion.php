<?php 
    
        try {
            
            include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
            
            $correo=$_POST["correo"];
            
            $contra=$_POST["contrasena"];
            
            $ip_usuario=$_SERVER["REMOTE_ADDR"];
            
            $consultaip="CALL SEARCH_LOGIN_ATTEMPTS(:IPUSER)";
            
            $resultado=$conexion->prepare($consultaip);
            
            $resultado->execute(array(":IPUSER"=>$ip_usuario));
            
            $fila=$resultado->fetch();
            
            $resultado->closeCursor();
            
            
            
            
            
            $hora_desbloqueo=$fila["fecha_intento"];
            
            $mensaje="Demasiados intentos fallidos. Intentalo a las " . $hora_desbloqueo;
            
            if($fila["cantidad"]>=4){
                
                
                
                echo json_encode([
                    "exito" => false,
                    "mensaje" => $mensaje
                ]);
                
                exit;
            }
            
            $consulta="CALL SEARCH_ID_PROFILE_SESSION(:correo)";
            
            $resultado=$conexion->prepare($consulta);
            
            $resultado->execute(array(":correo"=>$correo));
            
            $usuario=$resultado->fetch();
            
            $resultado->closeCursor();
            
            if($usuario && $usuario["blocked_until"] && strtotime($usuario["blocked_until"]) > time()){
                
                
                
                echo json_encode([
                    "exito" => false,
                    "mensaje" => "Cuenta bloqueada. Intenta más tarde"
                ]);
                
                exit;
            }
            
            if($usuario && password_verify($contra, $usuario["CONTRASENA"])){
                
                
                
                $eliminaip="CALL DELETE_IP_ADDRESS(:IP)";
                
                $resultado=$conexion->prepare($eliminaip);
                
                $resultado->execute(array(":IP"=>$ip_usuario));
                
                $quitaintentos="CALL UPDATE_ATTEMPTS_SUBTRACTION(:IDU)";
                
                $resultado=$conexion->prepare($quitaintentos);
                
                $resultado->execute(array(":IDU"=>$usuario["ID"]));
                
                session_start();
                
                $_SESSION["iduser"]=$usuario["ID"];
                
                $_SESSION["idusu"]=$usuario["IDHASH"];
                
                $_SESSION["usuario"]=$usuario["USUARIO"];
                
                $_SESSION["picture"]=$usuario["IMAGEN_PERFIL"];
                
                $_SESSION["portada"]=$usuario["IMAGEN_PORTADA"];
                
                $_SESSION["buscador"]='';
                
                $_SESSION["correo"]=$correo;
                
                echo json_encode([
                    "exito" => true,
                    "redireccion" => "index.php"
                ]);
                
                exit;
                
            }else {
                
                $conexion->prepare("CALL INSERT_ATTEMPTS_IP(:IP,:MAIL)")->execute(array(":IP"=>$ip_usuario,":MAIL"=>$correo));
                
                if($usuario){
                    
                    
                    
                    
                    $conexion->prepare("CALL UPDATE_ATTEMPTS_ADDITION(:MAIL)")->execute(array(":MAIL"=>$correo));
                }
                
                echo json_encode([
                    "exito" => false,
                    "mensaje" => "Correo o contraseña incorrectos"
                ]);
            }
            
        } catch (Exception $e) {
            
            die("Error: " . $e->getMessage());
        }

?>