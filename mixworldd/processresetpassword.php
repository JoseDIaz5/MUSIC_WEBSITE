<?php

$token=$_POST["token"];

$token_hash=hash("sha256", $token);

$conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");

$conexion->exec("SET CHARACTER SET utf8");

$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql="CALL GET_RESET_TOKEN(:rth)";

$resultado=$conexion->prepare($sql);

$resultado->execute(array(":rth"=>$token_hash));

$recordfound=$resultado->rowCount();

if ($recordfound<1) {
    
    die("Token not found");
}

while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
    
    $usertoken=$fila["reset_token_expires_at"];
    
    $ctime=$fila["CURRENTTIME"];
    
    $userid=$fila["ID"];
}

if (strtotime($usertoken)<=strtotime($ctime)) {
    
    die("Token has expired");
    
}

$contrasena=$_POST["password"];

$contrasenados=$_POST["password_confirmation"];

$password_hash=password_hash($contrasena, PASSWORD_DEFAULT);

if ($contrasena==$contrasenados && preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,12}$/", $contrasena) && preg_match("/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,12}$/", $contrasenados) && strlen($contrasena)>=8) {
    
    $sql="CALL C_PASSWORD(:pass,:id)";
    
    $resultado=$conexion->prepare($sql);
    
    $resultado->execute(array(":pass"=>$password_hash,":id"=>$userid));
    
    $rows=$resultado->rowCount();
    
    if ($rows>0) {
        
        header("location:iniciosesion.php");
    }else {
        
        header("processresetpasswordresult.php");
    }
    
}else {
    
    header("location:resetpassword.php");
}

?>