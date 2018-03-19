<?php
session_start();

error_reporting (0);

if (isset($_SESSION['usuario'])){

	$usuario= $_SESSION['usuario'];
	$indiceArray = array();
	$filedatas = array();
	$idSelectTable = -1;
	$idSelectOptions = -1;

	function leerIndice(){
		global $indiceArray;
		global $usuario;

		//si el archivo indice no existe lo inicia en 0

		$filename1 = "archivos/".$usuario."/indiceData";
		
		$indiceArray = file($filename1);
	}

	function leerDatos (){
		leerIndice();
		
		global $usuario;

		//si el archivo indice no existe lo inicia en 0

		$filename2 = "archivos/".$usuario."/detalleData";

		global $indiceArray;
		global $filedatas;
		
		$file = fopen($filename2, "r");
		
		
		$longitud = count($indiceArray);
		
	 
		for($i=0; $i<$longitud; $i++){
			$num = ( int ) $indiceArray[$i];
			if (!empty($indiceArray[$i+1])){
				$num2 = ( int ) $indiceArray[$i+1];
				fseek($file,$num);
				$datos = fread($file,$num2-$num);

				array_push($filedatas, $datos);
				
			}else{
				$num2 = ( int ) $indiceArray[$i];
				if ($num2 < 30){
					$num2 = 30;
				}
				fseek($file,$num);
				$datos = fread($file,$num2);
				
				array_push($filedatas, $datos);
			}
			
		}
		
		
		fclose($file);
		
	}

	function agregar ($dato, $filename){
	    $handle = fopen($filename, "a");
	   // $string= str_pad($dato, 10); 
		$numbytes = fwrite($handle, $dato);
	    fclose($handle);
	}

	function escribeArchivo($fileData){
		global $usuario;

		//si el archivo indice no existe lo inicia en 0

		$filename1 = "archivos/".$usuario."/indiceData";
		$filename2 = "archivos/".$usuario."/detalleData";
		$tam = -1;

		if (!file_exists($filename2)) {
			$tam = 0 . " \n";
			
		}else{
			
			$tam = filesize($filename2);

			$tam = $tam . " \n";
		}


		foreach($fileData as $clave => $valor){
			agregar ($valor, $filename2);

			agregar ($tam, $filename1);

			$tam = $tam+strlen($valor) . " \n";
		}

		$archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
		if ($archivo) {
		  $ruta_destino_archivo = "archivos/".$usuario."/{$archivo['name']}";
		  $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
		}
		else{
			echo "no archivos";
		}
	}

	function saveCookieTable(){
	    global $idSelectTable;
	    setcookie('idSelectTable', $idSelectTable, time()+3600);
	}

	function readCookieTable(){
	    if(isset($_COOKIE['idSelectTable'])){
	      global $idSelectTable;
	      $idSelectTable = json_decode($_COOKIE['idSelectTable'], true);
	    }
	}

	function printForm(){
		global $usuario;
		echo('
			<!DOCTYPE html>
			<html lang="es">

				<head>
					<meta charset="utf-8"/>
					<link rel="stylesheet" href="styles/normalize.css" type="text/css" media="all" />
					<link rel="stylesheet" href="styles/inicio.css" type="text/css" media="all" />
					<title>Administrador de archivos de Excel</title>
				</head>
				<body>
					<main>
						<header>
							<div class="iconUser">
								<a href="#"><img src="user.png"/></a>
								<span>'.$usuario.'</span>
							</div>

							<h1 class="inicio">Administrador de archivos de Excel</h1>

							    ');
			                    global $idSelectOptions;
			                  
			                    if($idSelectOptions == -1){
			                        echo ('
			                        <div class="iconOptions">
										<a href="http://localhost/inicio.php?idSelectOptions=0&boton=selectOptions"><img src="options.jpg"/></a>
										<span>opciones</span>
									</div>');
			                    }else{
			                        echo ('
			                        <table>
										<tr>
											<th>
												<div class="iconOptions">
													<a href="http://localhost/inicio.php?idSelectOptions=-1&boton=selectOptions"><img src="options.jpg"/></a>
													<span>opciones</span>
												</div>
											</th>
											<th>
												<a href="#" class="options">Ayuda</a>
												</br>
												</br>
												<a href="http://localhost/cerrarSesion.php" class="options">Salir</a></th>
										</tr>
									</table>');
			                    }  
			                echo('
						</header>

						<article>

							<nav>
					          <a class="boton_personalizado" href="http://localhost/inicio.php?boton=nuevo">Nuevo</a>
					          <a class="boton_personalizado" href="#">Editar</a>
					          <a class="boton_personalizado" href="#">Eliminar</a>
					        </nav>

							<table>
								<tr>
									<th>Nombre</th>
									<th>Autor</th>
									<th>Fecha</th>
									<th>Tamaño</th>
									<th>Descripcion</th>
									<th>Clasificacion</th>
								</tr>
		                        ');

				                  global $filedatas;
				                  global $idSelectTable;
				                  $longitud = count($filedatas);
		
	 
								  for($i=0; $i<$longitud; $i+=6){
				                    if($i == $idSelectTable){
				                        echo ('
				                        <tr class="selection">
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+1].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+2].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+3].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+4].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+5].'</a></td>
				                        </tr>');
				                    }else{
				                        echo ('
				                        <tr>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+1].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+2].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+3].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+4].'</a></td>
				                         <td><a href="http://localhost/inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+5].'</a></td>
				                        </tr>');
				                    }

				                   }  
				                echo('
							</table>
						</article>
					</main>
				</body>

			</html>
		');
	}

	function printNuevo(){
		echo('
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
						<form class="form-signin" method="post" enctype="multipart/form-data"> 
							<br /> <br /> <br />
							<h1>Nuevo archivo Excel</h1>
							<hr>
							<br />
							<div><label>Nombre: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30" required></div>
							<br />
							<div><label>Autor: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30" required></div>
							<br />
							<div><label>Fecha: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30" required></div>
							<br />
							<div><label>Tamaño: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30" required></div>
							<br />
							<div><label>Descripcion: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30" required></div>
							<br />
							<div><label>Clasificacion: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30" required></div>
							<br />
							<input type="file" name="archivo" required></input>
							<br />
							<br />
							<div><button type="submit" name="boton" value="guardar">Guardar</button></div> 
							<br />
							<hr>
								
						</form> 
					</main>
				</body>

			</html>
		');
	}

	function main(){
	if(isset($_POST["fileData"])){
		$fileData = $_POST["fileData"];
	}else{
		$fileData = array();
	}
	
	if(isset($_POST["boton"])){
		$boton = $_POST["boton"];
	}else{
		if(isset($_GET["boton"])){
			$boton = $_GET["boton"];
		}else{
			$boton = "";
		}
	}

	if(isset($_GET["idSelectTable"])){
		$id1 = $_GET["idSelectTable"];
	}else{
		$id1 = -1;
	}

	if(isset($_GET["idSelectOptions"])){
		$id2 = $_GET["idSelectOptions"];
	}else{
		$id2 = -1;
	}
	

	if (!empty($boton)){
	    switch ($boton) {
	        case 'selectTable':
	            readCookieTable();
	            global $idSelectTable;

	            //selecciona o deselecciona
	            if($idSelectTable == $id1){
	                $idSelectTable = -1;
	            }else{
	                $idSelectTable = $id1;
	            }
	            
	            saveCookieTable();
	            leerDatos();
	            printForm();
	            break;

	        case 'selectOptions':
	            global $idSelectOptions;

	            $idSelectOptions = $id2;

	            leerDatos();
	            printForm();
	            break;

	        case 'nuevo':
	            printNuevo();
	            break;

	        /*case 'editar':
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
	            break;*/

	        case 'guardar':
	            if (!empty($fileData)){
	                escribeArchivo($fileData);
	                leerDatos();
	                printForm();
	            }
	            else{
	                leerDatos();
	                printForm();
	            }
	            break;
	        
	        default:
	            leerDatos();
	            printForm();
	            break;
	    }
	}
	else{
	    leerDatos();
	    printForm();
	}
}
    
main();

}
else{
	header('location: index.php'); 
}

?>