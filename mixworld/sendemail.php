<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$correo=$_POST["mail"];

$token=bin2hex(random_bytes(16));

$token_hash=hash("sha256", $token);

$expiry=date("Y-m-d H:i:s",time() + 60 * 30);

$conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");

$conexion->exec("SET CHARACTER SET utf8");

$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql="UPDATE perfiles SET reset_token_hash=:rth,reset_token_expires_at=:rte WHERE CORREO=:email";

$resultado=$conexion->prepare($sql);

$resultado->execute(array(":rth"=>$token_hash,":rte"=>$expiry,":email"=>$correo));

$mailfound=$resultado->rowCount();

if ($mailfound>0) {
    
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '-------';                     //SMTP username
        $mail->Password   = '------';                               //SMTP password
        $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
        $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->isHTML(true);
        
        //Recipients
        $mail->setFrom('-------', 'Jose');
        $mail->addAddress($correo, 'MIXWORLD User');     //Add a recipient
        
        
        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Reestablecimiento de contraseña';
        $mail->Body    = <<<END
        
        Click <a href="http://localhost/MIXWORLD/mixworld/resetpassword.php?token=$token">AQUÍ</a>
        para cambiar la contraseña
        
        END;
        
        $mail->send();
        echo 'El mensaje se envió correctamente';
    } catch (Exception $e) {
        echo "El mensaje no se envió. Error: {$mail->ErrorInfo}";
    }
}

?>