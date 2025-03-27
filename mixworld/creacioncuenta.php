<?php
    
    if(isset($_POST["subedatos"])){
        
        $contrasena=$_POST["contra"];
        
        $contrasenados=$_POST["confirmar"];
        
        if($contrasena==$contrasenados && preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,12}$/", $contrasena) && preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,12}$/", $contrasenados)){
            
            try{
                
                $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
                
                $conexion->exec("SET CHARACTER SET utf8");
                
                $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                
                if (empty($_FILES["imagenperfil"]["name"])) {
                    
                    $imgperfil=NULL;
                }else {
                    
                    $imgperfil=$_FILES["imagenperfil"]["name"];
                }
                if (empty($_FILES["contportada"]["name"])) {
                    
                    $imgportada=NULL;
                }else {
                    
                    $imgportada=$_FILES["contportada"]["name"];
                }
                
                $carpeta=$_SERVER["DOCUMENT_ROOT"] . "/MIXWORLD/intranet/perfiles/";
                
                $usuario=addslashes($_POST["usuario"]);
                
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
                
                move_uploaded_file($_FILES["imagenperfil"]["tmp_name"], $carpeta.$imgperfil);
                
                move_uploaded_file($_FILES["contportada"]["tmp_name"], $carpeta.$imgportada);
                
                    
                $consulta="CALL CREATE_USER(:usuario,:correo,:contra,:perfil,:portada,:fuser,:iuser,:xuser)";
                
                $resultado=$conexion->prepare($consulta);
                
                $resultado->execute(array(":usuario"=>$usuario, ":correo"=>$correo, ":contra"=>$pass_c, ":perfil"=>$imgperfil, ":portada"=>$imgportada,":fuser"=>$facebook,":iuser"=>$instagram,":xuser"=>$twitter));
                
                $consultados="CALL GET_ID_USER()";
                
                $resultados=$conexion->prepare($consultados);
                
                $resultados->execute();
                
                $registro=$resultado->rowCount();
                
                if($registro!=0){
                    
                    session_start();
                    
                    $_SESSION["usuario"]=$_POST["usuario"];
                    
                    $_SESSION["picture"]=$_FILES["imagenperfil"]["name"];
                    
                    $_SESSION["portada"]=$_FILES["contportada"]["name"];
                    
                    header("location:index.php");
                }
                while($fila=$resultados->fetch(PDO::FETCH_ASSOC)){
                    
                    $_SESSION["idusu"]=$fila["ID"];
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