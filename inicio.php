<?php
   $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
   if ($archivo) {
      $ruta_destino_archivo = "archivos/{$archivo['name']}";
      $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
   }
?>


<!DOCTYPE html>
<html lang="es">

	<head>
		<meta charset="utf-8"/>
		<link rel="stylesheet" href="styles/normalize.css" type="text/css" media="all" />
		<link rel="stylesheet" href="styles/style.css" type="text/css" media="all" />
		<title>Administrador de archivos de Excel</title>
		
	</head>
	<body>
		<main>
			<h1 class="inicio">Administrador de archivos de Excel</h1>
			<a class="inicio" href="cerrarSesion.php">Cerrar sesion</a>
			<article>
				<table>
					<tr>
						<th>Nombre</th>
						<th>Fecha</th>
						<th>Tamaño</th>
						<th>Descripcion</th>
						<th>Acciones</th>
					</tr>
					<tr>
						<td>asfdsfsadgdfgfdsg</td>
						<td>dfghdfshgfdg</td>
						<td>hfghfghdfhfg</td>
						<td>fghffdhfghdfgh</td>
						<td>Editar | Borrar</td>
					</tr>
					<tr>
						<td>asfdsfsadgdfgfdsg</td>
						<td>dfghdfshgfdg</td>
						<td>hfghfghdfhfg</td>
						<td>fghffdhfghdfgh</td>
						<td>Editar | Borrar</td>
					</tr>
				</table>
			</article>
			<aside>
				<h2>Subir archivo Excel</h2>
				<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">

					<input type="file" name="archivo" required></input>

					<input type="submit" value="Subir archivo"></input>

				</form>

			
			<aside>
		</main>
	</body>

</html>