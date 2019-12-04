<?php
session_start();
$usuario = $_SESSION['username'];
if(!isset($usuario)){
    header("location:login.php");
}
$rol = $_SESSION['rol'];
if($rol != 2){
    header("location:login.php");
}
require_once "conexion.php";
$codigo_reserva = isset($_GET['codigo_reserva']) ? $_GET['codigo_reserva'] : '';

$sql_imagen_qr ="select codigo_qr from reservas where cod_reserva='$codigo_reserva'";
$resultado_imagen_qr = mysqli_query($conexion,$sql_imagen_qr);
$fila_imagen_qr = mysqli_fetch_assoc($resultado_imagen_qr);
$imagen_qr = $fila_imagen_qr['codigo_qr'];
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Check-in</title>
        <link rel="stylesheet" href="css/resetcss.css">
        <link rel="stylesheet" href="css/w3.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        <link rel="stylesheet" href="css/gr.css">
    </head>
    <body>
    <?php
    include "header.php";
    echo "<div class='codigo-qr'><p>Escaneé el código QR para obtener toda la información del viaje</p><img src='img/qr/".$imagen_qr."' class='image-qr'></div>";
    include "pie.html";
    ?>
    </body>
</html>
