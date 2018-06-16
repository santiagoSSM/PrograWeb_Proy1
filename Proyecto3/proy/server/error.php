<?php 
function error($numero,$texto){ 
$ddf = fopen('error.log','a'); 
fwrite($ddf,"[".date("r")."] Error $numero:$texto\r\n"); 
fclose($ddf); 
} 
set_error_handler('error'); 
?>