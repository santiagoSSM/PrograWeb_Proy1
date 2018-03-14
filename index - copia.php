<?php
error_reporting(0);

$tamanio = 40;
$nombres = array();
$idSelect = -1;
$userInput = array("", "", "", "", "");

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


function cargarIndices(){
    global $nombres;
    global $tamanio;
    $filename = "indice.txt";

    if (filesize($filename)!=0) {
        $handle = fopen($filename, "r");
        fseek($handle, -$tamanio, SEEK_END);
        $temp = fread($handle, $tamanio);
        if($temp!=restringeString(" ")){
            array_unshift($nombres, $temp);
        }
        

        while (ftell($handle) >= $tamanio*3) {
            fseek($handle, -$tamanio*3, SEEK_CUR);
            $temp = fread($handle, $tamanio);
            if($temp!=restringeString(" ")){
                array_unshift($nombres, $temp);
            }
        }

        fclose($handle);
    }   
}

function restringeString($mystring){
    global $tamanio;

    if(strlen($mystring)>$tamanio){
        return substr($mystring, 0, $tamanio);
    }

    if(strlen($mystring)<=$tamanio){
        while(strlen($mystring)<$tamanio){
            $mystring = $mystring." ";
        }
        return $mystring;
    }  
}

function loadInfo(){
    global $tamanio;
    global $userInput;
    global $idSelect;
    $filename = "indice.txt";
    $filename2 = "data.txt";

    //indice
    $handle = fopen($filename, "r");
    fseek($handle, $idSelect*$tamanio*2+$tamanio);
    $userInput[0] = fread($handle, $tamanio);
    fclose($handle);

    //data
    $handle = fopen($filename2, "r");
    fseek($handle, $idSelect*$tamanio*5+$tamanio);
    $userInput[1] = fread($handle, $tamanio);
    $userInput[2] = fread($handle, $tamanio);
    $userInput[3] = fread($handle, $tamanio);
    $userInput[4] = fread($handle, $tamanio);
    fclose($handle);
}

function escribeArchivo($user){
    readCookie();

    global $tamanio;
    global $idSelect;
    $filename = "indice.txt";
    $filename2 = "data.txt";

    if($idSelect == -1){
        //id
        $handle = fopen($filename, "r");
        if(fseek($handle, -$tamanio*2, SEEK_END) == 0){
            $id = fread($handle, 1);
        }else{
            $id = -1;
        }
        fclose($handle);

        //indice
        $handle = fopen($filename, "a");
        fwrite($handle, restringeString($id+1));
        fwrite($handle, restringeString($user[0]));
        fclose($handle);

        //datos
        $handle = fopen($filename2, "a");
        fwrite($handle, restringeString($id+1));
        fwrite($handle, restringeString($user[1]));
        fwrite($handle, restringeString($user[2]));
        fwrite($handle, restringeString($user[3]));
        fwrite($handle, restringeString($user[4]));
        fclose($handle);
    }else{
        //indice
        $handle = fopen($filename, "r+");
        fseek($handle, $idSelect*$tamanio*2+$tamanio);
        fwrite($handle, restringeString($user[0]));
        fclose($handle);

        //datos
        $handle = fopen($filename2, "r+");
        fseek($handle, $idSelect*$tamanio*5+$tamanio);
        fwrite($handle, restringeString($user[1]));
        fwrite($handle, restringeString($user[2]));
        fwrite($handle, restringeString($user[3]));
        fwrite($handle, restringeString($user[4]));
        fclose($handle);
        $idSelect = -1;
        saveCookie();
    }
}

function eliminaDeArchivo(){
    readCookie();

    global $tamanio;
    global $idSelect;
    $filename = "indice.txt";
    $filename2 = "data.txt";

    //indice
    $handle = fopen($filename, "r+");
    fseek($handle, $idSelect*$tamanio*2+$tamanio);
    fwrite($handle, restringeString(" "));
    fclose($handle);

    //datos
    $handle = fopen($filename2, "r+");
    fseek($handle, $idSelect*$tamanio*5+$tamanio);
    fwrite($handle, restringeString(" "));
    fwrite($handle, restringeString(" "));
    fwrite($handle, restringeString(" "));
    fwrite($handle, restringeString(" "));
    fclose($handle);
}

function printForm(){
    echo ('
    <style>
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
    <form action="'. htmlentities($_SERVER["PHP_SELF"]).'" method="GET">
        <table>
          <tr>
            <td>
                <label>Contactos</label>
                <table>');

                  global $nombres;
                  global $idSelect;
                  foreach($nombres as $clave => $valor){
                    if($clave == $idSelect){
                        echo ('
                        <tr class="selection">
                         <td><a href="http://localhost/index.php?idSelect='.$clave.'&boton=selected">'.$valor.'</a></td>
                        </tr>');
                    }else{
                        echo ('
                        <tr>
                         <td><a href="http://localhost/index.php?idSelect='.$clave.'&boton=selected">'.$valor.'</a></td>
                        </tr>');
                    }
                   }  
                global $userInput;
                echo('      
                </table>
                <button type="submit" name="boton" value="editar">Editar</button>
            </td>

            <td>
                <table>
                  <tr>
                    <td><label>Name: </label></td>
                    <td><input type="text" name="user[]" value="'.$userInput[0].'"/></td>
                  </tr>
                  <tr>
                    <td><label>Work: </label></td>
                    <td><input type="text" name="user[]" value="'.$userInput[1].'"/></td>
                  </tr>
                  <tr>
                    <td><label>Mobile: </label></td>
                    <td><input type="text" name="user[]" value="'.$userInput[2].'"/></td>
                  </tr>
                  <tr>
                    <td><label>Email: </label></td>
                    <td><input type="text" name="user[]" value="'.$userInput[3].'"/></td>
                  </tr>
                  <tr>
                    <td><label>Address: </label></td>
                    <td><input type="text" name="user[]" value="'.$userInput[4].'"/></td>
                  </tr>
                  <tr>
                    <td><button type="submit" name="boton" value="eliminar">Eliminar</button></td>
                    <td><button type="submit" name="boton" value="guardar">Guardar</button></td>
                  </tr>
                </table>
            </td>
          </tr>
        </table>
    </form>');  
}

function main(){
    $boton = $_GET["boton"];
    $user = $_GET["user"];
    $id = $_GET["idSelect"];

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
        cargarIndices();
        printForm();
    }
}
    
main();
?>