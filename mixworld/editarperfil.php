<!DOCTYPE html>
<html>

	<?php 
	
	session_start();
	
	if(!isset($_SESSION["idusu"])){
	    
	    header("location:index.php");
	}
	
	?>

	<head>
	
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        
        <title>MIXWORLD | Editar Perfil</title>
        
        <link rel="stylesheet" href="editarperfil.css?v=<?php echo time(); ?>">
        
        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-1.8.3.js"></script>
        
        <script src="editarperfil.js?v=<?php echo time(); ?>"></script>
	
	</head>
	<body>
	
		<?php 
		
		if (isset($_GET["id"])) {
		    
		    $id=$_GET["id"];
		    
		    try {
		        
		        $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		        
		        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		        
		        $conexion->exec("SET CHARACTER SET utf8");
		        
		        $consulta="CALL GET_USER_INFO_EDIT(:id)";
		        
		        $resultado=$conexion->prepare($consulta);
		        
		        $resultado->execute(array(":id"=>$id));
		        
		        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		            
		            $user=$fila["USUARIO"];
		            
		            if ($fila["IMAGEN_PERFIL"]=='') {
		                
		                $perfil="";
		            }else {
		                
		                $perfil=$fila["IMAGEN_PERFIL"];
		            }
		            if ($fila["IMAGEN_PORTADA"]=='') {
		                
		                $portada="";
		            }else {
		                
		                $portada=$fila["IMAGEN_PORTADA"];
		            }
		            if ($fila["USUARIO_FACEBOOK"]=='') {
		                
		                $face="";
		            }else {
		                
		                $face=$fila["USUARIO_FACEBOOK"];
		            }
		            if ($fila["USUARIO_INSTAGRAM"]=='') {
		                
		                $insta="";
		            }else{
		                
		                $insta=$fila["USUARIO_INSTAGRAM"];
		            }
		            if ($fila["USUARIO_X"]=='') {
		                
		                $userx="";
		            }else {
		                
		                $userx=$fila["USUARIO_X"];
		            }
		        }
		        
		    } catch (Exception $e) {
		        
		        die("Error: " . $e->getMessage());
		    }
		
		?>
	
		<section>
		
			<form action="edicionperfil.php" enctype="multipart/form-data" method='post'>
			
				<input type="text" value="<?php echo $id; ?>" name="id" hidden="hidden">
				
				<input type="text" value="<?php echo $perfil; ?>" name="profileimg" hidden="hidden">
				
				<input type="text" value="<?php echo $portada; ?>" name="portadaimg" hidden="hidden">
			
				<div id="formulariodos">
				
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
					
					<h2 id="tituloform">Edición de cuenta</h2>
					
					<input type="file" id="imageselect" hidden="hidden" name="imagenperfil">
					
					<input type="file" id="imageselects" hidden="hidden" name="contportada">
					
					<div id="imagenperfil">
					
						<div id="imagenperfildos">
						
							<label id="imagenperfiltres">
							
							<?php 
							
							if ($perfil=='') {
							
							?>
							
							<img width='100%' height='100%' src="/MIXWORLD/intranet/songsimages/defaultuser.png">
							
							<?php 
							
							}else {
							
							?>
							
							<img id='perf' width='100%' height='100%' src='/MIXWORLD/intranet/perfiles/<?php echo $perfil; ?>'>
							
							<?php 
							
							}
							
							?>
							
							</label>
							
							<label id="pictureicon"><i class="fas fa-camera"></i></label>
						
						</div>
						
						<span></span>
					
					</div>
					
					<div class="divimageerror">
					
						<span id="imageerror"></span>
					
					</div>
					
					<br>
					
					<div id="contportada">
					
						<div id="contportadados">
						
							<label id="contportadatres">
							
							<?php 
							
							if ($portada=='') {
							
							?>
							
							<img width='100%' height='100%' src="/MIXWORLD/intranet/songsimages/default.png">
							
							<?php 
							
							}else {
							
							?>
							
							<img id='perf' width='100%' height='100%' src='/MIXWORLD/intranet/perfiles/<?php echo $portada; ?>'>
							
							<?php 
							
							}
							
							?>
							
							</label>
							
							<label id="pictureicons"><i class="fas fa-camera"></i></label>
						
						</div>
						
						<span></span>
					
					</div>
					
					<div class="divimageerror">
					
						<span id="imageerrortwo"></span>
					
					</div>
					
					<br>
					
					<div class="wrapper">
					
						<div class="inputWithIcon" id="divusuario">
						
							<i class="fas fa-user icono" id="usericon"></i>
               			
               				<input type="text" name="usuario" id="usuario" class="datos" placeholder="Usuario" maxlength="50" value="<?php echo $user; ?>" required>
               				
               				<span class="focus-border"><i></i></span>
						
						</div>
						
						<br>
               			
               			<div class="inputWithIcon" id="divfacebook">
               			
               				<i class="fab fa-facebook icono" id="facebookicon"></i>
               				
               				<input type="text" name="facebook" id="facebook" class="datos" placeholder="Usuario Facebook (opcional)" maxlength="60" value="<?php echo $face; ?>">
               				
               				<span class="focus-border"><i></i></span>
               			
               			</div>
               			
               			<br>
               			
               			<div class="inputWithIcon" id="divinstagram">
               			
               				<i class="fab fa-instagram icono" id="instagramicon"></i>
               				
               				<input type="text" name="instagram" id="instagram" class="datos" placeholder="Usuario Instagram (opcional)" maxlength="60" value="<?php echo $insta; ?>">
               				
               				<span class="focus-border"><i></i></span>
               			
               			</div>
               			
               			<br>
               			
               			<div class="inputWithIcon" id="divx">
               			
               				<i class="fa-brands fa-x-twitter icono" id="xicon"></i>
               			
               				<input type="text" name="twitter" id="twitter" class="datos" placeholder="Usuario X (opcional)" maxlength="60" value="<?php echo $userx; ?>">
               				
               				<span class="focus-border"><i></i></span>
               			
               			</div>
               			
               			<br>
               			
               			<br>
               			
               			<input type="submit" id="botonregistrados" value="Crear" name="subedatos" hidden="hidden">
               			
               			<div id="botonregistra">Editar</div>
					
					</div>
				
				</div>
			
			</form>
		
		</section>
		
		<?php 
		
		$resultado->closeCursor();
		
		}else{
		    
		    header("location:iniciosesion.php");
		}
		
		?>
	
	</body>

</html>