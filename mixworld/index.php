<!DOCTYPE html>
<html>

	<head>
	
		<meta charset="utf-8">

        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>MIXWORLD</title>

        <link rel="stylesheet" href="principal.css?v=<?php echo time(); ?>">

        <script src="https://kit.fontawesome.com/f221aee085.js"></script>

        <script src="jquery-1.8.3.js"></script>

        <script src="principal.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejalikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="manejadislikescanciones.js?v=<?php echo time(); ?>"></script>
        
        <script src="reproducciones.js?v=<?php echo time(); ?>"></script>
        
        <?php 
        
        session_start();
        
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
        
        ?>
	
	</head>
	
	<?php 
	
	$conexion=new PDO("mysql:host=localhost; port=3306; dbname=mixworld","root","");
	
	$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$conexion->exec("SET CHARACTER SET utf8");
	
	if (isset($_SESSION["idusu"])) {
	    
	    $consulta="CALL GET_PROFILE_IMAGE(:iduser)";

	    $resultado=$conexion->prepare($consulta);
	    
	    $resultado->execute(array(":iduser"=>$_SESSION["idusu"]));
	    
	    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
	        
	        $profileimage=$fila["IMAGEN_PERFIL"];
	    }
	}
	
	?>
	
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
						
							<input type="search" placeholder="Buscar..." class="buscador" name="buscador" value="<?php echo $buscador; ?>">
        				
        					<span class="fas fa-search searchicon" id="searchicon"></span>
        					
        					<input type="submit" id="botonbusca" hidden="hidden" name='busca'>
        			
        				</div>
					
					</form>
				
				</div>
				
				<div class="nav-right">
				
				<?php 
				
				if(!isset($_SESSION["idusu"])){
				
				?>
				
					<label for="check">
				
						<span class="imagediv">
					
							<i class="fa-solid fa-user"></i>
					
						</span>
					
					</label>
					
					<input type="checkbox" id="check" class="checkb">
					
					<div class="profileoptions">
					
						<ul class="list-profile">
					
							<li><a href="crearcuenta.php"><i class="fas fa-user"></i><span>Crear cuenta</span></a></li>
        				
        					<li><a href="iniciosesion.php"><i class="fas fa-user"></i><span>Iniciar sesión</span></a></li>
					
						</ul>
					
					</div>	
				
				<?php 
				
				}else {
				
				?>
				
				<label for="check">
				
					<a href="cuenta.php">
					
						<span class="imagediv">
						
							<?php 
							
							if ($profileimage=='') {
							
							?>
							
							<img src="/MIXWORLD/intranet/songsimages/defaultuser.png" class="imguser"></img>
							
							<?php 
							
							}else{
							
							?>
							
							<img src="/MIXWORLD/intranet/perfiles/<?php echo $profileimage; ?>" class="imguser"></img>
							
							<?php 
							
							}
							
							?>
						
						</span>
					
					</a>
				
				</label>
				
				<input type="checkbox" id="check" class="checkb">
				
				<?php 
				
				}
				
				?>
				
				</div>
				
			</nav>
		
		</header>
		
		<?php 
		
		if(!isset($_SESSION["idusu"])){
		
		?>
		
		<section>
		
		<?php 
		
		try{
		    
		    $registros_pagina=14;
		    
		    if(isset($_GET["numeropagina"])){
		        
		        $inicio_registros=$_GET["numeropagina"];
		    }else {
		     
		        $inicio_registros=1;
		    }
		    
		    $inicio_paginacion=($inicio_registros-1)*$registros_pagina;
		    
		    $consulta_cantidad="SELECT ID FROM canciones WHERE TITULO LIKE CONCAT('%',:buscador,'%')";
		    
		    $resultado=$conexion->prepare($consulta_cantidad);
		    
		    $resultado->execute(array(":buscador"=>strval($buscador)));
		    
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
		    
		    $consulta="CALL GET_SONGS(:buscador,:i_paginacion,:r_paginacion)";
		    
		    $resultado=$conexion->prepare($consulta);
		    
		    $resultado->execute(array(":buscador"=>strval($buscador),":i_paginacion"=>$inicio_paginacion,":r_paginacion"=>$registros_pagina));
		    
		    while ($fila=$resultado->fetch(PDO::FETCH_ASSOC)) {
		        
		        ?>
		        
		        <div class="songcontainer">
			
    				<div class="imagecontainer">
    				
    				<?php 
    				
    				if ($fila["IMAGEN_CANCION"]=='') {
    				
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
    					
    						<span class="user"><?php echo $fila["USUARIO"]; ?></span>
    					
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
    					<div class="viewscontainer">
    						
    						<span class="rep<?php echo $fila["ID"]; ?>"><i class="fa-solid fa-ear-listen"></i><?php echo $fila["REPRODUCCIONES"]; ?></span>
    						
    						<span><i class="fa-regular fa-face-smile-wink"></i><?php echo $fila["LIKES"]; ?></span>
    						
    						<span><i class="fa-regular fa-face-sad-tear"></i><?php echo $fila["DISLIKES"]; ?></span>
    					
    					</div>
    				
    				</div>
    			
    			</div>
		        
		        <?php 
		    }
		    
		    
		}catch(Exception $e){
		    
		    die("Error: " . $e->getMessage());
		}
		
		?>
		
		</section>
		
		<div class='contenedor_paginacion'>
		
		<?php 
		
		  if ($inicio_registros > 1) {
		      
		      echo "<a href='?numeropagina=" . ($inicio_registros-1) . "'>";
		      
		      ?>
		      
		      &laquo;
		      
		      <?php
		      
		      echo "</a>";
		  }
		
		  for ($i = $numero_inicio; $i <= $numero_final; $i++) {
		      
		      echo "<a href='?numeropagina=". $i ."'><i class='fa-solid fa-music'></i><br>". $i ."</a>";
		  }
		
		  if ($inicio_registros < $limitepaginas) {
		      
		      echo "<a href='?numeropagina=" . ($inicio_registros+1) . "'>";
		      
		      ?>
		      
		      &raquo;
		      
		      <?php
		      
		      echo "</a>";
		  }
		?>
		
		</div>
		
		<?php 
		
		}else {
		
		?>
		
		<section>
		
			<?php 
			
			 try {
			     
			     $registros_pagina=14;
			     
			     if(isset($_GET["numeropagina"])){
			      
			         $inicio_registros=$_GET["numeropagina"];
			         
			     }else {
			         
			         $inicio_registros=1;
			     }
			     
			     $inicio_paginacion=($inicio_registros-1)*$registros_pagina;
			     
			     $consulta_cantidad="CALL GET_SONGS_COUNT(:TITULO)";
			     
			     $resultado=$conexion->prepare($consulta_cantidad);
			     
			     $resultado->execute(array(":TITULO"=>strval($buscador)));
			     
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
			     
			     $consulta="CALL GET_SONGS_TWO(:buscador,:iniciopaginacion,:registrospagina,:iduser)";
			     
			     $resultado=$conexion->prepare($consulta);
			     
			     $resultado->execute(array(":buscador"=>$buscador,":iniciopaginacion"=>$inicio_paginacion,":registrospagina"=>$registros_pagina,":iduser"=>$_SESSION["idusu"]));
			     
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
			         			
			         				<a href="/MIXWORLD/intranet/songs/<?php echo $fila["CANCION"]; ?>" download><i class="fa-solid  fa-download"></i></a>
			         			
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
			     
			 } catch (Exception $e) {
			     
			     die("Error: " . $e->getMessage());
			 }
			
			?>
		
		</section>
		
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
		      
		      echo "<a href='?numeropagina=". $i ."'><i class='fa-solid fa-music'></i><br>". $i ."</a>";
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
		
		}
		
		?>
	
	</body>

</html>