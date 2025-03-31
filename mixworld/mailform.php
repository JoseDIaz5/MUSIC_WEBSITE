<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
		
	<link rel="stylesheet" href="mailform.css?v=<?php echo time(); ?>">
	
	<script src="https://kit.fontawesome.com/f221aee085.js" crossorigin="anonymous"></script>
	
	<script src="jquery-1.8.3.js"></script>
	
	<script src="mailform.js?v=<?php echo time(); ?>"></script>
	
    <title>Cambio de contraseña</title>
</head>
<body>
    <section>
    
    	<form action="sendemail.php" method="post">
    	
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
    			
    				<div class="inputWithIcon" id="divcorreo">
    				
    					<i class="fas fa-envelope icono" id="mailicon"></i>
    					
    					<input type="email" name="mail" id="mail" class="datos" placeholder="Correo" maxLength="50" required>
    					
    					<span class="focus-border"><i></i></span>
    				
    				</div>
    				
    				<br>
    				
    				<br>
    		
    				<input type="submit" id="enviacorreo" name="send" hidden="hidden">
    				
    				<div id="botoncorreo">Enviar correo</div>
    			
    			</div>	
    		
    		</div>
    	
    	</form>
    
    </section>
</body>
</html>