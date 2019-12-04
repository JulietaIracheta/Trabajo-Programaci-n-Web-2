<?php
$error="";
require 'conexion.php';

$nombre = isset($_GET['n']) ? $_GET['n'] : '';
$apellido = isset($_GET['a']) ? $_GET['a'] : '';
$email = isset($_GET['e']) ? $_GET['e'] : '';
//$nombre = $_GET['n'];
//$apellido = $_GET['a'];
//$email = $_GET['e'];
$usuario="";

    if (isset($_POST['enviar'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $clave = md5($_POST['clave']);
        $clave2 = md5($_POST['clave2']);
        if(empty($usuario) or empty($clave)){
            $error = "<div class='w3-panel w3-red'><p>Nombre de Usuario/Contraseña<br>NO pueden estar vacios</p></div>";
            $clase ="animated shake";
        }
        else{
            $sql= "SELECT * FROM credenciales as c INNER JOIN usuarios as u 
                    ON c.id_usuario = u.id     
                    WHERE c.usuario = '$usuario'";
            $resultado = mysqli_query($conexion,$sql);
            $lista = mysqli_fetch_all($resultado);
            if(!empty($lista)){
                $error = "<div class='w3-panel w3-red'><p>El nombre de usuario ya existe</p></div>";
                $clase ="animated shake";
            }else {
                if ($clave == $clave2) {
                    $sql_idUsuario = "SELECT id FROM usuarios WHERE email = '$email'";
                    $resultado_idUsuario = mysqli_query($conexion,$sql_idUsuario);
                    $filaIdUsuario = mysqli_fetch_assoc($resultado_idUsuario);
                    $idUsuario = $filaIdUsuario['id'];

                    $sql_credenciales = "INSERT INTO credenciales(usuario,rol,clave,id_usuario) VALUES ('$usuario',2,'$clave','$idUsuario')";
                    $resultado_credenciales = mysqli_query($conexion,$sql_credenciales);

                    $usuario="";
                    $error = "<div class='w3-panel w3-light-green'><p>Usuario ingresado!!</p></div>";
                } else {
                    $error = "<div class='w3-panel w3-red'><p>La contraseña no coincide<br>Vuelva a tipearla</p></div>";
                    $clase = "animated shake";
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/gr.css">
</head>
<body>

<div class="w3-container w3-lobster banda">
    <p class="w3-xxxlarge w3-center">Registro a Gaucho Rocket</p><img src="img/cohete-espacial-mini.png" class="animated bounceInUp">
</div>

<div class="w3-display-container">
    <form class="w3-container w3-card-4 w3-content login <?php echo $clase; ?>" method="POST" action="completar_registro.php" >

        <?php echo $error; ?>


        <div class="col-izquierda">
        <label class="w3-large registro">Nombre:</label>
        <input type="hidden" name="nombre" value="<?php echo$nombre; ?>">
        <div class="campo-falso"><?php echo$nombre; ?></div>

        <label class="w3-large registro">Apellido:</label>
        <input type="hidden" name="apellido" value="<?php echo$apellido; ?>">
        <div class="campo-falso"><?php echo$apellido; ?></div>

        <label class="w3-large registro">Email:</label>
        <input type="hidden" name="email" value="<?php echo$email; ?>">
        <div class="campo-falso"><?php echo$email; ?></div>
        </div>
        <div class="col-derecha">
        <label class="w3-large registro">Nombre de Usuario:</label>
        <input class="w3-input w3-margin-bottom w3-hover-gray ingreso" type="text" name="usuario" value="<?php echo$usuario; ?>">

        <label class="w3-large registro">Contraseña:</label>
        <input class="w3-input w3-margin-bottom w3-hover-gray ingreso" type="password" name="clave">

        <label class="w3-large registro">Repita su contraseña:</label>
        <input class="w3-input w3-margin-bottom w3-hover-gray ingreso" type="password" name="clave2">
        </div>
        <div class="limpia-float"></div>
        <button class="w3-button w3-round-xlarge w3-green derecha" type="submit" name="enviar">Registrarse</button><br><br>
    </form>
</div>
<?php
include "pie.html";
?>
