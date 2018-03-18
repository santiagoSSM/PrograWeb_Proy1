<?php 
$filename1 = "archivos/indiceUser";
$filename2 = "archivos/detalleUser";
$directorio = "archivos";

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
	

	//si el directorio no existe lo crea
	if (!file_exists($directorio)) {
		mkdir($directorio, 0777, true);
	}
	
	//si el archivo indice no existe lo inicia en 0
	if (!file_exists($filename2)) {
		$tam = 0 . " \n";
		
	}else{
		
		$tam = filesize($filename2);

		$tam = $tam . " \n";
	}
	
	agregar ($usuario, $filename2);
	agregar ($tam, $filename1);
	agregar ($pass, $filename2);

	//si el directorio no existe lo crea
	if (!file_exists($usuario)) {
		mkdir("archivos/".$usuario, 0777, true);
	}
	
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
				<div><label>Usuario: </label>&nbsp &nbsp &nbsp <input id="usuario" name="usuario" type="text" maxlength="30" required></div>
				<br />
				<div><label>Contraseña: </label><input id="password" name="password" type="password" maxlength="30" required></div>
				<br />
				
				
				<!--<div style = "font-size:16px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : '' ; ?></div>-->
				<br />
				<div><input class="btn" name="login" type="submit" value="Crear usuario"></div> 
				
					
			</form> 
		</main>
	</body>

</html>