<?php

$token=$_GET["token"];

$token_hash=hash("sha256", $token);

$conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");

$conexion->exec("SET CHARACTER SET utf8");

$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql="SELECT ID,reset_token_expires_at FROM perfiles WHERE reset_token_hash=:rth";

$resultado=$conexion->prepare($sql);

$resultado->execute(array(":rth"=>$token_hash));

$recordfound=$resultado->rowCount();

if ($recordfound<1) {
    
    die("Token not found");
}

while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
    
    $usertoken=$fila["reset_token_expires_at"];
}

if (strtotime($usertoken)<=time()) {
    
    die("Token has expired");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

</head>
<body>
    
    <form action="processresetpassword.php" method="post">
    
    	<input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
    	
    	<input type="password" name="password" id="password">
    	
    	<input type="password" name="password_confirmation" id="password_confirmation">
    	
    	<input type="submit" name="bsubmit" value="cambiar">
    
    </form>
    
</body>
</html>