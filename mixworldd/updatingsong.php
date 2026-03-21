<head>

	<link rel="stylesheet" href="updatingsong.css?v=<?php echo time(); ?>">

</head>
<?php

    session_start();
    
    if (isset($_SESSION["idusu"])) {
        
        try {
            
            include $_SERVER["DOCUMENT_ROOT"] . '/mixworld/mixworldd/conexion.php';
            
            if ($_FILES["imagencancion"]["name"]=='') {
                
                $imagendefecto=$_POST["imagesong"];
            }else {
                
                $imagen=$_FILES["imagencancion"]["name"];
                
                $imagentipo=$_FILES["imagencancion"]["type"];
                
                $carpetaimg=$_SERVER["DOCUMENT_ROOT"] . "/mixworld/mixworldd/intranet/songs/";
                
                move_uploaded_file($_FILES['imagencancion']['tmp_name'], $carpetaimg.$imagen);
            }
            
            $iduser=$_SESSION["idusu"];
            
            $titulo=$_POST["titulo"];
            
            $descripcion=$_POST["comenta"];
            
            $id=$_POST["id"];
            
            $ids=$_POST["idsongh"];
            
            $consulta="CALL UPDATE_SONG(:songimage,:title,:description,:idsong)";
            
            if (isset($imagentipo)) {
                
                if ($imagentipo=="image/jpg" || $imagentipo=="image/jpeg" || $imagentipo=="image/png") {
                    
                    $resultado=$conexion->prepare($consulta);
                    
                    $resultado->execute(array(":songimage"=>$imagen,":title"=>$titulo,":description"=>$descripcion,":idsong"=>$id));
                    
                    $cantidad=$resultado->rowCount();
                    
                    if ($cantidad!=0) {
                        
                        header("location:cuenta.php?user=$iduser");
                    }else {
                        
                        echo "<body>";
                        
                        echo "<div class='diverror'>";
                        
                        echo "Error al actualizar la información, intentelo de nuevo";
                        
                        echo "<a href='updatesong.php?idsong=$id'>Volver</a>";
                        
                        echo "</div>";
                        
                        echo "</body>";
                    }
                }
                else {
                    
                    header("location:updatesong.php?song=$ids");
                }
            }
            else {
                
                $resultado=$conexion->prepare($consulta);
                
                $resultado->execute(array(":songimage"=>$imagendefecto,":title"=>$titulo,":description"=>$descripcion,":idsong"=>$id));
                
                $cantidad=$resultado->rowCount();
                
                if ($cantidad!=0) {
                    
                    header("location:cuenta.php?user=$iduser");
                }else {
                    
                    echo "<body>";
                    
                    echo "<div class='diverror'>";
                    
                    echo "No se actualizó ninguna información, intentelo de nuevo";
                    
                    echo "<br>";
                    
                    echo "<a href='updatesong.php?song=$ids'>Volver</a>";
                    
                    echo "</div>";
                    
                    echo "</body>";
                }
            }
            
        } catch (Exception $e) {
            
            die("Error: " . $e->getMessage());
        }
    }else {
        
        header("location:index.php");
    }

?>