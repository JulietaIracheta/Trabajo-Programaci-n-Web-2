<?php
$error="";
require 'conexion.php';

$nombre = isset($_GET['n']) ? $_GET['n'] : '';
$apellido = isset($_GET['a']) ? $_GET['a'] : '';
$email = isset($_GET['e']) ? $_GET['e'] : '';
//$nombre = $_GET['n'];
//$apellido = $_GET['a'];
//$email = $_GET['e'];

$sql_validacion_mail = "UPDATE usuarios SET confirmacion_mail = 1 WHERE email='$email'";
mysqli_query($conexion, $sql_validacion_mail);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar email</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="css/gr.css">
</head>
<body>
<div class="w3-display-container validacion">
    <div class="w3-container w3-card-4 w3-content login" >
        <p class="w3-xlarge w3-center">Ya puede acceder normalmente al sistema</p>
        <a class="w3-button w3-round-xlarge w3-dark-grey derecha" href="login.php">Iniciar sesion</a>
    </div>
</div>
</body>
<?php
include "pie.html";
?>
