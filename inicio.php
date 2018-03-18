<?php
$idSelect = -1;
session_start();

if (isset($_SESSION['usuario'])){

	$usuario= $_SESSION['usuario'];


	/*$archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
	if ($archivo) {
	  $ruta_destino_archivo = "archivos/{$archivo['name']}";
	  $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
	}*/

	$indiceArray = array();
	$filedatas = array();


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

		$filename1 = "archivos/".$usuario."/indiceData";
		$filename2 = "archivos/".$usuario."/detalleData";

		global $indiceArray;
		global $filedatas;
		
		$file = fopen($filename2, "r");
		
		
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
	}

	function saveCookie(){
	    global $idSelect;
	    setcookie('id', $idSelect, time()+3600);
	}

	function readCookie(){
	    if(isset($_COOKIE['id'])){
	      global $idSelect;
	      $idSelect = json_decode($_COOKIE['id'], true);
	    }
	}

	function printForm(){
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

							<nav>
					          <a class="boton_personalizado" href="http://localhost/inicio.php?boton=nuevo">Nuevo</a>
					          <a class="boton_personalizado" href="group.html">Editar</a>
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
				                  global $idSelect;
				                  $longitud = count($filedatas);
		
	 
								  for($i=0; $i<$longitud; $i+=6){
				                    if($i == $idSelect){
				                        echo ('
				                        <tr class="selection">
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                        </tr>');
				                    }else{
				                        echo ('
				                        <tr>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
				                         <td><a href="http://localhost/index.php?idSelect=1&boton=selected">'.$filedatas[$i].'</a></td>
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
						<form class="form-signin" action="" method="GET" > 
							<br /> <br /> <br />
							<h1>Nuevo archivo Excel</h1>
							<hr>
							<br />
							<div><label>Nombre: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30"></div>
							<br />
							<div><label>Autor: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30"></div>
							<br />
							<div><label>Fecha: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30"></div>
							<br />
							<div><label>Tamaño: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30"></div>
							<br />
							<div><label>Descripcion: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30"></div>
							<br />
							<div><label>Clasificacion: </label>&nbsp &nbsp &nbsp <input name="fileData[]" type="text" maxlength="30"></div>
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
	if(isset($_GET["fileData"])){
		$fileData = $_GET["fileData"];
	}else{
		$fileData = array();
	}
	
	if(isset($_GET["boton"])){
		$boton = $_GET["boton"];
	}else{
		$boton = "";
	}

	if(isset($_GET["idSelect"])){
		$id = $_GET["idSelect"];
	}else{
		$id = -1;
	}
	

	if (!empty($boton)){
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