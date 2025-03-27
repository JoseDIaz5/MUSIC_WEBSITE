<!DOCTYPE html>
<html>

	<head>
	
		<?php 
        
            session_start();
        
        ?>
        <?php
    	
    	   
    	   if (!isset($_SESSION["idusu"])) {
    	       
    	       header("location:index.php");
    	       
    	   }
    	
    	?>
	
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD | Cuenta</title>

        <link rel="stylesheet" href="cuenta.css?v=<?php echo time(); ?>">

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-1.8.3.js"></script>
        
        <script src="cuenta.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejareproduccionescuenta.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
	
	</head>
	<body>
	
		<?php 
						
		  try {
		      
		      $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
		      
		      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		      
		      $conexion->exec("SET CHARACTER SET utf8");
		      
		      $validaid=false;
		      
		      if (isset($_GET["iduser"])) {
		          
		          $iduser=$_GET["iduser"];
		          
		          if($iduser==$_SESSION["idusu"]){
		              
		              $validaid=true;
		          }
		      }
		      
		      $consultaperfil="CALL GET_USER_INFO(:id)";
		      
		      $consultaseguidores="CALL GET_FOLLOWERS(:iduserfollower,:iduserfollowed)";
		      
		      if (isset($iduser)) {
		          
		          $resultado=$conexion->prepare($consultaperfil);
		          
		          $resultado->execute(array(":id"=>$iduser));
		          
		          while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		              
		              $idusuario=$fila["ID"];
		              
		              $portada=$fila["IMAGEN_PORTADA"];
		              
		              $perfil=$fila["IMAGEN_PERFIL"];
		              
		              $usuario=$fila["USUARIO"];
		              
		              $cantidadcanciones=$fila["CANCIONES"];
		              
		              $seguidores=$fila["SEGUIDORES"];
		              
		              $siguiendo=$fila["SIGUIENDO"];
		              
		              $facebookuser=$fila["USUARIO_FACEBOOK"];
		              
		              $instagramuser=$fila["USUARIO_INSTAGRAM"];
		              
		              $xuser=$fila["USUARIO_X"];
		          }
		          
		          $resultado->closeCursor();
		          
		          $resultadof=$conexion->prepare($consultaseguidores);
		          
		          $resultadof->execute(array(":iduserfollower"=>$_SESSION["idusu"],":iduserfollowed"=>$iduser));
		          
		          $row=$resultadof->rowCount();
		          
		          if ($row<1) {
		              $seguido=0;
		          }else{
		              $seguido=1;
		          }
		          $resultadof->closeCursor();
		      }else {
		          
		          $resultado=$conexion->prepare($consultaperfil);
		          
		          $resultado->execute(array(":id"=>$_SESSION["idusu"]));
		          
		          while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		              
		              $idusuario=$fila["ID"];
		              
		              $usuario=$fila["USUARIO"];
		              
		              $perfil=$fila["IMAGEN_PERFIL"];
		              
		              $portada=$fila["IMAGEN_PORTADA"];
		              
		              $cantidadcanciones=$fila["CANCIONES"];
		              
		              $seguidores=$fila["SEGUIDORES"];
		              
		              $siguiendo=$fila["SIGUIENDO"];
		              
		              $facebookuser=$fila["USUARIO_FACEBOOK"];
		              
		              $instagramuser=$fila["USUARIO_INSTAGRAM"];
		              
		              $xuser=$fila["USUARIO_X"];
		          }
		          $resultado->closeCursor();
		      }
		      
		  } catch (Exception $e) {
		  
		      die("Error: " . $e->getMessage());
		  }
		
		?>
	
		<div class="header_wrapper">
		
			<?php 
			
			 if ($portada!=null) {
			
			?>
		
			<header style="background: url('/MIXWORLD/intranet/perfiles/<?php echo $portada; ?>'); background-size: 100% 100%"></header>
			
			<?php 
			
			 }elseif($portada==null){
			
			?>
			
			<header style="background: linear-gradient(#818181,white 85%); background-size: 100% 100%"></header>
			
			<?php 
			
			 }
			
			?>
			
			<div class="cols_container">
			
				<div class="left_col">
				
					<div class="img_container">
					
						<?php 
						
						if (!isset($iduser) && isset($_SESSION["idusu"]) && $idusuario==$_SESSION["idusu"] && $perfil!=null) {   
						
						?>
					
						<img src="/MIXWORLD/intranet/perfiles/<?php echo $perfil; ?>">
						
						<a href="editarperfil.php?id=<?php echo $_SESSION["idusu"]; ?>"><span><i class="fa-solid fa-pen editicon"></i></span></a>
						
						<?php 
						
						}elseif(isset($iduser) && $iduser==$_SESSION["idusu"] && $idusuario==$_SESSION["idusu"] && $perfil!=null){
						
						?>
						
						<img src="/MIXWORLD/intranet/perfiles/<?php echo $perfil; ?>">
						
						<a href="editarperfil.php?id=<?php echo $_SESSION["idusu"]; ?>"><span><i class="fa-solid fa-pen editicon"></i></span></a>
						
						<?php 
						
						  }elseif(!isset($iduser) && isset($_SESSION["idusu"]) && $idusuario==$_SESSION["idusu"] && $perfil==null){
						
						?>
						
						<img src="/MIXWORLD/intranet/songsimages/defaultuser.png"></img>
						
						<a href="editarperfil.php?id=<?php echo $_SESSION["idusu"]; ?>"><span><i class="fa-solid fa-pen editicon"></i></span></a>
						
						<?php 
						
						  }elseif(isset($iduser) && $iduser==$_SESSION["idusu"] && $idusuario==$_SESSION["idusu"] && $perfil==null){
						
						?>
						
						<img src="/MIXWORLD/intranet/songsimages/defaultuser.png"></img>
						
						<a href="editarperfil.php?id=<?php echo $iduser; ?>"><span><i class="fa-solid fa-pen editicon"></i></span></a>
						
						<?php 
						
						  }elseif(isset($iduser) && $iduser!=$_SESSION["idusu"] && $idusuario!=$_SESSION["idusu"] && $perfil!=null){
						
						?>
						
						<img src="/MIXWORLD/intranet/perfiles/<?php echo $perfil; ?>">
						
						<?php 
						
						 }elseif(isset($iduser) && $iduser!=$_SESSION["idusu"] && $idusuario!=$_SESSION["idusu"] && $perfil==null){
						
						?>
						
						<img src="/MIXWORLD/intranet/songsimages/defaultuser.png"></img>
						
						<?php 
						
						  }
						
						?>
					
						<span class="editaccount"><i class="fa-solid fa-pen editicon"></i></span>
					
					</div>
					
					<h2><?php echo $usuario; ?></h2>
								
					<ul class="about">
					
						<li><span><?php echo $seguidores; ?></span>Seguidores</li>
						
						<li><span><?php echo $siguiendo; ?></span>Siguiendo</li>
						
						<li><span><?php echo $cantidadcanciones; ?></span>Canciones</li>
					
					</ul>
					
					<div class="content">
					
						<ul>
					
							<?php 
							
							if ($xuser=='') {
							
							?>
							
							<li><i class="fa-brands fa-x-twitter"></i></li>
							
							<?php 
							
							}else {
							
							?>
							
							<li class="enlacered"><a href="https://www.x.com/<?php echo $xuser ?>/"><i class="fa-brands fa-x-twitter"></i></a></li>
							
							<?php 
							
							}
							
							?>
							
							<?php 
							
							if ($facebookuser=='') {
							    ?>
							    
							    <li><i class="fab fa-facebook"></i></li>
							    
							    <?php
							}else {
							    ?>
							    
							    <li class="enlacered"><a href="https://www.facebook.com/<?php echo $facebookuser ?>/"><i class="fab fa-facebook"></i></a></li>
							    
							    <?php
							}
							
							?>
						
							<?php 
							
							if ($instagramuser=='') {
							
							?>
						
							<li><i class="fab fa-instagram"></i></li>
							
							<?php 
							
							}else{
							
							?>
							
							<li class="enlacered"><a href="https://www.instagram.com/<?php echo $instagramuser ?>/"><i class="fab fa-instagram"></i></a></li>
							
							<?php 
							
							}
							?>
					
						</ul>
					
					</div>
					
				</div>
			
				<div class="right_col">
			
					<nav>
					
						<ul>
						
							<li id="contcanciones">Mis canciones</li>
							
							<?php 
							
							 if (!isset($iduser)) {
							
							?>
						
							<li id="comp">Subir canciones</li>
							
							<li id="delete">Eliminar cuenta</li>
							
							<?php 
							
							 }elseif (isset($iduser) && $iduser==$_SESSION["idusu"]){
							
							?>
							
							<li id="comp">Subir canciones</li>
							
							<li id="delete">Eliminar cuenta</li>
							
							<?php 
							
							 }
							
							?>
							<li id="comp" class="pestañasubir">Subir canciones</li>
							<li id="delete" class="pestañasubir">Eliminar cuenta</li>
						
						</ul>
						
						<?php 
						
						if (isset($iduser) && !$validaid) {
						    
						    if ($seguido==0) {
						
						?>
						
						<div class="seguir divseguir<?php echo $iduser; ?>" id="<?php echo $iduser; ?>">Seguir</div>
						
						<?php 
						
						    }else {
						     
						        ?>
						        
						        <div class="seguir divseguir<?php echo $iduser; ?>" id="<?php echo $iduser; ?>">Siguiendo</div>
						        
						        <?php
						        
						    }
						
						}else {
						
						?>
						
						<a href="cerrarsesion.php"><div>Cerrar sesión</div></a>
						
						<?php 
						
						}
						
						?>
				
					</nav>
				
					<div id="songs">
					
					<?php 
					
					try {
					    
					    $registrospagina=14;
					    
					    if(isset($_GET["numeropagina"])){
					        
					        $inicio_registros=$_GET["numeropagina"];
					        
					    }else{
					        
					        $inicio_registros=1;
					    }
					    
					    $inicio_paginacion=($inicio_registros-1)*$registrospagina;
					    
					    $consulta_cantidad="CALL GET_USER_SONGS_COUNT(:iduser)";
					    
					    $resultado=$conexion->prepare($consulta_cantidad);
					    
					    if (isset($iduser)) {
					        
					        $resultado->execute(array(":iduser"=>$iduser));
					    }
					    else {
					        
					        $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
					    }
					    
					    $totalresultados=$resultado->rowCount();
					    
					    $limitepaginas=ceil($totalresultados/$registrospagina);
					    
					    $resultado->closeCursor();
					    
					    $consultasongs="CALL GET_USER_SONGS(:iduser,:idusertwo,:iniciopaginacion,:registrospagina)";
					    
					    $resultado=$conexion->prepare($consultasongs);
					    
					    if (isset($iduser)) {
					        
					        $resultado->execute(array(":iduser"=>$_SESSION["idusu"],":idusertwo"=>$iduser,":iniciopaginacion"=>$inicio_paginacion,":registrospagina"=>$registrospagina));
					    }
					    else {
					        
					        $resultado->execute(array(":iduser"=>$_SESSION["idusu"],":idusertwo"=>$_SESSION["idusu"],":iniciopaginacion"=>$inicio_paginacion,":registrospagina"=>$registrospagina));
					    }
					    
					    $rows=$resultado->rowCount();
					    
					    while ($filas=$resultado->fetch(PDO::FETCH_ASSOC)) {
					        
					        $cantidadlikescancion=$filas["CANTIDAD_LIKES"];
					        
					        $cantidaddislikescancion=$filas["CANTIDAD_DISLIKES"];
					        
					        ?>
					        
					        <div class="songcontainer">
					        
					        	<div class="imagecontainer">
					        	
					        	<?php 
					        	
					        	if($filas["IMAGEN_CANCION"]==''){
					        	
					        	?>
					        	
					        		<img src="/MIXWORLD/intranet/songsimages/default.png">
					        		
					        	<?php 
					        	
					        	}else{
					        	
					        	?>
					        	
					        		<img src="/MIXWORLD/intranet/songs/<?php echo $filas["IMAGEN_CANCION"]; ?>">
					        	
					        	<?php 
					        	
					        	}
					        	
					        	?>
					        	
					        	</div>
					        	<div class="titleplayercontainer">
					        	
					        		<div class="titlecontainer">
					        		
					        			<div><?php echo $filas["TITULO"]; ?></div>
					        			
					        			<div class='divoptionstwo'><i class="fa-solid fa-ellipsis-v"></i></div>
					        			
					        			<?php 
					        			
					        			if ($validaid || !isset($iduser)) {
					        			
					        			?>
					        			
					        			<div class='divoptions'><i class="fa-solid fa-ellipsis-v optionlink" id="<?php echo $filas["ID"]; ?>"></i></div>
					        			
					        			<?php 
					        			
					        			}
					        			
					        			?>
					        			
					        		
					        		</div>
					        		
					        		
				        			<div class="dropdownoptions options<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>">
					        		
					        			<ul>
				        			
    				        				<li><a href="eliminacancion.php?id=<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-trash deleteicon"></i></a></li>
    				        				
    				        				<li><a href="updatesong.php?idsong=<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-pen editicon"></i></a></li>
			        			
			        					</ul>
					        		
					        		</div>
					        		
					        		<div class="usercontainer">
					        		
					        		<?php 
					        		
					        		if ($filas["IMAGEN_PERFIL"]=='') {
					        		
					        		?>
					        		
					        			<img src="/MIXWORLD/intranet/songsimages/defaultuser.png">
					        			
					        		<?php 
					        		
					        		}else {
					        		
					        		?>
					        		
					        			<img src="/MIXWORLD/intranet/perfiles/<?php echo $filas["IMAGEN_PERFIL"]; ?>">
					        		
					        		<?php 
					        		
					        		}
					        		
					        		?>
					        			
					        			<span><?php echo $filas["USUARIO"]; ?></span>
					        		
					        		</div>
					        		<div class="playercontainer">
					        		
					        			<div class="playicon">
					        			
					        				<i class="fa-solid fa-play play inicio<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $filas["CANCION"]; ?>"></i>
					        				
					        				<i class="fa-solid fa-pause pause detener<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $filas["CANCION"]; ?>"></i>
					        			
					        			</div>
					        			<div class="bar barra<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>">
					        			
					        				<div id="<?php echo $filas["ID"]; ?>" class="progress progreso<?php echo $filas["ID"]; ?>"></div>
					        			
					        			</div>
					        		
					        		</div>
					        		<div class="viewscontainer">
					        		
					        			<span class="rep<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $filas["REPRODUCCIONES"]; ?></span>
					        			
					        			<?php 
					        			
					        			if ($cantidadlikescancion<1) {
					        			  
					        			?>
					        			
					        			<span class="likesong spanlike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-regular fa-face-smile-wink"></i><?php echo $filas["LIKES"]; ?></span>
					        			
					        			<?php 
					        			
					        			}else {
					        			
					        			?>
					        			
					        			<span class="likesong spanlike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-face-smile-wink"></i><?php echo $filas["LIKES"]; ?></span>
					        			
					        			<?php 
					        			
					        			}
					        			if ($cantidaddislikescancion<1) {
					        			    
					        			?>
					        			
					        			<span class="dislikesong spandislike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-regular fa-face-sad-tear"></i><?php echo $filas["DISLIKES"]; ?></span>
					        			
					        			<?php
					        			
					        			}else {
					        			
					        			?>
					        			
					        			<span class="dislikesong spandislike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-face-sad-tear"></i><?php echo $filas["DISLIKES"]; ?></span>
					        			
					        			<?php 
					        			
					        			}
					        			
					        			?>
					        		
					        		</div>
					        	
					        	</div>
					        
					        </div>
					        
					        <?php 
					    }

					    if ($rows==0) {
					        
					        ?>
					        
					        <span class="nosongsmessage">No hay canciones</span>
					        
					        <?php
					    }else {
					    ?>
					    
					    <div class="contenedor_paginacion">
					    
					    	<?php 
					    	
					    	if (isset($iduser)) {
					    	    
					    	    for ($i = 1; $i <= $limitepaginas; $i++) {
					    	        
					    	        echo "<a href='?iduser=". $iduser ."?numeropagina=" . $i . "'><i class='fa-solid fa-music'></i><br>" . $i . "</a>";
					    	    }
					    	}else {
					    	 
					    	    for ($i = 1; $i <= $limitepaginas; $i++) {
					    	        
					    	        echo "<a href='?numeropagina=" . $i . "'><i class='fa-solid fa-music'></i><br>" . $i . "</a>";
					    	    }
					    	}
					    	
					    	?>
					    
					    </div>
					    
					    <?php
					    
					    }
					    
					} catch (Exception $e) {
					    
					    die("Error: " . $e->getMessage());
					}
					
					?>
				
									
		        		<div class="playercontainers">
		        		
		        			<div class="playicon">
		        			
		        				<i class="fa-solid fa-play play "></i>
		        				
		        				<i class="fa-solid fa-pause pause "></i>
		        			
		        			</div>
		        			<div class="bar">
		        			
		        				<div class="progress"></div>
		        			
		        			</div>
		        		
		        		</div>
					        
					</div>
					
					<div id="uploadsongs">
					
						<form action="subecancion.php" enctype="multipart/form-data" method="post">
						
							<div class="uploadsongstwo">
							
								<h2 id="tituloformsongs">Subir canción</h2>
								
								<div class="chosefile">
								
									<input type="file" id="songselect" hidden="hidden" name="song">
								
									<div id="uploadsongbutton">Seleccionar canción</div>
									
									<br>
								
									<span id="filenameone">Ningún archivo seleccionado</span>
								
								</div>
								
								<br>
								
								<div class="chosefiletwo">
								
									<input type="file" id="imageselect" hidden="hidden" name="imagesong">
								
									<div id="uploadimagesongbutton">Seleccionar imagen</div>
									
									<br>	
								
									<span id="filenametwo">Ningún archivo seleccionado</span>
								
								</div>
								
								<br>
								
								<br>
								
								<div class="inputWithIcon" id="divsongtitle">
								
									<i class="fa-solid fa-pen-to-square icono" id="titleicon"></i>
							
									<input type="text" name="titulo" id="campotitulo" class="datos" placeholder="Titulo" maxLength="90" required>
									
									<span class="focus-border"><i></i></span>
							
								</div>
								
								<br>
								
								<div class="contarea">
							
									<textarea name="area" id="desc" placeholder="Descripción de canción" maxlength="900" required></textarea>
							
									<span class="focus-border"><i></i></span>
							
								</div>
								
								<p><span class="counter">0</span>/900</p>
								
								<input type="submit" id="botonregistrados" value="Subir" name="subecancion" hidden="hidden">
								
								<div id="botonregistra">Subir</div>
							
							</div>
						
						</form>
					
					</div>
					
					<div class="deleteaccount">
					
						<form action="eliminarcuenta.php">
						
							<h3>¿De verdad desea eliminar la cuenta?</h3>
							
							<br>
							
							<div class="contelimina">
							
								<input type="submit" id="botonelimina" value="Eliminar" name="eliminacuenta" hidden="hidden">
							
								<div class="cierra" id="deleteaccountbutton">Eliminar</div>
							
							</div>
						
						</form>
					
					</div>
			
				</div>
			
			</div>
		
		</div>
	
	</body>


	

</html>