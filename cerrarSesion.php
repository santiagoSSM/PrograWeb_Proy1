<?php
//Inicia una nueva sesión o reanuda la existente 
    session_start(); 
//Destruye toda la información registrada de una sesión
    session_destroy(); 
	
//Redirecciona a la página de inicio de sesion
    header('location: index.php'); 
?>