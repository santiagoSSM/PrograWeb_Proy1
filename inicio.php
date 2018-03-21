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

		
   		//guarda Información
		$archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
		if ($archivo) {
		  //determina extension del archivo
		  $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
	      $extension = strtolower($extension);
	      $extension_correcta = ($extension == 'xlsx' or $extension == 'xls');
	      if ($extension_correcta) {
	      	 //guarda Info
	      	 $nombreArchivo = substr($tam, 0, -2).".".$extension;
	         $ruta_destino_archivo = "archivos/".$usuario."/".$nombreArchivo;
		  	 $archivo_ok = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);

		  	 foreach($fileData as $clave => $valor){
				 agregar ($valor, $filename2);

				 agregar ($tam, $filename1);

				 $tam = $tam+strlen($valor) . " \n";
			 }

			 agregar ($nombreArchivo, $filename2);

			 agregar ($tam, $filename1);

			 $tam = $tam+strlen($valor) . " \n";
	      }
	      else
	      {
	      	 return false; //error en el tipo de archivo
	      }
		}


		return true;
	}

	function descargarArchivo($filename){
		global $usuario;
		global $filedatas;

		if(substr($filename, -4) === ".xls"){
			$extension = ".xls";
			$id = substr($filename, 0, -4);
		}else{
			if(substr($filename, -5) === ".xlsx"){
				$extension = ".xlsx";
				$id = substr($filename, 0, -5);
			}
		}

		header("Content-disposition: attachment; filename=".$filedatas[$id].$extension);
		header("Content-type: MIME");
		readfile("archivos/".$usuario."/".$filename);
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
		global $filedatas;
		global $idSelectTable;
		$longitud = count($filedatas);
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
								<a href="#"><img src="images/user.png"/></a>
								<span>'.$usuario.'</span>
							</div>

							<h1 class="inicio">Administrador de archivos de Excel</h1>

							    ');
			                    global $idSelectOptions;
			                  
			                    if($idSelectOptions == -1){
			                        echo ('
			                        <div class="iconOptions">
										<a href="inicio.php?idSelectOptions=0&boton=selectOptions"><img src="images/options.jpg"/></a>
										<span>opciones</span>
									</div>');
			                    }else{
			                        echo ('
			                        <table>
										<tr>
											<th>
												<div class="iconOptions">
													<a href="inicio.php?idSelectOptions=-1&boton=selectOptions"><img src="options.jpg"/></a>
													<span>opciones</span>
												</div>
											</th>
											<th>
												<a href="#" class="options">Ayuda</a>
												</br>
												</br>
												<a href="cerrarSesion.php" class="options">Salir</a></th>
										</tr>
									</table>');
			                    }  
			                echo('
						</header>

						<article>

							<nav>
					          <a class="boton_personalizado" href="inicio.php?boton=nuevo">Nuevo</a>
					          <a class="boton_personalizado" href="#">Editar</a>
					          <a class="boton_personalizado" href="#">Eliminar</a>
					        </nav>
					        ');

			                if($longitud != 1){

				                echo('
								<table>
									<tr>
										<th>Nombre</th>
										<th>Autor</th>
										<th>Fecha</th>
										<th>Tamaño</th>
										<th>Descripcion</th>
										<th>Clasificacion</th>
										<th>Descargar</th>
									</tr>
			                        ');
		 
									  for($i=0; $i<$longitud; $i+=7){
					                    if($i == $idSelectTable){
					                        echo ('
					                        <tr class="selection">
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+1].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+2].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+3].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+4].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+5].'</a></td>
					                         <td><a href="inicio.php?filename='.$filedatas[$i+6].'&boton=descargarArchivo"><img src="images/xlsx.png"/></a></td>
					                        </tr>');
					                    }else{
					                        echo ('
					                        <tr>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+1].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+2].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+3].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+4].'</a></td>
					                         <td><a href="inicio.php?idSelectTable='.$i.'&boton=selectTable">'.$filedatas[$i+5].'</a></td>
					                         <td><a href="inicio.php?filename='.$filedatas[$i+6].'&boton=descargarArchivo"><img src="images/xlsx.png"/></a></td>
					                        </tr>');
					                    }

					                   }  
					                echo('
								</table>
								');

					        }

			                echo('
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

	if(isset($_GET["filename"])){
		$filename = $_GET["filename"];
	}else{
		$filename = "";
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

	        case 'descargarArchivo':
	        	global $idSelectTable;

	        	leerDatos();
	        	descargarArchivo($filename);
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
	            	if(escribeArchivo($fileData)){
	            		leerDatos();
	                	printForm();
	            	}else{
	            		printNuevo();
	            		echo "<script type='text/javascript'>alert('Formato de Archivo Incorrecto');</script>";
	            	}
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