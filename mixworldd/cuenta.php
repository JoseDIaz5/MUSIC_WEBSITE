<!DOCTYPE html>
<html>

	<head>
	
		<?php 
        
            session_start();
            
            $id_user=isset($_SESSION["iduser"]) ? $_SESSION["iduser"] : null;
        
            $id_visitado=isset($_GET["user"]) ? $_GET["user"] : '';
            
            $id_sesion=isset($_SESSION["idusu"]) ? $_SESSION["idusu"] : null;
            
            $es_dueño=($id_sesion!=null && $id_sesion==$id_visitado);
            
            $es_otro_usuario=($id_sesion!=null && $id_sesion!=$id_visitado);
            
            $es_visitante_externo=($id_sesion==null);
        ?>
		<?php 
		
		$url_actual = "https://mixworld.com/cuenta.php?user=" . $id_visitado;
		
		$descripcion="Visita mi perfil en MIXWORLD";
						
		  try {
		      
		      include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
		      
		      $consultaperfil="CALL GET_USER_INFO(:id)";
		      
		      $consultaseguidores="CALL GET_FOLLOWERS(:iduserfollower,:iduserfollowed)";
		          
	          $resultado=$conexion->prepare($consultaperfil);
	          
	          $resultado->execute(array(":id"=>$id_visitado));
	          
	          while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
	              
	              $idu=$fila["ID"];
	              
	              $idusuario=$fila["IDHASH"];
	              
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
	          //https://mixworld.com/img/default-avatar.png
	          
	          $resultado->closeCursor();
	          
	          $resultadof=$conexion->prepare($consultaseguidores);
	          
	          $resultadof->execute(array(":iduserfollower"=>$id_user,":iduserfollowed"=>$idu));
	          
	          $row=$resultadof->rowCount();
	          
	          if ($row<1) {
	              $seguido=0;
	          }else{
	              $seguido=1;
	          }
	          $resultadof->closeCursor();
		      
		  } catch (Exception $e) {
		  
		      die("Error: " . $e->getMessage());
		  }
		
		?>
		<meta charset="utf-8">
		
		<meta property="og:type" content="profile">
		
		<meta property="og:url" content="<?php echo $url_actual; ?>">
		
        <meta property="og:title" content="<?php echo $usuario; ?>">
        
        <meta property="og:description" content="<?php echo $descripcion; ?>">
        
        <meta property="og:image" content="<?php echo "https://mixworld.com/intranet/songs/".$perfil; ?>">
        
        <meta property="twitter:card" content="summary_large_image">
    
        <meta property="twitter:url" content="<?php echo $url_actual; ?>">
        
        <meta property="twitter:title" content="<?php echo $usuario; ?>">
        
        <meta property="twitter:description" content="<?php echo $descripcion; ?>">
        
        <meta property="twitter:image" content="<?php echo "https://mixworld.com/intranet/songs/".$perfil; ?>">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD | Cuenta</title>

        <link rel="stylesheet" href="cuenta.css?v=<?php echo time(); ?>">

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-3.7.1.min.js"></script>
        
        <script src="cuenta.js?v=<?php echo time(); ?>"></script>
        
        <script src="reproducciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
	
	</head>
	<body>
	
		
	
		<div class="header_wrapper">
		
			<?php 
			
			 if ($portada!=null) {
			
			?>
		
			<header style="background: url('./intranet/perfiles/<?php echo $portada; ?>'); background-size: 100% 100%"></header>
			
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
						
						if ($es_dueño && $perfil!=null) {   
						
						?>
					
						<img src="./intranet/perfiles/<?php echo $perfil; ?>">
						
						<a href="editarperfil.php?id=<?php echo $id_visitado; ?>"><span><i class="fa-solid fa-pen editicon"></i></span></a>
						
						<?php  
						
						  }elseif($es_dueño && $perfil==null){
						
						?>
						
						<img src="./intranet/songsimages/defaultuser.png"></img>
						
						<a href="editarperfil.php?id=<?php echo $id_visitado; ?>"><span><i class="fa-solid fa-pen editicon"></i></span></a>
						
						<?php 
						
						  }elseif($es_otro_usuario && $perfil!=null){
						
						?>
						
						<img src="./intranet/perfiles/<?php echo $perfil; ?>">
						
						<?php 
						
						 }elseif($es_otro_usuario && $perfil==null){
						
						?>
						
						<img src="./intranet/songsimages/defaultuser.png"></img>
						
						<?php 
						
						 }elseif ($es_visitante_externo && $perfil!=null){
						
						?>
						
						<img src="./intranet/perfiles/<?php echo $perfil; ?>">
						
						<?php 
						
						 }elseif ($es_visitante_externo && $perfil==null){
						
						?>
						
						<img src="./intranet/songsimages/defaultuser.png"></img>
						
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
							
							<li class="enlacered"><a href="https://www.x.com/<?php echo htmlspecialchars($xuser); ?>/"><i class="fa-brands fa-x-twitter"></i></a></li>
							
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
							    
							    <li class="enlacered"><a href="https://www.facebook.com/<?php echo htmlspecialchars($facebookuser); ?>/"><i class="fab fa-facebook"></i></a></li>
							    
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
							
							<li class="enlacered"><a href="https://www.instagram.com/<?php echo htmlspecialchars($instagramuser); ?>/"><i class="fab fa-instagram"></i></a></li>
							
							<?php 
							
							}
							?>
					
						</ul>
					
					</div>
					
					
					<?php 
					
					if ($es_dueño) {
					
					?>
					
					<div id="divshare">
					
						<span class="shareicon"><i class="fa-regular fa-share-from-square"></i></span>
					
					</div>
					
					<div id="shareicons">
					
						<span>
						
							<a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/mixworld/mixworldd/cuenta.php?user=<?php echo $id_visitado; ?>" target="\_blank\"><i class="fa-brands fa-square-facebook"></i></a>
							
							<a href="https://api.whatsapp.com/send?text=http://localhost/mixworld/mixworldd/cuenta.php?user=<?php echo $id_visitado; ?>" target="_blank"><i class="fa-brands fa-square-whatsapp"></i></a>
							
							<a href="https://twitter.com/intent/tweet?url=http://localhost/mixworld/mixworldd/cuenta.php?user=<?php echo $id_visitado; ?>" target="\_blank\"><i class="fa-brands fa-square-x-twitter"></i></a>
						
						</span>
					
					</div>
					
					
					
					<?php 
					
					}
					
					?>
					
					<div id="divshare" class="divshareprofile">
					
						<span class="shareicon"><i class="fa-regular fa-share-from-square"></i></span>
					
					</div>
					
					<div id="shareicons" class="shareprofileicons">
					
						<span>
						
							<a href="https://www.facebook.com/sharer/sharer.php?u=http://localhost/mixworld/mixworldd/cuenta.php?user=<?php echo $id_visitado; ?>" target="\_blank\"><i class="fa-brands fa-square-facebook"></i></a>
							
							<a href="https://api.whatsapp.com/send?text=http://localhost/mixworld/mixworldd/cuenta.php?user=<?php echo $id_visitado; ?>" target="_blank"><i class="fa-brands fa-square-whatsapp"></i></a>
							
							<a href="https://twitter.com/intent/tweet?url=http://localhost/mixworld/mixworldd/cuenta.php?user=<?php echo $id_visitado; ?>" target="\_blank\"><i class="fa-brands fa-square-x-twitter"></i></a>
						
						</span>
					
					</div>
					
				</div>
			
				<div class="right_col">
			
					<nav>
					
						<ul>
						
							<li id="contcanciones">Mis canciones</li>
							
							<?php 
							
							 if ($es_dueño) {
							
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
						
						if ($es_otro_usuario) {
						    
						    if ($seguido==0) {
						
        						?>
        						
        						<div class="seguir divseguir<?php echo $idu; ?>" id="<?php echo $idu; ?>">Seguir</div>
        						
        						<?php 
						
						    }else {
						     
						        ?>
						        
						        <div class="seguir divseguir<?php echo $idu; ?>" id="<?php echo $idu; ?>">Siguiendo</div>
						        
						        <?php
						        
						    }
						
						}elseif($es_dueño) {
						
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
					    
					    if ($es_otro_usuario || $es_visitante_externo) {
					        
					        $resultado->execute(array(":iduser"=>$idu));
					    }
					    else {
					        
					        $resultado->execute(array(":iduser"=>$id_user));
					    }
					    
					    $totalresultados=$resultado->rowCount();
					    
					    $limitepaginas=ceil($totalresultados/$registrospagina);
					    
					    $limitapaginas=3;
					    
					    if ($inicio_registros>$limitapaginas) {
					        
					        $numero_inicio=$inicio_registros-$limitapaginas;
					        
					    }else {
					        
					        $numero_inicio=1;
					    }
					    
					    if ($inicio_registros<($limitepaginas-$limitapaginas)) {
					        
					        $numero_final=$inicio_registros+$limitapaginas;
					        
					    }else {
					        
					        $numero_final=$limitepaginas;
					    }
					    
					    $resultado->closeCursor();
					    
					    $consultasongs="CALL GET_USER_SONGS(:iduser,:idusertwo,:iniciopaginacion,:registrospagina)";
					    
					    $resultado=$conexion->prepare($consultasongs);
					    
					    if ($es_otro_usuario || $es_visitante_externo) {
					        
					        $resultado->execute(array(":iduser"=>$id_user,":idusertwo"=>$idu,":iniciopaginacion"=>$inicio_paginacion,":registrospagina"=>$registrospagina));
					    }
					    else {
					        
					        $resultado->execute(array(":iduser"=>$id_user,":idusertwo"=>$idu,":iniciopaginacion"=>$inicio_paginacion,":registrospagina"=>$registrospagina));
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
					        	
					        		<img src="./intranet/songsimages/default.png">
					        		
					        	<?php 
					        	
					        	}else{
					        	
					        	?>
					        	
					        		<img src="./intranet/songs/<?php echo $filas["IMAGEN_CANCION"]; ?>">
					        	
					        	<?php 
					        	
					        	}
					        	
					        	?>
					        	
					        	</div>
					        	<div class="titleplayercontainer">
					        	
					        		<div class="songinfo">
					        		
    					        		<div class="songtitleuser">
    					        		
    					        			<div class="titlecontainer">
    					        		
        					        			<a href='cancion.php?song=<?php echo $filas["IDHASH"];?>' class='link'><span><?php echo htmlspecialchars($filas["TITULO"]); ?></span></a>
        					        		
        					        		</div>
        					        		
        					        		<div class="usercontainer">
    					        		
        					        		<?php 
        					        		
        					        		if ($filas["IMAGEN_PERFIL"]=='') {
        					        		
        					        		?>
        					        		
        					        			<img src="./intranet/songsimages/defaultuser.png">
        					        			
        					        		<?php 
        					        		
        					        		}else {
        					        		
        					        		?>
        					        		
        					        			<img src="./intranet/perfiles/<?php echo $filas["IMAGEN_PERFIL"]; ?>">
        					        		
        					        		<?php 
        					        		
        					        		}
        					        		
        					        		?>
        					        			
        					        			<span><?php echo htmlspecialchars($filas["USUARIO"]); ?></span>
        					        			
        					        			<span>|</span>
        					        			
        					        			<span><?php echo $filas["FECHA_HORA_DE_SUBIDA"]; ?></span>
        					        		
        					        		</div>
    					        		
    					        		</div>
    					        		
    					        		<div class="dropdownoptions options<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>">
    					        			
    					        			<div class='divoptionstwo'><i class="fa-solid fa-ellipsis-v"></i></div>
        					        			
    					        			<?php 
    					        			
    					        			if ($es_dueño) {
    					        			
    					        			?>
    					        			
    					        			<div class='divoptions'><i class="fa-solid fa-ellipsis-v optionlink" id="<?php echo $filas["ID"]; ?>"></i></div>
    					        			
    					        			<?php 
    					        			
    					        			}
    					        			
    					        			?>
    					        		
    					        			<div class="dropdownoptionstwo dropoptions<?php echo $filas["ID"]; ?>">
    				        			
        				        				<div>
        				        				
        				        					<a href="eliminacancion.php?id=<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-trash deleteicon"></i></a>
        				        				
        				        				</div>
        				        				
        				        				<div>
        				        				
        				        					<a href="updatesong.php?song=<?php echo $filas["IDHASH"]; ?>"><i class="fa-solid fa-pen editicon"></i></a>
        				        				
        				        				</div>
    			        			
    			        					</div>
    					        		
    					        		</div>
    					        	
    					        	</div>
    					        		
    				        		<div class="playercontainer">
    				        		
    				        			<div class="playicon">
    				        			
    				        				<i class="fa-solid fa-play play inicio<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>" ></i>
    				        				
    				        				<i class="fa-solid fa-pause pause detener<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"></i>
    				        			
    				        			</div>
    				        			
    				        			<audio src="./intranet/songs/<?php echo $filas["CANCION"]; ?>" class="audio" id="audios<?php echo $filas["ID"]; ?>"></audio>
    				        			
    				        			<div class="bar barra<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>">
    				        			
    				        				<div id="<?php echo $filas["ID"]; ?>" class="progress progreso<?php echo $filas["ID"]; ?>"></div>
    				        			
    				        			</div>
    				        			<?php 
    				        				
			        				    if($es_visitante_externo || $es_otro_usuario){
				        				    
				        				
				        				?>
    				        			<div class="downloadcontainer">
    				        				
    				        				<a href="./intranet/songs/<?php echo $filas["CANCION"]; ?>" download><i class="fa-solid  fa-download"></i></a>	
    				        			
    				        			</div>
    				        			
    				        			<?php 
    				        				
				        				}
				        				?>
    				        		
    				        		</div>
    				        		<div class="viewscontainer">
    				        		
    				        			<span class="rep<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $filas["REPRODUCCIONES"]; ?></span>
    				        			
    				        			<?php 
    				        			
    				        			if ($cantidadlikescancion<1 && ($es_dueño || $es_otro_usuario)) {
    				        			  
    				        			?>
    				        			
    				        			<span class="likesong spanlike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-regular fa-face-smile-wink"></i><?php echo $filas["LIKES"]; ?></span>
    				        			
    				        			<?php 
    				        			
    				        			}elseif($cantidadlikescancion>0 && ($es_dueño || $es_otro_usuario)) {
    				        			
    				        			?>
    				        			
    				        			<span class="likesong spanlike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-face-smile-wink"></i><?php echo $filas["LIKES"]; ?></span>
    				        			
    				        			<?php 
    				        			
    				        			}
    				        			if ($cantidaddislikescancion<1 && ($es_dueño || $es_otro_usuario)) {
    				        			    
    				        			?>
    				        			
    				        			<span class="dislikesong spandislike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-regular fa-face-sad-tear"></i><?php echo $filas["DISLIKES"]; ?></span>
    				        			
    				        			<?php
    				        			
    				        			}elseif($cantidaddislikescancion>0 && ($es_dueño || $es_otro_usuario)) {
    				        			
    				        			?>
    				        			
    				        			<span class="dislikesong spandislike<?php echo $filas["ID"]; ?>" id="<?php echo $filas["ID"]; ?>"><i class="fa-solid fa-face-sad-tear"></i><?php echo $filas["DISLIKES"]; ?></span>
    				        			
    				        			<?php 
    				        			
    				        			}
    				        			if($es_visitante_externo){
    				        			?>
    				        			
    				        			<span class="spanlike"><i class="fa-regular fa-face-smile-wink"></i><?php echo $filas["LIKES"]; ?></span>
    				        			
    				        			<span class="spandislike"><i class="fa-regular fa-face-sad-tear"></i><?php echo $filas["DISLIKES"]; ?></span>
    				        			
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
		
                    		if ($inicio_registros>1) {
                    		    
                    		    echo "<a href='?user=". $id_visitado ."&numeropagina=" . ($inicio_registros-1) . "'>";
                    		    
                    		?>
                    		    
                    		    &laquo;
                    		    
                    		<?php	
                    		
                    		    echo "</a>";
                    		
                    		}
                    
                    		?>
					    	<?php 
					    	    
					    	    for ($i = $numero_inicio; $i <= $numero_final; $i++) {
					    	        
					    	        if($i==$inicio_registros){
					    	            
					    	            echo "<span><i class='fa-solid fa-music'></i><br>" . $i . "</span>";
					    	        }else {
					    	            
					    	            echo "<a href='?user=". $id_visitado ."&numeropagina=" . $i . "'><i class='fa-solid fa-music'></i><br>" . $i . "</a>";
					    	            
					    	        }
					    	        
					    	        
					    	    }
					    	    ?>
					    	    <?php 
		
                        		if ($inicio_registros<$limitepaginas) {
                        		    
                        		    echo "<a href='?user=". $id_visitado ."&numeropagina=" . ($inicio_registros+1) . "'>";
                        		    
                        		?>
                        		    
                        		    &raquo;
                        		    
                        		<?php	
                        		
                        		    echo "</a>";
                        		
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
					
						<form action="subecancion.php" enctype="multipart/form-data" method="post" id="iform">
						
							<div class="uploadsongstwo">
							
								<h2 id="tituloformsongs">Subir canción</h2>
								
								<div class="chosefile">
								
									<input type="file" id="songselect" hidden="hidden" name="song" required>
								
									<div id="uploadsongbutton">Seleccionar canción</div>
									
									<br>
									
									<div><span id="filenameone">Ningún archivo seleccionado</span></div>
									
									<span id="filenametwo"></span>
									
									<span id="filenamethree"></span>
								
								</div>
								
								<br>
								
								<div class="chosefiletwo">
								
									<input type="file" id="imageselect" hidden="hidden" name="imagesong">
								
									<div id="uploadimagesongbutton">Seleccionar imagen</div>
									
									<br>	
								
									<span id="filenamei">Ningún archivo seleccionado</span>
								
								</div>
								
								<br>
								
								<br>
								
								<div class="inputWithIcon" id="divsongtitle">
								
									<i class="fa-solid fa-pen-to-square icono" id="titleicon"></i>
							
									<input type="text" name="titulo" id="campotitulo" class="datos" placeholder="Titulo" maxLength="90" required>
									
									<span class="focus-border"><i></i></span>
							
								</div>
								
								<br>
								
								<div class="inputWithIcon" id="divarea">
							
									<textarea cols="66" rows="3" name="area" id="desc" placeholder="Descripción de canción" maxlength="900" required></textarea>
							
									<span class="focus-border"><i></i></span>
							
								</div>
								
								<p><span class="counter">0</span>/900</p>
								
								<div class="divconfirmacion">
								
									<input type="checkbox" id="confirmacionderechos" name="confirmacionderechos" value="1" required>
									
									<label for="confirmacionderechos" class="confirmacionderechos">Confirmo que poseo los derechos de esta canción</label>
								
								</div>
								
								<input type="submit" id="botonregistrados" value="Subir" name="subecancion" hidden="hidden">
								
								<div id="progress-container" style="display:none; margin-top: 20px;">
								
                                    <progress id="progressBar" value="0" max="100" style="width:100%; height:20px;"></progress>
                                    
                                    <p id="statusText">0%</p>
                                    
                                </div>
								
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
		
		<footer class="pie">
	
    		<div>
    		
    			<a href="derechosautor.php">Política de derechos de autor</a>
    		
    		</div>
    		<span>|</span>
    		<div>
    		
    			<a href="terminosycondiciones.php">Términos y condiciones de uso</a>
    		
    		</div>
    		<span>|</span>
    		<div>
    		
    			<a href="politicadeprivacidad.php">Política de privacidad</a>
    		
    		</div>
    	
    	</footer>
	
	</body>
	

</html>