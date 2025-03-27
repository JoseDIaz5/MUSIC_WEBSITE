<?php 

    if(isset($_POST["envia"])){
    
        try {
            
            $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
            
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $conexion->exec("SET CHARACTER SET utf8");
            
            $correo=$_POST["correo"];
            
            $contra=$_POST["contra"];
            
            $consulta="CALL SEARCH_ID_PROFILE_SESSION(:correo)";
            
            $resultado=$conexion->prepare($consulta);
            
            $resultado->execute(array(":correo"=>$correo));
            
            $registro=$resultado->rowCount();
            
            if($registro!=0){
                
                session_start();
                
                while($fila=$resultado->fetch(PDO::FETCH_ASSOC)){
                    
                    if (password_verify($contra, $fila["CONTRASENA"])) {
                        
                        $_SESSION["idusu"]=$fila["ID"];
                        
                        $_SESSION["usuario"]=$fila["USUARIO"];
                        
                        $_SESSION["picture"]=$fila["IMAGEN_PERFIL"];
                        
                        $_SESSION["portada"]=$fila["IMAGEN_PORTADA"];
                        
                        $_SESSION["buscador"]='';
                        
                        $_SESSION["correo"]=$_POST["correo"];
                        
                        header("location:index.php");
                    }else {
                        
                        header("location:iniciosesion.php");
                    }
                    
                }
                
            }else{
                
                header("location:iniciosesion.php");
            }
            
        } catch (Exception $e) {
            
            die("Error: " . $e->getMessage());
        }
    }else {
        
        header("location:iniciosesion.php");
    }

?>