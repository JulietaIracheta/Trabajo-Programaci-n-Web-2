<?php
    require 'conexion.php';
    require 'funciones.php';
    $mensaje_error="";
    $estado="";
    $error="";
    $nombre = "";
    $apellido = "";
    $email = "";
    $usuario="";
    $clase="";

    if (isset($_POST['enviar'])) {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];
        $clave2 = md5($_POST['clave2']);
//        $apellidoU = $_SESSION['apellido'];
        $validaciones=true;

        // Verifico que todos los campos tengan valores
        if(empty($nombre)){
            $mensaje_error .= "<p>Debe ingresar un nombre</p>";
            $validaciones = false;
        }
        if(empty($apellido)){
            $mensaje_error .= "<p>Debe ingresar un apellido</p>";
            $validaciones = false;
        }
        if(empty($usuario)){
            $mensaje_error .= "<p>El nombre de usuario NO puede estar vacio</p>";
            $validaciones = false;
        }
        if(empty($clave)){
            $mensaje_error .= "<p>La contraseña NO puede estar vacia</p>";
            $validaciones = false;
        }
        if(empty($email)){
            $mensaje_error .= "<p>Debe ingresar un E-mail</p>";
            $validaciones = false;
        }
        elseif(!$estructura_mail = valida_email($email)) {
            $mensaje_error .= "<p>Verifique la correcta escritura del email</p>";
            $validaciones = false;
        }


        // Si estan todos los campos
        if($validaciones==true){
            $clave = md5($_POST['clave']);
            $correcto=true;

            // Compruebo que email y usuario no esten ingresados (repetidos)
            $sql= "SELECT * FROM credenciales as c INNER JOIN usuarios as u 
                    ON c.id_usuario = u.id     
                    WHERE c.usuario = '$usuario'";
            $resultado = mysqli_query($conexion,$sql);
            $lista = mysqli_fetch_all($resultado);
            if(!empty($lista)){
                $mensaje_error .= "<p>El nombre de usuario ya existe</p>";
                $correcto=false;
            }

            $sql_email = "SELECT email FROM usuarios WHERE email = '$email'";
            $resultado_email = mysqli_query($conexion,$sql_email);
            $lista_email = mysqli_fetch_all($resultado_email);
            if(!empty($lista_email)){
                $mensaje_error .= "<p>El Email ingresado ya existe</p>";
                $correcto=false;
            }


            // Grabo los datos
            if($correcto==true){
                if ($clave == $clave2) {
                    $sql_usuario = "INSERT INTO usuarios (nombre, apellido, email, nivel_vuelo, se_chequeo, confirmacion_mail) VALUES ('$nombre','$apellido','$email','0','0','0')";
                    $consulta_usuario = mysqli_query($conexion, $sql_usuario);
                    if (!$consulta_usuario) {
                        $mensaje_error = "<p>ERROR<br>No se pudieron guardar los datos</p>";
                    } else {
                        $sql_idUsuario = "SELECT id FROM usuarios WHERE email = '$email'";
                        $resultado_idUsuario = mysqli_query($conexion,$sql_idUsuario);
                        $filaIdUsuario = mysqli_fetch_assoc($resultado_idUsuario);
                        $idUsuario = $filaIdUsuario['id'];
                        $sql_credenciales = "INSERT INTO credenciales(usuario,rol,clave,id_usuario) VALUES ('$usuario',2,'$clave','$idUsuario')";
                        $resultado_credenciales = mysqli_query($conexion,$sql_credenciales);
                        $nombre = "";
                        $apellido = "";
                        $email = "";
                        $usuario="";
                        $mensaje_error = "<p><b>Usuario ingresado !!</b><br>
                                            Para poder ingresar al sistema primero debe validar el email.<br>
                                            Para ello le hemos enviado un correo, donde encontrará un link,<br>
                                            para completar el proceso</p>";
                        $estado="ok";
                    }
                } else {
                    $mensaje_error = "<p>La contraseña no coincide<br>Vuelva a tipearla</p>";
                }

            }

        }

        iF($estado=="ok"){
            $error = "<div class='w3-panel w3-light-green'>".$mensaje_error."</div>";
        }
        else{
            $error = "<div class='w3-panel w3-red'>".$mensaje_error."</div>";
            $clase = "animated shake";
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
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
        <link rel="stylesheet" href="css/gr.css">
    </head>
<body>

<body>
<div class="w3-container w3-lobster banda">
    <p class="w3-xxxlarge w3-center">Registro a Gaucho Rocket</p><img src="img/cohete-espacial-mini.png" class="animated bounceInUp">
</div>

<div class="w3-display-container">
    <form class="w3-container w3-card-4 w3-content login <?php echo $clase; ?>" method="POST" action="registro.php" >

        <?php echo $error; ?>
        <div class="col-izquierda">
            <label class="w3-large registro">Nombre:</label>
            <input class="w3-input w3-margin-bottom w3-hover-gray" type="text" name="nombre" value="<?php echo$nombre; ?>">

            <label class="w3-large registro">Apellido:</label>
            <input class="w3-input w3-margin-bottom w3-hover-gray" type="text" name="apellido" value="<?php echo$apellido; ?>">

            <label class="w3-large registro">Email:</label>
            <input class="w3-input w3-margin-bottom w3-hover-gray" type="text" name="email" value="<?php echo$email; ?>">
        </div>
        <div class="col-derecha">
            <label class="w3-large registro">Nombre de Usuario:</label>
            <input class="w3-input w3-margin-bottom w3-hover-gray" type="text" name="usuario" value="<?php echo$usuario; ?>">

            <label class="w3-large registro">Contraseña:</label>
            <input class="w3-input w3-margin-bottom w3-hover-gray" type="password" name="clave">

            <label class="w3-large registro">Repita su contraseña:</label>
            <input class="w3-input w3-margin-bottom w3-hover-gray" type="password" name="clave2">
        </div>
        <button class="w3-button w3-round-xlarge w3-green derecha" type="submit" name="enviar">Registrarse</button><br><br>
        <a class="w3-button w3-round-xlarge w3-dark-grey derecha" href="login.php">Iniciar sesion</a>
    </form>
</div>
<?php
include "pie.html";
?>