<?php 
$filename1 = "archivos/indiceUser";
$filename2 = "archivos/detalleUser";

function agregar ($dato, $filename){
    //global $filename;
	//global $filename2;
    $handle = fopen($filename, "a");
   // $string= str_pad($dato, 10); 
	$numbytes = fwrite($handle, $dato);
    fclose($handle);
}


if(isset($_GET["usuario"])){
	$usuario = $_GET['usuario'];
	$pass = $_GET['password'];
	
	$tam = filesize($filename2);
	//$tam = str_pad($tam,5);
	$tam = $tam . " \n";
	
	agregar ($usuario, $filename2);
	agregar ($tam, $filename1);
	agregar ($pass, $filename2);
	
	 header('location: cerrarSesion.php'); 
	 exit;
}
?>


<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="styles/normalize.css" type="text/css" media="all" />
		<link rel="stylesheet" href="styles/style.css" type="text/css" media="all" />
		<title>Crear usuario</title>
		
	</head>
	<body>
		<main>
			<form class="form-signin" action="" method="GET"> 
				<br /> <br /> <br />
				<h1>Crear usuario</h1>
				<hr>
				<br />
				<div><label>Usuario: </label>&nbsp &nbsp &nbsp <input id="usuario" name="usuario" type="text" required></div>
				<br />
				<div><label>Contraseña: </label><input id="password" name="password" type="password" required></div>
				<br />
				
				
				<!--<div style = "font-size:16px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : '' ; ?></div>-->
				<br />
				<div><input class="btn" name="login" type="submit" value="Crear usuario"></div> 
				
					
			</form> 
		</main>
	</body>

</html>