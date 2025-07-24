<!DOCTYPE html>
<html>

	<head>
	
		<?php 
        
            session_start();
        
        ?>
        
        <meta charset="utf-8">
        
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        
        <title>MIXWORLD | Canción</title>
        
        <link rel="stylesheet" href="cancion.css?v=<?php echo time(); ?>">
        
        <script src="https://kit.fontawesome.com/f221aee085.js"></script>
        
        <script src="jquery-1.8.3.js"></script>
        
        <script src="cancion.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="reproducciones.js?v=<?php echo time(); ?>"></script>
        
        <?php 
        
        if (isset($_SESSION["idusu"])){
            
            $buscador='';
        }
        else {
            
            header("location:index.php");
        }
        
        if (isset($_POST['busca'])) {
            
            $buscador=$_POST["buscador"];
            
            $_SESSION["buscador"]=$buscador;
            
        }else if(!isset($_SESSION["buscador"])){
            $buscador='';
        }
        else {
            
            $buscador=$_SESSION["buscador"];
            
            if (!isset($_POST["busca"]) && !isset($_GET["numeropagina"])) {
                unset($_SESSION["buscador"]);
                
                $buscador='';
            }
        }
        
        $conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
        
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $conexion->exec("SET CHARACTER SET utf8");
        
        $consulta="CALL GET_PROFILE_IMAGE(:iduser)";
        
        $resultado=$conexion->prepare($consulta);
        
        $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
        
        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
            
            $profileimage=$fila["IMAGEN_PERFIL"];
        }
        
        ?>
	
	</head>
	<body>
	
		<header class="background">
		
			<nav class="secondnav">
			
				<div class="nav-left">
				
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
				
				</div>
				
				<div class="nav-center">
				
					<form action="<?php $_SERVER["PHP_SELF"] ?>" method='POST'>
					
						<div class="search-box">
						
							<input type="search" placeholder="Buscar..." class="buscador" name="buscador">
        				
        					<span class="fas fa-search searchicon" id="searchicon"></span>
        					
        					<input type="submit" id="botonbusca" hidden="hidden" name='busca'>
        			
        				</div>
					
					</form>
				
				</div>
				
				<div class="nav-right">
				
					<label for="check">
					
						<a href="cuenta.php">
				
    						<span class="imagediv">
    						
    							<?php 
    							
    							if ($profileimage=='') {
    							?>
    							
    							<img src="../intranet/songsimages/defaultuser.png" class="imguser"></img>
    							
    							<?php
    							}else {
    							    
    							?>
    							
    							<img src="../intranet/perfiles/<?php echo $profileimage; ?>" class="imguser"></img>
    							
    							<?php
    							}
    							
    							?>
    					
    						</span>
					
						</a>
					
					</label>
				
				</div>
				
			</nav>
		
		</header>
		
		<?php
		
		if($buscador==''){
		
		?>
		
		<section class="sectionone">
		
			<?php
		
			try{
		    
		    $idcancion=$_GET["song"];
		    
		    $consulta="CALL GET_SONG(:idsong,:iduser)";
		    
		    $resultado=$conexion->prepare($consulta);
		    
		    $resultado->execute(array(':idsong'=>$idcancion,":iduser"=>$_SESSION["iduser"]));
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		        
		        $idsong=$fila["ID"];
		        
		        $cantidadlikescancion=$fila["CANTIDAD_LIKES"];
		        
		        $cantidaddislikescancion=$fila["CANTIDAD_DISLIKES"];
		        
		        ?>
		        
		        <div class="songtwocontainer">
			
        			<div class="imagecontainer">
        			
        			<?php 
        			
        			if ($fila["IMAGEN_CANCION"]=='') {
        			
        			?>
        			
        				<img src="../intranet/songsimages/default.png">
        				
        				
        			<?php 
        			
        			}else {
        			
        			?>
        			
        				<img src="../intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
        			
        			<?php 
        			
        			}
        			
        			?>
        			
        			</div>
        			<div class="titleplayercontainer">
        			
        				<div class="titlecontainer">
        				
        					<span><?php echo htmlspecialchars($fila["TITULO"]); ?></span>	
        				
        				</div>
        				<div class="usercontainer">
        				
        				<?php 
        				
        				if ($fila["IMAGEN_PERFIL"]=='') {
        				
        				?>
			         		
		         			<img src="../intranet/songsimages/defaultuser.png">
		         			
		         		<?php 
		         		
        				}else {
		         		
		         		?>
		         		
		         			<img src="../intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
		         		
		         		<?php 
		         		
        				}
		         		
		         		?>
		         			
		         			<span><a href="cuenta.php?user=<?php echo $fila["IDHASH"]; ?>"><?php echo htmlspecialchars($fila["USUARIO"]); ?></a></span>
		         			
		         			<span>|</span>
		         			
		         			<span><?php echo $fila["FECHA_HORA_DE_SUBIDA"]; ?></span>
		         		
		         		</div>
		         		<div class="playercontainer">
			         		
		         			
		         			
		         			<audio src="../intranet/songs/<?php echo $fila["CANCION"]; ?>" class="audio" id="audios<?php echo $fila["ID"]; ?>"></audio>
		         			
		         			<div class="bar barra<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>">
		         			
		         				<div id="<?php echo $fila["ID"]; ?>" class="progress progreso<?php echo $fila["ID"]; ?>"></div>
		         			
		         			</div>
		         		
		         		</div>
		         		
		         		<div class="playicon">
		         			
		         			<div class="playi">
		         			
		         				<i class="fa-solid fa-play play inicio<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"></i>
	         				
	         					<i class="fa-solid fa-pause pause detener<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"></i>
		         			
		         			</div>
		         			<div class="downloadcontainer">
    		         			
        	         				<a href="../intranet/songs/<?php echo $fila["CANCION"] ?>" download><i class="fa-solid fa-download"></i></a>
        	         			
    	         			</div>
	         				
	         			
	         			</div>
		         		
		         		<div class="likescontainer">
			         		
			         			<span class="rep<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $fila["REPRODUCCIONES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 if ($cantidadlikescancion<1) {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }
			         			 if($cantidaddislikescancion<1){
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }
			         			
			         			?>
			         		
			         		</div>
        			</div>
    			
    			</div>
    			
    			<div class="descriptioncontainer">
    			
    				<h2>DESCRIPCIÓN</h2>
    				
    				<div class="description"><?php echo htmlspecialchars($fila["DESCRIPCION"]); ?></div>
    			
    			</div>
    			
    			<div class='commentscontainer'>
    			
    				<h2>COMENTARIOS</h2>
    				
    				<div class="formcomments">
    				
    					<form action="subecomentario.php" class="mainform" enctype="multipart/form-data" method="post" data-ajax="false">
    					
    						<div class="areacontainer" id="divarea">
    						
    							<textarea cols="66" rows="3" placeholder="Comenta aquí..." id="textarea" name="comenta" maxlength="400" minlength="1"></textarea>
    							
    							<span class="focus-border"><i></i></span>
    						
    						</div>
    						
    						<p><span class="size">0</span>/400</p>
        					
        					<input type="submit" id="botoncomentar" value="Comentar">
        					
        					<div id="botoncomenta">Comentar</div>
    				
    					</form>
    				
    				</div>
		        </div>
		        <?php 
		        
		        $_SESSION["idcancion"]=$fila["ID"];
		        
		        $_SESSION["idsong"]=$_GET["song"];
		    }
		    
		    $consultacomentarios="CALL GET_COMMENTS(:idsong)";
		    
		    $resultado=$conexion->prepare($consultacomentarios);
		    
		    $resultado->execute(array(":idsong"=>$idsong));
		    ?>
                <div class='divcomment'>
            <?php
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
                
		        $idusuario=$fila["ID_USUARIO"];
		        ?>
		        
		        	<div class="commentmain">
		        	
		        		<div class="comment" id="c<?php echo $fila["ID"];?>">
    		        
        		        	<div class="infocommentdiv comment<?php echo $fila["ID"]; ?>">
        		        	
        		        		<div class="profilecomment">
        		        	
                		        	<?php 
                		        	
                		        	if ($fila["IMAGEN_PERFIL"]=='') {
                		        	
                		        	?>
                		        
                		        		<div><img src="../intranet/songsimages/defaultuser.png"></div>
                		        		
                		        	<?php 
                		        	
                		        	}else {
                		        	
                		        	?>
                		        	
                		        		<div><img src="../intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>"></div>
                		        	
                		        	<?php 
                		        	
                		        	}
                		        	
                		        	?>
            		        	
            		        		<div class="username"><?php echo htmlspecialchars($fila["USUARIO"]); ?></div>
            		        		
            		        		<span>|</span>
            		        		
            		        		<span class="commentdate"><?php echo $fila["FECHA_COMENTARIO"]; ?></span>
        		        
            		        	</div>
            		        	<div class="commentcontent">
            		        	
            		        		<span class="spancomment scomment<?php echo $fila["ID"]; ?>"><?php echo htmlspecialchars($fila["COMENTARIO"]); ?></span>
            		        	
            		        	</div>
        		        	
        		        	</div>
        		        
        		        <?php 
        		        
        		        if ($idusuario==$_SESSION["iduser"]) {
        		        
        		        ?>
        		        
        		        	<div class="options ocomment<?php echo $fila["ID"]; ?>">
        		        	
        		        		<div class="divoptions" id="doptions<?php echo $fila["ID"]; ?>">
        		        		
        		        			<div class="divoptionstwo">
        		        			
        		        				<div>
        		        			
        		        					<a href="deletecomment.php?id=<?php echo $fila["ID"]; ?>&idsong=<?php echo $fila["ID_CANCION"]; ?>"><i class="fa-solid fa-trash deleteicon"></i></a>
            		        			
            		        			</div>
            		        			<div>
            		        			
            		        				<i class="fa-solid fa-pen editicon" id="<?php echo $fila["ID"]; ?>"></i>
            		        			
            		        			</div>
        		        			
        		        			</div>
        		        		
        		        		</div>
        		        		<div class="divicon">
        		        		
        		        			<i class="fa-solid fa-ellipsis-v optionlink" id="<?php echo $fila["ID"]; ?>"></i>
        		        		
        		        		</div>
        		        	
        		        	</div>
        		        
    		        	<?php 
    		        	
    	                }
    		        	
    		        	?>
        		        	<div class="optionstwo">
        		        	
        		        		<div class="divoptions">
        		        		
        		        			<i class="fa-solid fa-trash deleteicon"></i>
        		        			
        		        			<i class="fa-solid fa-pen editicon"></i>
        		        		
        		        		</div>
        		        		<div class="divicon">
        		        		
        		        			<i class="fa-solid fa-ellipsis-v optionlink"></i>
        		        		
        		        		</div>
        		        	
        		        	</div>
        		        
        		        </div>
		        	
		        		<div class="editcomment" id="edit<?php echo $fila["ID"]; ?>">
    		        	
    		        		<div class="editcommenttwo">
    		        		
    		        			<div class="divform">
    		        		
        		        			<form action="editcomment.php" method="post">
        		        			
        		        				<div class="textareaeditdiv">
        		        				
        		        					<textarea class="tarea starea<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" maxlength="400"><?php echo htmlspecialchars($fila["COMENTARIO"]); ?></textarea>
        		        				
        		        					<span class="focus-border"><i></i></span>
        		        				
        		        				</div>
        		        				
        		        				<p><span class="sizetwo<?php echo $fila["ID"]; ?>"><?php echo $fila["LONGITUD"]; ?></span>/400</p>
        		        				
        		        				<input type="submit" name="editarcomentario" hidden="hidden">
        		        				
        		        				<div class="editcommentbutton" id="<?php echo $fila["ID"]; ?>">
        		        				
        		        					<span>Editar</span>
        		        				
        		        				</div>
        		        			
        		        			</form>
        		        		
        		        		</div>
        		        		<div class="divclose">
        		        		
        		        			<i class="fa-solid fa-xmark closeedit" id="<?php echo $fila["ID"]; ?>"></i>
        		        		
        		        		</div>
    		        		
    		        		</div>
    		        		
    		        	</div>
		        	
		        	</div>
		        
    		        
		        
		        <?php
		    }
		    
		  }catch(Exception $e){
		    
		    die("Error: " . $e->getMessage());
		  }
		
		?>
			</div>
		
		</section>
		
		<?php 
		
		}else {
		    
		    try {
		        
		        $registros_pagina=14;
		        
		        if (isset($_GET["numeropagina"])) {
		            
		            $inicio_registros=$_GET["numeropagina"];
		        }else {
		            
		            $inicio_registros=1;
		        }
		        
		        $inicio_paginacion=($inicio_registros-1)*$registros_pagina;
		        
		        $consulta_cantidad="CALL GET_SONGS_COUNT(:titulo)";
		        
		        $resultado=$conexion->prepare($consulta_cantidad);
		        
		        $resultado->execute(array(":titulo"=>strval($buscador)));
		        
		        $totalresultados=$resultado->rowCount();
		        
		        $limitepaginas=ceil($totalresultados/$registros_pagina);
		        
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
		        
		        $consultabusqueda="CALL GET_SONGS_TWO(:buscador,:iniciopaginacion,:registrospagina,:iduser)";
		        
		        $resultado=$conexion->prepare($consultabusqueda);
		        
		        $resultado->execute(array(":buscador"=>$buscador,":iniciopaginacion"=>$inicio_paginacion,":registrospagina"=>$registros_pagina,":iduser"=>$_SESSION["idusu"]));
		        
		        echo "<section class='sectionsongs'>";
		        
		        while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		            
		            $id=$fila["ID"];
		            
		            $cantidadlikescancion=$fila["CANTIDAD_LIKES"];
		            
		            $cantidaddislikescancion=$fila["CANTIDAD_DISLIKES"];
		            
		            ?>
		            
		            <div class="songcontainer">
			         
			         	<div class="imagecontainer">
			         	
			         	<?php 
			         	
			         	if($fila["IMAGEN_CANCION"]==''){
			         	
			         	?>
			         	
			         		<img src="../intranet/songsimages/default.png">
			         	
			         	<?php 
			         	
			         	}else{
			         	
			         	?>
			         	
			         		<img src="../intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
			         		
			         	<?php 
			         	
			         	}
			         	
			         	?>
			         	
			         	</div>
			         	<div class="titleplayercontainer">
			         	
			         		<div class="titlecontainer">
			         		
			         			<a href='cancion.php?song=<?php echo $fila["IDHASH"];?>' class='link'><span><?php echo htmlspecialchars($fila["TITULO"]); ?></span></a>
			         		
			         		</div>
			         		<div class="usercontainer">
			         		
			         			<img src="../intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
			         			
			         			<span><a href="cuenta.php?user=<?php echo $fila["IDH"]; ?>"><?php echo htmlspecialchars($fila["USUARIO"]); ?></a></span>
			         		
			         		</div>
			         		<div class="playercontainer">
			         		
			         			<div class="playicon">
			         			
			         				<i class="fa-solid fa-play play inicio<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"></i>
			         				
			         				<i class="fa-solid fa-pause pause detener<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"></i>
			         			
			         			</div>
			         			
			         			<audio src="../intranet/songs/<?php echo $fila["CANCION"]; ?>" class="audio" id="audios<?php echo $fila["ID"]; ?>"></audio>
			         			
			         			<div class="bar barra<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>">
			         			
			         				<div id="<?php echo $fila["ID"]; ?>" class="progress progreso<?php echo $fila["ID"]; ?>"></div>
			         			
			         			</div>
			         		
			         		</div>
			         		<div class="likescontainer">
			         		
			         			<span class="rep<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $fila["REPRODUCCIONES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 if ($cantidadlikescancion<1) {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			
			         			?>
			         			
			         			<span class="likesong spanlike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }
			         			 if($cantidaddislikescancion<1){
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-regular fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php 
			         			
			         			 }else {
			         			     
			         			
			         			?>
			         			
			         			<span class="dislikesong spandislike<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
			         			
			         			<?php  
			         			     
			         			
			         			 }
			         			
			         			?>
			         		
			         		</div>
			         	
			         	</div>
			         
			         </div>
		            
		            <?php
		        }
		        
		        echo "</section>";
		        
		        ?>
		        
		        <div class='contenedor_paginacion'>
		        
		        <?php 
		        
		        if ($inicio_registros>1) {
	            
		           echo "<a href='?numeropagina=" . ($inicio_registros-1) . "'>";
		            
	            ?>
	            
	            	&laquo;
	            
	            <?php
	            
	               echo "</a>";
		        }
		        
		        ?>
		        
		        <?php 
		        
		        for ($i = $numero_inicio; $i <= $numero_final; $i++) {
		            
		            echo "<a href='?numeropagina=" . $i . "'><i class='fa-solid fa-music'></i><br>" . $i . "</a>";
		        }
		        
		        ?>
		        
		        <?php 
		        
		        if ($inicio_registros<$limitepaginas) {
		            
		            echo "<a href='?numeropagina=" . ($inicio_registros+1) . "'>";
		            
	            ?>
	            
	            	&raquo;
	            
	            <?php
	            
	               echo "</a>";
		        }
		        
		        ?>
		        
		        </div>
		        
		        <?php
		        
		    } catch (Exception $e) {
		        
		        die("Error: " . $e->getMessage());
		    }
		    $resultado->closeCursor();
		    ?> 
		     <div class="formcommentstwo">
    				
				<form action="subecomentario.php" class="mainform" enctype="multipart/form-data" method="post" data-ajax="false">
				
					<div class="areacontainer" id="divarea">
					
						<textarea cols="66" rows="3" placeholder="Comenta aquí..." id="textarea" name="comenta" maxlength="900" minlength="1"></textarea>
						
						<span class="focus-border"><i></i></span>
					
					</div>
					
					<p><span class="size">0</span>/900</p>
					
					<input type="submit" id="botoncomentar" value="Comentar">
					
					<div id="botoncomenta">Comentar</div>
			
				</form>
			
			</div>
		    <?php
		}
		
		?>
	
	</body>
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
</html>