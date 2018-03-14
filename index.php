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
			<form class="form-signin" action="inicio.php" method="POST" > 
				<br /> <br /> <br />
				<h1>Iniciar sesion</h1>
				<hr>
				<br />
				<div><label>Usuario: </label>&nbsp &nbsp &nbsp <input id="usuario" name="usuario" type="text"></div>
				<br />
				<div><label>Contraseña: </label><input id="password" name="password" type="password"></div>
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