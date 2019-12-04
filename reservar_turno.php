<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Turno medico</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/w3.css">
    <link rel="stylesheet" href="css/animate.min.css">
    <link rel="stylesheet" href="css/gr.css">
</head>
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
$id_usuario_session = $_SESSION['id'];
$error="";
require 'conexion.php';
include 'header.php';

$sql_id_usuario = "select id_usuario from credenciales where id = '$id_usuario_session'";
$resultado_id_usuario = mysqli_query($conexion,$sql_id_usuario);
$fila_id_usuario = mysqli_fetch_assoc($resultado_id_usuario);
$numero_de_usuario = $fila_id_usuario['id_usuario'];

$sql_centro_medico = "SELECT * FROM centros_medicos";
$resultado_centro_medico = mysqli_query($conexion,$sql_centro_medico);

date_default_timezone_set('America/Argentina/Buenos_Aires');
$hoy = date("Y-m-d");
$fecha_minimo = date("Y-m-d",strtotime($hoy."+ 1 days"));
$nuevo_turno = false;

$sql_se_chequeo = "SELECT se_chequeo FROM usuarios WHERE id = '$numero_de_usuario'";
$resultado_se_chequeo = mysqli_query($conexion,$sql_se_chequeo);
$fila_se_chequeo = mysqli_fetch_assoc($resultado_se_chequeo);

$se_chequeo = $fila_se_chequeo['se_chequeo'];
//$nuevo_turno == false;
if($se_chequeo == false) {

    $centro_medico = isset($_POST['centro_medico']) ? $_POST['centro_medico'] : '';
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : '';
//    $centro_medico = $_POST['centro_medico'];
//    $fecha = $_POST['fecha'];

    $sql_verificar_turno_pendiente = "SELECT (id_usuario) COUNT FROM turnos WHERE id_usuario = '$numero_de_usuario';";
    $resultado_verificar_turno_pendiente = mysqli_query($conexion, $sql_verificar_turno_pendiente);
    $fila_verificar_turno_pendiente = mysqli_fetch_array($resultado_verificar_turno_pendiente);

    if (!$fila_verificar_turno_pendiente) {

        if (isset($_POST['enviar'])) {

            if ($fecha >= $fecha_minimo) {
                $sql_cantidad = "SELECT turnos_diarios FROM centros_medicos WHERE id = '$centro_medico'";
                $resultado_cantidad = mysqli_query($conexion, $sql_cantidad);
                $fila_cantidad = mysqli_fetch_assoc($resultado_cantidad);
                $cantidad_turnos = $fila_cantidad['turnos_diarios'];

                $sql_turnos = "SELECT COUNT (t.id) as cantidad FROM turnos as t inner join centros_medicos as cm on t.centro_medico = cm.id WHERE cm.id = '$centro_medico'";
                $resultado_turnos = mysqli_query($conexion, $sql_turnos);

                if (mysqli_affected_rows($conexion) > 0) {
                    $fila_turnos = mysqli_fetch_assoc($resultado_turnos);
                    $cantidad_turnos -= $fila_turnos['cantidad'];
                }

                if ($cantidad_turnos > 0) {
                    $sql_nuevo_turno = "INSERT INTO turnos (fecha,id_usuario,centro_medico) values('$fecha','$numero_de_usuario','$centro_medico')";
                    $resultado_nuevo_turno = mysqli_query($conexion, $sql_nuevo_turno);
                    $nuevo_turno = true;
                } else {
                    $error = "<div class='w3-panel w3-red animated shake'><p>No hay mas turnos disponibles para esta fecha</p></div>";
                }
            } else {
                $error = "<div class='w3-panel w3-red animated shake'><p>La fecha ingresada es incorrecta</p></div>";
            }

        }


    } else {
        $error = "<div class='w3-panel w3-yellow animated shake'><p>Ya tiene un turno pendiente</p></div>";
    }

}else {
    echo "<div class='mensaje-yahecho'>El usuario ya realizó el chequeo médico.</div>";
    include "pie.html";
    die;
}
?>
<body>
<div class="w3-container banda">
    <p class="w3-xxlarge w3-center">Reservas de turno médico</p>
</div>

<?php
if ($nuevo_turno != true){
?>
<div class="w3-display-container">

    <form class="w3-container w3-card-4 w3-content reserva-turno-medico" autocomplete="off" method="POST" action="reservar_turno.php">

        <?php echo $error; ?>
       <center>
           <label class="w3-large reserva-medica">Centro Médico:</label>
              <select name="centro_medico" >
                <?php
                while ($fila_centro_medico = mysqli_fetch_assoc($resultado_centro_medico)){
                    echo "<option value='" . $fila_centro_medico['id'] . "'>" . $fila_centro_medico['nombre'] . "</option>";
                }
                ?>
              </select><br><br>

           <center>
               <label class="w3-large reserva-medica">Fecha:</label>
               <input  type="text" name="fecha" id="fecha" placeholder="yy-mm-dd" min="<?php echo $fecha_minimo;?>">
           </center><br><br>


           <button class="w3-button w3-round-xlarge w3-green" type="submit" name="enviar">Reservar</button><br><br>

       </center>
    </form>
</div>
<?php
}else if ($nuevo_turno == true){
    echo "<div class=w3-container banda'>
          <p>El turno fue reservado correctamente</p>
          <a href='inicio.php' class='w3-button w3-round-xlarge w3-blue'>Volver al inicio</a>
          </div>";
}
?>

<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css">-->

<script>
    $(function() {
        $('#fecha').datepicker({
            dateFormat: 'yy-mm-dd',
            maxDate: '+ 3m',
            minDate: '-0d',
            beforeShowDay: $ .datepicker.noWeekends
        });
    });
</script>
</body>

<?php
include "pie.html";
?>