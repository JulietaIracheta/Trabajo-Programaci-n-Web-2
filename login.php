<?php
$error="";
$clase="";
require 'conexion.php';
if (isset($_POST['enviar'])) {
    $usuario = $_POST['usuario'];
    $clave = md5($_POST['clave']);
    if(empty($usuario) or empty($clave)){
        $error = "<div class='w3-panel w3-red'><p>Los datos ingresados son incorrectos</p></div>";
        $clase ="animated shake";
    }else {
        $sql = "SELECT * FROM credenciales WHERE usuario = '" . $usuario . "' AND clave = '" . $clave . "'";
        $consulta = mysqli_query($conexion, $sql);
        if (!$consulta) {
            $error = "<div class='w3-panel w3-red'><p>Los datos ingresados son incorrectos</p></div>";
            $clase ="animated shake";
        } else {
            $resultado = mysqli_fetch_assoc($consulta);
            if ($resultado['clave'] == $clave) {
                $id_usuario = $resultado['id_usuario'];

                $sql_confirmacion_mail = "select confirmacion_mail from usuarios where id='$id_usuario'";
                $resultado_confirmacion_mail = mysqli_query($conexion, $sql_confirmacion_mail);
                $fila_confirmacion_mail = mysqli_fetch_assoc($resultado_confirmacion_mail);
                $confirmacion_mail = $fila_confirmacion_mail['confirmacion_mail'];

                // Confirmo que el usuario haya validado el mail
                if($confirmacion_mail==0){
                    $error = "<div class='w3-panel w3-red'><p>El email no esta validado. Complete el proceso para poder ingresar al sistema</p></div>";
                    $clase ="animated shake";
                }
                else{
                    session_start();
                    $_SESSION['username'] = $usuario;
                    $_SESSION['id'] = $resultado['id'];
                    $_SESSION['rol'] = $resultado['rol'];
                    header("location:inicio.php");
                    exit();
                }

            } else {
                $error = "<div class='w3-panel w3-red'><p>Los datos ingresados son incorrectos</p></div>";
                $clase ="animated shake";
            }
        }
    }
}
?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Iniciar sesión</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/w3.css">
        <link rel="stylesheet" href="css/animate.min.css">
        <link rel="stylesheet" href="css/gr.css">
    </head>
<body>

<div class="w3-container w3-lobster banda">
    <p class="w3-xxxlarge w3-center">Login a Gaucho Rocket<img src="img/cohete-espacial-mini.png" class="animated bounceInUp"></p>
</div>

<div class="w3-display-container">
    <form class="w3-container w3-card-4 w3-content login2 <?php echo $clase; ?>" method="POST" action="login.php">

        <?php echo $error; ?>
        <label class="w3-large registro">Nombre:</label>
        <input class="w3-input w3-margin-bottom w3-hover-gray" type="text" name="usuario">

        <label class="w3-large registro">Contraseña:</label>
        <input class="w3-input w3-margin-bottom w3-hover-gray" type="password" name="clave">

        <button class="w3-button w3-round-xlarge w3-green derecha" type="submit" name="enviar">Entrar</button><br><br>
        <a href="registro.php" class="w3-button w3-round-xlarge w3-dark-grey derecha">Registrarse</a>
    </form>
</div>
<?php
include "pie.html";
?>