<?php
session_start();

error_reporting (0);

$filename1 = "archivos/indiceUser";
$filename2 = "archivos/detalleUser";
$indiceArray = array();

function leerIndice(){
	global $indiceArray;
	global $filename1;
	
	$indiceArray = file($filename1);
}

function leerDatos ($usuario, $pass){
	
	leerIndice();
	
	global $filename1;
	global $filename2;
	global $indiceArray;
	
	$indiceArray = file($filename1);
	
	$datoSesion=$usuario.$pass;
	
	$file = fopen($filename2, "r");
	//$tam = filesize($filename);
	
	
	$longitud = count($indiceArray);
	
 
	for($i=0; $i<$longitud; $i++){
		$num = ( int ) $indiceArray[$i];
		if (!empty($indiceArray[$i+1])){
			$num2 = ( int ) $indiceArray[$i+1];
			//echo $indiceArray[0] . "<br>";
			//echo $indiceArray[1]. "<br>";
			//echo $indiceArray[2]. "<br>";
			fseek($file,$num);
			$datos = fread($file,$num2-$num);
			
			if ($datoSesion == $datos){
				$_SESSION['usuario'] = $usuario;
				header('location: inicio.php'); 
				exit;
			}
			
		}else{
			$num2 = ( int ) $indiceArray[$i];
			if ($num2 < 30){
				$num2 = 30;
			}
			fseek($file,$num);
			$datos = fread($file,$num2);
			if ($datoSesion == $datos){
				$_SESSION['usuario'] = $usuario;
				header('location: inicio.php'); 
				exit;
			}
		}
		
	}
	
	
	fclose($file);
	
}

 
 if(isset($_GET["usuario"])){
	$usuario = $_GET['usuario'];
	$pass = $_GET['password'];
	
	//$dato=$usuario.$pass;
	
	leerDatos($usuario, $pass);
}

?>

<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="styles/normalize.css" type="text/css" media="all" />
		<link rel="stylesheet" href="styles/style.css" type="text/css" media="all" />
		<title>Iniciar sesion</title>
		
	</head>
	<body>
		<main>
			<form class="form-signin" action="" method="GET" > 
				<br /> <br /> <br />
				<h1>Iniciar sesion</h1>
				<hr>
				<br />
				<div><label>Usuario: </label>&nbsp &nbsp &nbsp <input id="usuario" name="usuario" type="text" maxlength="30"></div>
				<br />
				<div><label>Contraseña: </label><input id="password" name="password" type="password" maxlength="30"></div>
				<br />
				
				<!--<div style = "font-size:16px; color:#cc0000;"><?php echo isset($error) ? utf8_decode($error) : '' ; ?></div>-->
				<br />
				<div><input class="btn" name="login" type="submit" value="Iniciar sesion"></div> 
				<br />
				<hr>
				<br />
				<small><a href="crearUsuario.php">Crear cuenta</a></small>
					
			</form> 
		</main>
	</body>

</html>