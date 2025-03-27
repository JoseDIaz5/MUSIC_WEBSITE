<!DOCTYPE html>
<html>

	<?php session_start(); ?>

	<head>
	
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD | Editar canción</title>

        <link rel="stylesheet" href="updatesong.css?v=<?php echo time(); ?>">

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-1.8.3.js"></script>
        
        <script src="updatesong.js?v=<?php echo time(); ?>"></script>
	
	</head>
	<body>
	
		<?php 
		
		  if (isset($_SESSION["idusu"])) {
		      
		      if (isset($_GET["idsong"])) {
		
    		  $id=$_GET["idsong"];
    		  
    		  try {
    		      
    		      $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
    		      
    		      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    		      
    		      $conexion->exec("SET CHARACTER SET utf8");
    		      
    		      $consulta="CALL GET_SONG_INFO(:idsong)";
    		      
    		      $resultado=$conexion->prepare($consulta);
    		      
    		      $resultado->execute(array(":idsong"=>$id));
    		      
    		      while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
    		          
    		          $titulo=$fila["TITULO"];
    		          
    		          $imagen=$fila["IMAGEN_CANCION"];
    		          
    		          $descripcion=$fila["DESCRIPCION"];
    		      }
    		      
    		  } catch (Exception $e) {
    		      
    		      die("Error: " . $e->getMessage());
    		  }
    		
    		?>
    	
    		<section>
    		
    			<form action="updatingsong.php" enctype="multipart/form-data" method="post">
    			
    				<input type=text value="<?php echo $id; ?>" name="id" hidden="hidden">
    				
    				<input type=text value="<?php echo $imagen; ?>" name="imagesong" hidden="hidden">
    			
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
    					
    					<h2 id="tituloform">Editar canción</h2>
    					
    					<input type="file" id="imageselect" hidden="hidden" name="imagencancion">
    					
    					<div id="imagencancion">
    					
    						<div id="imagencanciondos">
    						
    							<label id="imagencanciontres">
    							
    							<?php 
    							
    							 if ($imagen=='') {
    							
    							?>
    							
    							<img width='100%' height='100%' src="/MIXWORLD/intranet/songsimages/default.png">
    							
    							<?php 
    							
    							 }else {
    							
    							?>
    							
    							<img id='perf' width='100%' height='100%' src='/MIXWORLD/intranet/songs/<?php echo $imagen; ?>'>
    								
    							<?php 
    							
    							 }
    							
    							?>
    							
    							</label>
    							
    							<label id="songimage"><i class="fas fa-camera"></i></label>
    						
    						</div>
    						
    						<span></span>
    					
    					</div>
    					
    					<div class="divimageerror">
    					
    						<span id="imageerror"></span>
    					
    					</div>
    					
    					<br>
    					
    					<div class="wrapper">
    					
    						<div class="inputWithIcon" id="divtitulo">
    						
    							<i class="fas fa-user icono" id="titleicon"></i>
    							
    							<input type="text" name="titulo" id="titulo" class="datos" placeholder="Titulo" maxlength="90" value="<?php echo $titulo; ?>" required>
    							
    							<span class="focus-border"><i></i></span>
    						
    						</div>
    						
    						<br>
    						
    						<div class="inputWithIcon" id="divdescripcion">
    						
    							<textarea cols="66" rows="3" placeholder="Comentario..." id="textarea" name="comenta" maxlength="900" minlength="1"><?php echo $descripcion; ?></textarea>
    							
    							<span class="focus-border"><i></i></span>
    						
    						</div>
    						
    						<br>
    						
    						<br>
    						
    						<input type="submit" id="botonactualizados" value="Actualizar" name="actualizadatos" hidden="hidden">
    						
    						<div id="botonactualiza">Actualizar</div>
    					
    					</div>
    				
    				</div>
    			
    			</form>
    		
    		</section>
		
		<?php 
		
		  $resultado->closeCursor();
		      }else {
		       
		          header("location:iniciosesion.php");
		      }
		
		  }else {
		      
		      header("location:index.php");
		  }
		
		?>
	
	</body>

</html>