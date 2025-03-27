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
        
        <script src="manejareproducciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <?php 
        
        if (isset($_SESSION["usuario"])){
            
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
    							
    							<img src="/MIXWORLD/intranet/songsimages/defaultuser.png" class="imguser"></img>
    							
    							<?php
    							}else {
    							    
    							?>
    							
    							<img src="/MIXWORLD/intranet/perfiles/<?php echo $profileimage; ?>" class="imguser"></img>
    							
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
		    
		    $idcancion=$_GET["id"];
		    
		    $consulta="CALL GET_SONG(:idsong,:iduser)";
		    
		    $resultado=$conexion->prepare($consulta);
		    
		    $resultado->execute(array(':idsong'=>$idcancion,":iduser"=>$_SESSION["idusu"]));
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		        
		        $cantidadlikescancion=$fila["CANTIDAD_LIKES"];
		        
		        $cantidaddislikescancion=$fila["CANTIDAD_DISLIKES"];
		        
		        ?>
		        
		        <div class="songtwocontainer">
			
        			<div class="imagecontainer">
        			
        			<?php 
        			
        			if ($fila["IMAGEN_CANCION"]=='') {
        			
        			?>
        			
        				<img src="/MIXWORLD/intranet/songsimages/default.png">
        				
        				
        			<?php 
        			
        			}else {
        			
        			?>
        			
        				<img src="/MIXWORLD/intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
        			
        			<?php 
        			
        			}
        			
        			?>
        			
        			</div>
        			<div class="titleplayercontainer">
        			
        				<div class="titlecontainer">
        				
        					<span><?php echo $fila["TITULO"]; ?></span>	
        				
        				</div>
        				<div class="usercontainer">
        				
        				<?php 
        				
        				if ($fila["IMAGEN_PERFIL"]=='') {
        				
        				?>
			         		
		         			<img src="/MIXWORLD/intranet/songsimages/defaultuser.png">
		         			
		         		<?php 
		         		
        				}else {
		         		
		         		?>
		         		
		         			<img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
		         		
		         		<?php 
		         		
        				}
		         		
		         		?>
		         			
		         			<span><a href="cuenta.php?iduser=<?php echo $fila["iduser"]; ?>"><?php echo $fila["USUARIO"]; ?></a></span>
		         		
		         		</div>
		         		<div class="playercontainer">
			         		
		         			<div class="playicon">
		         			
		         				<i class="fa-solid fa-play play inicio<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
		         				
		         				<i class="fa-solid fa-pause pause detener<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
		         			
		         			</div>
		         			
		         			<div class="bar barra<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>">
		         			
		         				<div id="<?php echo $fila["ID"]; ?>" class="progress progreso<?php echo $fila["ID"]; ?>"></div>
		         			
		         			</div>
		         			
		         			<div class="downloadcontainer">
		         			
		         				<a href="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>" download><i class="fa-solid fa-download"></i></a>
		         			
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
    				
    				<div class="description"><?php echo $fila["DESCRIPCION"]; ?></div>
    			
    			</div>
    			
    			<div class='commentscontainer'>
    			
    				<h2>COMENTARIOS</h2>
    				
    				<div class="formcomments">
    				
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
		        </div>
		        <?php 
		        
		        $_SESSION["idcancion"]=$fila["ID"];
		    }
		    
		    $consultacomentarios="CALL GET_COMMENTS(:idsong)";
		    
		    $resultado=$conexion->prepare($consultacomentarios);
		    
		    $resultado->execute(array(":idsong"=>$idcancion));
		    ?>
                <div class='divcomment'>
            <?php
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
                
		        
		        ?>
		        
    		        <div class="comment">
    		        
    		        	<div class="profilecomment">
    		        	
    		        	<?php 
    		        	
    		        	if ($fila["IMAGEN_PERFIL"]=='') {
    		        	
    		        	?>
    		        
    		        		<div><img src="/MIXWORLD/intranet/songsimages/defaultuser.png"></div>
    		        		
    		        	<?php 
    		        	
    		        	}else {
    		        	
    		        	?>
    		        	
    		        		<div><img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>"></div>
    		        	
    		        	<?php 
    		        	
    		        	}
    		        	
    		        	?>
    		        	
    		        		<div><?php echo $fila["USUARIO"]; ?></div>
    		        
    		        	</div>
    		        	<div class="date">
    		        
    		        		<span><?php echo $fila["FECHA_COMENTARIO"]; ?></span>
    		        
    		        	</div>
    		        	<div class="commentcontent">
    		        	
    		        		<span><?php echo $fila["COMENTARIO"]; ?></span>
    		        	
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
			         	
			         		<img src="/MIXWORLD/intranet/songsimages/default.png">
			         	
			         	<?php 
			         	
			         	}else{
			         	
			         	?>
			         	
			         		<img src="/MIXWORLD/intranet/songs/<?php echo $fila["IMAGEN_CANCION"]; ?>">
			         		
			         	<?php 
			         	
			         	}
			         	
			         	?>
			         	
			         	</div>
			         	<div class="titleplayercontainer">
			         	
			         		<div class="titlecontainer">
			         		
			         			<a href='cancion.php?id=<?php echo $id;?>' class='link'><span><?php echo $fila["TITULO"]; ?></span></a>
			         		
			         		</div>
			         		<div class="usercontainer">
			         		
			         			<img src="/MIXWORLD/intranet/perfiles/<?php echo $fila["IMAGEN_PERFIL"]; ?>">
			         			
			         			<span><a href="cuenta.php?iduser=<?php echo $fila["iduser"]; ?>"><?php echo $fila["USUARIO"]; ?></a></span>
			         		
			         		</div>
			         		<div class="playercontainer">
			         		
			         			<div class="playicon">
			         			
			         				<i class="fa-solid fa-play play inicio<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
			         				
			         				<i class="fa-solid fa-pause pause detener<?php echo $fila["ID"]; ?>" id="<?php echo $fila["ID"]; ?>" data-file="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"] ?>"></i>
			         			
			         			</div>
			         			
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

</html>