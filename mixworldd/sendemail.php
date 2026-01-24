<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$correo=$_POST["mail"];

$token=bin2hex(random_bytes(16));

$token_hash=hash("sha256", $token);

include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';

$sql="CALL RESET_TOKEN(:rth,:email)";

$resultado=$conexion->prepare($sql);

$resultado->execute(array(":rth"=>$token_hash,":email"=>$correo));

$mailfound=$resultado->rowCount();

if ($mailfound>0) {
    
    $mail = new PHPMailer(true);
    
    try {
        //Server settings
        $mail->SMTPDebug = 0;                      
        $mail->isSMTP();                                            
        $mail->Host       = '';                     
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = '';                     
        $mail->Password   = '';                               
        $mail->SMTPSecure = 'tls';            
        $mail->Port       = 587;
        $mail->isHTML(true);
        
        //Recipients
        $mail->setFrom('', 'MIXWORLD');
        $mail->addAddress($correo, 'MIXWORLD User'); 
        
        
        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Reestablecimiento de contraseña';
        $mail->Body    = <<<END
        
        Click <a href="http://localhost/mixworld/mixworldd/resetpassword.php?token=$token">AQUÍ</a>
        para cambiar la contraseña
        
        END;
        
        $mail->send();
        
        header("location:sendemailconfirmation.php");
        
    } catch (Exception $e) {
        echo "El mensaje no se envió. Error: {$mail->ErrorInfo}";
    }
}

?>