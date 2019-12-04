<?php
$conexion = mysqli_connect("127.0.0.1:3307","pw2","pw22019","gauchorocket");
if(!$conexion){
    echo "<div class='w3-panel w3-red'><p>ERROR de conexión a la BD</p></div>";
    die;
}
?>