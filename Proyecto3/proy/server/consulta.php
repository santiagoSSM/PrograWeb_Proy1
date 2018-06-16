<?php

    $path = "http://localhost/proy/server/index.php/user";

    $data = file_get_contents($path);
    $json = json_decode($data, true);

    echo "<html><body><table border=1>";
    echo "<tr><th>User</th><th>Pass</th></tr>";
    foreach ($json as $row) {
        echo "<tr><td>".$row['user']."</td><td>".$row['pass']."</td></tr>";
    }
    echo "</table></body></html>";

?>