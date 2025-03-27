<!DOCTYPE html>
<html>

	<head>
	
		<meta charset="utf-8">
		
		<title>Inicio sesión</title>
		
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		
		<link rel="stylesheet" href="iniciosesion.css?v=<?php echo time(); ?>">
		
		<script src="https://kit.fontawesome.com/f221aee085.js" crossorigin="anonymous"></script>
		
		<script src="jquery-1.8.3.js"></script>
		
		<script src="iniciosesion.js?v=<?php echo time(); ?>"></script>
	
	</head>
	
	<body>
	
		<section>
		
			<form action="validasesion.php" enctype="multipart/form-data" method="post">
			
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
					
					<h2 id="tituloform">Inicio de sesión</h2>
					
					<div class="wrapper">
					
						<div class="inputWithIcon" id="divcorreo">
						
							<i class="fas fa-envelope icono" id="mailicon"></i>
							
							<input type="email" name="correo" id="correo" class="datos" placeholder="Correo" maxLength="50" required>
						
							<span class="focus-border"><i></i></span>
						
						</div>
						
						<br>
						
						<div class="inputWithIcon" id="divcontrasena">
						
							<i class="fas fa-key icono" id="passicon"></i>
							
							<input type="password" name="contra" id="contrasena" class="datos" placeholder="Contraseña" maxLength="64" required>
							
							<span class="focus-border"><i></i></span>
						
						</div>
						
						<br>
					
						<br>
						
						<input type="submit" id="sesion" value="Iniciar sesión" name="envia" hidden="hidden">
						
						<div id="botonsesion">Iniciar sesión</div>
						
						<br>
						
						<a href="mailform.php" class="passlink">¿Olvidó la contraseña?</a>
					
					</div>
				
				</div>
			
			</form>
		
		</section>
	
	</body>

</html>