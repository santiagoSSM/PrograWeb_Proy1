<?php
	/*$archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
	if ($archivo) {
	  $ruta_destino_archivo = "archivos/{$archivo['name']}";
	  $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
	}*/

	function printForm(){
		echo('
			<!DOCTYPE html>
			<html lang="es">

				<head>
					<meta charset="utf-8"/>
					<title>Administrador de archivos de Excel</title>
					
				</head>
				<style>
					header {
						display: flex;
						justify-content: space-between;
					}

					h1 {
						text-align: center;
					}

					img {
			        	width: 50px;
			        	height: 50px;
			        }

			        .iconUser {
			        	width: 50px;
			        	text-align: center;
			        }

			        .iconOptions {
			        	width: 60px;
			        	text-align: center;
			        }

			        table {
			            border-collapse: collapse;
			            width: 100%;
			        }

			        td, th {
			            border: 1px solid #dddddd;
			            text-align: center;
			            padding: 8px;
			        }

			        td a {
			            text-decoration: none;
			            color: inherit;
			        }

			        .selection {
			            background-color: #dddddd;
			        }
			    </style>
				<body>
					<main>
						<header>
							<div class="iconUser">
								<img src="user.png"/>
								<span>perfil</span>
							</div>

							<h1 class="inicio">Administrador de archivos de Excel</h1>

							<div class="iconOptions">
								<img src="options.jpg"/>
								<span>opciones</span>
							</div>
						</header>

						<article>
							<table>
								<tr>
									<th>Nombre</th>
									<th>Fecha</th>
									<th>Tamaño</th>
									<th>Descripcion</th>
									<th>Clasificacion</th>
								</tr>
								<tr>
									<td>asfdsfsadgdfgfdsg</td>
									<td>dfghdfshgfdg</td>
									<td>hfghfghdfhfg</td>
									<td>fghffdhfghdfgh</td>
									<td>gafgafgaf</td>
								</tr>
								<tr>
									<td>asfdsfsadgdfgfdsg</td>
									<td>dfghdfshgfdg</td>
									<td>hfghfghdfhfg</td>
									<td>fghffdhfghdfgh</td>
									<td>sdfgfdfgdf</td>
								</tr>
							</table>
						</article>
						<aside>
							<h2>Subir archivo Excel</h2>
							<form action="<?php echo $_SERVER['."'PHP_SELF'".'] ?>" method="POST" enctype="multipart/form-data">

								<input type="file" name="archivo" required></input>

								<input type="submit" value="Subir archivo"></input>

							</form>

						
						<aside>
					</main>
				</body>

			</html>
		');
	}

	function main(){
	/*$boton = $_GET["boton"];
	$user = $_GET["user"];
	$id = $_GET["idSelect"];*/

	/*if (!empty($boton)){
	    switch ($boton) {
	        case 'selected':
	            readCookie();
	            global $idSelect;

	            //selecciona o deselecciona
	            if($idSelect == $id){
	                $idSelect = -1;
	            }else{
	                $idSelect = $id;
	            }
	            
	            saveCookie();
	            cargarIndices();
	            printForm();
	            break;

	        case 'editar':
	            readCookie();
	            global $idSelect;

	            if($idSelect != -1){
	                loadInfo();
	            }

	            cargarIndices();
	            printForm();
	            break;

	        case 'eliminar':
	            eliminaDeArchivo();

	            cargarIndices();
	            printForm();
	            break;

	        case 'guardar':
	            if (!empty($user)){
	                escribeArchivo($user);
	                cargarIndices();
	                printForm();
	            }
	            else{
	                cargarIndices();
	                printForm();
	            }
	            break;
	        
	        default:
	            cargarIndices();
	            printForm();
	            break;
	    }
	}
	else{
	    cargarIndices();*/
	    printForm();
	//}
}
    
main();
?>