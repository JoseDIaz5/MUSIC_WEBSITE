<!DOCTYPE html>
<html>

<?php 

    session_start();
    
    if (!isset($_SESSION["idusu"])) {
        
        header("location:index.php");
    }
    
?>

<head>

	<meta charset="utf-8">

    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    
    <title>MIXWORLD | Confirmación canción</title>
    
    <link rel="stylesheet" href="confirmacioncancion.css?v=<?php echo time(); ?>">

</head>
<body>

	<div>
	
		<?php 

            echo "<span>Canción compartida con éxito</span>";

        ?>
        
        <br>
        
        <br>
	
		<a href="cuenta.php">Volver a la cuenta</a>
	
	</div>

</body>

</html>
