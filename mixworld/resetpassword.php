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
    <title>Cambio de contraseña</title>
    
    <link rel="stylesheet" href="resetpassword.css?v=<?php echo time(); ?>">
	
	<script src="https://kit.fontawesome.com/f221aee085.js" crossorigin="anonymous"></script>
	
	<script src="jquery-1.8.3.js"></script>
	
	<script src="resetpassword.js?v=<?php echo time(); ?>"></script>

</head>
<body>
    <section>
    
    	<form action="processresetpassword.php" method="post">
    
    		<div id="formulario">
    		
    			<div class="logo">
    			
    				<div class="loader">
					
						<span class="stroke"></span>
						<span class="stroke"></span>
						<span class="stroke"></span>
						<span class="stroke"></span>
						<span class="stroke"></span>
					
					</div>
					
					<a href="index.php" id="logodos">MIXWORLD</a>
    			
    			</div>
    			
    			<h2 id="tituloform">Cambiar la contraseña</h2>
    			
    			<div class="wrapper">
    			
    				<input type="hidden" name="token" value="<?= htmlspecialchars($token); ?>">
    			
    				<div class="inputWithIcon" id="divcontrasena">
    				
    					<i class="fas fa-key icono" id="passicon"></i>
    					
    					<input type="password" name="password" id="password" class="datos" placeholder="Contraseña" maxLength="64" required>
    					
    					<span class="focus-border"><i></i></span>
    				
    				</div>
    				
    				<br>
    				
    				<div class="inputWithIcon" id="divconfirmacioncontrasena">
    				
    					<i class="fas fa-key icono" id="passicontwo"></i>
    					
    					<input type="password" name="password_confirmation" id="password_confirmation" class="datos" placeholder="Confirmar contraseña" maxLength="64" required>
    					
    					<span class="focus-border"><i></i></span>
    				
    				</div>
    			
    				<br>
    				
    				<br>
    			
    				<input type="submit" name="bsubmit" hidden="hidden" id="enviacontrasena">
    				
    				<div id="botoncontrasena">Cambiar contraseña</div>
    			
    			</div>
    		
    		</div>
        
        </form>
    
    </section>
    
</body>
</html>